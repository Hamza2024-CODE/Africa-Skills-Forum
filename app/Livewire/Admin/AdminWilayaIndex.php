<?php

namespace App\Livewire\Admin;

use App\Models\Region;
use App\Models\Wilaya;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminWilayaIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterRegion = '';

    // Form
    public bool   $formOpen  = false;
    public bool   $isEditing = false;
    public ?int   $editingId = null;

    #[Validate('required|integer|min:1|max:58')] public ?int   $code     = null;
    #[Validate('required|min:2')]                public string $name_ar  = '';
    #[Validate('required|min:2')]                public string $name_fr  = '';
    #[Validate('nullable|integer')]              public ?int   $region_id = null;

    // Detail Drawer
    public bool    $drawerOpen    = false;
    public ?Wilaya $selectedWilaya = null;

    // Delete
    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetId   = null;

    protected $queryString = ['search', 'filterRegion'];

    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingFilterRegion(): void { $this->resetPage(); }

    /* ─── Form ─── */
    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->formOpen  = true;
    }

    public function openEdit(int $id): void
    {
        $w = Wilaya::findOrFail($id);
        $this->editingId  = $id;
        $this->code       = $w->code;
        $this->name_ar    = $w->name_ar ?? '';
        $this->name_fr    = $w->name_fr ?? '';
        $this->region_id  = $w->region_id;
        $this->isEditing  = true;
        $this->formOpen   = true;
    }

    public function save(): void
    {
        $this->validate([
            'code'    => 'required|integer|min:1|max:58',
            'name_ar' => 'required|min:2',
            'name_fr' => 'required|min:2',
        ]);

        $data = [
            'code'      => $this->code,
            'name_ar'   => $this->name_ar,
            'name_fr'   => $this->name_fr,
            'region_id' => $this->region_id ?: null,
        ];

        if ($this->isEditing) {
            Wilaya::findOrFail($this->editingId)->update($data);
            $msg = 'تم تحديث الولاية بنجاح';
        } else {
            Wilaya::create($data);
            $msg = 'تم إضافة الولاية بنجاح';
        }

        $this->formOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => $msg]);
    }

    public function openDrawer(int $id): void
    {
        $this->selectedWilaya = Wilaya::with(['region', 'communes', 'organizations'])->find($id);
        $this->drawerOpen     = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteWilaya(): void
    {
        Wilaya::findOrFail($this->deleteTargetId)->delete();
        $this->deleteConfirmOpen = false;
        $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف الولاية']);
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->code      = null;
        $this->name_ar   = $this->name_fr = '';
        $this->region_id = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Wilaya::with(['region', 'communes'])
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name_ar', 'like', '%'.$this->search.'%')
                  ->orWhere('name_fr', 'like', '%'.$this->search.'%')
                  ->orWhere('code',    'like', '%'.$this->search.'%');
            }))
            ->when($this->filterRegion, fn($q) => $q->where('region_id', $this->filterRegion))
            ->orderBy('code');

        return view('livewire.admin.wilayas.index', [
            'wilayas'      => $query->paginate(20),
            'regions'      => Region::orderBy('name_ar')->get(),
            'totalWilayas' => Wilaya::count(),
        ]);
    }
}
