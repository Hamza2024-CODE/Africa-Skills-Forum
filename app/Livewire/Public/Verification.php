<?php

namespace App\Livewire\Public;

use App\Models\Registration;
use App\Models\RoomAllocation;
use App\Services\CertificateService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class Verification extends Component
{
    public string $query = '';
    public ?Registration $result = null;
    public ?RoomAllocation $accommodation = null;
    public string $lifecycleStatus = '';
    public bool $searched = false;
    public bool $isAuthorizedScanner = false;

    public function mount()
    {
        $user = Auth::user();
        if ($user instanceof \App\Models\User && ($user->hasRole(\App\Enums\RoleEnum::SUPER_ADMIN->value) || $user->canScanQr())) {
            $this->isAuthorizedScanner = true;
        }

        $token = request()->query('token') ?? request()->query('reg');
        if ($token) {
            $this->query = (string) $token;
            $this->verify();
        }
    }

    public function verify()
    {
        $this->searched = true;
        $cleanQuery = trim($this->query);

        if (empty($cleanQuery)) {
            $this->result = null;
            $this->lifecycleStatus = '';
            $this->accommodation = null;
            return;
        }

        $service = new CertificateService();
        
        $this->result = $service->verifyByToken($cleanQuery) 
            ?? $service->verifyByNumber($cleanQuery);

        if ($this->result) {
            $this->lifecycleStatus = $service->getLifecycleStatus($this->result);

            if ($this->isAuthorizedScanner && $this->result->participant_id) {
                $this->accommodation = RoomAllocation::with(['room.accommodation'])
                    ->where('participant_profile_id', $this->result->participant_id)
                    ->first();
            }
        }
    }

    public function render()
    {
        return view('livewire.public.verification');
    }
}
