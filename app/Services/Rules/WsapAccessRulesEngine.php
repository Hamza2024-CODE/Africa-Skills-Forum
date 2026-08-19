<?php

namespace App\Services\Rules;

use App\Models\AccessDecisionLog;
use App\Models\AuditLog;
use App\Models\Badge;
use App\Models\BadgeZonePermission;
use App\Models\MealEntitlement;
use App\Models\MealSlot;
use App\Models\ScheduleEvent;
use App\Models\User;
use App\Models\Zone;
use App\Services\Emergency\EmergencyControlService;
use Illuminate\Support\Facades\DB;

class WsapAccessRulesEngine
{
    protected EmergencyControlService $emergencyService;
    protected AntiPassbackEngine $antiPassbackEngine;

    public function __construct(?EmergencyControlService $emergencyService = null, ?AntiPassbackEngine $antiPassbackEngine = null)
    {
        $this->emergencyService   = $emergencyService ?: app(EmergencyControlService::class);
        $this->antiPassbackEngine = $antiPassbackEngine ?: app(AntiPassbackEngine::class);
    }

    /**
     * Universal access evaluation pipeline in WSAP V8.4.
     */
    public function evaluateAccess(
        string|int $badgeIdentifier,
        ?string $serviceType = null,
        ?string $serviceId = null,
        ?int $zoneId = null,
        ?string $scannerUserId = null
    ): array {
        $cleanBadge = trim((string) $badgeIdentifier);

        // Extract token or identifier if full URL passed
        if (str_contains($cleanBadge, 'http://') || str_contains($cleanBadge, 'https://')) {
            $parsedUrl = parse_url($cleanBadge);
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $queryParams);
                $extracted = $queryParams['token'] ?? $queryParams['query'] ?? $queryParams['reg'] ?? $queryParams['identifier'] ?? null;
                if (!empty($extracted)) {
                    $cleanBadge = trim($extracted);
                }
            }
            if (isset($parsedUrl['path'])) {
                $segments = array_filter(explode('/', $parsedUrl['path']));
                $lastSegment = end($segments);
                if ($lastSegment && !in_array($lastSegment, ['verify', 'badge', 'certificate', 'accreditation'])) {
                    $cleanBadge = rawurldecode($lastSegment);
                }
            }
        }

        // 1. Emergency Lockdown Check
        if ($serviceType && $this->emergencyService->isScopeLockedDown($serviceType, $serviceId)) {
            return $this->deny('EMERGENCY_LOCKDOWN_ACTIVE', 'الموقع أو الخدمة تحت وضع الإغلاق الأمني التام للطوارئ', 'Service under active emergency lockdown', null, $zoneId, $serviceType, $serviceId, $scannerUserId);
        }

        // 2. Resolve Badge
        $badgeQuery = Badge::with(['user.roles', 'user.country', 'user.participant.registrations'])
            ->where('access_token', $cleanBadge)
            ->orWhere('badge_uuid', $cleanBadge)
            ->orWhere('id', $cleanBadge);

        if (strlen($cleanBadge) >= 8) {
            $badgeQuery->orWhere('badge_uuid', 'like', $cleanBadge . '%')
                       ->orWhere('access_token', 'like', $cleanBadge . '%');
        }

        $badge = $badgeQuery->first();

        if (!$badge) {
            // Check lookup via Registration, User or DelegationMember
            $user = User::where('uuid', $cleanBadge)
                ->orWhere('email', $cleanBadge)
                ->orWhere('id', $cleanBadge)
                ->orWhereHas('participant.registrations', fn($r) => $r->where('registration_number', $cleanBadge)->orWhere('uuid', $cleanBadge)->orWhere('verification_token', $cleanBadge))
                ->first();

            if (!$user) {
                $reg = \App\Models\Registration::where('registration_number', $cleanBadge)
                    ->orWhere('uuid', $cleanBadge)
                    ->orWhere('verification_token', $cleanBadge)
                    ->first();
                if ($reg && $reg->participant) {
                    $user = $reg->participant->user;
                }
            }

            if ($user) {
                $badge = Badge::firstOrCreate(
                    ['user_id' => $user->id],
                    [
                        'badge_uuid'   => (string) \Illuminate\Support\Str::uuid(),
                        'access_token' => \Illuminate\Support\Str::random(32),
                        'status'       => 'ACTIVE',
                    ]
                );
                $badge->loadMissing(['user.roles', 'user.country', 'user.participant.registrations']);
            }
        }

        if (!$badge) {
            return $this->deny('BADGE_NOT_FOUND', 'الشارة غير معروفة في النظام', 'Unknown badge identifier', null, $zoneId, $serviceType, $serviceId, $scannerUserId);
        }

        // 3. Revocation / Loss Check
        if ($badge->status === 'LOST') {
            return $this->deny('BADGE_LOST', 'تم الإبلاغ عن فقدان هذه الشارة ومحظور استخدامها', 'Badge reported lost', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
        }

        if (in_array($badge->status, ['REVOKED', 'SUSPENDED', 'INACTIVE', 'BLOCKED'])) {
            return $this->deny('BADGE_REVOKED', 'الشارة ملغاة أو معلقة من قِبل إدارة الأمن', 'Badge is revoked or suspended', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
        }

        $user = $badge->user;
        if (!$user || !$user->is_active) {
            return $this->deny('USER_INACTIVE', 'حساب المستخدم المعني غير نشط', 'User account is inactive', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
        }

        // 4. Anti-Passback Check
        if ($serviceType && $this->antiPassbackEngine->isPassbackViolation($badge, $serviceType, $serviceId, 5)) {
            return $this->deny('ANTI_PASSBACK_VIOLATION', 'تنبيه منع التمرير المزدوج: تم مسح الشارة في هذا الموقع منذ أقل من 5 دقائق', 'Anti-passback rule violated', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
        }

        // 5. Zone Permission check (if zoneId provided)
        if ($zoneId) {
            $zone = Zone::find($zoneId);
            if ($zone && !$zone->is_active) {
                return $this->deny('ZONE_INACTIVE', 'منطقة الوصول المغلقة مؤقتاً', 'Zone is temporarily inactive', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
            }

            $zonePerm = BadgeZonePermission::where('badge_id', $badge->id)
                ->where('zone_id', $zoneId)
                ->first();

            if ($zonePerm && !$zonePerm->isValidAt(now())) {
                return $this->deny('ZONE_DENIED', 'الوصول لهذه المنطقة غير مسموح بهذه الشارة', 'Access to this zone is unauthorized for this badge', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
            }
        }

        // 6. Meal Slot Entitlement & Transaction-Safe Capacity check
        if ($serviceType === 'MEAL_SLOT' && $serviceId) {
            return $this->evaluateMealSlotAccess($badge, $user, (int) $serviceId, $zoneId, $scannerUserId);
        }

        // 7. Schedule Event Access check
        if ($serviceType === 'SCHEDULE_EVENT' && $serviceId) {
            $event = ScheduleEvent::find($serviceId);
            if (!$event || in_array($event->status, ['CANCELLED', 'ARCHIVED'])) {
                return $this->deny('EVENT_CANCELLED', 'الحدث غير متاح أو تم إلغاؤه', 'Event is unavailable or cancelled', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
            }
        }

        return $this->allow('ACCESS_GRANTED', 'تم منح إذن الوصول والموافقة 100%', 'Access authorized', $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
    }

    /**
     * Super Admin Emergency Override execution with mandatory audit reason.
     */
    public function evaluateAccessWithOverride(
        string|int $badgeIdentifier,
        string $overrideReasonAr,
        ?string $serviceType = null,
        ?string $serviceId = null,
        ?int $zoneId = null
    ): array {
        $cleanBadge = trim((string) $badgeIdentifier);
        $badge = Badge::where('access_token', $cleanBadge)
            ->orWhere('badge_uuid', $cleanBadge)
            ->orWhere('id', $cleanBadge)
            ->first();

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('audit_logs')) {
                AuditLog::create([
                    'event'       => 'SUPER_ADMIN_EMERGENCY_OVERRIDE',
                    'user_id'     => auth()->id() ?: 1,
                    'target_type' => Badge::class,
                    'target_id'   => $badge?->id ?? 0,
                    'meta'        => [
                        'reason'       => $overrideReasonAr,
                        'badge_uuid'   => $badge?->badge_uuid,
                        'service_type' => $serviceType,
                        'service_id'   => $serviceId,
                    ],
                ]);
            }
        } catch (\Throwable $e) {}

        return $this->allow('SUPER_ADMIN_OVERRIDE', "تجاوز طارئ مصرح به من مدير النظام: {$overrideReasonAr}", "Emergency Super Admin Override: {$overrideReasonAr}", $badge, $zoneId, $serviceType, $serviceId, auth()->id());
    }

    /**
     * Transaction-safe meal slot entitlement and capacity evaluation with pessimistic locking.
     */
    protected function evaluateMealSlotAccess(Badge $badge, User $user, int $slotId, ?int $zoneId, ?string $scannerUserId): array
    {
        return DB::transaction(function () use ($badge, $user, $slotId, $zoneId, $scannerUserId) {
            $slot = MealSlot::where('id', $slotId)->lockForUpdate()->first();

            if (!$slot || !$slot->is_open) {
                return $this->deny('MEAL_SLOT_CLOSED', 'فترة الوجبة مغلقة أو غير متاحة', 'Meal slot is closed', $badge, $zoneId, 'MEAL_SLOT', (string) $slotId, $scannerUserId);
            }

            if (!empty($slot->date) && !\Carbon\Carbon::parse($slot->date)->isToday()) {
                return $this->deny('MEAL_SLOT_OUTSIDE_DATE', 'موعد الوجبة خارج الإطار الزمني المسموح', 'Meal slot is outside valid time window', $badge, $zoneId, 'MEAL_SLOT', (string) $slotId, $scannerUserId);
            }

            $currentCount = $slot->scans()->count();
            if ($slot->max_capacity > 0 && $currentCount >= $slot->max_capacity) {
                return $this->deny('MEAL_CAPACITY_EXCEEDED', 'تم الوصول للحد الأقصى لاستيعاب هذا المطعم', 'Meal slot capacity exceeded', $badge, $zoneId, 'MEAL_SLOT', (string) $slotId, $scannerUserId);
            }

            $countryId = $user->country_id ?: $user->participant?->registrations?->first()?->country_id;

            $hasEntitlement = MealEntitlement::where('meal_slot_id', $slotId)
                ->where(function ($q) use ($user, $countryId) {
                    $q->where('user_id', $user->id);
                    if ($countryId) {
                        $q->orWhere('country_id', $countryId);
                    }
                })
                ->exists();

            if (!$hasEntitlement) {
                return $this->deny('MEAL_NOT_ENTITLED', 'هذا المطعم والوجبة غير مخصصين لهذا المستخدم', 'User is not entitled to this meal slot', $badge, $zoneId, 'MEAL_SLOT', (string) $slotId, $scannerUserId);
            }

            return $this->allow('MEAL_AUTHORIZED', 'الوجبة مخصصة ومصرح بها 100%', 'Meal access authorized', $badge, $zoneId, 'MEAL_SLOT', (string) $slotId, $scannerUserId);
        });
    }

    protected function allow(string $code, string $msgAr, string $msgEn, ?Badge $badge, ?int $zoneId, ?string $serviceType, ?string $serviceId, ?string $scannerUserId): array
    {
        $res = [
            'is_allowed'  => true,
            'reason_code' => $code,
            'message_ar'  => $msgAr,
            'message_en'  => $msgEn,
            'badge'       => $badge,
            'user'        => $badge?->user,
        ];
        $this->recordAccessDecision('ALLOW', $code, $msgAr, $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
        return $res;
    }

    protected function deny(string $code, string $msgAr, string $msgEn, ?Badge $badge, ?int $zoneId, ?string $serviceType, ?string $serviceId, ?string $scannerUserId): array
    {
        $res = [
            'is_allowed'  => false,
            'reason_code' => $code,
            'message_ar'  => $msgAr,
            'message_en'  => $msgEn,
            'badge'       => $badge,
            'user'        => $badge?->user,
        ];
        $this->recordAccessDecision('DENY', $code, $msgAr, $badge, $zoneId, $serviceType, $serviceId, $scannerUserId);
        return $res;
    }

    private function recordAccessDecision(string $decision, string $code, string $msgAr, ?Badge $badge, ?int $zoneId, ?string $serviceType, ?string $serviceId, ?string $scannerUserId): void
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('access_decision_logs')) {
                AccessDecisionLog::create([
                    'badge_id'          => $badge?->id,
                    'user_id'           => $badge?->user_id,
                    'service_type'      => $serviceType ?: 'GENERAL',
                    'service_id'        => $serviceId ? (string) $serviceId : null,
                    'zone_id'           => $zoneId,
                    'decision'          => $decision,
                    'reason_code'       => $code,
                    'reason_message_ar' => $msgAr,
                    'scanned_by'        => $scannerUserId ?: (auth()->id() ?: 1),
                    'scanned_at'        => now(),
                ]);
            }
        } catch (\Throwable $e) {}

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('audit_logs')) {
                AuditLog::create([
                    'event'       => 'ACCESS_' . $decision,
                    'user_id'     => $badge?->user_id ?? (auth()->id() ?: 1),
                    'target_type' => Badge::class,
                    'target_id'   => $badge?->id ?? 0,
                    'meta'        => [
                        'reason_code'  => $code,
                        'message_ar'   => $msgAr,
                        'badge_uuid'   => $badge?->badge_uuid,
                        'service_type' => $serviceType,
                        'service_id'   => $serviceId,
                        'zone_id'      => $zoneId,
                    ],
                ]);
            }
        } catch (\Throwable $e) {}
    }
}
