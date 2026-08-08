<?php

namespace App\Livewire\Admin;

use App\Models\CompetitionAssessmentModule;
use App\Models\CompetitionResult;
use App\Models\Edition;
use App\Models\ParticipantAssessment;
use App\Models\Skill;
use App\Services\CisScoringService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminCisEvaluationIndex extends Component
{
    use WithPagination;

    public string $activeTab   = 'modules'; // modules | skills | discrepancies | results
    public string $search      = '';
    public string $filterSkill = '';
    public bool   $moduleFormOpen = false;

    // Module form fields
    public ?int   $editingModuleId = null;
    public string $code            = '';
    public string $title_ar        = '';
    public string $title_fr        = '';
    public float  $max_score       = 100;
    public int    $skill_id_form   = 0;
    public ?int   $edition_id_form = null;

    protected array $rules = [
        'title_ar'       => 'required|string|max:200',
        'title_fr'       => 'required|string|max:200',
        'code'           => 'nullable|string|max:50',
        'max_score'      => 'required|numeric|min:0.01|max:9999',
        'skill_id_form'  => 'required|integer|min:1',
    ];

    public function setTab(string $tab): void
    {
        if (in_array($tab, ['modules', 'skills', 'discrepancies', 'results'])) {
            $this->activeTab = $tab;
        }
    }

    public function openCreate(): void
    {
        $this->reset(['editingModuleId', 'code', 'title_ar', 'title_fr', 'max_score', 'skill_id_form', 'edition_id_form']);
        $this->max_score     = 100;
        $this->moduleFormOpen = true;
    }

    public function openEdit(int $id): void
    {
        $m = CompetitionAssessmentModule::findOrFail($id);
        $this->editingModuleId = $m->id;
        $this->code           = $m->code ?? '';
        $this->title_ar       = $m->title_ar;
        $this->title_fr       = $m->title_fr;
        $this->max_score      = $m->max_score;
        $this->skill_id_form  = $m->skill_id;
        $this->edition_id_form = $m->edition_id;
        $this->moduleFormOpen  = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'code'       => $this->code ?: null,
            'title_ar'   => $this->title_ar,
            'title_fr'   => $this->title_fr,
            'max_score'  => $this->max_score,
            'skill_id'   => $this->skill_id_form,
            'edition_id' => $this->edition_id_form,
        ];

        if ($this->editingModuleId) {
            CompetitionAssessmentModule::findOrFail($this->editingModuleId)->update($data);
        } else {
            CompetitionAssessmentModule::create($data);
        }

        $this->moduleFormOpen = false;
        session()->flash('success', 'تم حفظ وحدة التقييم بنجاح.');
    }

    public function lockAssessment(int $assessmentId): void
    {
        try {
            (new CisScoringService())->lockAssessment($assessmentId, auth()->id());
            session()->flash('success', 'تم قفل التقييم بنجاح.');
        } catch (\DomainException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function calculateResults(int $skillId): void
    {
        $edition = Edition::where('is_active', true)->first() ?? Edition::first();
        if (!$edition) {
            session()->flash('error', 'لا توجد دورة نشطة.');
            return;
        }

        try {
            (new CisScoringService())->calculateResultsForSkill($skillId, $edition->id);
            session()->flash('success', 'تم احتساب النتائج والميداليات بنجاح عبر محرك التقييم الحسابي.');
        } catch (\DomainException $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function publishResults(int $skillId): void
    {
        CompetitionResult::where('skill_id', $skillId)->update([
            'is_published' => true,
            'published_at' => now(),
        ]);

        session()->flash('success', 'تم نشر نتائج التخصص رسمياً للجمهور والمشاركين.');
    }

    public function render()
    {
        $modules = CompetitionAssessmentModule::with(['skill'])
            ->when($this->search, fn ($q) => $q->where('title_ar', 'like', "%{$this->search}%"))
            ->when($this->filterSkill, fn ($q) => $q->where('skill_id', $this->filterSkill))
            ->paginate(15);

        $results = CompetitionResult::with(['registration.participant', 'skill'])
            ->orderBy('rank')
            ->take(30)
            ->get();

        // Discrepancy Detection Scan
        $service = new CisScoringService();
        $allDiscrepancies = [];
        $activeAssessments = ParticipantAssessment::where('is_locked', false)->take(20)->get();
        foreach ($activeAssessments as $asm) {
            $disc = $service->detectDiscrepancies($asm->id);
            if (!empty($disc)) {
                $allDiscrepancies = array_merge($allDiscrepancies, $disc);
            }
        }

        return view('livewire.admin.cis.index', [
            'modules'          => $modules,
            'results'          => $results,
            'discrepancies'    => $allDiscrepancies,
            'skills'           => Skill::where('is_active', true)->orderBy('name_ar')->get(),
            'editions'         => Edition::orderByDesc('year')->get(),
            'totalModules'     => CompetitionAssessmentModule::count(),
            'pendingResults'   => CompetitionResult::where('is_published', false)->count(),
            'publishedResults' => CompetitionResult::where('is_published', true)->count(),
        ]);
    }
}
