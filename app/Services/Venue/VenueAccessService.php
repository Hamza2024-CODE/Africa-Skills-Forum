<?php

namespace App\Services\Venue;

use App\Models\Badge;
use App\Models\User;
use App\Models\VenuePoi;
use App\Services\Rules\WsapAccessRulesEngine;

class VenueAccessService
{
    protected WsapAccessRulesEngine $rulesEngine;

    public function __construct(WsapAccessRulesEngine $rulesEngine)
    {
        $this->rulesEngine = $rulesEngine;
    }

    /**
     * Evaluate badge access status for a specific POI or Zone.
     */
    public function evaluateBadgeAccess(?User $user, VenuePoi $poi): array
    {
        if (!$user) {
            return [
                'access_status'    => 'PUBLIC_ONLY',
                'status_code'      => 'ALLOWED',
                'label_ar'         => 'متاح للجمهور والزوار',
                'is_allowed'       => true,
                'denial_reason_code' => null,
            ];
        }

        // Check if user is Super Admin or Admin
        if ($user->hasRole('SUPER_ADMIN') || $user->hasRole('ADMIN')) {
            return [
                'access_status'    => 'ADMIN_FULL',
                'status_code'      => 'ALLOWED',
                'label_ar'         => 'مسموح (صلاحيات إدارية كاملة)',
                'is_allowed'       => true,
                'denial_reason_code' => null,
            ];
        }

        // Evaluate POI access role
        $requiredRole = strtoupper($poi->access_role ?? 'ALL');

        if ($requiredRole === 'ALL' || $requiredRole === 'PUBLIC') {
            return [
                'access_status'    => 'PUBLIC_ALLOWED',
                'status_code'      => 'ALLOWED',
                'label_ar'         => 'مسموح لك بالدخول',
                'is_allowed'       => true,
                'denial_reason_code' => null,
            ];
        }

        // Check user role match
        if ($user->hasRole($requiredRole)) {
            return [
                'access_status'    => 'ROLE_ALLOWED',
                'status_code'      => 'ALLOWED',
                'label_ar'         => 'مسموح وفقاً لشارتك الرسمية',
                'is_allowed'       => true,
                'denial_reason_code' => null,
            ];
        }

        // Evaluate via WsapAccessRulesEngine if badge exists
        $badge = Badge::where('user_id', $user->id)->first();
        if ($badge) {
            $decision = $this->rulesEngine->evaluateAccess(
                $badge->access_token ?? $badge->badge_uuid ?? $badge->id,
                $poi->building->code ?? 'ZONE_GENERIC',
                $requiredRole
            );

            if (!empty($decision['granted'])) {
                return [
                    'access_status'    => 'BADGE_GRANTED',
                    'status_code'      => 'ALLOWED',
                    'label_ar'         => 'مسموح لشارتك الفعالة',
                    'is_allowed'       => true,
                    'denial_reason_code' => null,
                ];
            }
        }

        return [
            'access_status'    => 'RESTRICTED_DENIED',
            'status_code'      => 'DENIED',
            'label_ar'         => 'منطقة غير متاحة لشارتك (BADGE_ZONE_DENIED)',
            'is_allowed'       => false,
            'denial_reason_code' => 'BADGE_ZONE_DENIED',
            'icon_name'        => 'lock-keyhole',
        ];
    }
}
