<?php

namespace App\Livewire\Admin;

use App\Enums\RoleEnum;
use App\Models\Skill;
use App\Models\User;
use App\Models\CompetitionAssignment;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminJudgeIndex extends Component
{
    use WithPagination;

    public string $search      = '';
    public string $filterSkill = '';
    public string $filterStatus = '';

    // Assign form
    public bool   $assignFormOpen = false;
    public ?int   $selectedUserId = null;
    public ?int   $selectedSkillId = null;
    public string $assignmentType  = 'CHIEF_JUDGE';

    // Detail Drawer
    public bool  $drawerOpen  = false;
    public ?User $selectedJudge = null;

    // Revoke confirm
    public bool $revokeConfirmOpen  = false;
    public ?int $revokeAssignmentId = null;

    protected $queryString = ['search', 'filterSkill', 'filterStatus'];

    public function updatingSearch(): void      { $this->resetPage(); }
    public function updatingFilterSkill(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    /* ─── Assign ─── */
    public function openAssign(): void
    {
        $this->selectedUserId   = null;
        $this->selectedSkillId  = null;
        $this->assignmentType   = 'CHIEF_JUDGE';
        $this->assignFormOpen   = true;
    }

    public function saveAssignment(): void
    {
        $this->validate([
            'selectedUserId'  => 'required|integer|exists:users,id',
            'selectedSkillId' => 'required|integer|exists:skills,id',
            'assignmentType'  => 'required|string',
        ]);

        // Assign JUDGE role if not already
        $user = User::findOrFail($this->selectedUserId);
        if (!$user->hasRole(RoleEnum::JUDGE->value)) {
            $user->syncRoles([RoleEnum::JUDGE->value]);
        }

        CompetitionAssignment::create([
            'user_id'         => $this->selectedUserId,
            'skill_id'        => $this->selectedSkillId,
            'assignment_type' => $this->assignmentType,
            'assigned_by'     => auth()->id(),
            'assigned_at'     => now(),
            'is_active'       => true,
        ]);

        $this->assignFormOpen = false;
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم تعيين المحكم بنجاح']);
    }

    /* ─── Drawer ─── */
    public function openDrawer(int $userId): void
    {
        $this->selectedJudge = User::with([
            'competitionAssignments.skill',
            'competitionAssignments.assigner',
        ])->findOrFail($userId);
        $this->drawerOpen = true;
    }

    /* ─── Revoke ─── */
    public function confirmRevoke(int $assignmentId): void
    {
        $this->revokeAssignmentId = $assignmentId;
        $this->revokeConfirmOpen  = true;
    }

    public function revokeAssignment(): void
    {
        CompetitionAssignment::findOrFail($this->revokeAssignmentId)->update([
            'is_active'  => false,
            'revoked_at' => now(),
        ]);
        $this->revokeConfirmOpen = false;
        $this->drawerOpen        = false;
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم إلغاء التعيين']);
    }

    public function render()
    {
        // Users who are judges (via Spatie roles)
        $query = User::role(RoleEnum::JUDGE->value)
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name',  'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%');
            }))
            ->withCount(['competitionAssignments as active_assignments_count' => fn($q) => $q->where('is_active', true)]);

        if ($this->filterSkill) {
            $query->whereHas('competitionAssignments', fn($q) => $q->where('skill_id', $this->filterSkill)->where('is_active', true));
        }

        if ($this->filterStatus === 'active') {
            $query->whereHas('competitionAssignments', fn($q) => $q->where('is_active', true));
        } elseif ($this->filterStatus === 'inactive') {
            $query->whereDoesntHave('competitionAssignments', fn($q) => $q->where('is_active', true));
        }

        // Users that can be assigned as judges (don't already have JUDGE role)
        $availableUsers = User::whereDoesntHave('roles', fn($q) => $q->where('name', RoleEnum::JUDGE->value))
            ->orderBy('name')
            ->get();

        return view('livewire.admin.judges.index', [
            'judges'            => $query->orderBy('name')->paginate(15),
            'skills'            => Skill::where('is_active', true)->orderBy('name_ar')->get(),
            'availableUsers'    => $availableUsers,
            'totalJudges'       => User::role(RoleEnum::JUDGE->value)->count(),
            'activeAssignments' => CompetitionAssignment::where('is_active', true)->count(),
        ]);
    }
}
