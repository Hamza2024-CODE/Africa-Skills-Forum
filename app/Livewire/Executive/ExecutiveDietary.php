<?php

namespace App\Livewire\Executive;

use App\Models\MinisterialOfficial;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class ExecutiveDietary extends Component
{
    public array $requirements = [];
    public string $dietaryNotes = '';
    public string $flashMessage = '';

    public function mount()
    {
        $user = Auth::user();
        $minister = MinisterialOfficial::where('user_id', $user?->id)->first();

        if ($minister) {
            $notes = $minister->ministry_name ?? '';
            // We can store dietary info in minister model or user profile
            $this->dietaryNotes = $user->notes ?? '';
            $this->requirements = is_array($user->dietary_requirements ?? null) ? $user->dietary_requirements : [];
        } else {
            $this->requirements = is_array($user?->dietary_requirements ?? null) ? $user->dietary_requirements : [];
            $this->dietaryNotes = $user?->notes ?? '';
        }
    }

    public function toggleRequirement(string $code)
    {
        if (in_array($code, $this->requirements)) {
            $this->requirements = array_values(array_filter($this->requirements, fn($c) => $c !== $code));
        } else {
            $this->requirements[] = $code;
        }
    }

    public function saveDietaryInfo()
    {
        $user = Auth::user();
        if ($user) {
            $user->update([
                'dietary_requirements' => array_values(array_unique($this->requirements)),
                'notes' => trim($this->dietaryNotes),
            ]);
        }

        $this->flashMessage = __('messages.success') ?? 'تم حفظ خيارات وجبات الإطعام والتفضيلات الغذائية بنجاح';
    }

    public function render()
    {
        return view('livewire.executive.executive-dietary');
    }
}
