<?php

namespace App\Livewire\Admin\Schedule;

use App\Models\Country;
use App\Models\ScheduleEvent;
use App\Models\Skill;
use App\Models\Zone;
use App\Services\Schedule\ScheduleNotificationDispatcher;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class MasterScheduleIndex extends Component
{
    use WithPagination;

    public string $viewMode      = 'operations'; // calendar, agenda, operations, timeline
    public string $filterType    = '';
    public string $filterStatus  = '';
    public string $filterSkill   = '';
    public string $filterCountry = '';
    public string $search        = '';

    // Create / Reschedule Form fields
    public bool   $showCreateModal = false;
    public string $event_type      = 'TECHNICAL_MEETING';
    public string $title_ar        = '';
    public string $title_fr        = '';
    public string $title_en        = '';
    public string $location_name   = '';
    public string $start_at        = '';
    public string $end_at          = '';
    public ?int   $zone_id         = null;
    public ?int   $skill_id        = null;
    public ?int   $country_id      = null;
    public array  $targetRoles     = [];

    public string $flashMessage    = '';

    public function createEvent(ScheduleNotificationDispatcher $dispatcher): void
    {
        $this->validate([
            'title_ar'    => 'required|string|max:255',
            'start_at'    => 'required',
            'event_type'  => 'required|string',
        ]);

        $event = ScheduleEvent::create([
            'event_type'    => $this->event_type,
            'title_ar'      => $this->title_ar,
            'title_fr'      => $this->title_fr ?: null,
            'title_en'      => $this->title_en ?: null,
            'location_name' => $this->location_name ?: null,
            'start_at'      => $this->start_at,
            'end_at'        => $this->end_at ?: null,
            'zone_id'       => $this->zone_id ?: null,
            'skill_id'      => $this->skill_id ?: null,
            'country_id'    => $this->country_id ?: null,
            'status'        => 'SCHEDULED',
            'created_by'    => auth()->id(),
        ]);

        foreach ($this->targetRoles as $role) {
            $event->targets()->create([
                'target_type' => 'role',
                'target_id'   => $role,
            ]);
        }

        $this->flashMessage = "تم إضافة الحدث المجدول بنجاح.";
        $this->resetCreateForm();
    }

    public function transitionStatus(int $eventId, string $newStatus, ScheduleNotificationDispatcher $dispatcher): void
    {
        $event = ScheduleEvent::findOrFail($eventId);

        if ($newStatus === 'CANCELLED') {
            $dispatcher->dispatchCancellationAlert($event);
        }

        if ($event->transitionTo($newStatus)) {
            $this->flashMessage = "تم تغيير حالة الحدث إلى: {$newStatus}";
        } else {
            $this->flashMessage = "عذراً، هذا الانتقال غير مسموح بحسب دورة حياة الحدث.";
        }
    }

    public function deleteEvent(int $eventId): void
    {
        ScheduleEvent::findOrFail($eventId)->delete();
        $this->flashMessage = "تم حذف الحدث من الجدول.";
    }

    private function resetCreateForm(): void
    {
        $this->showCreateModal = false;
        $this->title_ar = '';
        $this->title_fr = '';
        $this->title_en = '';
        $this->location_name = '';
        $this->start_at = '';
        $this->end_at = '';
        $this->zone_id = null;
        $this->skill_id = null;
        $this->country_id = null;
        $this->targetRoles = [];
    }

    public function render()
    {
        $query = ScheduleEvent::with(['zone', 'skill', 'country', 'creator', 'targets'])
            ->when($this->search, fn($q) => $q->where('title_ar', 'like', "%{$this->search}%"))
            ->when($this->filterType, fn($q) => $q->where('event_type', $this->filterType))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->when($this->filterSkill, fn($q) => $q->where('skill_id', $this->filterSkill))
            ->when($this->filterCountry, fn($q) => $q->where('country_id', $this->filterCountry));

        $events = $query->orderBy('start_at')->paginate(12);

        return view('livewire.admin.schedule.index', [
            'events'        => $events,
            'zones'         => Zone::where('is_active', true)->get(),
            'skills'        => Skill::orderBy('name_ar')->get(),
            'countries'     => Country::orderBy('name_ar')->get(),
            'totalEvents'   => ScheduleEvent::count(),
            'todayEvents'   => ScheduleEvent::whereDate('start_at', today())->count(),
            'activeEvents'  => ScheduleEvent::whereIn('status', ['OPEN', 'IN_PROGRESS'])->count(),
        ]);
    }
}
