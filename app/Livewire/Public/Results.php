<?php

namespace App\Livewire\Public;

use Livewire\Component;

class Results extends Component
{
    public function render()
    {
        return view('livewire.public.results')->layout('components.layouts.public');
    }
}
