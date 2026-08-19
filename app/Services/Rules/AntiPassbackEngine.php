<?php

namespace App\Services\Rules;

use App\Models\AccessDecisionLog;
use App\Models\Badge;

class AntiPassbackEngine
{
    /**
     * Verify if a scan violates the anti-passback buffer rule for a given badge and service.
     */
    public function isPassbackViolation(Badge $badge, string $serviceType, ?string $serviceId = null, int $bufferMinutes = 5): bool
    {
        try {
            if (!\Illuminate\Support\Facades\Schema::hasTable('access_decision_logs')) {
                return false;
            }

            $windowStart = now()->subMinutes($bufferMinutes);

            return AccessDecisionLog::where('badge_id', $badge->id)
                ->where('service_type', $serviceType)
                ->when($serviceId, fn($q) => $q->where('service_id', (string) $serviceId))
                ->where('decision', 'ALLOW')
                ->where('scanned_at', '>=', $windowStart)
                ->exists();
        } catch (\Throwable $e) {
            return false;
        }
    }
}
