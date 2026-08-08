<?php

namespace App\Livewire\Executive;

use App\Models\DiplomaticMeeting;
use App\Models\DiplomaticMeetingRoom;
use App\Models\MinisterialOfficial;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class ExecutiveDashboard extends Component
{
    public int $totalMeetings = 0;
    public int $scheduledMeetings = 0;
    public int $inProgressMeetings = 0;
    public int $completedMeetings = 0;
    public int $cancelledMeetings = 0;

    public float $completionPercentage = 0.0;
    public float $scheduledPercentage = 0.0;
    public float $inProgressPercentage = 0.0;

    public int $totalRooms = 0;
    public string $selectedStatus = 'ALL';

    public function mount()
    {
        $this->loadMeetingMetrics();
    }

    public function updatedSelectedStatus()
    {
        $this->loadMeetingMetrics();
    }

    private function loadMeetingMetrics()
    {
        $user = Auth::user();
        $minister = MinisterialOfficial::where('user_id', $user?->id)->first();

        if ($minister) {
            $baseQuery = DiplomaticMeeting::where(function ($q) use ($minister) {
                $q->where('host_minister_id', $minister->id)
                  ->orWhere('guest_minister_id', $minister->id);
            });
        } else {
            $baseQuery = DiplomaticMeeting::query();
        }

        $this->totalMeetings     = (clone $baseQuery)->count();
        $this->scheduledMeetings  = (clone $baseQuery)->where('status', 'SCHEDULED')->count();
        $this->inProgressMeetings = (clone $baseQuery)->where('status', 'IN_PROGRESS')->count();
        $this->completedMeetings  = (clone $baseQuery)->where('status', 'COMPLETED')->count();
        $this->cancelledMeetings  = (clone $baseQuery)->where('status', 'CANCELLED')->count();

        $denom = max($this->totalMeetings, 1);
        $this->completionPercentage = round(($this->completedMeetings / $denom) * 100, 1);
        $this->scheduledPercentage  = round(($this->scheduledMeetings / $denom) * 100, 1);
        $this->inProgressPercentage = round(($this->inProgressMeetings / $denom) * 100, 1);

        $this->totalRooms = DiplomaticMeetingRoom::count();
    }

    public function render()
    {
        $user = Auth::user();
        $minister = MinisterialOfficial::where('user_id', $user?->id)->first();

        if ($minister) {
            $meetingsQuery = DiplomaticMeeting::with(['hostMinister.country', 'guestMinister.country', 'room'])
                ->where(function ($q) use ($minister) {
                    $q->where('host_minister_id', $minister->id)
                      ->orWhere('guest_minister_id', $minister->id);
                });
        } else {
            $meetingsQuery = DiplomaticMeeting::with(['hostMinister.country', 'guestMinister.country', 'room']);
        }

        if ($this->selectedStatus !== 'ALL') {
            $meetingsQuery->where('status', $this->selectedStatus);
        }

        $meetings = $meetingsQuery->orderBy('start_time', 'asc')->get();

        return view('livewire.executive.executive-dashboard', [
            'meetings' => $meetings,
            'minister' => $minister,
        ]);
    }
}
