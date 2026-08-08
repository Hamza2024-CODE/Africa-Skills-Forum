<?php

namespace App\Livewire\Admin;

use App\Models\AuditLog;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminAuditLogIndex extends Component
{
    use WithPagination;

    public string $search    = '';
    public string $filterEvent = '';

    // Drawer
    public bool      $drawerOpen  = false;
    public ?AuditLog $selectedLog = null;

    protected $queryString = ['search', 'filterEvent'];

    public function updatingSearch(): void      { $this->resetPage(); }
    public function updatingFilterEvent(): void { $this->resetPage(); }

    public function openDrawer(int $id): void
    {
        $this->selectedLog = AuditLog::with('user')->find($id);
        $this->drawerOpen  = true;
    }

    public function render()
    {
        $query = AuditLog::with('user')
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('event', 'like', '%'.$this->search.'%')
                  ->orWhere('ip_address', 'like', '%'.$this->search.'%')
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', '%'.$this->search.'%'));
            }))
            ->when($this->filterEvent, fn($q) => $q->where('event', $this->filterEvent))
            ->latest();

        return view('livewire.admin.audit.index', [
            'logs'      => $query->paginate(20),
            'totalLogs' => AuditLog::count(),
            'events'    => AuditLog::select('event')->distinct()->pluck('event'),
        ]);
    }
}
