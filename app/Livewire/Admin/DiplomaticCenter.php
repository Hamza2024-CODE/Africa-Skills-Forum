<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use App\Models\DiplomaticMeeting;
use App\Models\DiplomaticMeetingRoom;
use App\Models\MinisterialOfficial;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class DiplomaticCenter extends Component
{
    // Filter & Tab states
    public string $activeTab = 'MEETINGS'; // MEETINGS, MINISTERS, ROOMS
    public string $searchQuery = '';
    public string $selectedStatus = 'ALL';

    // New Meeting Form
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

    // Minister Creation Form
    public bool $showAddMinisterModal = false;
    public ?int $newMinisterCountryId = null;
    public string $newMinisterName = '';
    public string $newMinisterTitleAr = '';
    public string $newMinisterTitleFr = '';
    public string $newMinisterTitleEn = '';
    public string $newMinisterMinistry = '';
    public string $newMinisterPhone = '';

    public string $flashMessage = '';
    public string $errorMessage = '';

    public function mount()
    {
        $this->showBookingModal = false;
        $this->showAddMinisterModal = false;
        $this->showCredentialModal = false;
        $this->meetingDate = now()->format('Y-m-d');
        
        $algMinister = MinisterialOfficial::where('title_ar', 'like', '%وزير%')->first();
        if ($algMinister) {
            $this->hostMinisterId = $algMinister->id;
        }
    }

    public function closeModal()
    {
        $this->showBookingModal = false;
        $this->showAddMinisterModal = false;
        $this->showCredentialModal = false;
        $this->credentialData = [];
        $this->errorMessage = '';
    }

    public function updateMinisterStatus(int $ministerId, string $status)
    {
        $minister = MinisterialOfficial::find($ministerId);
        if ($minister) {
            $minister->update(['availability_status' => $status]);
            $this->flashMessage = 'تم تحديث حالة توافر الوزير بنجاح';
        }
    }

    public function openBookingModal(?int $guestId = null, ?int $roomId = null)
    {
        $this->resetErrorBag();
        $this->errorMessage = '';

        if ($guestId) {
            $this->guestMinisterId = $guestId;
        }

        if ($roomId) {
            $this->roomId = $roomId;
        }

        $this->showBookingModal = true;
    }

    public function createBilateralMeeting()
    {
        $this->validate([
            'hostMinisterId'  => 'required|exists:ministerial_officials,id',
            'guestMinisterId' => 'required|exists:ministerial_officials,id|different:hostMinisterId',
            'roomId'          => 'required|exists:diplomatic_meeting_rooms,id',
            'meetingTitle'    => 'required|string|min:3',
            'meetingDate'     => 'required|date',
            'startTime'       => 'required',
            'endTime'         => 'required',
        ]);

        $startDateTime = Carbon::parse($this->meetingDate . ' ' . $this->startTime);
        $endDateTime   = Carbon::parse($this->meetingDate . ' ' . $this->endTime);

        if ($endDateTime->lte($startDateTime)) {
            $this->errorMessage = 'وقت نهاية الاجتماع يجب أن يكون بعد وقت البداية.';
            return;
        }

        // Check for room conflict
        $existingOverlap = DiplomaticMeeting::where('room_id', $this->roomId)
            ->where('status', '!=', 'CANCELLED')
            ->where(function ($q) use ($startDateTime, $endDateTime) {
                $q->whereBetween('start_time', [$startDateTime, $endDateTime])
                  ->orWhereBetween('end_time', [$startDateTime, $endDateTime])
                  ->orWhere(function ($q2) use ($startDateTime, $endDateTime) {
                      $q2->where('start_time', '<=', $startDateTime)
                         ->where('end_time', '>=', $endDateTime);
                  });
            })->exists();

        if ($existingOverlap) {
            $this->errorMessage = 'عذراً، القاعة محجوزة بالفعل في هذا التوقيت المح محدد. يرجى اختيار وقت آخر أو قاعة أخرى.';
            return;
        }

        DiplomaticMeeting::create([
            'host_minister_id'  => $this->hostMinisterId,
            'guest_minister_id' => $this->guestMinisterId,
            'room_id'           => $this->roomId,
            'title'             => trim($this->meetingTitle),
            'purpose'           => trim($this->purpose),
            'start_time'        => $startDateTime,
            'end_time'          => $endDateTime,
            'status'            => 'SCHEDULED',
            'notes'             => trim($this->notes),
            'created_by'        => Auth::id(),
        ]);

        // Update minister status to BUSY during that window
        $guest = MinisterialOfficial::find($this->guestMinisterId);
        if ($guest) {
            $guest->update(['availability_status' => 'BUSY']);
        }

        $this->flashMessage = 'تم حجز قاعة الاجتماعات الدبلوماسية وتثبيت موعد اللقاء الثنائي بنجاح';
        $this->showBookingModal = false;
        $this->reset(['meetingTitle', 'purpose', 'notes']);
    }

    public function cancelMeeting(int $meetingId)
    {
        $meeting = DiplomaticMeeting::find($meetingId);
        if ($meeting) {
            $meeting->update(['status' => 'CANCELLED']);
            $this->flashMessage = 'تم إلغاء موعد الاجتماع الدبلوماسي';
        }
    }

    // Credential Modal State
    public bool $showCredentialModal = false;
    public array $credentialData = [];

    public function showMinisterCredentials(int $ministerId)
    {
        $minister = MinisterialOfficial::with(['country', 'user'])->find($ministerId);
        if (!$minister) return;

        // If user account doesn't exist, create one now!
        if (!$minister->user) {
            $email = Str::slug($minister->full_name, '') . rand(100, 999) . '@gov.dz';
            $password = 'Ministry2026!';
            
            $user = \App\Models\User::create([
                'name'       => $minister->full_name,
                'email'      => $email,
                'password'   => \Illuminate\Support\Facades\Hash::make($password),
                'country_id' => $minister->country_id,
                'locale'     => 'ar',
                'is_active'  => true,
            ]);

            $minister->update(['user_id' => $user->id]);
            $minister->refresh();
        } else {
            $email = $minister->user->email;
            $password = 'Ministry2026!'; // Standard official initial password
        }

        $this->credentialData = [
            'name'       => $minister->full_name,
            'title'      => $minister->title_ar,
            'ministry'   => $minister->ministry_name,
            'country'    => $minister->country?->getLocalized('name') ?? 'الجزائر',
            'country_code' => $minister->country?->code ?? 'DZA',
            'email'      => $email,
            'password'   => $password,
        ];

        $this->showCredentialModal = true;
    }

    public function saveNewMinister()
    {
        $this->validate([
            'newMinisterName'      => 'required|string|min:3',
            'newMinisterTitleAr'   => 'required|string',
            'newMinisterMinistry'  => 'required|string',
            'newMinisterCountryId' => 'required|exists:countries,id',
        ]);

        $email = Str::slug($this->newMinisterName, '') . rand(100, 999) . '@gov.dz';
        $password = 'Ministry2026!';

        $user = \App\Models\User::create([
            'name'       => trim($this->newMinisterName),
            'email'      => $email,
            'password'   => \Illuminate\Support\Facades\Hash::make($password),
            'country_id' => $this->newMinisterCountryId,
            'locale'     => 'ar',
            'is_active'  => true,
        ]);

        $minister = MinisterialOfficial::create([
            'user_id'             => $user->id,
            'country_id'          => $this->newMinisterCountryId,
            'full_name'           => trim($this->newMinisterName),
            'title_ar'            => trim($this->newMinisterTitleAr),
            'title_fr'            => trim($this->newMinisterTitleFr),
            'title_en'            => trim($this->newMinisterTitleEn),
            'ministry_name'       => trim($this->newMinisterMinistry),
            'contact_phone'       => trim($this->newMinisterPhone),
            'availability_status' => 'AVAILABLE',
            'security_level'      => 'VIP_DIPLOMATIC',
        ]);

        $countryObj = Country::find($this->newMinisterCountryId);

        $this->credentialData = [
            'name'         => $minister->full_name,
            'title'        => $minister->title_ar,
            'ministry'     => $minister->ministry_name,
            'country'      => $countryObj?->getLocalized('name') ?? 'الجزائر',
            'country_code' => $countryObj?->code ?? 'DZA',
            'email'        => $email,
            'password'     => $password,
        ];

        $this->flashMessage = 'تمت إضافة المسؤول والوزير وإنشاء حساب الدخول الموحد بنجاح';
        $this->showAddMinisterModal = false;
        $this->showCredentialModal = true;

        $this->reset(['newMinisterName', 'newMinisterTitleAr', 'newMinisterTitleFr', 'newMinisterTitleEn', 'newMinisterMinistry', 'newMinisterPhone']);
    }

    public function render()
    {
        $ministersQuery = MinisterialOfficial::with(['country', 'hostedMeetings', 'guestMeetings']);

        if (!empty($this->searchQuery)) {
            $s = '%' . trim($this->searchQuery) . '%';
            $ministersQuery->where(function ($q) use ($s) {
                $q->where('full_name', 'like', $s)
                  ->orWhere('title_ar', 'like', $s)
                  ->orWhere('ministry_name', 'like', $s);
            });
        }

        $ministers = $ministersQuery->orderBy('country_id')->get();

        $meetingsQuery = DiplomaticMeeting::with(['hostMinister.country', 'guestMinister.country', 'room'])
            ->orderBy('start_time', 'asc');

        if ($this->selectedStatus !== 'ALL') {
            $meetingsQuery->where('status', $this->selectedStatus);
        }

        $meetings = $meetingsQuery->get();

        $rooms = DiplomaticMeetingRoom::with(['meetings' => function ($q) {
            $q->where('status', '!=', 'CANCELLED')
              ->whereDate('start_time', now()->toDateString());
        }])->get();

        $countries = Country::orderBy('name_ar')->get();

        // Statistics
        $totalMinistersCount = MinisterialOfficial::count();
        $availableMinistersCount = MinisterialOfficial::where('availability_status', 'AVAILABLE')->count();
        $scheduledMeetingsCount = DiplomaticMeeting::where('status', 'SCHEDULED')->count();
        $activeRoomsCount = DiplomaticMeetingRoom::where('status', 'AVAILABLE')->count();

        return view('livewire.admin.diplomatic-center', [
            'ministers'               => $ministers,
            'meetings'                => $meetings,
            'rooms'                   => $rooms,
            'countries'               => $countries,
            'totalMinistersCount'     => $totalMinistersCount,
            'availableMinistersCount' => $availableMinistersCount,
            'scheduledMeetingsCount'  => $scheduledMeetingsCount,
            'activeRoomsCount'        => $activeRoomsCount,
        ]);
    }
}
