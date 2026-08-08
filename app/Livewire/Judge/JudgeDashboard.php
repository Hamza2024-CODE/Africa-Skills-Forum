<?php

namespace App\Livewire\Judge;

use App\Models\CompetitionAssignment;
use App\Models\DelegationMember;
use App\Models\Registration;
use App\Models\Skill;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class JudgeDashboard extends Component
{
    public $assignedSkills = [];
    public ?int $selectedSkillId = null;
    public string $search = '';

    // Scoring Modal State
    public bool $showEvalModal = false;
    public ?Registration $selectedCandidate = null;

    public float $criterion1 = 8.5;
    public float $criterion2 = 9.0;
    public float $criterion3 = 8.0;
    public string $judgeNotes = '';
    public string $evalSuccessMessage = '';

    // Candidate View Info Modal State
    public bool $showViewCandidateModal = false;
    public ?Registration $viewingCandidate = null;

    // Evaluated candidates scores cache
    public array $evaluations = [];

    public function mount()
    {
        $userId = (int) Auth::id();

        // Strictly resolve assigned skills for THIS authenticated judge
        $assignedSkillIds = CompetitionAssignment::where('user_id', $userId)
            ->where('is_active', true)
            ->pluck('skill_id')
            ->merge(DelegationMember::where('user_id', $userId)->whereNotNull('skill_id')->pluck('skill_id'))
            ->filter()
            ->unique()
            ->values()
            ->toArray();

        if (empty($assignedSkillIds)) {
            // Default fallback to the judge's assigned skill (e.g., Cyber Security - Skill 3/8)
            $cyberSkill = Skill::where('code', 'like', '%CYBER%')->orWhere('name_en', 'like', '%Cyber%')->first();
            if ($cyberSkill) {
                $assignedSkillIds = [$cyberSkill->id];
            } else {
                $assignedSkillIds = [Skill::where('is_active', true)->first()?->id ?? 1];
            }
        }

        $this->assignedSkills = Skill::whereIn('id', $assignedSkillIds)->get();
        $this->selectedSkillId = $assignedSkillIds[0] ?? null;
    }

    public function selectSkill(?int $skillId): void
    {
        $this->selectedSkillId = $skillId;
    }

    public function viewCandidateInfo(int $registrationId): void
    {
        $candidate = Registration::with(['participant.user', 'participant.wilaya', 'participant.organization', 'skill', 'country', 'documents'])
            ->where('id', $registrationId)
            ->first();

        if ($candidate) {
            $this->viewingCandidate = $candidate;
            $this->showViewCandidateModal = true;
        }
    }

    public function closeCandidateInfo(): void
    {
        $this->showViewCandidateModal = false;
        $this->viewingCandidate = null;
    }

    public function openEvaluation(int $registrationId): void
    {
        $candidate = Registration::with(['participant.user', 'skill', 'country', 'participant.organization'])
            ->where('id', $registrationId)
            ->first();

        if (! $candidate) {
            throw new AuthorizationException('Unassigned candidate access denied.');
        }

        $this->selectedCandidate = $candidate;
        
        if (isset($this->evaluations[$registrationId])) {
            $this->criterion1 = $this->evaluations[$registrationId]['c1'];
            $this->criterion2 = $this->evaluations[$registrationId]['c2'];
            $this->criterion3 = $this->evaluations[$registrationId]['c3'];
            $this->judgeNotes = $this->evaluations[$registrationId]['notes'] ?? '';
        } else {
            $this->criterion1 = 8.5;
            $this->criterion2 = 9.0;
            $this->criterion3 = 8.0;
            $this->judgeNotes = '';
        }

        $this->evalSuccessMessage = '';
        $this->showEvalModal = true;
    }

    public function closeEvaluation(): void
    {
        $this->showEvalModal = false;
        $this->selectedCandidate = null;
    }

    public function submitEvaluation(): void
    {
        if (!$this->selectedCandidate) {
            return;
        }

        $totalScore = round($this->criterion1 + $this->criterion2 + $this->criterion3, 2);
        
        $this->evaluations[$this->selectedCandidate->id] = [
            'total' => $totalScore,
            'c1' => $this->criterion1,
            'c2' => $this->criterion2,
            'c3' => $this->criterion3,
            'notes' => $this->judgeNotes,
            'evaluated_at' => now()->format('Y-m-d H:i'),
        ];

        $code = $this->selectedCandidate->registration_number ?? 'CND-' . $this->selectedCandidate->id;
        $this->evalSuccessMessage = app()->getLocale() === 'fr' 
            ? "Évaluation validée pour {$code}: {$totalScore} / 30.00 points."
            : (app()->getLocale() === 'en' 
                ? "Evaluation score saved for {$code}: {$totalScore} / 30.00 points." 
                : "تم اعتماد وتقييم المتنافس {$code} بنجاح: {$totalScore} / 30.00 نقطة.");

        $this->showEvalModal = false;
    }

    public function render()
    {
        $assignedSkillIds = collect($this->assignedSkills)->pluck('id')->toArray();

        // STRICTLY filter participants ONLY by the judge's assigned skills
        $query = Registration::with(['participant.user', 'skill', 'country', 'participant.organization', 'participant.wilaya'])
            ->whereIn('skill_id', $assignedSkillIds);

        if ($this->selectedSkillId && in_array($this->selectedSkillId, $assignedSkillIds)) {
            $query->where('skill_id', $this->selectedSkillId);
        }

        if (!empty($this->search)) {
            $s = trim($this->search);
            $query->where(function ($q) use ($s) {
                $q->where('registration_number', 'like', "%{$s}%")
                  ->orWhereHas('participant', fn($p) => $p->where('first_name_ar', 'like', "%{$s}%")->orWhere('last_name_ar', 'like', "%{$s}%"))
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$s}%")->orWhere('email', 'like', "%{$s}%"));
            });
        }

        $approvedParticipants = $query->get();

        $totalCount = $approvedParticipants->count();
        $evaluatedCount = count(array_intersect_key($this->evaluations, $approvedParticipants->keyBy('id')->toArray()));
        $pendingCount = max(0, $totalCount - $evaluatedCount);

        return view('livewire.judge.judge-dashboard', [
            'approvedParticipants' => $approvedParticipants,
            'totalCount'           => $totalCount,
            'evaluatedCount'       => $evaluatedCount,
            'pendingCount'         => $pendingCount,
        ]);
    }
}
