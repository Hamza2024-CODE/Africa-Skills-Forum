<?php

namespace App\Livewire\Public;

use App\Services\SettingsEngine;
use Livewire\Component;

class Guide extends Component
{
    public array $forumData = [];

    public function mount(SettingsEngine $settings)
    {
        $locale = app()->getLocale();
        $this->forumData = [
            'name'             => $settings->get("forum.name_{$locale}") ?: $settings->get('forum.name_ar'),
            'slogan'           => $settings->get("forum.slogan_{$locale}") ?: $settings->get('forum.slogan_ar'),
            'dates'            => $settings->get("forum.dates_{$locale}") ?: $settings->get('forum.dates_ar'),
            'principle'        => $settings->get("forum.principle_{$locale}") ?: $settings->get('forum.principle_ar'),
            'description'      => $settings->get("forum.description_{$locale}") ?: $settings->get('forum.description_ar'),
            'stat_countries'   => $settings->get('forum.stat_countries', '+30'),
            'stat_ministers'   => $settings->get('forum.stat_ministers', '+20'),
            'stat_roundtables' => $settings->get('forum.stat_roundtables', '2'),
            'stat_panels'      => $settings->get('forum.stat_panels', '5+'),
        ];
    }

    public function render()
    {
        return view('livewire.public.guide')->layout('components.layouts.public');
    }
}

