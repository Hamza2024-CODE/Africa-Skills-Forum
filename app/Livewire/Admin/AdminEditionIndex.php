<?php

namespace App\Livewire\Admin;

use App\Models\Edition;
use App\Models\EditionDate;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminEditionIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterStatus = '';

    // Form
    public bool   $formOpen  = false;
    public bool   $isEditing = false;
    public ?int   $editingId = null;

    #[Validate('required|integer|min:2020')] public ?int   $year     = null;
    #[Validate('required|min:2')]            public string $name_ar  = '';
    #[Validate('required|min:2')]            public string $name_fr  = '';
    #[Validate('nullable')]                  public string $name_en  = '';
    #[Validate('nullable')]                  public string $status   = 'draft';
    public bool   $is_active = false;

    // Dates sub-form
    public array $dates = [];

    // Detail Drawer
    public bool     $drawerOpen     = false;
    public ?Edition $selectedEdition = null;

    // Delete
    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetId   = null;

    protected $queryString = ['search', 'filterStatus'];

    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    /* ─── Form ─── */
    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->formOpen  = true;
    }

    public function openEdit(int $id): void
    {
        $e = Edition::with('dates')->findOrFail($id);
        $this->editingId = $id;
        $this->year      = $e->year;
        $this->name_ar   = $e->name_ar ?? '';
        $this->name_fr   = $e->name_fr ?? '';
        $this->name_en   = $e->name_en ?? '';
        $this->status    = $e->status ?? 'draft';
        $this->is_active = (bool) $e->is_active;
        $this->dates     = $e->dates->map(fn($d) => [
            'id'         => $d->id,
            'label_ar'   => $d->label_ar ?? '',
            'label_fr'   => $d->label_fr ?? '',
            'event_date' => $d->event_date?->format('Y-m-d') ?? '',
        ])->toArray();
        $this->isEditing = true;
        $this->formOpen  = true;
    }

    public function addDate(): void
    {
        $this->dates[] = ['id' => null, 'label_ar' => '', 'label_fr' => '', 'event_date' => ''];
    }

    public function removeDate(int $idx): void
    {
        unset($this->dates[$idx]);
        $this->dates = array_values($this->dates);
    }

    public function save(): void
    {
        $this->validate([
            'year'    => 'required|integer|min:2020',
            'name_ar' => 'required|min:2',
            'name_fr' => 'required|min:2',
        ]);

        $data = [
            'year'      => $this->year,
            'name_ar'   => $this->name_ar,
            'name_fr'   => $this->name_fr,
            'name_en'   => $this->name_en ?: $this->name_fr,
            'status'    => $this->status,
            'is_active' => $this->is_active,
        ];

        if ($this->isEditing) {
            $edition = Edition::findOrFail($this->editingId);
            $edition->update($data);
            // Sync dates
            $edition->dates()->delete();
        } else {
            $edition = Edition::create($data);
        }

        foreach ($this->dates as $date) {
            if (!empty($date['event_date'])) {
                $edition->dates()->create([
                    'label_ar'   => $date['label_ar'] ?? '',
                    'label_fr'   => $date['label_fr'] ?? '',
                    'event_date' => $date['event_date'],
                ]);
            }
        }

        $this->formOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => $this->isEditing ? 'تم تحديث الدورة بنجاح' : 'تم إضافة الدورة بنجاح']);
    }

    public function toggleActive(int $id): void
    {
        $edition = Edition::findOrFail($id);
        $edition->update(['is_active' => !$edition->is_active]);
    }

    public function openDrawer(int $id): void
    {
        $this->selectedEdition = Edition::with(['dates', 'countries'])->find($id);
        $this->drawerOpen      = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteEdition(): void
    {
        Edition::findOrFail($this->deleteTargetId)->delete();
        $this->deleteConfirmOpen = false;
        $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف الدورة']);
    }

    private function resetForm(): void
    {
        $this->editingId = null;
        $this->year      = null;
        $this->name_ar   = $this->name_fr = $this->name_en = '';
        $this->status    = 'draft';
        $this->is_active = false;
        $this->dates     = [];
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Edition::withCount('countries')
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name_ar', 'like', '%'.$this->search.'%')
                  ->orWhere('name_fr', 'like', '%'.$this->search.'%')
                  ->orWhere('year',    'like', '%'.$this->search.'%');
            }))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->orderByDesc('year');

        return view('livewire.admin.editions.index', [
            'editions'      => $query->paginate(10),
            'totalEditions' => Edition::count(),
            'activeEdition' => Edition::where('is_active', true)->first(),
        ]);
    }
}
