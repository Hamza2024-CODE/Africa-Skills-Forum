<?php

namespace App\Livewire\Public;

use Livewire\Component;

class Contact extends Component
{
    public $name = '';
    public $email = '';
    public $subject = '';
    public $message = '';

    public function submit()
    {
        $this->validate([
            'name' => 'required|min:2',
            'email' => 'required|email',
            'subject' => 'required|min:3',
            'message' => 'required|min:10',
        ]);

        $this->reset(['name', 'email', 'subject', 'message']);
        session()->flash('message', 'تم إرسال رسالتكم بنجاح إلى اللجنة التنفيذية لأولمبياد المهن.');
    }

    public function render()
    {
        return view('livewire.public.contact')->layout('components.layouts.public');
    }
}
