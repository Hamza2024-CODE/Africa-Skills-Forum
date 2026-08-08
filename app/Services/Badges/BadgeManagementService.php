<?php

namespace App\Services\Badges;

use App\Models\AuditLog;
use App\Models\Badge;
use App\Models\BadgeReplacement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BadgeManagementService
{
    /**
     * Revoke or suspend a badge immediately across all field services.
     */
    public function revokeBadge(Badge $badge, string $reasonAr, string $actionType = 'REVOKED'): BadgeReplacement
    {
        return DB::transaction(function () use ($badge, $reasonAr, $actionType) {
            $badge->update([
                'status' => 'BLOCKED',
            ]);

            $replacement = BadgeReplacement::create([
                'original_badge_id' => $badge->id,
                'user_id'           => $badge->user_id,
                'action_type'       => $actionType,
                'reason_ar'         => $reasonAr,
                'performed_by'      => auth()->id() ?: 1,
            ]);

            AuditLog::create([
                'event'       => 'BADGE_' . $actionType,
                'user_id'     => auth()->id() ?: 1,
                'target_type' => Badge::class,
                'target_id'   => $badge->id,
                'meta'        => [
                    'badge_uuid'  => $badge->badge_uuid,
                    'reason'      => $reasonAr,
                    'action_type' => $actionType,
                ],
            ]);

            return $replacement;
        });
    }

    /**
     * Issue a new replacement badge after loss/theft and transfer active zone permissions.
     */
    public function issueReplacementBadge(Badge $originalBadge, string $reasonAr): Badge
    {
        return DB::transaction(function () use ($originalBadge, $reasonAr) {
            // 1. Revoke original badge
            $this->revokeBadge($originalBadge, $reasonAr, 'LOST');

            // 2. Create new active replacement badge
            $newBadge = Badge::create([
                'user_id'          => $originalBadge->user_id,
                'role_title'       => $originalBadge->role_title,
                'allowed_zone_ids' => $originalBadge->allowed_zone_ids,
                'status'           => 'ACTIVE',
                'badge_uuid'       => (string) Str::uuid(),
                'access_token'     => Str::random(32),
            ]);

            // 3. Link replacement history
            BadgeReplacement::where('original_badge_id', $originalBadge->id)
                ->latest()
                ->first()
                ?->update(['replacement_badge_id' => $newBadge->id]);

            return $newBadge;
        });
    }
}
