<?php

namespace App\Livewire\Admin;

use App\Models\Organization;
use App\Models\Wilaya;
use App\Models\Country;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminOrganizationIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterWilaya = '';
    public string $filterType   = '';
    public string $filterStatus = '';

    public bool   $formOpen    = false;
    public bool   $isEditing   = false;
    public ?int   $editingId   = null;
    public bool   $drawerOpen  = false;
    public ?Organization $selected = null;
    public bool   $deleteConfirmOpen = false;
    public ?int   $deleteTargetId   = null;

    #[Validate('required|min:2')] public string $name_ar  = '';
    #[Validate('required|min:2')] public string $name_fr  = '';
    public string $name_en  = '';
    public string $code     = '';
    public string $type     = 'cfpa';
    public string $email    = '';
    public string $phone    = '';
    public string $address  = '';
    public ?int   $wilaya_id   = null;
    public ?int   $country_id  = null;
    public bool   $is_active  = true;

    protected $queryString = ['search', 'filterWilaya', 'filterType', 'filterStatus'];

    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingFilterWilaya(): void  { $this->resetPage(); }
    public function updatingFilterType(): void    { $this->resetPage(); }
    public function updatingFilterStatus(): void  { $this->resetPage(); }

    public function openCreate(): void { $this->resetForm(); $this->isEditing = false; $this->formOpen = true; }

    public function openEdit(int $id): void
    {
        $org = Organization::findOrFail($id);
        $this->editingId   = $id;
        $this->name_ar     = $org->name_ar ?? '';
        $this->name_fr     = $org->name_fr ?? '';
        $this->name_en     = $org->name_en ?? '';
        $this->code        = $org->code ?? '';
        $this->type        = strtolower($org->type ?? 'cfpa');
        $this->email       = $org->email ?? '';
        $this->phone       = $org->phone ?? '';
        $this->address     = $org->address ?? '';
        $this->wilaya_id   = $org->wilaya_id;
        $this->country_id  = $org->country_id;
        $this->is_active   = (bool) $org->is_active;
        $this->isEditing   = true;
        $this->formOpen    = true;
    }

    public function save(): void
    {
        $this->validate(['name_ar' => 'required|min:2', 'name_fr' => 'required|min:2']);
        $data = [
            'code'      => $this->code ?: ('ORG-' . time()),
            'name_ar'   => $this->name_ar, 
            'name_fr'   => $this->name_fr, 
            'name_en'   => $this->name_en ?: $this->name_fr,
            'type'      => strtolower($this->type), 
            'email'     => $this->email, 
            'phone'     => $this->phone, 
            'address'   => $this->address,
            'wilaya_id' => $this->wilaya_id, 
            'country_id'=> $this->country_id ?: null, 
            'is_active' => $this->is_active,
        ];
        if ($this->isEditing) {
            Organization::findOrFail($this->editingId)->update($data);
            $msg = 'تم تحديث المؤسسة بنجاح';
        } else {
            Organization::create($data);
            $msg = 'تم إضافة المؤسسة بنجاح';
        }
        $this->formOpen = false; $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => $msg]);
    }

    public function toggleActive(int $id): void
    {
        $org = Organization::findOrFail($id);
        $org->update(['is_active' => !$org->is_active]);
    }

    public function openDrawer(int $id): void
    {
        $this->selected = Organization::with(['wilaya', 'country'])->find($id);
        $this->drawerOpen = true;
    }

    public function confirmDelete(int $id): void { $this->deleteTargetId = $id; $this->deleteConfirmOpen = true; }

    public function deleteOrg(): void
    {
        Organization::findOrFail($this->deleteTargetId)->delete();
        $this->deleteConfirmOpen = false; $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف المؤسسة بنجاح']);
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->code = $this->name_ar = $this->name_fr = $this->name_en = $this->email = $this->phone = $this->address = '';
        $this->type = 'cfpa'; $this->wilaya_id = $this->country_id = null; $this->is_active = true;
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Organization::with(['wilaya'])
            ->when($this->search, fn($q) => $q->where(fn($q) => 
                $q->where('name_ar', 'like', '%'.$this->search.'%')
                  ->orWhere('name_fr', 'like', '%'.$this->search.'%')
                  ->orWhere('code', 'like', '%'.$this->search.'%')
                  ->orWhere('address', 'like', '%'.$this->search.'%')
            ))
            ->when($this->filterWilaya,  fn($q) => $q->where('wilaya_id', $this->filterWilaya))
            ->when($this->filterType,    fn($q) => $q->where('type', $this->filterType))
            ->when($this->filterStatus !== '', fn($q) => $q->where('is_active', $this->filterStatus === '1'))
            ->latest('id');

        $orgTypes = [
            'cfpa'    => 'مركز تكوين مهني (CFPA)',
            'insfp'   => 'معهد وطني متخصص (INSFP)',
            'ifep'    => 'معهد التكوين والتعليم (IFEP)',
            'cfppa'   => 'مركز التكوين الفلاحي (CFPPA)',
        ];

        return view('livewire.admin.organizations.index', [
            'organizations' => $query->paginate(20),
            'wilayas'       => Wilaya::orderBy('code')->get(),
            'orgTypes'      => $orgTypes,
            'totalOrgs'     => Organization::count(),
            'activeOrgs'    => Organization::where('is_active', true)->count(),
        ]);
    }
}
