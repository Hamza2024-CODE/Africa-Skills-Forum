<?php

namespace App\Livewire\Public;

use App\Models\Event;
use Livewire\Component;

class EventsIndex extends Component
{
    public string $selectedCategory = '';
    public string $search = '';

    public function render()
    {
        $events = Event::where('status', 'PUBLISHED')
            ->when($this->search, fn($q) => $q->where(function($sub) {
                $sub->where('title_ar', 'like', "%{$this->search}%")
                    ->orWhere('title_fr', 'like', "%{$this->search}%")
                    ->orWhere('title_en', 'like', "%{$this->search}%")
                    ->orWhere('summary_ar', 'like', "%{$this->search}%");
            }))
            ->when($this->selectedCategory, fn($q) => $q->where(function($sub) {
                $typeMap = [
                    'meetings' => ['لقاءات', 'B2B', 'Recontres', 'Meetings'],
                    'lectures' => ['محاضرات', 'Conférences', 'Lectures', 'Keynote'],
                    'assemblies' => ['اجتماعات', 'Assemblées', 'Assemblies', 'Réunions'],
                    'high_level' => ['جلسات رفيعة المستوى', 'Haut Niveau', 'High Level', 'Sessions'],
                    'seminars' => ['ندوات', 'Séminaires', 'Seminars', 'Symposium'],
                ];
                if (isset($typeMap[$this->selectedCategory])) {
                    foreach ($typeMap[$this->selectedCategory] as $keyword) {
                        $sub->orWhere('title_ar', 'like', "%{$keyword}%")
                            ->orWhere('title_fr', 'like', "%{$keyword}%")
                            ->orWhere('summary_ar', 'like', "%{$keyword}%");
                    }
                }
            }))
            ->orderBy('start_at')
            ->get();

        return view('livewire.public.events-index', [
            'events' => $events,
        ])->layout('components.layouts.public');
    }
}
