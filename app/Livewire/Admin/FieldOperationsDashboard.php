<?php

namespace App\Livewire\Admin;

use App\Models\AccessDecisionLog;
use App\Models\Country;
use App\Models\EmergencyLockdown;
use App\Models\MealScan;
use App\Models\MealSlot;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\Restaurant;
use App\Models\ScheduleEvent;
use App\Models\Skill;
use App\Models\User;

use App\Models\UserNotification;
use App\Models\WsapNotification;
use App\Services\Emergency\EmergencyControlService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class FieldOperationsDashboard extends Component
{
    public bool   $showEmergencyModal = false;
    public string $lockdown_scope     = 'ZONE';
    public string $target_id          = '';
    public string $title_ar           = '';
    public string $reason_ar          = '';
    public string $flashMessage       = '';

    public function initiateLockdown(EmergencyControlService $emergencyService): void
    {
        $this->validate([
            'lockdown_scope' => 'required|string',
            'title_ar'       => 'required|string|max:255',
            'reason_ar'      => 'required|string',
        ]);

        $emergencyService->initiateLockdown(
            $this->lockdown_scope,
            $this->target_id ?: null,
            $this->title_ar,
            $this->reason_ar
        );

        $this->flashMessage = "تم تفعيل وضع الإغلاق الأمني للطوارئ بنجاح.";
        $this->showEmergencyModal = false;
        $this->title_ar = '';
        $this->reason_ar = '';
    }

    public function liftLockdown(int $lockdownId, EmergencyControlService $emergencyService): void
    {
        $lockdown = EmergencyLockdown::findOrFail($lockdownId);
        $emergencyService->liftLockdown($lockdown);
        $this->flashMessage = "تم رفع وضع الإغلاق الأمني للطوارئ.";
    }

    public function render()
    {
        $todayAccesses = AccessDecisionLog::whereDate('scanned_at', today())->get();
        $allowedToday  = $todayAccesses->where('decision', 'ALLOW')->count();
        $deniedToday   = $todayAccesses->where('decision', 'DENY')->count();

        $activeLockdowns = EmergencyLockdown::where('is_active', true)->get();
        $recentDecisions = AccessDecisionLog::with(['badge.user', 'operator', 'zone'])
            ->latest('scanned_at')
            ->take(15)
            ->get();

        $totalNotifications = WsapNotification::count();
        $deliveredCount     = UserNotification::count();
        $readCount          = UserNotification::whereNotNull('read_at')->orWhere('status', 'READ')->count();

        return view('livewire.admin.field-operations', [
            'totalUsers'         => User::count(),
            'totalParticipants'  => ParticipantProfile::count(),
            'totalCountries'     => Country::count(),
            'totalSkills'        => Skill::count(),
            'totalRestaurants'   => \Illuminate\Support\Facades\Schema::hasTable('restaurants') ? Restaurant::count() : 0,
            'activeMealSlots'    => \Illuminate\Support\Facades\Schema::hasTable('meal_slots') ? MealSlot::where('is_open', true)->count() : 0,
            'todayMealScans'     => \Illuminate\Support\Facades\Schema::hasTable('meal_scans') ? MealScan::whereDate('scanned_at', today())->count() : 0,
            'allowedToday'       => $allowedToday,
            'deniedToday'        => $deniedToday,
            'recentDecisions'    => $recentDecisions,
            'activeLockdowns'    => $activeLockdowns,
            'todayEvents'        => ScheduleEvent::whereDate('start_at', today())->get(),
            'totalNotifications' => $totalNotifications,
            'deliveredCount'     => $deliveredCount,
            'readCount'          => $readCount,
        ]);
    }
}
