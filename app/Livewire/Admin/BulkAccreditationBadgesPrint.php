<?php

namespace App\Livewire\Admin;

use App\Models\Badge;
use App\Models\Country;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class BulkAccreditationBadgesPrint extends Component
{
    public string $filterRole = 'ALL';
    public string $filterCountry = '';
    public array $badgeItems = [];

    public function mount()
    {
        $this->filterRole = request()->get('role', 'ALL');
        $this->filterCountry = request()->get('country', '');
        $selectedIds = request()->get('ids', '');

        $query = User::with(['roles', 'country', 'participant.registrations.skill', 'badges']);

        if (!empty($selectedIds)) {
            $ids = array_filter(explode(',', $selectedIds));
            $query->whereIn('id', $ids);
        } else {
            if ($this->filterRole !== 'ALL') {
                $roleMap = [
                    'COMPETITOR'      => ['PARTICIPANT'],
                    'DELEGATION HEAD' => ['COUNTRY_ADMIN'],
                    'EXPERT JUDGE'    => ['JUDGE', 'EXPERT'],
                    'MEDIA'           => ['MEDIA_MANAGER'],
                    'VIP'             => ['EXECUTIVE_VIEWER'],
                    'ORGANIZER'       => ['ORGANIZATION_ADMIN', 'SUPER_ADMIN', 'NATIONAL_ADMIN'],
                ];

                if (isset($roleMap[$this->filterRole])) {
                    $query->whereHas('roles', fn($r) => $r->whereIn('name', $roleMap[$this->filterRole]));
                }
            }

            if (!empty($this->filterCountry)) {
                $query->where('country_id', $this->filterCountry);
            }
        }

        $users = $query->orderBy('name')->get();

        $this->badgeItems = [];
        foreach ($users as $user) {
            $userRole = $user->roles->first()?->name ?? 'PARTICIPANT';
            $roleConfig = $this->getRoleConfig($userRole);

            $badge = Badge::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'badge_uuid'   => (string) Str::uuid(),
                    'access_token' => Str::random(32),
                    'role_title'   => $roleConfig['titleEn'],
                    'status'       => 'ACTIVE',
                ]
            );

            $reg = Registration::with(['participant', 'country', 'skill'])
                ->whereHas('participant', fn($p) => $p->where('user_id', $user->id))
                ->latest()
                ->first();

            $token = $badge->access_token;
            $verifyUrl = route('verify', ['token' => $token]);
            $qrCodeUrl = \App\Services\QrCodeService::generateDataUri($verifyUrl, 250);

            $nameAr = $reg?->participant?->first_name_ar ? ($reg->participant->first_name_ar . ' ' . $reg->participant->last_name_ar) : $user->name;
            $nameLatin = $reg?->participant?->first_name_latin ? ($reg->participant->first_name_latin . ' ' . $reg->participant->last_name_latin) : ($user->email ?? 'Accredited Member');

            $this->badgeItems[] = [
                'id'          => $user->id,
                'user'        => $user,
                'roleTitle'   => $roleConfig['titleEn'],
                'roleConfig'  => $roleConfig,
                'token'       => $token,
                'qrCodeUrl'   => $qrCodeUrl,
                'nameAr'      => $nameAr,
                'nameLatin'   => $nameLatin,
                'country'     => $user->country?->name_ar ?? $reg?->country?->name_ar ?? 'إفريقيا',
                'skill'       => $reg?->skill?->name_ar ?? 'اعتماد عام',
            ];
        }
    }

    private function getRoleConfig(string $role): array
    {
        switch ($role) {
            case 'EXECUTIVE_VIEWER':
                return [
                    'titleAr'     => 'وزير / مسؤول تنفيذي ورئاسي (VIP)',
                    'titleEn'     => 'MINISTERIAL EXECUTIVE OBSERVER (VIP)',
                    'gradient'    => 'linear-gradient(135deg, #1E1B4B 0%, #06205C 40%, #B45309 100%)',
                    'stripeBg'    => '#D4AF37',
                    'stripeText'  => '#000000',
                    'accentColor' => '#F59E0B',
                    'zones'       => ['VIP', 'PLENARY', 'EXPO', 'PRESS', 'CATERING'],
                ];
            case 'KEYNOTE_SPEAKER':
            case 'PANELIST':
                return [
                    'titleAr'     => 'محاضر ومتحدث رئيسي',
                    'titleEn'     => 'KEYNOTE SPEAKER & PANELIST',
                    'gradient'    => 'linear-gradient(135deg, #3B0764 0%, #581C87 50%, #0284C7 100%)',
                    'stripeBg'    => '#7E22CE',
                    'stripeText'  => '#FFFFFF',
                    'accentColor' => '#38BDF8',
                    'zones'       => ['PLENARY', 'VIP', 'EXPO', 'CATERING'],
                ];
            case 'JUDGE':
            case 'EXPERT':
                return [
                    'titleAr'     => 'خبير دولي ومحكم متخصص',
                    'titleEn'     => 'INTERNATIONAL EXPERT & JUDGE',
                    'gradient'    => 'linear-gradient(135deg, #022C22 0%, #065F46 50%, #047857 100%)',
                    'stripeBg'    => '#059669',
                    'stripeText'  => '#FFFFFF',
                    'accentColor' => '#34D399',
                    'zones'       => ['EXPO', 'PLENARY', 'CATERING'],
                ];
            case 'COUNTRY_ADMIN':
                return [
                    'titleAr'     => 'رئيس وفد رسمي / مسؤول دولة',
                    'titleEn'     => 'HEAD OF OFFICIAL DELEGATION',
                    'gradient'    => 'linear-gradient(135deg, #030712 0%, #1E3A8A 50%, #0D9488 100%)',
                    'stripeBg'    => '#1D4ED8',
                    'stripeText'  => '#FFFFFF',
                    'accentColor' => '#60A5FA',
                    'zones'       => ['PLENARY', 'EXPO', 'CATERING'],
                ];
            case 'MEDIA_MANAGER':
                return [
                    'titleAr'     => 'إعلام وصحافة معتمدة',
                    'titleEn'     => 'OFFICIAL PRESS & MEDIA',
                    'gradient'    => 'linear-gradient(135deg, #451A03 0%, #9A3412 50%, #C2410C 100%)',
                    'stripeBg'    => '#EA580C',
                    'stripeText'  => '#FFFFFF',
                    'accentColor' => '#FDBA74',
                    'zones'       => ['PRESS', 'PLENARY', 'EXPO'],
                ];
            default:
                return [
                    'titleAr'     => 'زائر / ضيف معتمد',
                    'titleEn'     => 'APPROVED GUEST & VISITOR',
                    'gradient'    => 'linear-gradient(135deg, #042F2E 0%, #115E59 50%, #0F766E 100%)',
                    'stripeBg'    => '#0D9488',
                    'stripeText'  => '#FFFFFF',
                    'accentColor' => '#2DD4BF',
                    'zones'       => ['EXPO', 'CATERING'],
                ];
        }
    }

    public function render()
    {
        return view('livewire.admin.accreditations.bulk-print', [
            'countries' => Country::orderBy('name_ar')->get(),
        ]);
    }
}
