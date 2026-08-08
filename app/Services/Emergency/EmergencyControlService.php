<?php

namespace App\Services\Emergency;

use App\Models\AuditLog;
use App\Models\EmergencyLockdown;
use Illuminate\Support\Facades\DB;

class EmergencyControlService
{
    /**
     * Initiate instant emergency lockdown on a zone, restaurant, or service scope.
     */
    public function initiateLockdown(string $scope, ?string $targetId, string $titleAr, string $reasonAr): EmergencyLockdown
    {
        return DB::transaction(function () use ($scope, $targetId, $titleAr, $reasonAr) {
            $lockdown = EmergencyLockdown::create([
                'lockdown_scope' => $scope,
                'target_id'      => $targetId ? (string) $targetId : null,
                'title_ar'       => $titleAr,
                'reason_ar'      => $reasonAr,
                'is_active'      => true,
                'initiated_by'   => auth()->id() ?: 1,
                'initiated_at'   => now(),
            ]);

            AuditLog::create([
                'event'       => 'EMERGENCY_LOCKDOWN_INITIATED',
                'user_id'     => auth()->id() ?: 1,
                'target_type' => EmergencyLockdown::class,
                'target_id'   => $lockdown->id,
                'meta'        => [
                    'scope'     => $scope,
                    'target_id' => $targetId,
                    'reason'    => $reasonAr,
                ],
            ]);

            return $lockdown;
        });
    }

    /**
     * Lift an active emergency lockdown.
     */
    public function liftLockdown(EmergencyLockdown $lockdown): void
    {
        $lockdown->update([
            'is_active' => false,
            'lifted_at' => now(),
        ]);

        AuditLog::create([
            'event'       => 'EMERGENCY_LOCKDOWN_LIFTED',
            'user_id'     => auth()->id() ?: 1,
            'target_type' => EmergencyLockdown::class,
            'target_id'   => $lockdown->id,
            'meta'        => [
                'scope'     => $lockdown->lockdown_scope,
                'target_id' => $lockdown->target_id,
            ],
        ]);
    }

    /**
     * Check if a specific service scope or target is under active lockdown.
     */
    public function isScopeLockedDown(string $scope, ?string $targetId = null): bool
    {
        return EmergencyLockdown::where('is_active', true)
            ->where(function ($q) use ($scope, $targetId) {
                $q->where('lockdown_scope', 'ALL_SYSTEM')
                  ->orWhere('lockdown_scope', $scope)
                  ->when($targetId, fn($sub) => $sub->orWhere('target_id', (string) $targetId));
            })
            ->exists();
    }
}
