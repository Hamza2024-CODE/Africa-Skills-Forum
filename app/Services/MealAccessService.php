<?php

namespace App\Services;

use App\Models\MealEntitlement;
use App\Models\MealScan;
use App\Models\MealSlot;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * MealAccessService — Zero-Trust Badge Scan Engine
 *
 * Every scan must pass ALL of these gates in order:
 *  1. Badge token resolves to a real, active user
 *  2. Meal slot exists and is open
 *  3. Slot date is today
 *  4. Current time is within slot time window
 *  5. Restaurant is active
 *  6. User has a ACTIVE entitlement for this slot (or delegation-level entitlement)
 *  7. No previous AUTHORIZED scan exists for this user + slot (duplicate prevention)
 *  8. Capacity has not been exceeded (with DB lock)
 *
 * On failure at any gate → DENIED (with reason logged)
 * On success → AUTHORIZED scan recorded
 */
class MealAccessService
{
    public function scan(string $badgeCode, int $mealSlotId, ?int $scannedByUserId = null): array
    {
        return DB::transaction(function () use ($badgeCode, $mealSlotId, $scannedByUserId) {

            $slot = MealSlot::with('restaurant')->lockForUpdate()->find($mealSlotId);
            $scannerUser = $scannedByUserId ? User::find($scannedByUserId) : null;

            // ── GATE 1: Slot exists and is open ─────────────────────────────
            if (!$slot) {
                return $this->recordDenied(null, $mealSlotId, $badgeCode, $scannerUser, 'وجبة غير موجودة.', null);
            }

            if (!$slot->is_open) {
                return $this->recordDenied(null, $mealSlotId, $badgeCode, $scannerUser, 'هذه الوجبة مغلقة حالياً.', $slot);
            }

            // ── GATE 2: Slot date is today ───────────────────────────────────
            if (!$slot->date->isToday()) {
                return $this->recordDenied(null, $mealSlotId, $badgeCode, $scannerUser, 'تاريخ هذه الوجبة غير صحيح (ليس اليوم).', $slot);
            }

            // ── GATE 3: Current time within meal window ──────────────────────
            $now  = now()->format('H:i:s');
            $start = $slot->start_time;
            $end   = $slot->end_time;
            if ($now < $start || $now > $end) {
                return $this->recordDenied(null, $mealSlotId, $badgeCode, $scannerUser,
                    "خارج وقت الوجبة ({$start} → {$end}). الوقت الحالي: {$now}.", $slot);
            }

            // ── GATE 4: Resolve badge → user ─────────────────────────────────
            // Badge code can be user UUID or accreditation badge_code stored in users table
            $user = User::where('uuid', $badgeCode)
                ->orWhere('badge_code', $badgeCode)
                ->first();

            if (!$user) {
                return $this->recordDenied(null, $mealSlotId, $badgeCode, $scannerUser, 'شارة غير معروفة أو غير مسجلة في المنصة.', $slot);
            }

            // ── GATE 5: User/badge is active ─────────────────────────────────
            if (!$user->is_active) {
                return $this->recordDenied($user, $mealSlotId, $badgeCode, $scannerUser, 'الشارة موقوفة — الحساب غير نشط.', $slot);
            }

            // ── GATE 6: Restaurant active ─────────────────────────────────────
            if (!$slot->restaurant->is_active) {
                return $this->recordDenied($user, $mealSlotId, $badgeCode, $scannerUser, 'المطعم مغلق أو غير نشط.', $slot);
            }

            // ── GATE 7: Entitlement check (user-level OR delegation-level) ────
            $entitled = MealEntitlement::where('meal_slot_id', $mealSlotId)
                ->where('status', 'ACTIVE')
                ->where(function ($q) use ($user) {
                    $q->where('user_id', $user->id)
                      ->orWhere('country_id', $user->country_id ?? null);
                })
                ->exists();

            if (!$entitled) {
                return $this->recordDenied($user, $mealSlotId, $badgeCode, $scannerUser,
                    "شارتك غير مخوّلة لهذه الوجبة في مطعم «{$slot->restaurant->name_ar}». راجع مسؤول الوفد.", $slot);
            }

            // ── GATE 8: Duplicate check ───────────────────────────────────────
            $alreadyScanned = MealScan::where('meal_slot_id', $mealSlotId)
                ->where('user_id', $user->id)
                ->where('status', 'AUTHORIZED')
                ->exists();

            if ($alreadyScanned) {
                $prevScan = MealScan::where('meal_slot_id', $mealSlotId)
                    ->where('user_id', $user->id)
                    ->where('status', 'AUTHORIZED')
                    ->latest('scanned_at')
                    ->first();

                $time = $prevScan?->scanned_at?->format('H:i') ?? '—';

                $scan = MealScan::create([
                    'uuid'                     => (string) Str::uuid(),
                    'meal_slot_id'             => $slot->id,
                    'user_id'                  => $user->id,
                    'scanned_by_user_id'       => $scannedByUserId,
                    'badge_code'               => $badgeCode,
                    'status'                   => 'DUPLICATE',
                    'denial_reason'            => "تم استهلاك هذه الوجبة مسبقاً عند الساعة {$time}.",
                    'participant_name_snapshot'=> $user->name,
                    'country_snapshot'         => $user->country?->name_ar ?? '',
                    'restaurant_snapshot'      => $slot->restaurant->name_ar,
                    'meal_type_snapshot'       => $slot->meal_type,
                    'scanned_at'               => now(),
                ]);

                return [
                    'status'  => 'DUPLICATE',
                    'message' => "⚠️ تم استهلاك هذه الوجبة مسبقاً عند الساعة {$time}.",
                    'user'    => $user,
                    'slot'    => $slot,
                    'scan'    => $scan,
                ];
            }

            // ── GATE 9: Capacity check (with lock already applied) ────────────
            $consumed = MealScan::where('meal_slot_id', $mealSlotId)
                ->where('status', 'AUTHORIZED')
                ->count();

            if ($consumed >= $slot->max_capacity) {
                return $this->recordDenied($user, $mealSlotId, $badgeCode, $scannerUser,
                    "وصل المطعم إلى الطاقة الاستيعابية القصوى ({$slot->max_capacity} شخص).", $slot);
            }

            // ── ✅ ALL GATES PASSED — AUTHORIZED ──────────────────────────────
            $scan = MealScan::create([
                'uuid'                     => (string) Str::uuid(),
                'meal_slot_id'             => $slot->id,
                'user_id'                  => $user->id,
                'scanned_by_user_id'       => $scannedByUserId,
                'badge_code'               => $badgeCode,
                'status'                   => 'AUTHORIZED',
                'denial_reason'            => null,
                'participant_name_snapshot'=> $user->name,
                'country_snapshot'         => $user->country?->name_ar ?? '',
                'restaurant_snapshot'      => $slot->restaurant->name_ar,
                'meal_type_snapshot'       => $slot->meal_type,
                'scanned_at'               => now(),
            ]);

            return [
                'status'  => 'AUTHORIZED',
                'message' => "✅ مسموح — بالصحة والهناء!",
                'user'    => $user,
                'slot'    => $slot,
                'scan'    => $scan,
            ];
        });
    }

    // ── Helper: record a DENIED scan ─────────────────────────────────────────
    private function recordDenied(?User $user, int $slotId, string $badgeCode, ?User $scanner, string $reason, ?MealSlot $slot): array
    {
        $scan = MealScan::create([
            'uuid'                     => (string) Str::uuid(),
            'meal_slot_id'             => $slotId,
            'user_id'                  => $user?->id,
            'scanned_by_user_id'       => $scanner?->id,
            'badge_code'               => $badgeCode,
            'status'                   => 'DENIED',
            'denial_reason'            => $reason,
            'participant_name_snapshot'=> $user?->name ?? 'غير معروف',
            'country_snapshot'         => $user?->country?->name_ar ?? '',
            'restaurant_snapshot'      => $slot?->restaurant?->name_ar ?? '',
            'meal_type_snapshot'       => $slot?->meal_type ?? '',
            'scanned_at'               => now(),
        ]);

        return [
            'status'  => 'DENIED',
            'message' => "❌ {$reason}",
            'user'    => $user,
            'slot'    => $slot,
            'scan'    => $scan,
        ];
    }
}
