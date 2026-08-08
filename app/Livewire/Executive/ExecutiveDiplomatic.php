<?php

namespace App\Livewire\Executive;

use App\Models\DiplomaticMeeting;
use App\Models\DiplomaticMeetingRoom;
use App\Models\MinisterialOfficial;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class ExecutiveDiplomatic extends Component
{
    public bool $showBookingModal = false;
    public ?int $hostMinisterId = null;
    public ?int $guestMinisterId = null;
    public ?int $roomId = null;
    public string $meetingTitle = '';
    public string $purpose = '';
    public string $meetingDate = '';
    public string $startTime = '10:00';
    public string $endTime = '11:00';
    public string $notes = '';

    public string $flashMessage = '';
    public string $errorMessage = '';

    public function mount()
    {
        $this->meetingDate = now()->format('Y-m-d');
        $user = Auth::user();
        $min = MinisterialOfficial::where('user_id', $user?->id)->first();
        if ($min) {
            $this->hostMinisterId = $min->id;
        } else {
            $firstMin = MinisterialOfficial::first();
            $this->hostMinisterId = $firstMin?->id;
        }
    }

    public function openBookingModal(?int $targetRoomId = null)
    {
        if ($targetRoomId) {
            $this->roomId = $targetRoomId;
        }
        $this->showBookingModal = true;
    }

    public function closeModal()
    {
        $this->showBookingModal = false;
    }

    public function saveBooking()
    {
        $this->validate([
            'hostMinisterId' => 'required|exists:ministerial_officials,id',
            'guestMinisterId' => 'required|exists:ministerial_officials,id|different:hostMinisterId',
            'roomId'          => 'required|exists:diplomatic_meeting_rooms,id',
            'meetingTitle'    => 'required|string|min:3',
            'meetingDate'     => 'required|date',
            'startTime'       => 'required',
            'endTime'         => 'required',
        ]);

        $start = "{$this->meetingDate} {$this->startTime}:00";
        $end   = "{$this->meetingDate} {$this->endTime}:00";

        // Check room conflict
        $conflict = DiplomaticMeeting::where('room_id', $this->roomId)
            ->where('status', '!=', 'CANCELLED')
            ->where(function ($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                  ->orWhereBetween('end_time', [$start, $end]);
            })->exists();

        if ($conflict) {
            $this->errorMessage = 'عذراً! القاعة المختارة محجوزة بالفعل في هذا التوقيت المحدد.';
            return;
        }

        DiplomaticMeeting::create([
            'host_minister_id'  => $this->hostMinisterId,
            'guest_minister_id' => $this->guestMinisterId,
            'room_id'           => $this->roomId,
            'title'             => trim($this->meetingTitle),
            'purpose'           => trim($this->purpose),
            'start_time'        => $start,
            'end_time'          => $end,
            'status'            => 'SCHEDULED',
            'notes'             => trim($this->notes),
        ]);

        $this->flashMessage = 'تم حجز قاعة المباحثات الدبلوماسية وتأكيد موعد اللقاء الثنائي بنجاح.';
        $this->showBookingModal = false;
        $this->reset(['meetingTitle', 'purpose', 'notes']);
    }

    public function render()
    {
        $rooms = DiplomaticMeetingRoom::all();
        $ministers = MinisterialOfficial::with('country')->get();
        $user = Auth::user();
        $myMinister = MinisterialOfficial::where('user_id', $user?->id)->first();

        $myMeetings = DiplomaticMeeting::with(['hostMinister.country', 'guestMinister.country', 'room'])
            ->where(function($q) use ($myMinister) {
                if ($myMinister) {
                    $q->where('host_minister_id', $myMinister->id)
                      ->orWhere('guest_minister_id', $myMinister->id);
                }
            })
            ->orderBy('start_time', 'asc')
            ->get();

        if ($myMeetings->isEmpty()) {
            $myMeetings = DiplomaticMeeting::with(['hostMinister.country', 'guestMinister.country', 'room'])
                ->orderBy('start_time', 'asc')
                ->take(5)
                ->get();
        }

        return view('livewire.executive.executive-diplomatic', [
            'rooms'      => $rooms,
            'ministers'  => $ministers,
            'myMeetings' => $myMeetings,
        ]);
    }
}
