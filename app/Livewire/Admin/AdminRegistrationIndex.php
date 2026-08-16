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
    public string $filterRole    = '';

    // Bulk selection
    public array $selectedIds = [];
    public bool $selectAll = false;

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

    protected $queryString = ['search', 'filterStatus', 'filterCountry', 'filterSkill', 'filterEdition', 'filterRole'];

    public function updatingSearch(): void        { $this->resetPage(); }
    public function updatingFilterStatus(): void  { $this->resetPage(); }
    public function updatingFilterCountry(): void { $this->resetPage(); }
    public function updatingFilterSkill(): void   { $this->resetPage(); }
    public function updatingFilterEdition(): void { $this->resetPage(); }
    public function updatingFilterRole(): void    { $this->resetPage(); }

    public function resetFilters(): void
    {
        $this->reset(['search', 'filterStatus', 'filterCountry', 'filterSkill', 'filterEdition', 'filterRole', 'selectedIds', 'selectAll']);
        $this->resetPage();
    }

    public function updatedSelectAll($value): void
    {
        if ($value) {
            $this->selectedIds = $this->getFilteredQuery()->pluck('id')->map(fn($id) => (string)$id)->all();
        } else {
            $this->selectedIds = [];
        }
    }

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

    /* ─── Status Actions ─── */
    public function approveRegistration(int $id): void
    {
        $reg = Registration::findOrFail($id);
        $reg->update(['status' => ParticipantStatus::APPROVED->value, 'reviewed_at' => now()]);
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم قبول واعتماد طلب التسجيل بنجاح']);
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

    public function approveSelected(): void
    {
        if (empty($this->selectedIds)) return;
        Registration::whereIn('id', $this->selectedIds)->update([
            'status' => ParticipantStatus::APPROVED->value,
            'reviewed_at' => now()
        ]);
        $this->selectedIds = [];
        $this->selectAll = false;
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم اعتماد الطلبات المحددة بنجاح']);
    }

    public function printSelected(): void
    {
        if (empty($this->selectedIds)) return;
        $ids = implode(',', $this->selectedIds);
        $this->redirect(route('admin.accreditations.batch-print', ['ids' => $ids]));
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

    private function getFilteredQuery()
    {
        return Registration::with(['participant.user', 'country', 'skill', 'edition'])
            ->when($this->search, fn($q) => $q->where(function ($sq) {
                $term = '%'.$this->search.'%';
                $sq->where('registration_number', 'like', $term)
                   ->orWhere('verification_token', 'like', $term)
                   ->orWhereHas('participant', fn($p) => 
                       $p->where('first_name_ar', 'like', $term)
                         ->orWhere('last_name_ar', 'like', $term)
                         ->orWhere('first_name_fr', 'like', $term)
                         ->orWhere('last_name_fr', 'like', $term)
                         ->orWhere('email', 'like', $term)
                         ->orWhere('phone', 'like', $term)
                         ->orWhere('national_id', 'like', $term)
                         ->orWhere('passport_number', 'like', $term)
                   )
                   ->orWhereHas('participant.user', fn($u) => 
                       $u->where('name', 'like', $term)
                         ->orWhere('email', 'like', $term)
                   );
            }))
            ->when($this->filterStatus,  fn($q) => $q->where('status',     $this->filterStatus))
            ->when($this->filterCountry, fn($q) => $q->where('country_id', $this->filterCountry))
            ->when($this->filterSkill,   fn($q) => $q->where('skill_id',   $this->filterSkill))
            ->when($this->filterEdition, fn($q) => $q->where('edition_id', $this->filterEdition))
            ->when($this->filterRole, function($q) {
                $role = strtoupper($this->filterRole);
                if ($role === 'VISITOR' || $role === 'PARTICIPANT') {
                    $q->where(function($subQ) {
                        $subQ->where(function($innerQ) {
                            $innerQ->whereHas('participant.user.roles', fn($rQ) => $rQ->whereIn('name', ['VISITOR', 'PARTICIPANT']))
                                   ->orWhereHas('user.roles', fn($rQ) => $rQ->whereIn('name', ['VISITOR', 'PARTICIPANT']));
                        })
                        ->whereDoesntHave('participant.user.roles', fn($rQ) => $rQ->whereIn('name', ['EXPERT', 'SPEAKER', 'COUNTRY_ADMIN', 'MEDIA_MANAGER']))
                        ->whereDoesntHave('user.roles', fn($rQ) => $rQ->whereIn('name', ['EXPERT', 'SPEAKER', 'COUNTRY_ADMIN', 'MEDIA_MANAGER']));
                    });
                } elseif ($role === 'COUNTRY_ADMIN') {
                    $q->where(function($subQ) {
                        $subQ->whereHas('participant.user.roles', fn($rQ) => $rQ->where('name', 'COUNTRY_ADMIN'))
                             ->orWhereHas('user.roles', fn($rQ) => $rQ->where('name', 'COUNTRY_ADMIN'))
                             ->orWhere('job_title', 'like', '%وزير%')
                             ->orWhere('job_title', 'like', '%وفد%')
                             ->orWhereHas('participant.user', fn($uQ) => $uQ->where('position', 'like', '%وزير%')->orWhere('position', 'like', '%وفد%'));
                    });
                } else {
                    $q->where(function($subQ) use ($role) {
                        $subQ->whereHas('participant.user.roles', fn($rQ) => $rQ->where('name', $role))
                             ->orWhereHas('user.roles', fn($rQ) => $rQ->where('name', $role));
                    });
                }
            })
            ->orderByDesc('submitted_at')
            ->orderByDesc('created_at');
    }

    public function render()
    {
        $query = $this->getFilteredQuery();

        $statuses = ParticipantStatus::cases();

        return view('livewire.admin.registrations.index', [
            'registrations'      => $query->paginate(15),
            'statuses'           => $statuses,
            'countries'          => Country::orderBy('name_ar')->get(),
            'skills'             => Skill::where('is_active', true)->orderBy('name_ar')->get(),
            'editions'           => Edition::orderByDesc('year')->get(),
            'totalCount'         => Registration::count(),
            'totalRegistrations' => Registration::count(),
            'pendingCount'       => Registration::whereIn('status', [ParticipantStatus::PENDING->value, ParticipantStatus::SUBMITTED->value, ParticipantStatus::UNDER_REVIEW->value, 'PENDING', 'pending'])->count(),
            'approvedCount'      => Registration::whereIn('status', [ParticipantStatus::APPROVED->value, 'APPROVED', 'approved'])->count(),
            'rejectedCount'      => Registration::whereIn('status', [ParticipantStatus::REJECTED->value, 'REJECTED', 'rejected'])->count(),
        ]);
    }
}
