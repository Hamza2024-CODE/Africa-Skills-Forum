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
        // Total Flights count (Matching Admin Arrivals Center /panel/arrivals)
        $totalMemberFlights = DelegationMember::where(function ($q) {
            $q->whereNotNull('flight_ticket_path')
              ->orWhere(function ($sub) {
                  $sub->whereNotNull('arrival_flight')->where('arrival_flight', '!=', '');
              });
        })->count();
        $totalDelegationArrivals = DelegationArrival::count();
        $totalFlights = $totalMemberFlights + $totalDelegationArrivals;

        // Fetch real flight tickets from DelegationMember (matching /panel/arrivals)
        $memberArrivals = DelegationMember::with(['delegation.country'])
            ->where(function ($q) {
                $q->whereNotNull('flight_ticket_path')
                  ->orWhere(function ($sub) {
                      $sub->whereNotNull('arrival_flight')->where('arrival_flight', '!=', '');
                  });
            })
            ->orderByDesc('id')
            ->get();

        // Delegation arrivals / group flight tickets list
        $groupArrivals = DelegationArrival::with('country')
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
            'arrivals' => $groupArrivals,
            'memberArrivals' => $memberArrivals,
        ]);
    }
}
