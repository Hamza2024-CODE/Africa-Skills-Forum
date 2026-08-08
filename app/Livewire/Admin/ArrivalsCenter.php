<?php

namespace App\Livewire\Admin;

use App\Models\DelegationArrival;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class ArrivalsCenter extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = 'ALL';
    public string $airportFilter = 'ALL';
    
    // In-Platform Preview Modal State
    public bool $previewModalOpen = false;
    public ?int $selectedArrivalId = null;
    public ?DelegationArrival $selectedArrival = null;

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingStatusFilter(): void { $this->resetPage(); }
    public function updatingAirportFilter(): void { $this->resetPage(); }

    public function openTicketPreview(int $id): void
    {
        $arrival = DelegationArrival::with('country')->find($id);
        if ($arrival) {
            $this->selectedArrivalId = $arrival->id;
            $this->selectedArrival = $arrival;
            $this->previewModalOpen = true;
        }
    }

    public function closeTicketPreview(): void
    {
        $this->previewModalOpen = false;
        $this->selectedArrivalId = null;
        $this->selectedArrival = null;
    }

    public function approveArrival(int $id, string $shuttleName = 'حافلة بروتوكولية معتمدة'): void
    {
        $arrival = DelegationArrival::find($id);
        if ($arrival) {
            $arrival->update([
                'status' => 'APPROVED',
                'shuttle_assigned' => $shuttleName,
            ]);

            if ($this->selectedArrival && $this->selectedArrival->id === $id) {
                $this->selectedArrival->refresh();
            }

            session()->flash('message', __('messages.arrival_approved') ?? 'تم اعتماد استقبال الرحلة وتخصيص الحافلة البروتوكولية بنجاح!');
        }
    }

    public function render()
    {
        $query = DelegationArrival::with('country');

        if (!empty($this->search)) {
            $s = '%' . trim($this->search) . '%';
            $query->where(function ($q) use ($s) {
                $q->where('airline_name', 'like', $s)
                  ->orWhere('flight_number', 'like', $s)
                  ->orWhere('arrival_airport', 'like', $s)
                  ->orWhereHas('country', function ($cq) use ($s) {
                      $cq->where('name_ar', 'like', $s)
                        ->orWhere('name_en', 'like', $s)
                        ->orWhere('code', 'like', $s);
                  });
            });
        }

        if ($this->statusFilter !== 'ALL') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->airportFilter !== 'ALL') {
            $query->where('arrival_airport', 'like', '%' . $this->airportFilter . '%');
        }

        $arrivals = $query->latest('arrival_date')->paginate(15);

        // Real Database Metric Stats
        $totalArrivalsCount = DelegationArrival::count();
        $totalDelegatesCount = (int) DelegationArrival::sum('passenger_count');
        $pendingCount = DelegationArrival::where('status', 'PENDING')->count();
        $approvedCount = DelegationArrival::where('status', 'APPROVED')->count();

        return view('livewire.admin.arrivals-center', [
            'arrivals' => $arrivals,
            'totalArrivalsCount' => $totalArrivalsCount,
            'totalDelegatesCount' => $totalDelegatesCount,
            'pendingCount' => $pendingCount,
            'approvedCount' => $approvedCount,
        ]);
    }
}
