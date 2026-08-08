<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminCountryIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterStatus = '';

    public bool  $formOpen   = false;
    public bool  $isEditing  = false;
    public ?int  $editingId  = null;
    public bool  $drawerOpen = false;
    public ?Country $selected = null;
    public bool  $deleteConfirmOpen = false;
    public ?int  $deleteTargetId   = null;

    #[Validate('required|min:2')] public string $name_ar   = '';
    #[Validate('required|min:2')] public string $name_fr   = '';
    public string $name_en   = '';
    public string $code      = '';
    public string $flag_emoji = '';
    public string $continent  = '';
    public bool   $is_active  = true;

    protected $queryString = ['search', 'filterStatus'];

    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingFilterStatus(): void  { $this->resetPage(); }

    public function openCreate(): void { $this->resetForm(); $this->isEditing = false; $this->formOpen = true; }

    public function openEdit(int $id): void
    {
        $country = Country::findOrFail($id);
        $this->editingId    = $id;
        $this->name_ar      = $country->name_ar ?? '';
        $this->name_fr      = $country->name_fr ?? '';
        $this->name_en      = $country->name_en ?? '';
        $this->code         = $country->code ?? '';
        $this->flag_emoji   = $country->flag_emoji ?? '';
        $this->continent    = $country->continent ?? '';
        $this->is_active    = (bool)($country->is_active ?? true);
        $this->isEditing    = true;
        $this->formOpen     = true;
    }

    public function save(): void
    {
        $this->validate(['name_ar' => 'required|min:2', 'name_fr' => 'required|min:2']);
        $data = [
            'name_ar' => $this->name_ar, 'name_fr' => $this->name_fr, 'name_en' => $this->name_en ?: $this->name_fr,
            'code' => strtoupper($this->code), 'flag_emoji' => $this->flag_emoji,
            'continent' => $this->continent, 'is_active' => $this->is_active,
        ];
        if ($this->isEditing) {
            Country::findOrFail($this->editingId)->update($data); $msg = 'تم تحديث الدولة';
        } else {
            Country::create($data); $msg = 'تم إضافة الدولة';
        }
        $this->formOpen = false; $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => $msg]);
    }

    public function toggleActive(int $id): void
    {
        $c = Country::findOrFail($id); $c->update(['is_active' => !$c->is_active]);
    }

    public function openDrawer(int $id): void
    {
        $this->selected = Country::withCount(['registrations'])->find($id);
        $this->drawerOpen = true;
    }

    public function confirmDelete(int $id): void { $this->deleteTargetId = $id; $this->deleteConfirmOpen = true; }

    public function deleteCountry(): void
    {
        Country::findOrFail($this->deleteTargetId)->delete();
        $this->deleteConfirmOpen = false; $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف الدولة']);
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->name_ar = $this->name_fr = $this->name_en = $this->code = $this->flag_emoji = $this->continent = '';
        $this->is_active = true; $this->resetErrorBag();
    }

    public function exportExcel()
    {
        $countries = Country::withCount('registrations')->orderBy('name_ar')->get();

        $csvData = [];
        $csvData[] = ['#ID', 'الرمز ISO', 'اسم الدولة / الوفد بالعربية', 'الاسم بالفرنسية', 'القارة', 'عدد المسجلين والمعتمدين', 'حالة المشاركة'];

        foreach ($countries as $c) {
            $csvData[] = [
                $c->id,
                $c->code ?: '—',
                $c->name_ar,
                $c->name_fr,
                $c->continent ?: '—',
                $c->registrations_count,
                $c->is_active ? 'نشطة ومشاركة' : 'معطلة',
            ];
        }

        $filename = 'WSAP_Delegations_Countries_' . date('Y_m_d_His') . '.csv';

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
        $query = Country::withCount(['registrations'])
            ->when($this->search, fn($q) => $q->where(fn($q) =>
                $q->where('name_ar','like','%'.$this->search.'%')
                  ->orWhere('name_fr','like','%'.$this->search.'%')
                  ->orWhere('code','like','%'.$this->search.'%')
            ))
            ->when($this->filterStatus !== '', fn($q) => $q->where('is_active', $this->filterStatus === '1'))
            ->orderBy('name_ar');

        return view('livewire.admin.countries.index', [
            'countries'    => $query->paginate(20),
            'totalCountries' => Country::count(),
            'activeCountries' => Country::where('is_active', true)->count(),
        ]);
    }
}
