<?php

namespace App\Livewire\Public;

use Livewire\Component;

class Regulations extends Component
{
    public function render()
    {
        return view('livewire.public.regulations')->layout('components.layouts.public');
    }
}
