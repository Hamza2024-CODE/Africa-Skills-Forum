<?php

namespace App\Livewire\Admin;

use App\Models\Event;
use App\Models\Wilaya;
use App\Services\ActiveEventService;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminEventCenter extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterStatus = '';

    // Form
    public bool   $formOpen  = false;
    public bool   $isEditing = false;
    public ?int   $editingId = null;

    #[Validate('required|min:3')] public string $title_ar       = '';
    #[Validate('required|min:3')] public string $title_fr       = '';
    #[Validate('nullable')]       public string $title_en       = '';
    #[Validate('nullable')]       public string $summary_ar     = '';
    #[Validate('nullable')]       public string $summary_fr     = '';
    #[Validate('nullable')]       public string $venue          = '';
    #[Validate('nullable')]       public ?string $start_at      = null;
    #[Validate('nullable')]       public ?string $end_at        = null;

    // Drawer
    public bool   $drawerOpen    = false;
    public ?Event $selectedEvent = null;

    // Delete
    public bool $deleteConfirmOpen = false;
    public ?int $deleteTargetId   = null;

    protected $queryString = ['search', 'filterStatus'];

    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function openCreate(): void
    {
        $this->resetForm();
        $this->isEditing = false;
        $this->formOpen  = true;
    }

    public function openEdit(int $id): void
    {
        $event = Event::findOrFail($id);
        $this->editingId   = $id;
        $this->title_ar    = $event->title_ar ?? '';
        $this->title_fr    = $event->title_fr ?? '';
        $this->title_en    = $event->title_en ?? '';
        $this->summary_ar  = $event->summary_ar ?? '';
        $this->summary_fr  = $event->summary_fr ?? '';
        $this->venue       = $event->venue ?? '';
        $this->start_at    = $event->start_at ? $event->start_at->format('Y-m-d\TH:i') : null;
        $this->end_at      = $event->end_at ? $event->end_at->format('Y-m-d\TH:i') : null;
        $this->isEditing   = true;
        $this->formOpen    = true;
    }

    public function save(): void
    {
        $this->validate(['title_ar' => 'required|min:3', 'title_fr' => 'required|min:3']);

        $data = [
            'title_ar'   => $this->title_ar,
            'title_fr'   => $this->title_fr,
            'title_en'   => $this->title_en ?: $this->title_fr,
            'summary_ar' => $this->summary_ar,
            'summary_fr' => $this->summary_fr,
            'venue'      => $this->venue,
            'start_at'   => $this->start_at ?: null,
            'end_at'     => $this->end_at ?: null,
            'status'     => 'PUBLISHED',
        ];

        if ($this->isEditing) {
            Event::findOrFail($this->editingId)->update($data);
            $msg = 'تم تحديث الفعالية بنجاح';
        } else {
            Event::create($data);
            $msg = 'تم إضافة الفعالية الجديدة بنجاح';
        }

        $this->formOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => $msg]);
    }

    public function toggleActive($eventId, ActiveEventService $activeEventService): void
    {
        Event::query()->update(['is_active' => false]);
        Event::where('id', $eventId)->update(['is_active' => true]);
        $activeEventService->clearCache();

        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم تفعيل هذا الحدث كحدث رئيسي في البوابة الرسمية بنجاح']);
    }

    public function openDrawer(int $id): void
    {
        $this->selectedEvent = Event::find($id);
        $this->drawerOpen    = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteEvent(): void
    {
        Event::findOrFail($this->deleteTargetId)->delete();
        $this->deleteConfirmOpen = false;
        $this->drawerOpen        = false;
        $this->selectedEvent     = null;
        $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف الحدث بنجاح']);
    }

    private function resetForm(): void
    {
        $this->editingId  = null;
        $this->title_ar   = $this->title_fr = $this->title_en = '';
        $this->summary_ar = $this->summary_fr = $this->venue = '';
        $this->start_at   = $this->end_at = null;
        $this->resetErrorBag();
    }

    public function render()
    {
        $query = Event::when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('title_ar', 'like', '%'.$this->search.'%')
                  ->orWhere('title_fr', 'like', '%'.$this->search.'%')
                  ->orWhere('venue',    'like', '%'.$this->search.'%');
            }))
            ->when($this->filterStatus !== '', fn($q) => $q->where('is_active', $this->filterStatus === '1'))
            ->latest();

        return view('livewire.admin.admin-event-center', [
            'events'      => $query->paginate(10),
            'totalEvents' => Event::count(),
            'activeEvent' => Event::where('is_active', true)->first(),
        ]);
    }
}
