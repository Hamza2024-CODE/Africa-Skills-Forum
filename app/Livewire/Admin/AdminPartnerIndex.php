<?php

namespace App\Livewire\Admin;

use App\Models\Partner;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminPartnerIndex extends Component
{
    use WithPagination, WithFileUploads;

    public string $search       = '';
    public string $filterType   = '';
    public string $filterStatus = '';

    public bool   $formOpen   = false;
    public bool   $isEditing  = false;
    public ?int   $editingId  = null;
    public bool   $drawerOpen = false;
    public ?Partner $selected  = null;
    public bool   $deleteConfirmOpen = false;
    public ?int   $deleteTargetId   = null;

    #[Validate('required|min:2')] public string $name_ar      = '';
    #[Validate('required|min:2')] public string $name_fr      = '';
    public string $name_en         = '';
    public string $description_ar  = '';
    public string $description_fr  = '';
    public string $website_url     = '';
    public string $partner_type    = 'OFFICIAL';
    public string $level           = 'GOLD';
    public int    $sort_order      = 0;
    public bool   $is_featured     = false;
    public string $status          = 'ACTIVE';
    public        $logo_file;

    protected $queryString = ['search', 'filterType', 'filterStatus'];

    public function updatingSearch(): void      { $this->resetPage(); }
    public function updatingFilterType(): void   { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->formOpen  = true;
    }

    public function openEdit(int $id): void
    {
        $p = Partner::findOrFail($id);
        $this->editingId      = $id;
        $this->name_ar        = $p->name_ar ?? '';
        $this->name_fr        = $p->name_fr ?? '';
        $this->name_en        = $p->name_en ?? '';
        $this->description_ar = $p->description_ar ?? '';
        $this->description_fr = $p->description_fr ?? '';
        $this->website_url    = $p->website_url ?? '';
        $this->partner_type   = $p->partner_type ?? 'OFFICIAL';
        $this->level          = $p->level ?? 'GOLD';
        $this->sort_order     = (int)($p->sort_order ?? 0);
        $this->is_featured    = (bool)($p->is_featured ?? false);
        $this->status         = $p->status ?? 'ACTIVE';
        $this->logo_file      = null;
        $this->isEditing      = true;
        $this->formOpen       = true;
    }

    public function save(): void
    {
        $this->validate(['name_ar' => 'required|min:2', 'name_fr' => 'required|min:2']);

        $data = [
            'name_ar'        => $this->name_ar,
            'name_fr'        => $this->name_fr,
            'name_en'        => $this->name_en ?: $this->name_fr,
            'description_ar' => $this->description_ar,
            'description_fr' => $this->description_fr,
            'website_url'    => $this->website_url,
            'partner_type'   => $this->partner_type,
            'level'          => $this->level,
            'sort_order'     => $this->sort_order,
            'is_featured'    => $this->is_featured,
            'status'         => $this->status,
        ];

        if ($this->logo_file) {
            $path = $this->logo_file->store('partners', 'public');
            $data['logo_path'] = 'storage/' . $path;
        }

        if ($this->isEditing) {
            Partner::findOrFail($this->editingId)->update($data);
            $msg = 'تم تحديث بيانات الشريك بنجاح';
        } else {
            Partner::create($data);
            $msg = 'تم إضافة الشريك بنجاح';
        }

        $this->formOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => $msg]);
    }

    public function toggleFeatured(int $id): void
    {
        $p = Partner::findOrFail($id);
        $p->update(['is_featured' => !$p->is_featured]);
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم تحديث حالة تمييز الشريك']);
    }

    public function toggleStatus(int $id): void
    {
        $p = Partner::findOrFail($id);
        $newStatus = $p->status === 'ACTIVE' ? 'INACTIVE' : 'ACTIVE';
        $p->update(['status' => $newStatus]);
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم تغيير حالة الشريك']);
    }

    public function openDrawer(int $id): void
    {
        $this->selected   = Partner::find($id);
        $this->drawerOpen = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deletePartner(): void
    {
        Partner::findOrFail($this->deleteTargetId)->delete();
        $this->deleteConfirmOpen = false;
        $this->drawerOpen        = false;
        $this->selected          = null;
        $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف الشريك بنجاح']);
    }

    private function resetForm(): void
    {
        $this->editingId      = null;
        $this->name_ar        = $this->name_fr = $this->name_en = $this->description_ar = $this->description_fr = $this->website_url = '';
        $this->partner_type   = 'OFFICIAL';
        $this->level          = 'GOLD';
        $this->sort_order     = 0;
        $this->is_featured    = false;
        $this->status         = 'ACTIVE';
        $this->logo_file      = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Partner::when($this->search, fn($q) => $q->where(fn($q) =>
                $q->where('name_ar','like','%'.$this->search.'%')->orWhere('name_fr','like','%'.$this->search.'%')
            ))
            ->when($this->filterType,   fn($q) => $q->where('partner_type', $this->filterType))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->orderBy('sort_order')->orderBy('name_ar');

        return view('livewire.admin.partners.index', [
            'partners'      => $query->paginate(15),
            'totalPartners' => Partner::count(),
            'partnerTypes'  => ['STRATEGIC', 'OFFICIAL', 'INSTITUTIONAL', 'MEDIA', 'SPONSOR'],
            'levels'        => ['PLATINUM', 'GOLD', 'SILVER', 'BRONZE'],
            'statuses'      => ['ACTIVE', 'INACTIVE'],
        ]);
    }
}
