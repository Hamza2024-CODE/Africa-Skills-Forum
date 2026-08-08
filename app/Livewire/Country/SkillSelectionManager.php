<?php

namespace App\Livewire\Country;

use App\Models\Country;
use App\Models\CountrySkillSelection;
use App\Models\Edition;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class SkillSelectionManager extends Component
{
    public ?Edition $edition = null;
    public ?Country $country = null;
    public array $selectedSkills = [];
    public $allSkills = [];
    public string $search = '';
    public string $flashMessage = '';

    public function mount(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user && $user->country_id) {
            $this->country = Country::find($user->country_id);
        } else {
            $this->country = Country::where('iso2', 'DZ')->first() ?? Country::first();
        }

        $this->edition = Edition::where('is_active', true)->first();

        $this->loadData();
    }

    public function loadData(): void
    {
        if ($this->edition && $this->country) {
            $this->allSkills = Skill::where('is_active', true)->orderBy('sort_order')->get();

            $selections = CountrySkillSelection::where('edition_id', $this->edition->id)
                ->where('country_id', $this->country->id)
                ->get();

            $this->selectedSkills = $selections->pluck('status', 'skill_id')->toArray();
        }
    }

    public function toggleSkill(int $skillId): void
    {
        if (!$this->edition || !$this->country) return;

        if (array_key_exists($skillId, $this->selectedSkills)) {
            CountrySkillSelection::where('edition_id', $this->edition->id)
                ->where('country_id', $this->country->id)
                ->where('skill_id', $skillId)
                ->delete();

            unset($this->selectedSkills[$skillId]);
            $this->flashMessage = 'تمت إزالة التخصص من قائمة رغبات الوفد بنجاح.';
        } else {
            CountrySkillSelection::create([
                'edition_id'   => $this->edition->id,
                'country_id'   => $this->country->id,
                'skill_id'     => $skillId,
                'status'       => 'REQUESTED',
                'requested_at' => now(),
            ]);

            $this->selectedSkills[$skillId] = 'REQUESTED';
            $this->flashMessage = 'تمت إضافة وتحديد التخصص للوفد بنجاح.';
        }
    }

    public function render()
    {
        $filteredSkills = collect($this->allSkills)->filter(function ($skill) {
            if (empty($this->search)) return true;
            return str_contains(mb_strtolower($skill->name_ar), mb_strtolower($this->search)) ||
                   str_contains(mb_strtolower($skill->name_fr), mb_strtolower($this->search)) ||
                   str_contains(mb_strtolower($skill->code), mb_strtolower($this->search));
        });

        return view('livewire.country.skill-selection-manager', [
            'skills' => $filteredSkills
        ]);
    }
}
