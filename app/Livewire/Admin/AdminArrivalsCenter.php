<?php

namespace App\Livewire\Admin;

use App\Models\DelegationArrival;
use App\Models\DelegationMember;
use App\Models\Country;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminArrivalsCenter extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterCountry = '';
    public string $filterStatus = 'ALL';
    public string $filterType = 'TICKETS_ONLY'; // TICKETS_ONLY default

    public ?DelegationMember $selectedMember = null;
    public bool $ticketModalOpen = false;

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterCountry(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }
    public function updatingFilterType(): void { $this->resetPage(); }

    public function openTicketModal(int $memberId): void
    {
        $this->selectedMember = DelegationMember::with(['delegation.country', 'skill'])->find($memberId);
        if ($this->selectedMember) {
            $this->ticketModalOpen = true;
        }
    }

    public function approveArrival(int $memberId): void
    {
        $member = DelegationMember::find($memberId);
        if ($member) {
            $member->update(['status' => 'APPROVED']);
            session()->flash('message', 'تم تأكيد واعتماد وصول وتذكرة العضو بنجاح.');
        }
    }

    public function render()
    {
        $query = DelegationMember::with(['delegation.country', 'skill']);

        if ($this->filterType === 'TICKETS_ONLY') {
            $query->where(function ($q) {
                $q->whereNotNull('flight_ticket_path')
                  ->orWhere(function ($sub) {
                      $sub->whereNotNull('arrival_flight')->where('arrival_flight', '!=', '');
                  });
            });
        }

        if (!empty($this->filterCountry)) {
            $query->whereHas('delegation', function ($q) {
                $q->where('country_id', $this->filterCountry);
            });
        }

        if (!empty($this->search)) {
            $s = '%' . $this->search . '%';
            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'like', $s)
                  ->orWhere('last_name', 'like', $s)
                  ->orWhere('passport_number', 'like', $s)
                  ->orWhere('arrival_flight', 'like', $s)
                  ->orWhere('departure_flight', 'like', $s);
            });
        }

        $members = $query->orderBy('id', 'desc')->paginate(15);

        // Also fetch delegation level arrivals
        $arrivalsQuery = DelegationArrival::with('country');
        if (!empty($this->filterCountry)) {
            $arrivalsQuery->where('country_id', $this->filterCountry);
        }
        $arrivals = $arrivalsQuery->orderBy('id', 'desc')->get();

        $countries = Country::where('is_active', true)->orderBy('name_ar')->get();

        $totalMembersWithTickets = DelegationMember::whereNotNull('flight_ticket_path')->count();
        $totalArrivalsCount = DelegationArrival::count();

        return view('livewire.admin.admin-arrivals-center', [
            'members'                 => $members,
            'arrivals'                => $arrivals,
            'countries'               => $countries,
            'totalMembersWithTickets' => $totalMembersWithTickets,
            'totalArrivalsCount'      => $totalArrivalsCount,
        ]);
    }
}
