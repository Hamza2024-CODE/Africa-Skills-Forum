<?php

namespace App\Livewire\Participant;

use App\Enums\DateType;
use App\Models\Edition;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Services\DateEngine;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class ParticipantDashboard extends Component
{
    public $registration;
    public $profile;
    public $countdown = [];
    public int $journeyStep = 3;

    public function mount(DateEngine $dateEngine, ?int $targetParticipantId = null)
    {
        $user = Auth::user();

        // Strict Participant Profile IDOR Scoping
        if ($user) {
            $this->profile = ParticipantProfile::where('user_id', $user->id)->first();
            if ($targetParticipantId && $this->profile && $targetParticipantId !== $this->profile->id && !$user->hasRole('SUPER_ADMIN')) {
                throw new AuthorizationException('Cross-participant profile access denied.');
            }
        }

        if (!$this->profile) {
            $this->profile = ParticipantProfile::first();
        }

        if ($this->profile) {
            $this->registration = Registration::with('skill')->where('participant_id', $this->profile->id)->first();
        }

        if (!$this->registration) {
            $this->registration = Registration::with('skill')->first();
        }

        $edition = Edition::where('is_active', true)->first();
        if ($edition) {
            $this->countdown = $dateEngine->timeRemainingFormatted($edition->id, DateType::REGISTRATION);
        }
    }

    public function render()
    {
        return view('livewire.participant.participant-dashboard');
    }
}
