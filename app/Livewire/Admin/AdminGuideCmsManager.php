<?php

namespace App\Livewire\Admin;

use App\Models\GuideSection;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class AdminGuideCmsManager extends Component
{
    public string $activeSectionKey = 'overview';

    public string $title_ar = '';
    public string $title_fr = '';
    public string $title_en = '';

    public string $body_ar = '';
    public string $body_fr = '';
    public string $body_en = '';

    public string $icon_svg = '';
    public int $sort_order = 1;
    public bool $is_active = true;

    public string $successMessage = '';

    public function mount(): void
    {
        $first = GuideSection::orderBy('sort_order')->first();
        if ($first) {
            $this->loadSection($first->section_key);
        }
    }

    public function loadSection(string $key): void
    {
        $this->activeSectionKey = $key;
        $this->successMessage = '';

        $section = GuideSection::where('section_key', $key)->first();
        if ($section) {
            $this->title_ar = $section->title_ar ?? '';
            $this->title_fr = $section->title_fr ?? '';
            $this->title_en = $section->title_en ?? '';

            $this->body_ar = $section->body_ar ?? '';
            $this->body_fr = $section->body_fr ?? '';
            $this->body_en = $section->body_en ?? '';

            $this->icon_svg = $section->icon_svg ?? '';
            $this->sort_order = $section->sort_order;
            $this->is_active = $section->is_active;
        }
    }

    public function saveSection(): void
    {
        GuideSection::updateOrCreate(
            ['section_key' => $this->activeSectionKey],
            [
                'title_ar'   => $this->title_ar,
                'title_fr'   => $this->title_fr,
                'title_en'   => $this->title_en,
                'body_ar'    => $this->body_ar,
                'body_fr'    => $this->body_fr,
                'body_en'    => $this->body_en,
                'icon_svg'   => $this->icon_svg,
                'sort_order' => $this->sort_order,
                'is_active'  => $this->is_active,
            ]
        );

        $this->successMessage = 'تم حفظ البيانات وتحديث الصفحة بنجاح في قاعدة البيانات (AR / FR / EN).';
    }

    public function render()
    {
        $sections = GuideSection::orderBy('sort_order')->get();
        return view('livewire.admin.admin-guide-cms-manager', compact('sections'));
    }
}
