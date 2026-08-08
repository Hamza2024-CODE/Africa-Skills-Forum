<?php

namespace App\Livewire\Public;

use App\Services\CertificateService;
use Livewire\Component;

class CertificateVerify extends Component
{
    public string $token = '';
    public ?array $result = null;

    public function mount(string $token): void
    {
        $this->token  = $token;
        $this->result = (new CertificateService())->verify($token);
    }

    public function render()
    {
        return view('livewire.public.certificate-verify', [
            'verifyStatus'  => $this->result['status'] ?? 'NOT_FOUND',
            'certificate'   => $this->result['certificate'] ?? null,
        ])->layout('components.layouts.public', ['title' => 'التحقق من صحة الشهادة']);
    }
}
