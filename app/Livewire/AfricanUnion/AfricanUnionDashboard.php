<?php

namespace App\Livewire\AfricanUnion;

use App\Models\Country;
use App\Models\DelegationArrival;
use App\Models\Registration;
use App\Models\Zone;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AfricanUnionDashboard extends Component
{
    use WithPagination;

    public string $activeTab = 'overview'; // 'overview', 'nations', 'accreditations', 'zones', 'logistics'

    // Filtering for accreditations tab
    public string $search = '';
    public string $countryFilter = 'ALL';
    public string $roleFilter = 'ALL';
    public string $statusFilter = 'ALL';

    // Badge preview modal state
    public bool $showBadgeModal = false;
    public ?Registration $viewingRegistration = null;

    public function setTab(string $tab): void
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedCountryFilter(): void
    {
        $this->resetPage();
    }

    public function updatedRoleFilter(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function openBadgeModal(int $registrationId): void
    {
        $this->viewingRegistration = Registration::with('country')->find($registrationId);
        if ($this->viewingRegistration) {
            $this->showBadgeModal = true;
        }
    }

    public function closeBadgeModal(): void
    {
        $this->showBadgeModal = false;
        $this->viewingRegistration = null;
    }

    public function render()
    {
        // High-level statistics
        $totalParticipants = Registration::count();
        $totalCountries = Country::has('registrations')->count() ?: Country::count();
        $ministerialCount = Registration::where(function($q) {
            $q->whereHas('participant.user.roles', fn($r) => $r->whereIn('name', ['COUNTRY_ADMIN', 'VIP', 'EXECUTIVE_VIEWER', 'EXPERT']))
              ->orWhere('job_title', 'like', '%وزير%')
              ->orWhere('job_title', 'like', '%وفد%')
              ->orWhere('job_title', 'like', '%سفير%');
        })->count();

        $badgesApproved = Registration::where('status', 'APPROVED')->count();
        $totalFlights = DelegationArrival::count();

        // Countries list with delegate breakdown
        $africanCountries = Country::withCount('registrations')
            ->orderByDesc('registrations_count')
            ->get();

        // Query for Unified Accreditations Table
        $accreditationsQuery = Registration::with(['participant.user', 'country'])
            ->when(!empty($this->search), function ($q) {
                $term = '%' . $this->search . '%';
                $q->where(function ($sub) use ($term) {
                    $sub->where('registration_number', 'like', $term)
                        ->orWhere('job_title', 'like', $term)
                        ->orWhere('organization_name', 'like', $term)
                        ->orWhereHas('participant', fn($p) => 
                            $p->where('first_name_ar', 'like', $term)
                              ->orWhere('last_name_ar', 'like', $term)
                              ->orWhere('first_name_en', 'like', $term)
                              ->orWhere('last_name_en', 'like', $term)
                              ->orWhere('email', 'like', $term)
                              ->orWhere('passport_number', 'like', $term)
                        );
                });
            })
            ->when($this->countryFilter !== 'ALL', function ($q) {
                $q->where('country_id', $this->countryFilter);
            })
            ->when($this->statusFilter !== 'ALL', function ($q) {
                $q->where('status', $this->statusFilter);
            })
            ->orderByDesc('created_at');

        $accreditations = $accreditationsQuery->paginate(12);

        // Security Zones Definitions
        $securityZones = [
            [
                'code' => 'ZONE-01',
                'name_ar' => 'قاعة قمة الوزراء ومفوضية الاتحاد الأفريقي',
                'name_fr' => 'Plénière Ministérielle & Commission UA',
                'name_en' => 'Ministerial Plenary & AU Commission Hall',
                'access_level' => 'HIGH_SECURITY',
                'badge_color' => '#006837', // AU Deep Green
                'allowed_roles' => ['الوزراء الأفارقة', 'مفوضو الاتحاد الأفريقي', 'رؤساء الوفود الدبلوماسية', 'كبار الشخصيات VIP'],
            ],
            [
                'code' => 'ZONE-02',
                'name_ar' => 'قاعات الموائد المستديرة والاجتماعات المغلقة',
                'name_fr' => 'Salons des Tables Rondes & Réunions Bi-latérales',
                'name_en' => 'Ministerial Roundtables & Bilateral Lounges',
                'access_level' => 'RESTRICTED',
                'badge_color' => '#D4AF37', // AU Gold
                'allowed_roles' => ['الوفود الوزارية الرسمية', 'الخبراء المعتمدون', 'المسؤولون التنفيذيون'],
            ],
            [
                'code' => 'ZONE-03',
                'name_ar' => 'الصالون الشرفي وكبار الشخصيات VIP',
                'name_fr' => 'Salon d\'Honneur Executive & VIP Lounge',
                'name_en' => 'VIP Executive Protocol Lounge',
                'access_level' => 'PROTOCOL_ONLY',
                'badge_color' => '#0B2A6F', // Deep Navy
                'allowed_roles' => ['ضيوف الشرف', 'الدبلوماسيون', 'الرعاة البارزون'],
            ],
            [
                'code' => 'ZONE-04',
                'name_ar' => 'المركز الإعلامي الدولي والبث المباشر',
                'name_fr' => 'Centre de Presse International & TV',
                'name_en' => 'International Press & Broadcast Center',
                'access_level' => 'PRESS_MEDIA',
                'badge_color' => '#C0392B', // Media Red
                'allowed_roles' => ['الصحافة الدولية والمحلية', 'فرق التغطية والإعلام', 'مسؤولو التواصل'],
            ],
            [
                'code' => 'ZONE-05',
                'name_ar' => 'معرض تخصصات المهارات والورشات التخصصية',
                'name_fr' => 'Exposition des Métiers & Ateliers Techniques',
                'name_en' => 'Skills Exhibition & Technical Workshops',
                'access_level' => 'GENERAL_ACCESS',
                'badge_color' => '#24BDC3', // Teal
                'allowed_roles' => ['جميع المشاركين والزوار المعتمدين', 'المتنافسون والخبراء التقنيون'],
            ],
        ];

        // Delegation arrivals / flight tickets list
        $arrivals = DelegationArrival::with('country')
            ->orderByDesc('created_at')
            ->get();

        return view('livewire.african-union.dashboard', [
            'totalParticipants' => $totalParticipants,
            'totalCountries' => $totalCountries,
            'ministerialCount' => $ministerialCount,
            'badgesApproved' => $badgesApproved,
            'totalFlights' => $totalFlights,
            'africanCountries' => $africanCountries,
            'accreditations' => $accreditations,
            'securityZones' => $securityZones,
            'arrivals' => $arrivals,
        ]);
    }
}
