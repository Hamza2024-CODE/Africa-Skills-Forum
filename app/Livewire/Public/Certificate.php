<?php

namespace App\Livewire\Public;

use App\Models\Registration;
use App\Services\CertificateService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class Certificate extends Component
{
    public ?Registration $registration = null;
    public string $lifecycleStatus = '';

    public function mount(string $number)
    {
        $service = new CertificateService();

        $this->registration = $service->verifyByNumber($number) 
            ?? $service->verifyByToken($number);

        if (!$this->registration) {
            abort(404, 'الشهادة المطلوب الاستعلام عنها غير موجودة أو كود التوثيق غير صحيح.');
        }

        $this->lifecycleStatus = $service->getLifecycleStatus($this->registration);
    }

    public function render()
    {
        return view('livewire.public.certificate');
    }
}
