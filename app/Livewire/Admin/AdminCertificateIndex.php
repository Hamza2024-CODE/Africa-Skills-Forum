<?php

namespace App\Livewire\Admin;

use App\Models\Certificate;
use App\Models\Registration;
use App\Models\Skill;
use App\Services\CertificateService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminCertificateIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterType   = '';
    public string $filterStatus = '';
    public bool   $formOpen     = false;

    // Issue form
    public int    $registration_id  = 0;
    public string $certificate_type = 'PARTICIPATION';

    public function openCreate(): void
    {
        $this->reset(['registration_id', 'certificate_type']);
        $this->certificate_type = 'PARTICIPATION';
        $this->formOpen         = true;
    }

    public function issue(): void
    {
        $this->validate([
            'registration_id'  => 'required|integer|min:1',
            'certificate_type' => 'required|string',
        ]);

        $reg = Registration::find($this->registration_id);
        if ($reg) {
            (new CertificateService())->issue(
                $reg->user?->id ?? 1,
                $this->certificate_type,
                $reg->id,
                $reg->skill_id
            );
            $this->formOpen = false;
            session()->flash('success', 'تم استخراج وإصدار الشهادة الرسمية بنجاح.');
        }
    }

    public function render()
    {
        $registrations = Registration::with(['participant.user', 'country', 'skill', 'organization', 'wilaya'])
            ->where('status', 'APPROVED')
            ->when($this->search, function ($q) {
                $s = '%' . $this->search . '%';
                $q->where('registration_number', 'like', $s)
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', $s)->orWhere('email', 'like', $s))
                  ->orWhereHas('participant', fn($p) => $p->where('first_name_ar', 'like', $s)->orWhere('last_name_ar', 'like', $s));
            })
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('livewire.admin.certificates.index', [
            'registrations' => $registrations,
            'certificates'  => Certificate::with(['user', 'skill'])->orderByDesc('issued_at')->take(10)->get(),
            'totalCerts'    => Registration::where('status', 'APPROVED')->count(),
            'goldCount'     => Certificate::where('certificate_type', 'WINNER_GOLD')->count(),
            'silverCount'   => Certificate::where('certificate_type', 'WINNER_SILVER')->count(),
            'bronzeCount'   => Certificate::where('certificate_type', 'WINNER_BRONZE')->count(),
        ]);
    }
}
