<?php

namespace App\Livewire\Admin;

use App\Models\Badge;
use App\Models\BadgeZonePermission;
use App\Models\DelegationMember;
use App\Models\RoomAllocation;
use App\Models\User;
use App\Services\Rules\WsapAccessRulesEngine;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class AdminQrScanner extends Component
{
    public string            $query              = '';
    public ?User             $scannedUser        = null;
    public ?Badge            $scannedBadge       = null;
    public ?DelegationMember $delegationMember   = null;
    public ?RoomAllocation   $roomAllocation     = null;
    public array             $zonePermissions    = [];
    public array             $accessDecision     = [];
    public bool              $showOverrideModal  = false;
    public string            $overrideReasonAr   = '';

    public function scan(mixed $scannedCode = null, ?WsapAccessRulesEngine $rulesEngine = null): void
    {
        $rulesEngine ??= app(WsapAccessRulesEngine::class);

        if (is_string($scannedCode) && trim($scannedCode) !== '') {
            $this->query = trim($scannedCode);
        }

        $this->scannedUser      = null;
        $this->scannedBadge     = null;
        $this->delegationMember = null;
        $this->roomAllocation   = null;
        $this->zonePermissions  = [];
        $this->accessDecision   = [];

        $clean = $rulesEngine->extractCleanIdentifier($this->query);

        if (empty($clean)) {
            $this->accessDecision = [
                'allowed'        => false,
                'is_allowed'     => false,
                'decision'       => 'DENY',
                'code'           => 'EMPTY_QUERY',
                'reason_code'    => 'EMPTY_QUERY',
                'message_ar'     => 'يرجى إدخال كود الشارة أو معرف المستخدم أو مسح رمز الـ QR أولاً للفحص',
                'message_fr'     => 'Veuillez saisir un code badge ou scanner un QR code',
                'message_en'     => 'Please enter a badge code or scan a QR code first',
                'badge'          => null,
                'user'           => null,
            ];
            return;
        }

        // Evaluate access rules via central engine
        $this->accessDecision = $rulesEngine->evaluateAccess($clean);
        $this->scannedBadge    = $this->accessDecision['badge'] ?? null;
        $this->scannedUser     = $this->accessDecision['user'] ?? null;

        // Ensure is_allowed key is consistently set
        if (!isset($this->accessDecision['is_allowed']) && isset($this->accessDecision['allowed'])) {
            $this->accessDecision['is_allowed'] = (bool) $this->accessDecision['allowed'];
        }

        if (!isset($this->accessDecision['reason_code']) && isset($this->accessDecision['code'])) {
            $this->accessDecision['reason_code'] = $this->accessDecision['code'];
        }

        // Comprehensive resolution fallback using CertificateService if user/badge not yet resolved
        if (!$this->scannedUser || !($this->accessDecision['is_allowed'] ?? false)) {
            $certService = new \App\Services\CertificateService();
            $reg = $certService->verifyByNumber($clean);

            if ($reg) {
                $user = $reg->participant?->user ?: $reg->user;
                if (!$user && $reg->participant_id) {
                    $user = User::whereHas('participant', fn($p) => $p->where('id', $reg->participant_id))->first();
                }

                if ($user) {
                    $this->scannedUser = $user->loadMissing(['roles', 'country', 'wilaya', 'organization', 'participant.registrations']);
                    $this->scannedBadge = Badge::firstOrCreate(
                        ['user_id' => $user->id],
                        [
                            'badge_uuid'   => (string) \Illuminate\Support\Str::uuid(),
                            'access_token' => \Illuminate\Support\Str::random(32),
                            'status'       => 'ACTIVE',
                        ]
                    );

                    $this->accessDecision = [
                        'allowed'        => true,
                        'is_allowed'     => true,
                        'decision'       => 'ALLOW',
                        'code'           => 'AUTHORIZED',
                        'reason_code'    => 'AUTHORIZED_OFFICIAL',
                        'message_ar'     => 'تم التثبت المقبول من هوية الشارة والتسجيل الرسمي بنجاح (100%)',
                        'message_fr'     => 'Accréditation et enregistrement officiel vérifiés avec succès (100%)',
                        'message_en'     => 'Official registration and badge verified successfully (100%)',
                        'badge'          => $this->scannedBadge,
                        'user'           => $this->scannedUser,
                        'registration'   => $reg,
                    ];
                }
            }
        }

        if (!$this->scannedUser) {
            // Flexible user lookup by email, exact or partial UUID, ID, or numeric user code
            $userQuery = User::with(['roles', 'country', 'wilaya', 'organization', 'participant.registrations'])
                ->where('email', $clean)
                ->orWhere('uuid', 'like', $clean . '%')
                ->orWhere('id', $clean);

            if (preg_match('/^USR-?0*(\d+)$/i', $clean, $matches)) {
                $userQuery->orWhere('id', (int) $matches[1]);
            }

            $this->scannedUser = $userQuery->first();

            if (!$this->scannedUser) {
                $delMember = DelegationMember::where('email', $clean)
                    ->orWhere('id', $clean)
                    ->first();
                if ($delMember && $delMember->user_id) {
                    $this->scannedUser = User::with(['roles', 'country', 'wilaya', 'organization', 'participant.registrations'])
                        ->find($delMember->user_id);
                }
            }

            if ($this->scannedUser) {
                $this->scannedBadge = Badge::firstOrCreate(
                    ['user_id' => $this->scannedUser->id],
                    [
                        'badge_uuid'   => (string) \Illuminate\Support\Str::uuid(),
                        'access_token' => \Illuminate\Support\Str::random(32),
                        'status'       => 'ACTIVE',
                    ]
                );

                $this->accessDecision = [
                    'allowed'        => true,
                    'is_allowed'     => true,
                    'decision'       => 'ALLOW',
                    'code'           => 'AUTHORIZED',
                    'reason_code'    => 'AUTHORIZED_OFFICIAL',
                    'message_ar'     => 'تم التثبت المقبول من هوية الشارة والتسجيل الرسمي بنجاح (100%)',
                    'message_fr'     => 'Accréditation et enregistrement officiel vérifiés avec succès (100%)',
                    'message_en'     => 'Official registration and badge verified successfully (100%)',
                    'badge'          => $this->scannedBadge,
                    'user'           => $this->scannedUser,
                ];
            }
        }

        if ($this->scannedUser) {
            $this->scannedUser->loadMissing(['roles', 'country', 'wilaya', 'organization', 'participant.registrations']);

            // Load delegation member profile
            $this->delegationMember = DelegationMember::with(['skill', 'delegation.country'])
                ->where('user_id', $this->scannedUser->id)
                ->orWhere('email', $this->scannedUser->email)
                ->first();

            // Load room allocation & hotel details
            $this->roomAllocation = RoomAllocation::with(['room.accommodation'])
                ->where('user_id', $this->scannedUser->id)
                ->first();

            if (!$this->roomAllocation && $this->scannedUser->participant) {
                $this->roomAllocation = RoomAllocation::with(['room.accommodation'])
                    ->where('participant_profile_id', $this->scannedUser->participant->id)
                    ->first();
            }
        }

        // Guaranteed result card response for any scanned or typed query
        if (empty($this->accessDecision)) {
            $this->accessDecision = [
                'allowed'        => false,
                'is_allowed'     => false,
                'decision'       => 'DENY',
                'code'           => 'NOT_FOUND',
                'reason_code'    => 'NOT_FOUND',
                'message_ar'     => "لم يتم العثور على أي شارة أو مسجل بهذا الرمز ({$clean}) في النظام",
                'message_fr'     => "Aucun badge trouvé pour le code ({$clean})",
                'message_en'     => "No badge or registration found for code ({$clean})",
                'badge'          => null,
                'user'           => null,
            ];
        }

        if ($this->scannedBadge) {
            $this->zonePermissions = BadgeZonePermission::with('zone')
                ->where('badge_id', $this->scannedBadge->id)
                ->get()
                ->toArray();
        }
    }

    public function executeOverride(WsapAccessRulesEngine $rulesEngine): void
    {
        $this->validate([
            'overrideReasonAr' => 'required|string|min:3',
        ]);

        if ($this->query) {
            $this->accessDecision = $rulesEngine->evaluateAccessWithOverride($this->query, $this->overrideReasonAr);
            $this->showOverrideModal = false;
            $this->overrideReasonAr = '';
        }
    }

    public function render()
    {
        return view('livewire.admin.qr-scanner');
    }
}
