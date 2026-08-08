<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use App\Models\MealEntitlement;
use App\Models\MealScan;
use App\Models\MealSlot;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminRestaurantIndex extends Component
{
    use WithPagination;

    // ── Tabs ─────────────────────────────────────────────────
    public string $activeTab = 'restaurants'; // restaurants | slots | entitlements | scans | dashboard

    // ── Filters ──────────────────────────────────────────────
    public string $search      = '';
    public string $filterDate  = '';
    public string $filterMeal  = '';
    public string $filterStatus = '';

    // ── Restaurant Form ───────────────────────────────────────
    public bool   $restaurantFormOpen = false;
    public bool   $restaurantEditing  = false;
    public ?int   $restaurantEditId   = null;

    public string $name_ar       = '';
    public string $name_fr       = '';
    public string $name_en       = '';
    public string $location      = '';
    public string $contact_phone = '';
    public int    $capacity      = 300;
    public bool   $is_active     = true;
    public string $notes_r       = '';

    // ── Meal Slot Form ────────────────────────────────────────
    public bool   $slotFormOpen   = false;
    public bool   $slotEditing    = false;
    public ?int   $slotEditId     = null;
    public ?int   $slot_restaurant_id = null;
    public string $slot_date      = '';
    public string $slot_meal_type = 'LUNCH';
    public string $slot_start     = '12:00';
    public string $slot_end       = '14:30';
    public int    $slot_capacity  = 300;
    public bool   $slot_is_open   = true;
    public string $slot_notes     = '';

    // ── Entitlement Form ──────────────────────────────────────
    public bool   $entitlementFormOpen = false;
    public ?int   $ent_meal_slot_id    = null;
    public string $ent_assign_type     = 'user';  // user | delegation
    public ?int   $ent_user_id         = null;
    public ?int   $ent_country_id      = null;

    // ── Delete confirmation ───────────────────────────────────
    public bool $deleteOpen       = false;
    public ?int  $deleteTargetId  = null;
    public string $deleteTargetType = '';

    // ── Flash ─────────────────────────────────────────────────
    public string $flashMessage = '';
    public string $flashType    = 'success';

    public function mount(): void
    {
        $this->filterDate = today()->toDateString();
    }

    // ────────────────────────────────────────────────────────
    // RESTAURANT CRUD
    // ────────────────────────────────────────────────────────
    public function openRestaurantForm(?int $id = null): void
    {
        $this->resetRestaurantForm();
        $this->restaurantFormOpen = true;

        if ($id) {
            $r = Restaurant::findOrFail($id);
            $this->restaurantEditing  = true;
            $this->restaurantEditId   = $id;
            $this->name_ar            = $r->name_ar;
            $this->name_fr            = $r->name_fr ?? '';
            $this->name_en            = $r->name_en ?? '';
            $this->location           = $r->location ?? '';
            $this->contact_phone      = $r->contact_phone ?? '';
            $this->capacity           = $r->capacity;
            $this->is_active          = $r->is_active;
            $this->notes_r            = $r->notes ?? '';
        }
    }

    public function saveRestaurant(): void
    {
        $this->validate([
            'name_ar'  => 'required|min:2|max:100',
            'capacity' => 'required|integer|min:1|max:9999',
        ], [
            'name_ar.required' => 'اسم المطعم بالعربية مطلوب.',
            'capacity.required' => 'الطاقة الاستيعابية مطلوبة.',
        ]);

        $data = [
            'name_ar'       => $this->name_ar,
            'name_fr'       => $this->name_fr ?: null,
            'name_en'       => $this->name_en ?: null,
            'location'      => $this->location ?: null,
            'contact_phone' => $this->contact_phone ?: null,
            'capacity'      => $this->capacity,
            'is_active'     => $this->is_active,
            'notes'         => $this->notes_r ?: null,
        ];

        if ($this->restaurantEditing) {
            Restaurant::findOrFail($this->restaurantEditId)->update($data);
            $this->flash('تم تحديث بيانات المطعم بنجاح.');
        } else {
            Restaurant::create(array_merge($data, ['uuid' => (string) Str::uuid()]));
            $this->flash('تمت إضافة المطعم الجديد بنجاح.');
        }

        $this->restaurantFormOpen = false;
        $this->resetRestaurantForm();
        $this->resetPage();
    }

    public function toggleRestaurantStatus(int $id): void
    {
        $r = Restaurant::findOrFail($id);
        $r->update(['is_active' => !$r->is_active]);
        $this->flash($r->is_active ? 'تم تفعيل المطعم.' : 'تم تعطيل المطعم.');
    }

    // ────────────────────────────────────────────────────────
    // MEAL SLOT CRUD
    // ────────────────────────────────────────────────────────
    public function openSlotForm(?int $restaurantId = null, ?int $slotId = null): void
    {
        $this->resetSlotForm();
        $this->slotFormOpen = true;
        $this->slot_restaurant_id = $restaurantId;

        if ($slotId) {
            $s = MealSlot::findOrFail($slotId);
            $this->slotEditing          = true;
            $this->slotEditId           = $slotId;
            $this->slot_restaurant_id   = $s->restaurant_id;
            $this->slot_date            = $s->date->toDateString();
            $this->slot_meal_type       = $s->meal_type;
            $this->slot_start           = $s->start_time;
            $this->slot_end             = $s->end_time;
            $this->slot_capacity        = $s->max_capacity;
            $this->slot_is_open         = $s->is_open;
            $this->slot_notes           = $s->notes ?? '';
        }
    }

    public function saveSlot(): void
    {
        $this->validate([
            'slot_restaurant_id' => 'required|exists:restaurants,id',
            'slot_date'          => 'required|date',
            'slot_meal_type'     => 'required|in:BREAKFAST,LUNCH,DINNER,SNACK',
            'slot_start'         => 'required',
            'slot_end'           => 'required',
            'slot_capacity'      => 'required|integer|min:1',
        ], [
            'slot_restaurant_id.required' => 'يجب اختيار مطعم.',
            'slot_date.required'          => 'يجب اختيار تاريخ الوجبة.',
            'slot_meal_type.required'     => 'يجب اختيار نوع الوجبة.',
        ]);

        $data = [
            'restaurant_id' => $this->slot_restaurant_id,
            'date'          => $this->slot_date,
            'meal_type'     => $this->slot_meal_type,
            'start_time'    => $this->slot_start,
            'end_time'      => $this->slot_end,
            'max_capacity'  => $this->slot_capacity,
            'is_open'       => $this->slot_is_open,
            'notes'         => $this->slot_notes ?: null,
        ];

        if ($this->slotEditing) {
            MealSlot::findOrFail($this->slotEditId)->update($data);
            $this->flash('تم تحديث خانة الوجبة بنجاح.');
        } else {
            MealSlot::create(array_merge($data, ['uuid' => (string) Str::uuid()]));
            $this->flash('تمت إضافة خانة الوجبة بنجاح.');
        }

        $this->slotFormOpen = false;
        $this->resetSlotForm();
        $this->resetPage();
    }

    public function toggleSlotStatus(int $id): void
    {
        $s = MealSlot::findOrFail($id);
        $s->update(['is_open' => !$s->is_open]);
        $this->flash($s->is_open ? 'تم فتح الوجبة.' : 'تم إغلاق الوجبة.');
    }

    // Clone a full day's slots to another date
    public function cloneDaySlots(string $fromDate, string $toDate): void
    {
        $slots = MealSlot::whereDate('date', $fromDate)->get();

        if ($slots->isEmpty()) {
            $this->flash('لا توجد خانات لهذا اليوم.', 'warning');
            return;
        }

        foreach ($slots as $slot) {
            MealSlot::create(array_merge($slot->toArray(), [
                'id'   => null,
                'uuid' => (string) Str::uuid(),
                'date' => $toDate,
            ]));
        }

        $this->flash("تم نسخ " . $slots->count() . " خانة من {$fromDate} إلى {$toDate} بنجاح.");
    }

    // ────────────────────────────────────────────────────────
    // ENTITLEMENT MANAGEMENT
    // ────────────────────────────────────────────────────────
    public function openEntitlementForm(int $slotId): void
    {
        $this->ent_meal_slot_id  = $slotId;
        $this->ent_assign_type   = 'delegation';
        $this->ent_user_id       = null;
        $this->ent_country_id    = null;
        $this->entitlementFormOpen = true;
    }

    public function saveEntitlement(): void
    {
        $this->validate([
            'ent_meal_slot_id' => 'required|exists:meal_slots,id',
            'ent_assign_type'  => 'required|in:user,delegation',
        ]);

        $slot = MealSlot::findOrFail($this->ent_meal_slot_id);

        if ($this->ent_assign_type === 'delegation') {
            $this->validate(['ent_country_id' => 'required|exists:countries,id']);

            // Grant entitlement to all users of this delegation
            $users = User::where('country_id', $this->ent_country_id)->where('is_active', true)->get();
            $created = 0;

            foreach ($users as $user) {
                $exists = MealEntitlement::where('meal_slot_id', $this->ent_meal_slot_id)
                    ->where('user_id', $user->id)->exists();

                if (!$exists) {
                    MealEntitlement::create([
                        'uuid'          => (string) Str::uuid(),
                        'meal_slot_id'  => $this->ent_meal_slot_id,
                        'restaurant_id' => $slot->restaurant_id,
                        'user_id'       => $user->id,
                        'country_id'    => $this->ent_country_id,
                        'status'        => 'ACTIVE',
                        'created_by'    => Auth::id(),
                    ]);
                    $created++;
                }
            }

            $this->flash("تم منح {$created} استحقاق وجبة لأعضاء الوفد بنجاح.");
        } else {
            $this->validate(['ent_user_id' => 'required|exists:users,id']);

            MealEntitlement::firstOrCreate(
                ['meal_slot_id' => $this->ent_meal_slot_id, 'user_id' => $this->ent_user_id],
                [
                    'uuid'          => (string) Str::uuid(),
                    'restaurant_id' => $slot->restaurant_id,
                    'country_id'    => User::find($this->ent_user_id)?->country_id,
                    'status'        => 'ACTIVE',
                    'created_by'    => Auth::id(),
                ]
            );

            $this->flash('تم منح استحقاق الوجبة للشخص بنجاح.');
        }

        $this->entitlementFormOpen = false;
    }

    public function revokeEntitlement(int $id): void
    {
        MealEntitlement::findOrFail($id)->update(['status' => 'CANCELLED']);
        $this->flash('تم إلغاء الاستحقاق.');
    }

    // ────────────────────────────────────────────────────────
    // RENDER
    // ────────────────────────────────────────────────────────
    public function render()
    {
        // Today's KPIs
        $todaySlots = MealSlot::with('restaurant', 'scans')->whereDate('date', today())->get();
        $totalAuthorized = MealScan::whereDate('scanned_at', today())->where('status', 'AUTHORIZED')->count();
        $totalDenied     = MealScan::whereDate('scanned_at', today())->where('status', 'DENIED')->count();
        $totalDuplicate  = MealScan::whereDate('scanned_at', today())->where('status', 'DUPLICATE')->count();
        $totalCapacity   = $todaySlots->sum('max_capacity');

        // Restaurants list
        $restaurants = Restaurant::withCount(['mealSlots'])
            ->when($this->search, fn($q) => $q->where('name_ar', 'like', "%{$this->search}%"))
            ->when($this->filterStatus === 'active',   fn($q) => $q->where('is_active', true))
            ->when($this->filterStatus === 'inactive', fn($q) => $q->where('is_active', false))
            ->latest()
            ->paginate(15);

        // Meal Slots
        $slotsDate = $this->filterDate ?: today()->toDateString();
        $mealSlots = MealSlot::with(['restaurant', 'scans'])
            ->when($slotsDate, fn($q) => $q->whereDate('date', $slotsDate))
            ->when($this->filterMeal, fn($q) => $q->where('meal_type', $this->filterMeal))
            ->orderBy('start_time')
            ->paginate(20);

        // Scans log
        $scansLog = MealScan::with(['mealSlot.restaurant', 'user'])
            ->when($this->filterDate, fn($q) => $q->whereDate('scanned_at', $this->filterDate))
            ->when($this->filterMeal, fn($q) => $q->where('meal_type_snapshot', $this->filterMeal))
            ->when($this->filterStatus, fn($q) => $q->where('status', strtoupper($this->filterStatus)))
            ->latest('scanned_at')
            ->paginate(30);

        $allRestaurants = Restaurant::where('is_active', true)->orderBy('name_ar')->get();
        $allCountries   = Country::where('is_active', true)->orderBy('name_ar')->get();
        $allUsers       = User::where('is_active', true)->orderBy('name')->get();

        return view('livewire.admin.restaurants.index', compact(
            'restaurants', 'mealSlots', 'scansLog',
            'todaySlots', 'totalAuthorized', 'totalDenied', 'totalDuplicate', 'totalCapacity',
            'allRestaurants', 'allCountries', 'allUsers'
        ));
    }

    // ── Helpers ───────────────────────────────────────────────
    private function flash(string $msg, string $type = 'success'): void
    {
        $this->flashMessage = $msg;
        $this->flashType    = $type;
        $this->dispatch('flash-message');
    }

    private function resetRestaurantForm(): void
    {
        $this->restaurantEditing = false;
        $this->restaurantEditId  = null;
        $this->name_ar = $this->name_fr = $this->name_en = '';
        $this->location = $this->contact_phone = $this->notes_r = '';
        $this->capacity  = 300;
        $this->is_active = true;
    }

    private function resetSlotForm(): void
    {
        $this->slotEditing       = false;
        $this->slotEditId        = null;
        $this->slot_restaurant_id = null;
        $this->slot_date         = today()->toDateString();
        $this->slot_meal_type    = 'LUNCH';
        $this->slot_start        = '12:00';
        $this->slot_end          = '14:30';
        $this->slot_capacity     = 300;
        $this->slot_is_open      = true;
        $this->slot_notes        = '';
    }

    // Export Scans to CSV
    public function exportScansCsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $date = $this->filterDate ?: today()->toDateString();

        return response()->streamDownload(function () use ($date) {
            $bom = "\xEF\xBB\xBF";
            echo $bom;
            echo "التاريخ,الوجبة,المطعم,الاسم,الدولة,رمز الشارة,الحالة,سبب الرفض,وقت المسح\n";

            MealScan::with(['mealSlot.restaurant', 'user'])
                ->whereDate('scanned_at', $date)
                ->orderBy('scanned_at')
                ->chunk(500, function ($rows) {
                    foreach ($rows as $r) {
                        echo implode(',', [
                            $r->mealSlot?->date?->format('Y-m-d') ?? '',
                            $r->meal_type_snapshot ?? '',
                            '"' . ($r->restaurant_snapshot ?? '') . '"',
                            '"' . ($r->participant_name_snapshot ?? '') . '"',
                            '"' . ($r->country_snapshot ?? '') . '"',
                            $r->badge_code ?? '',
                            $r->status,
                            '"' . ($r->denial_reason ?? '') . '"',
                            $r->scanned_at?->format('H:i:s') ?? '',
                        ]) . "\n";
                    }
                });
        }, "meal_scans_{$date}.csv", ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
