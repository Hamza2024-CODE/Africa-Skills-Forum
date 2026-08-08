<?php

namespace App\Livewire\Public;

use App\Models\GuideSection;
use App\Models\Skill;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class GuideRegulations extends Component
{
    public string $activeSection   = 'overview';
    public string $selectedSkillTd = 'td01_industrial_mechanics';
    public string $skillSearch     = '';

    public function mount(): void
    {
        if (request()->has('td')) {
            $this->selectedSkillTd = request()->get('td');
            $this->activeSection   = 'skills_td';
        } elseif (request()->has('section')) {
            $this->activeSection = request()->get('section');
        } else {
            $first = GuideSection::active()->where('section_key', 'not like', 'td%')->first();
            if ($first) {
                $this->activeSection = $first->section_key;
            }
        }
    }

    public function setSection(string $section): void
    {
        $this->activeSection = $section;
    }

    public function setSkillTd(string $tdKey): void
    {
        $this->selectedSkillTd = $tdKey;
        $this->activeSection   = 'skills_td';
    }

    public function render()
    {
        $allSections = GuideSection::active()->get();

        // Split core general sections vs skill TD sections
        $generalSections = $allSections->reject(fn($s) => str_starts_with($s->section_key, 'td'))->values();
        $skillTdSections = $allSections->filter(fn($s) => str_starts_with($s->section_key, 'td'))->values();

        // Filter skills search if needed
        if ($this->skillSearch !== '') {
            $filteredSkillTds = $skillTdSections->filter(function ($s) {
                return str_contains(mb_strtolower($s->title_ar ?? ''), mb_strtolower($this->skillSearch)) ||
                       str_contains(mb_strtolower($s->title_fr ?? ''), mb_strtolower($this->skillSearch)) ||
                       str_contains(mb_strtolower($s->section_key), mb_strtolower($this->skillSearch));
            })->values();
        } else {
            $filteredSkillTds = $skillTdSections;
        }

        $currentSection = null;
        if ($this->activeSection === 'skills_td') {
            $currentSection = $skillTdSections->firstWhere('section_key', $this->selectedSkillTd) 
                              ?? $skillTdSections->first();
        } else {
            $currentSection = $generalSections->firstWhere('section_key', $this->activeSection) 
                              ?? $generalSections->first();
        }

        return view('livewire.public.guide-regulations', [
            'generalSections'  => $generalSections,
            'skillTdSections'  => $skillTdSections,
            'filteredSkillTds' => $filteredSkillTds,
            'currentSection'   => $currentSection,
        ]);
    }
}
