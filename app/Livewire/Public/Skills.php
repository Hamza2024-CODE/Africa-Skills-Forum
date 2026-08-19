<?php

namespace App\Livewire\Public;

use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\SkillEquipment;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class Skills extends Component
{
    public string $search = '';
    public string $selectedCategory = '';

    // Modal State
    public bool $showModal = false;
    public ?Skill $selectedSkill = null;
    public ?\App\Models\GuideSection $selectedGuideSection = null;
    public $selectedSkillEquipments = [];

    public function mount(): void
    {
        if (request()->has('skill')) {
            $this->openSkillDetails((int) request('skill'));
        }
    }

    private function findSkillWithRelations(int $skillId): ?Skill
    {
        $relations = ['category'];
        if (\Illuminate\Support\Facades\Schema::hasTable('competition_assessment_modules')) {
            $relations[] = 'assessmentModules.criteria';
        }
        return Skill::with($relations)->find($skillId);
    }

    public function openSkillDetails(int $skillId): void
    {
        $this->selectedSkill = $this->findSkillWithRelations($skillId);
        if ($this->selectedSkill) {
            if (\Illuminate\Support\Facades\Schema::hasTable('skill_equipment')) {
                $this->selectedSkillEquipments = SkillEquipment::with('equipmentItem')->where('skill_id', $skillId)->get();
            } else {
                $this->selectedSkillEquipments = collect();
            }
            
            $num = null;
            if (!empty($this->selectedSkill->code) && preg_match('/(\d+)/', (string) $this->selectedSkill->code, $m)) {
                $num = (int) $m[1];
            } elseif (!empty($this->selectedSkill->id)) {
                $num = (int) $this->selectedSkill->id;
            }

            if ($num) {
                $prefix = 'td' . str_pad($num, 2, '0', STR_PAD_LEFT) . '_';
                $this->selectedGuideSection = \App\Models\GuideSection::where('section_key', 'like', $prefix . '%')->first();
            } else {
                $this->selectedGuideSection = null;
            }
            
            $this->showModal = true;
        }
    }

    public function openPdfViewer(int $skillId): void
    {
        $this->selectedSkill = $this->findSkillWithRelations($skillId);
        if ($this->selectedSkill) {
            $num = null;
            if (!empty($this->selectedSkill->code) && preg_match('/(\d+)/', (string) $this->selectedSkill->code, $m)) {
                $num = (int) $m[1];
            } elseif (!empty($this->selectedSkill->id)) {
                $num = (int) $this->selectedSkill->id;
            }

            if ($num) {
                $prefix = 'td' . str_pad($num, 2, '0', STR_PAD_LEFT) . '_';
                $this->selectedGuideSection = \App\Models\GuideSection::where('section_key', 'like', $prefix . '%')->first();
            } else {
                $this->selectedGuideSection = null;
            }

            $pdfUrl = $this->selectedSkill->getPdfUrl();
            $pdfTitle = $this->selectedSkill->code . ' — ' . $this->selectedSkill->getLocalized('name');
            $this->dispatch('open-pdf-viewer', pdfUrl: $pdfUrl, pdfTitle: $pdfTitle);
        }
    }

    public function closeSkillDetails(): void
    {
        $this->showModal = false;
        $this->selectedSkill = null;
        $this->selectedGuideSection = null;
        $this->selectedSkillEquipments = [];
    }

    public function render()
    {
        $categories = SkillCategory::all();

        $skills = Skill::where('is_active', true)
            ->when($this->selectedCategory, fn($q) => $q->where('category_id', $this->selectedCategory))
            ->when($this->search, fn($q) => $q->where('name_ar', 'like', "%{$this->search}%")
                ->orWhere('code', 'like', "%{$this->search}%")
                ->orWhere('name_fr', 'like', "%{$this->search}%"))
            ->orderBy('sort_order')
            ->get();

        return view('livewire.public.skills', [
            'categories' => $categories,
            'skills' => $skills,
        ]);
    }
}
