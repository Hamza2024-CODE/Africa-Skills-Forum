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
        $this->isAuthorizedScanner = true;

        $token = request()->query('identifier') 
            ?? request()->query('token') 
            ?? request()->query('reg') 
            ?? request()->query('uuid') 
            ?? request()->query('query') 
            ?? request()->query('code') 
            ?? request()->query('id');

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

        $this->isAuthorizedScanner = true;

        if ($this->result) {
            $this->lifecycleStatus = $service->getLifecycleStatus($this->result);

            if ($this->result->participant_id) {
                try {
                    $this->accommodation = RoomAllocation::with(['room.accommodation'])
                        ->where('participant_profile_id', $this->result->participant_id)
                        ->first();
                } catch (\Throwable $e) {}
            }
        }
    }

    public function render()
    {
        return view('livewire.public.verification');
    }
}
