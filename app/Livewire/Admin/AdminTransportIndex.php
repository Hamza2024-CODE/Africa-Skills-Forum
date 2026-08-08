<?php

namespace App\Livewire\Admin;

use App\Models\TransportRoute;
use App\Models\TransportTrip;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminTransportIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterStatus = '';

    // Form
    public bool   $formOpen  = false;
    public bool   $isEditing = false;
    public ?int   $editingId = null;

    #[Validate('required|min:2')] public string $name_ar          = '';
    #[Validate('required|min:2')] public string $name_fr          = '';
    #[Validate('nullable')]       public string $origin           = '';
    #[Validate('nullable')]       public string $destination      = '';
    #[Validate('nullable|integer|min:1')] public ?int $vehicle_capacity = null;
    #[Validate('nullable')]       public string $status           = 'ACTIVE';

    // Trips sub-form
    public bool   $tripsOpen    = false;
    public ?int   $tripsRouteId = null;
    public string $tripsRouteName = '';
    public array  $tripsList    = [];

    // New trip fields
    public string $new_departure_at  = '';
    public string $new_arrival_at    = '';
    public string $new_vehicle_number = '';

    // Drawer
    public bool              $drawerOpen    = false;
    public ?TransportRoute   $selectedRoute = null;

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
        $r = TransportRoute::findOrFail($id);
        $this->editingId        = $id;
        $this->name_ar          = $r->name_ar ?? '';
        $this->name_fr          = $r->name_fr ?? '';
        $this->origin           = $r->origin ?? '';
        $this->destination      = $r->destination ?? '';
        $this->vehicle_capacity = $r->vehicle_capacity;
        $this->status           = $r->status ?? 'ACTIVE';
        $this->isEditing        = true;
        $this->formOpen         = true;
    }

    public function save(): void
    {
        $this->validate(['name_ar' => 'required|min:2', 'name_fr' => 'required|min:2']);
        $data = [
            'name_ar'          => $this->name_ar,
            'name_fr'          => $this->name_fr,
            'origin'           => $this->origin,
            'destination'      => $this->destination,
            'vehicle_capacity' => $this->vehicle_capacity,
            'status'           => $this->status,
        ];
        $this->isEditing
            ? TransportRoute::findOrFail($this->editingId)->update($data)
            : TransportRoute::create($data);
        $this->formOpen = false;
        $this->resetForm();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حفظ المسار بنجاح']);
    }

    /* ─── Trips ─── */
    public function openTrips(int $id): void
    {
        $route = TransportRoute::with('trips')->findOrFail($id);
        $this->tripsRouteId   = $id;
        $this->tripsRouteName = $route->name_ar;
        $this->tripsList      = $route->trips->toArray();
        $this->tripsOpen      = true;
    }

    public function addTrip(): void
    {
        if (!$this->new_departure_at) return;
        TransportTrip::create([
            'route_id'       => $this->tripsRouteId,
            'departure_at'   => $this->new_departure_at,
            'arrival_at'     => $this->new_arrival_at ?: null,
            'vehicle_number' => $this->new_vehicle_number,
        ]);
        $this->new_departure_at = $this->new_arrival_at = $this->new_vehicle_number = '';
        $route = TransportRoute::with('trips')->findOrFail($this->tripsRouteId);
        $this->tripsList = $route->trips->toArray();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تمت إضافة الرحلة']);
    }

    /* ─── Drawer ─── */
    public function openDrawer(int $id): void
    {
        $this->selectedRoute = TransportRoute::withCount('trips')->with('trips')->find($id);
        $this->drawerOpen    = true;
    }

    public function confirmDelete(int $id): void
    {
        $this->deleteTargetId    = $id;
        $this->deleteConfirmOpen = true;
    }

    public function deleteRoute(): void
    {
        TransportRoute::findOrFail($this->deleteTargetId)->delete();
        $this->deleteConfirmOpen = false;
        $this->resetPage();
        $this->dispatch('notify', ['type' => 'success', 'msg' => 'تم حذف المسار']);
    }

    private function resetForm(): void
    {
        $this->editingId        = null;
        $this->name_ar          = $this->name_fr = $this->origin = $this->destination = '';
        $this->vehicle_capacity = null;
        $this->status           = 'ACTIVE';
        $this->resetErrorBag();
    }

    public function exportExcel()
    {
        $routes = TransportRoute::withCount('trips')->with('trips')->latest()->get();

        $csvData = [];
        $csvData[] = ['#ID', 'اسم المسار / خط النقل', 'نقطة الانطلاق', 'الوجهة / مقر الإقامة / موقع المسابقة', 'سعة الحافلة / المركبة', 'عدد الرحلات المبرمجة', 'حالة الخط'];

        foreach ($routes as $r) {
            $csvData[] = [
                $r->id,
                $r->name_ar,
                $r->origin ?: '—',
                $r->destination ?: '—',
                $r->vehicle_capacity ? $r->vehicle_capacity . ' راكب' : '—',
                $r->trips_count,
                $r->status === 'ACTIVE' ? 'نشط ومستمر' : 'متوقف',
            ];
        }

        $filename = 'WSAP_Transport_Routes_' . date('Y_m_d_His') . '.csv';

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
        $query = TransportRoute::withCount('trips')
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name_ar',     'like', '%'.$this->search.'%')
                  ->orWhere('origin',      'like', '%'.$this->search.'%')
                  ->orWhere('destination', 'like', '%'.$this->search.'%');
            }))
            ->when($this->filterStatus, fn($q) => $q->where('status', $this->filterStatus))
            ->latest();

        return view('livewire.admin.transport.index', [
            'routes'      => $query->paginate(10),
            'totalRoutes' => TransportRoute::count(),
            'totalTrips'  => TransportTrip::count(),
        ]);
    }
}
