<?php

namespace App\Livewire\Public;

use App\Models\Event;
use Livewire\Component;

class EventsIndex extends Component
{
    public function render()
    {
        $events = Event::where('status', 'PUBLISHED')->orderBy('start_at')->get();

        return view('livewire.public.events-index', [
            'events' => $events,
        ])->layout('components.layouts.public');
    }
}
