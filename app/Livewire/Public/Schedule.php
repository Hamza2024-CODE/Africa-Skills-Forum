<?php

namespace App\Livewire\Public;

use App\Models\Edition;
use Livewire\Component;

class Schedule extends Component
{
    public function render()
    {
        $edition = Edition::where('is_active', true)->first();
        $dates = $edition ? $edition->dates()->where('is_active', true)->get() : collect();

        return view('livewire.public.schedule', [
            'edition' => $edition,
            'dates' => $dates,
        ])->layout('components.layouts.public');
    }
}
