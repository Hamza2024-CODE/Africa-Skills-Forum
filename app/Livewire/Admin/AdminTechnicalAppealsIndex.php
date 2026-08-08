<?php

namespace App\Livewire\Admin;

use App\Models\TechnicalAppeal;
use App\Models\Skill;
use App\Services\AppealWorkflowService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminTechnicalAppealsIndex extends Component
{
    use WithPagination;

    public string $search        = '';
    public string $filterStatus  = '';
    public string $filterPriority = '';
    public bool   $drawerOpen    = false;
    public bool   $decisionModalOpen = false;
    public ?TechnicalAppeal $selected = null;

    // Decision form
    public string $decisionValue  = '';
    public string $decisionReason = '';

    // Transition
    public string $transitionTarget = '';

    public function openDrawer(int $id): void
    {
        $this->selected   = TechnicalAppeal::with(['skill', 'submittedBy', 'events.user', 'decision.decidedBy'])->findOrFail($id);
        $this->drawerOpen = true;
    }

    public function advanceAppealStatus(int $appealId, string $newStatus): void
    {
        $appeal = TechnicalAppeal::findOrFail($appealId);
        try {
            (new AppealWorkflowService())->transition($appeal, $newStatus, auth()->id());
            $this->selected = $appeal->fresh(['skill', 'submittedBy', 'events.user', 'decision.decidedBy']);
            session()->flash('success', 'تم تحديث حالة الطعن بنجاح.');
        } catch (\DomainException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function openDecisionModal(int $appealId): void
    {
        $this->selected         = TechnicalAppeal::findOrFail($appealId);
        $this->decisionValue    = '';
        $this->decisionReason   = '';
        $this->decisionModalOpen = true;
    }

    public function issueDecision(): void
    {
        $this->validate([
            'decisionValue'  => 'required|in:UPHELD,REJECTED,PARTIALLY_UPHELD',
            'decisionReason' => 'required|string|min:10',
        ]);

        try {
            (new AppealWorkflowService())->issueDecision(
                $this->selected,
                $this->decisionValue,
                $this->decisionReason,
                auth()->id()
            );
            session()->flash('success', 'تم إصدار القرار النهائي وتسجيله بصفة دائمة في سجل التدقيق.');
        } catch (\DomainException $e) {
            session()->flash('error', $e->getMessage());
        }

        $this->decisionModalOpen = false;
    }

    public function render()
    {
        $appeals = TechnicalAppeal::with(['skill', 'submittedBy'])
            ->when($this->search, fn($q) => $q->where('subject', 'like', "%{$this->search}%"))
            ->when($this->filterStatus,   fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterPriority, fn($q) => $q->where('priority', $this->filterPriority))
            ->orderByDesc('submitted_at')
            ->paginate(15);

        $service = new AppealWorkflowService();

        return view('livewire.admin.appeals.index', [
            'appeals'       => $appeals,
            'totalAppeals'  => TechnicalAppeal::count(),
            'openAppeals'   => TechnicalAppeal::whereNotIn('status', ['CLOSED'])->count(),
            'skills'        => Skill::where('is_active', true)->orderBy('name_ar')->get(),
            'service'       => $service,
        ]);
    }
}
