<?php

namespace App\Livewire\Admin;

use App\Models\Accommodation;
use App\Models\EquipmentItem;
use App\Models\TransportRoute;
use App\Models\TransportTrip;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class AdminLogisticsCenter extends Component
{
    public int $totalEquipment = 0;
    public int $totalAccommodations = 0;
    public int $totalCapacity = 0;
    public int $totalTransportRoutes = 0;
    public int $totalTrips = 0;

    public function mount()
    {
        $this->totalEquipment = EquipmentItem::count();
        $this->totalAccommodations = Accommodation::count();
        $this->totalCapacity = (int) Accommodation::sum('total_capacity');
        $this->totalTransportRoutes = TransportRoute::count();
        $this->totalTrips = TransportTrip::count();
    }

    public function render()
    {
        return view('livewire.admin.admin-logistics-center', [
            'recentEquipment' => EquipmentItem::with('category')->latest()->take(5)->get(),
            'recentAccommodations' => Accommodation::withCount('rooms')->latest()->take(5)->get(),
            'recentRoutes' => TransportRoute::withCount('trips')->latest()->take(5)->get(),
        ]);
    }
}
