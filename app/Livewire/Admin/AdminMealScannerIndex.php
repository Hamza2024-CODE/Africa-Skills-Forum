<?php

namespace App\Livewire\Admin;

use App\Models\MealScan;
use App\Models\MealSlot;
use App\Models\Restaurant;
use App\Services\MealAccessService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class AdminMealScannerIndex extends Component
{
    public ?int   $selectedSlotId     = null;
    public string $badgeInput         = '';
    public bool   $scannerReady       = false;
    public ?array $lastResult         = null;
    public string $alertClass         = '';

    // QR camera mode
    public bool $cameraMode = false;

    public function mount(): void
    {
        // Default to first open slot today
        $slot = MealSlot::where('is_open', true)->whereDate('date', today())->first();
        if ($slot) {
            $this->selectedSlotId = $slot->id;
            $this->scannerReady   = true;
        }
    }

    public function updatedSelectedSlotId(): void
    {
        $this->scannerReady = (bool) $this->selectedSlotId;
        $this->lastResult   = null;
        $this->badgeInput   = '';
    }

    public function scanBadge(): void
    {
        if (!$this->selectedSlotId || !trim($this->badgeInput)) return;

        $service = app(MealAccessService::class);
        $result  = $service->scan(
            trim($this->badgeInput),
            $this->selectedSlotId,
            Auth::id()
        );

        $this->lastResult = [
            'status'   => $result['status'],
            'message'  => $result['message'],
            'name'     => $result['user']?->name ?? 'غير معروف',
            'country'  => $result['user']?->country?->name_ar ?? '',
            'role'     => $result['user']?->roles?->first()?->name ?? '',
            'meal'     => $result['slot']?->meal_label ?? '',
            'restaurant'=> $result['slot']?->restaurant?->name_ar ?? '',
            'time'     => now()->format('H:i'),
            'scan_id'  => $result['scan']?->id,
        ];

        $this->alertClass = match($result['status']) {
            'AUTHORIZED' => 'authorized',
            'DUPLICATE'  => 'duplicate',
            default      => 'denied',
        };

        $this->badgeInput = '';
        $this->dispatch('scan-complete', status: $result['status']);
    }

    public function scanFromQr(string $code): void
    {
        $this->badgeInput = $code;
        $this->scanBadge();
    }

    public function render()
    {
        $todaySlots = MealSlot::with('restaurant')
            ->whereDate('date', today())
            ->orderBy('start_time')
            ->get();

        $stats = null;
        if ($this->selectedSlotId) {
            $slot = MealSlot::with('restaurant')->find($this->selectedSlotId);
            if ($slot) {
                $authorized = MealScan::where('meal_slot_id', $this->selectedSlotId)->where('status', 'AUTHORIZED')->count();
                $denied     = MealScan::where('meal_slot_id', $this->selectedSlotId)->where('status', 'DENIED')->count();
                $duplicate  = MealScan::where('meal_slot_id', $this->selectedSlotId)->where('status', 'DUPLICATE')->count();

                $stats = [
                    'slot'        => $slot,
                    'authorized'  => $authorized,
                    'denied'      => $denied,
                    'duplicate'   => $duplicate,
                    'remaining'   => max(0, $slot->max_capacity - $authorized),
                    'capacity'    => $slot->max_capacity,
                    'pct'         => $slot->max_capacity > 0 ? round(($authorized / $slot->max_capacity) * 100) : 0,
                ];
            }
        }

        return view('livewire.admin.meal-scanner.index', compact('todaySlots', 'stats'));
    }
}
