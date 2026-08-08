<?php

namespace App\Livewire\Admin;

use App\Enums\ParticipantStatus;
use App\Models\Country;
use App\Models\Edition;
use App\Models\Registration;
use App\Models\Skill;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminRegistrationIndex extends Component
{
    use WithPagination;

    public string $search        = '';
    public string $filterStatus  = '';
    public string $filterCountry = '';
    public string $filterSkill   = '';
    public string $filterEdition = '';

    // Detail Drawer
    public bool          $drawerOpen          = false;
    public ?Registration $selectedRegistration = null;

    // Status change modal
    public bool    $statusModalOpen   = false;
    public ?int    $statusTargetId    = null;
    public string  $newStatus         = '';
    public string  $rejectionReason   = '';

    // Delete confirm
    public bool $deleteConfirmOpen = false;
    public bool $deleteModalOpen   = false;
    public bool $rejectModalOpen   = false;
    public ?int $deleteTargetId   = null;

    protected $queryString = ['search', 'filterStatus', 'filterCountry', 'filterSkill', 'filterEdition'];

    public function updatingSearch(): void        { $this->resetPage(); }
    public function updatingFilterStatus(): void  { $this->resetPage(); }
    public function updatingFilterCountry(): void { $this->resetPage(); }
    public function updatingFilterSkill(): void   { $this->resetPage(); }
    public function updatingFilterEdition(): void { $this->resetPage(); }

    /* ─── Drawer ─── */
    public function openDrawer(int $id): void
    {
        $this->selectedRegistration = Registration::with([
            'participant.user',
            'country',
            'skill',
            'edition',
            'documents',
        ])->findOrFail($id);
        $this->drawerOpen = true;
    }

    /* ─── Status Change ─── */
    public function openStatusModal(int $id, string $status): void
    {
        $this->statusTargetId  = $id;
        $this->newStatus       = $status;
        $this->rejectionReason = '';
        $this->statusModalOpen = true;
    }

    public function applyStatus(): void
    {
        $registration = Registration::findOrFail($this->statusTargetId);
        $updateData   = ['status' => $this->newStatus, 'reviewed_at' => now()];

        if ($this->newStatus === ParticipantStatus::REJECTED->value) {
            $updateData['rejection_reason'] = $this->rejectionReason;
        }

        $registration->update($updateData);
        $this->statusModalOpen = false;
        $this->selectedRegistration = null;
        $this->drawerOpen = false;
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم تحديث حالة التسجيل']);
    }

    public function approveRegistration(int $id): void
    {
        $reg = Registration::findOrFail($id);
        $reg->update(['status' => ParticipantStatus::APPROVED->value, 'reviewed_at' => now()]);
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم قبول طلب التسجيل']);
    }

    public function openRejectModal(int $id): void
    {
        $this->statusTargetId  = $id;
        $this->newStatus       = ParticipantStatus::REJECTED->value;
        $this->rejectionReason = '';
        $this->rejectModalOpen  = true;
    }

    public function rejectRegistration(): void
    {
        if ($this->statusTargetId) {
            $reg = Registration::findOrFail($this->statusTargetId);
            $reg->update([
                'status'           => ParticipantStatus::REJECTED->value,
                'rejection_reason' => $this->rejectionReason,
                'reviewed_at'      => now(),
            ]);
            $this->rejectModalOpen = false;
            $this->dispatch('notify', ['type' => 'warning', 'msg' => 'تم رفض طلب التسجيل']);
        }
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteRegistration(): void
    {
        if ($this->deleteTargetId) {
            Registration::findOrFail($this->deleteTargetId)->delete();
        }
        $this->deleteConfirmOpen = false;
        $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف التسجيل نهائياً']);
    }

    public function render()
    {
        $query = Registration::with(['participant.user', 'country', 'skill', 'edition'])
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('registration_number', 'like', '%'.$this->search.'%');
            }))
            ->when($this->filterStatus,  fn($q) => $q->where('status',     $this->filterStatus))
            ->when($this->filterCountry, fn($q) => $q->where('country_id', $this->filterCountry))
            ->when($this->filterSkill,   fn($q) => $q->where('skill_id',   $this->filterSkill))
            ->when($this->filterEdition, fn($q) => $q->where('edition_id', $this->filterEdition))
            ->orderByDesc('submitted_at')
            ->orderByDesc('created_at');

        $statuses = ParticipantStatus::cases();

        return view('livewire.admin.registrations.index', [
            'registrations' => $query->paginate(15),
            'statuses'      => $statuses,
            'countries'     => Country::orderBy('name_ar')->get(),
            'skills'        => Skill::where('is_active', true)->orderBy('name_ar')->get(),
            'editions'      => Edition::orderByDesc('year')->get(),
            'totalCount'         => Registration::count(),
            'totalRegistrations' => Registration::count(),
            'pendingCount'  => Registration::whereIn('status', [ParticipantStatus::SUBMITTED->value, ParticipantStatus::UNDER_REVIEW->value])->count(),
            'approvedCount' => Registration::where('status', ParticipantStatus::APPROVED->value)->count(),
            'rejectedCount' => Registration::where('status', ParticipantStatus::REJECTED->value)->count(),
        ]);
    }
}
