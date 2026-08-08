<?php

namespace App\Livewire\Public;

use Livewire\Component;

class Faq extends Component
{
    public function render()
    {
        return view('livewire.public.faq')->layout('components.layouts.public');
    }
}
