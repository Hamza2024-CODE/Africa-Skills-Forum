<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\AuditLog;
use App\Models\Badge;
use App\Models\BadgeZonePermission;
use App\Models\MealEntitlement;
use App\Models\MealSlot;
use App\Models\Restaurant;
use App\Models\ScheduleEvent;
use App\Models\User;

use App\Models\Zone;
use App\Services\Rules\WsapAccessRulesEngine;
use App\Services\Schedule\ScheduleNotificationDispatcher;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class V83EventOperationsPlatformTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $participantUser;
    protected User $judgeUser;
    protected Badge $participantBadge;
    protected Zone $zoneA;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => RoleEnum::SUPER_ADMIN->value]);
        Role::firstOrCreate(['name' => RoleEnum::PARTICIPANT->value]);
        Role::firstOrCreate(['name' => RoleEnum::JUDGE->value]);

        $this->superAdmin = User::factory()->create([
            'name' => 'Master Super Admin',
            'email' => 'master.admin@worldskills.dz',
            'is_active' => true,
        ]);
        $this->superAdmin->assignRole(RoleEnum::SUPER_ADMIN->value);

        $this->participantUser = User::factory()->create([
            'name' => 'Competitor Alpha',
            'email' => 'comp.alpha@worldskills.dz',
            'is_active' => true,
        ]);
        $this->participantUser->assignRole(RoleEnum::PARTICIPANT->value);

        $this->participantBadge = Badge::create([
            'user_id'    => $this->participantUser->id,
            'role_title' => 'COMPETITOR',
            'status'     => 'ACTIVE',
        ]);

        $this->judgeUser = User::factory()->create([
            'name' => 'Expert Judge Beta',
            'email' => 'judge.beta@worldskills.dz',
            'is_active' => true,
        ]);
        $this->judgeUser->assignRole(RoleEnum::JUDGE->value);

        $this->zoneA = Zone::create([
            'code'    => 'ZONE-A',
            'name_ar' => 'منطقة الورشات الرئيسية',
            'is_active' => true,
        ]);
    }

    public function test_polymorphic_schedule_event_creation_and_source_resolution(): void
    {
        $restaurant = Restaurant::create(['name_ar' => 'مطعم A', 'is_active' => true]);
        $slot = MealSlot::create([
            'restaurant_id' => $restaurant->id,
            'meal_type' => 'LUNCH',
            'meal_label' => 'وجبة الغداء A',
            'date' => now()->toDateString(),
            'start_time' => '12:00',
            'end_time' => '14:00',
            'max_capacity' => 100,
            'is_open' => true,
        ]);

        $event = ScheduleEvent::create([
            'event_type'    => 'MEAL_SLOT',
            'source_type'   => MealSlot::class,
            'source_id'     => (string) $slot->id,
            'title_ar'      => 'وجبة الغداء الرسمية',
            'start_at'      => now(),
            'end_at'        => now()->addHours(2),
            'status'        => 'SCHEDULED',
            'created_by'    => $this->superAdmin->id,
        ]);

        $this->assertInstanceOf(MealSlot::class, $event->source);
        $this->assertEquals($slot->id, $event->source->id);
    }

    public function test_valid_lifecycle_transitions_and_invalid_transitions_rejected(): void
    {
        $event = ScheduleEvent::create([
            'event_type' => 'TECHNICAL_MEETING',
            'title_ar'   => 'اجتماع تقني مغلق',
            'start_at'   => now(),
            'status'     => 'DRAFT',
            'created_by' => $this->superAdmin->id,
        ]);

        $this->assertTrue($event->transitionTo('SCHEDULED'));
        $this->assertEquals('SCHEDULED', $event->fresh()->status);

        $this->assertTrue($event->transitionTo('OPEN'));
        $this->assertEquals('OPEN', $event->fresh()->status);

        // Invalid transition: OPEN directly to DRAFT must fail
        $this->assertFalse($event->transitionTo('DRAFT'));
        $this->assertEquals('OPEN', $event->fresh()->status);
    }

    public function test_event_cancellation_dispatches_cancellation_notification(): void
    {
        $dispatcher = app(ScheduleNotificationDispatcher::class);

        $event = ScheduleEvent::create([
            'event_type'  => 'TECHNICAL_MEETING',
            'title_ar'    => 'اجتماع خبراء ميكانيك السيارات',
            'start_at'    => now(),
            'status'      => 'SCHEDULED',
            'auto_notify' => true,
            'created_by'  => $this->superAdmin->id,
        ]);

        $dispatcher->dispatchCancellationAlert($event);

        $this->assertDatabaseHas('wsap_notifications', [
            'priority' => 'URGENT',
            'type'     => 'URGENT',
        ]);
    }

    public function test_event_rescheduling_dispatches_smart_rescheduling_alert(): void
    {
        $dispatcher = app(ScheduleNotificationDispatcher::class);

        $event = ScheduleEvent::create([
            'event_type'  => 'TECHNICAL_MEETING',
            'title_ar'    => 'اجتماع تقنيات الويب',
            'start_at'    => now()->addHours(2),
            'status'      => 'SCHEDULED',
            'auto_notify' => true,
            'created_by'  => $this->superAdmin->id,
        ]);

        $dispatcher->dispatchReschedulingAlert($event, '14:00');

        $this->assertDatabaseHas('wsap_notifications', [
            'priority' => 'HIGH',
            'type'     => 'TECHNICAL_MEETING',
        ]);
    }

    public function test_reminder_idempotency_prevents_duplicate_dispatches(): void
    {
        $dispatcher = app(ScheduleNotificationDispatcher::class);

        $event = ScheduleEvent::create([
            'event_type'  => 'TECHNICAL_MEETING',
            'title_ar'    => 'تذكير بالاجتماع التقني',
            'start_at'    => now()->addMinutes(30),
            'status'      => 'SCHEDULED',
            'created_by'  => $this->superAdmin->id,
        ]);

        $dispatched1 = $dispatcher->dispatchReminderIfNeeded($event, 30);
        $this->assertTrue($dispatched1);

        // Re-dispatching same offset must be prevented by idempotency key
        $dispatched2 = $dispatcher->dispatchReminderIfNeeded($event, 30);
        $this->assertFalse($dispatched2);
    }

    public function test_access_rules_engine_authorizes_valid_badge_and_logs_audit_record(): void
    {
        $engine = new WsapAccessRulesEngine();

        $res = $engine->evaluateAccess($this->participantBadge->access_token, null, null, null);

        $this->assertTrue($res['is_allowed']);
        $this->assertEquals('ACCESS_GRANTED', $res['reason_code']);

        $this->assertDatabaseHas('audit_logs', [
            'event' => 'ACCESS_ALLOW',
            'user_id' => $this->participantUser->id,
        ]);
    }

    public function test_access_rules_engine_denies_inactive_user(): void
    {
        $this->participantUser->update(['is_active' => false]);
        $engine = new WsapAccessRulesEngine();

        $res = $engine->evaluateAccess($this->participantBadge->access_token);

        $this->assertFalse($res['is_allowed']);
        $this->assertEquals('USER_INACTIVE', $res['reason_code']);
    }

    public function test_access_rules_engine_denies_unauthorized_zone(): void
    {
        // Add explicit DENY permission for zone
        BadgeZonePermission::create([
            'badge_id'   => $this->participantBadge->id,
            'zone_id'    => $this->zoneA->id,
            'permission' => 'DENY',
        ]);

        $engine = new WsapAccessRulesEngine();
        $res = $engine->evaluateAccess($this->participantBadge->access_token, null, null, $this->zoneA->id);

        $this->assertFalse($res['is_allowed']);
        $this->assertEquals('ZONE_DENIED', $res['reason_code']);
    }

    public function test_transaction_safe_meal_capacity_blocks_exceeded_scans(): void
    {
        $restaurant = Restaurant::create(['name_ar' => 'مطعم السكن 1', 'is_active' => true]);
        $slot = MealSlot::create([
            'restaurant_id' => $restaurant->id,
            'meal_type' => 'LUNCH',
            'meal_label' => 'وجبة محدودة',
            'date' => now()->toDateString(),
            'start_time' => '12:00',
            'end_time' => '14:00',
            'max_capacity' => 1,
            'is_open' => true,
        ]);

        \App\Models\MealScan::create([
            'restaurant_id' => $restaurant->id,
            'meal_slot_id'  => $slot->id,
            'badge_id'      => $this->participantBadge->id,
            'scanned_by'    => $this->superAdmin->id,
            'status'        => 'AUTHORIZED',
        ]);

        MealEntitlement::create([
            'restaurant_id' => $restaurant->id,
            'meal_slot_id'  => $slot->id,
            'user_id'       => $this->participantUser->id,
        ]);

        $engine = new WsapAccessRulesEngine();
        $res = $engine->evaluateAccess($this->participantBadge->access_token, 'MEAL_SLOT', $slot->id);

        $this->assertFalse($res['is_allowed']);
        $this->assertEquals('MEAL_CAPACITY_EXCEEDED', $res['reason_code']);
    }
}
