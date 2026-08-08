<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\Wilaya;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminParticipantIndex extends Component
{
    use WithPagination;

    public string $search         = '';
    public string $filterCountry  = '';
    public string $filterWilaya   = '';
    public string $filterSkill    = '';
    public string $filterStatus   = '';

    public bool   $drawerOpen     = false;
    public ?Registration $selected = null;

    // Delete modal
    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetId    = null;

    protected $queryString = ['search', 'filterCountry', 'filterSkill', 'filterStatus'];

    public function updatingSearch(): void        { $this->resetPage(); }
    public function updatingFilterCountry(): void  { $this->resetPage(); }
    public function updatingFilterSkill(): void    { $this->resetPage(); }
    public function updatingFilterStatus(): void   { $this->resetPage(); }

    public function openDrawer(int $id): void
    {
        $this->selected = Registration::with([
            'participant.user',
            'participant.wilaya',
            'participant.organization',
            'skill',
            'organization',
            'wilaya',
            'country',
            'documents'
        ])->find($id);

        $this->drawerOpen = true;
    }

    public function closeDrawer(): void
    {
        $this->drawerOpen = false;
        $this->selected   = null;
    }

    public function approve(int $id): void
    {
        $reg = Registration::findOrFail($id);
        $reg->update(['status' => 'APPROVED']);
        if ($this->selected?->id === $id) {
            $this->selected = $reg->fresh(['participant.user', 'skill', 'organization', 'wilaya', 'country', 'documents']);
        }
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم قبول المشارك بنجاح']);
    }

    public function reject(int $id): void
    {
        $reg = Registration::findOrFail($id);
        $reg->update(['status' => 'REJECTED']);
        if ($this->selected?->id === $id) {
            $this->selected = $reg->fresh(['participant.user', 'skill', 'organization', 'wilaya', 'country', 'documents']);
        }
        $this->dispatch('notify', ['type' => 'warning', 'msg' => 'تم رفض الطلب']);
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteParticipant(): void
    {
        if ($this->deleteTargetId) {
            $reg = Registration::find($this->deleteTargetId);
            if ($reg) {
                if ($reg->participant_id) {
                    ParticipantProfile::where('id', $reg->participant_id)->delete();
                }
                $reg->delete();
            }
        }
        $this->deleteConfirmOpen = false;
        $this->drawerOpen        = false;
        $this->selected          = null;
        $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف المشارك نهائياً من قاعدة البيانات']);
    }

    public function exportExcel()
    {
        $registrations = Registration::with(['participant.user', 'skill', 'country', 'wilaya', 'organization'])
            ->latest()
            ->get();

        $csvData = [];
        $csvData[] = [
            'رقم التسجيل',
            'اسم المترشح / المشارك',
            'البريد الإلكتروني',
            'الهاتف',
            'التخصص المهني',
            'الدولة / الوفد',
            'الولاية / المؤسسة',
            'حالة التسجيل',
            'تاريخ التسجيل'
        ];

        foreach ($registrations as $reg) {
            $p = $reg->participant;
            $csvData[] = [
                $reg->registration_number,
                ($p?->first_name_ar . ' ' . $p?->last_name_ar) ?: ($reg->user?->name ?? '—'),
                $reg->user?->email ?? '—',
                $p?->phone ?? '—',
                $reg->skill?->name_ar ?? '—',
                $reg->country?->name_ar ?? '—',
                $reg->wilaya?->name_ar ?? $reg->organization?->name_ar ?? '—',
                $reg->status,
                $reg->created_at ? $reg->created_at->format('Y-m-d H:i') : '—',
            ];
        }

        $filename = 'WSAP_Participants_Export_' . date('Y_m_d_His') . '.csv';

        return response()->streamDownload(function () use ($csvData) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function render()
    {
        $query = Registration::with(['participant.user', 'skill', 'country', 'wilaya', 'organization'])
            ->when($this->search, fn($q) => $q->where(function($sub) {
                $sub->where('registration_number', 'like', '%'.$this->search.'%')
                    ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%'.$this->search.'%')->orWhere('email', 'like', '%'.$this->search.'%'))
                    ->orWhereHas('participant', fn($p) => $p->where('first_name_ar', 'like', '%'.$this->search.'%')->orWhere('last_name_ar', 'like', '%'.$this->search.'%'));
            }))
            ->when($this->filterCountry, fn($q) => $q->where('country_id', $this->filterCountry))
            ->when($this->filterSkill,   fn($q) => $q->where('skill_id',   $this->filterSkill))
            ->when($this->filterStatus,  fn($q) => $q->where('status',     $this->filterStatus))
            ->latest();

        return view('livewire.admin.participants.index', [
            'registrations'        => $query->paginate(15),
            'countries'            => Country::orderBy('name_ar')->get(),
            'skills'               => Skill::where('is_active', true)->orderBy('name_ar')->get(),
            'totalParticipants'    => Registration::count(),
            'approvedParticipants' => Registration::where('status', 'APPROVED')->count(),
            'pendingParticipants'  => Registration::where('status', 'SUBMITTED')->count(),
        ]);
    }
}
