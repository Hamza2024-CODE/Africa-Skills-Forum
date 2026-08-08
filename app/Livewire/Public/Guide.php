<?php

namespace App\Livewire\Public;

use Livewire\Component;

class Guide extends Component
{
    public function render()
    {
        return view('livewire.public.guide')->layout('components.layouts.public');
    }
}
