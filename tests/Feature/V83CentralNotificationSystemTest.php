<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\Country;
use App\Models\MealEntitlement;
use App\Models\MealSlot;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\Restaurant;
use App\Models\Skill;
use App\Models\User;
use App\Models\UserNotification;
use App\Models\WsapNotification;
use App\Services\Notifications\NotificationActionResolver;
use App\Services\Notifications\NotificationService;
use App\Services\Notifications\NotificationTargetResolver;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class V83CentralNotificationSystemTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $participantUser;
    protected User $judgeUser;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => RoleEnum::SUPER_ADMIN->value]);
        Role::firstOrCreate(['name' => RoleEnum::PARTICIPANT->value]);
        Role::firstOrCreate(['name' => RoleEnum::JUDGE->value]);

        $this->superAdmin = User::factory()->create([
            'name' => 'Super Admin Notification Tester',
            'email' => 'admin.notify@worldskills.dz',
            'is_active' => true,
        ]);
        $this->superAdmin->assignRole(RoleEnum::SUPER_ADMIN->value);

        $this->participantUser = User::factory()->create([
            'name' => 'Competitor One',
            'email' => 'participant1@worldskills.dz',
            'is_active' => true,
        ]);
        $this->participantUser->assignRole(RoleEnum::PARTICIPANT->value);

        $this->judgeUser = User::factory()->create([
            'name' => 'Expert Judge One',
            'email' => 'judge1@worldskills.dz',
            'is_active' => true,
        ]);
        $this->judgeUser->assignRole(RoleEnum::JUDGE->value);
    }

    public function test_super_admin_can_access_notification_center(): void
    {
        $response = $this->actingAs($this->superAdmin)->get(route('admin.notifications.index'));
        $response->assertStatus(200);
        $response->assertSee('مركز التنبيهات والتواصل المركزي');
    }

    public function test_non_admin_cannot_access_notification_center(): void
    {
        $response = $this->actingAs($this->participantUser)->get(route('admin.notifications.index'));
        $response->assertStatus(403);
    }

    public function test_target_resolver_deduplicates_and_resolves_role_targets(): void
    {
        $resolver = new NotificationTargetResolver();

        $userIds = $resolver->resolveUserIds([
            ['target_type' => 'role', 'target_id' => 'PARTICIPANT'],
            ['target_type' => 'individual_user', 'target_id' => (string) $this->participantUser->id],
        ]);

        $this->assertContains($this->participantUser->id, $userIds);
        $this->assertNotContains($this->judgeUser->id, $userIds);
        $this->assertEquals(count(array_unique($userIds)), count($userIds));
    }

    public function test_target_resolver_resolves_meal_slot_entitlements(): void
    {
        $restaurant = Restaurant::create(['name_ar' => 'مطعم الوفود 1', 'is_active' => true]);
        $slot = MealSlot::create([
            'restaurant_id' => $restaurant->id,
            'meal_type' => 'LUNCH',
            'meal_label' => 'غداء الوفود',
            'date' => now()->toDateString(),
            'start_time' => '12:00',
            'end_time' => '14:00',
            'max_capacity' => 100,
            'is_open' => true,
        ]);

        MealEntitlement::create([
            'restaurant_id' => $restaurant->id,
            'meal_slot_id' => $slot->id,
            'user_id' => $this->participantUser->id,
            'allowed_meals_count' => 1,
        ]);

        $resolver = new NotificationTargetResolver();
        $userIds = $resolver->resolveUserIds([
            ['target_type' => 'meal_slot', 'target_id' => (string) $slot->id]
        ]);

        $this->assertContains($this->participantUser->id, $userIds);
        $this->assertNotContains($this->judgeUser->id, $userIds);
    }

    public function test_notification_dispatch_freezes_recipient_snapshot_with_idempotency(): void
    {
        $service = app(NotificationService::class);

        $notification = $service->createNotification([
            'type' => 'MEAL',
            'title_ar' => '🍽️ وجبة الغداء مفتوحة',
            'body_ar' => 'يرجى التوجه للمطعم الإقليمي وإبراز الشارة',
            'created_by' => $this->superAdmin->id,
            'priority' => 'HIGH',
        ], [
            ['target_type' => 'role', 'target_id' => 'PARTICIPANT'],
        ]);

        $res1 = $service->dispatchNotification($notification);
        $this->assertEquals('sent', $res1['status']);
        $this->assertGreaterThan(0, $res1['recipients_count']);

        // Test Idempotency: re-dispatching must not duplicate user_notifications records
        $res2 = $service->dispatchNotification($notification->fresh());
        $this->assertEquals('already_sent', $res2['status']);

        $userNotifCount = UserNotification::where('notification_id', $notification->id)
            ->where('user_id', $this->participantUser->id)
            ->count();

        $this->assertEquals(1, $userNotifCount);
    }

    public function test_user_can_view_notifications_and_mark_as_read(): void
    {
        $service = app(NotificationService::class);

        $notification = $service->createNotification([
            'type' => 'GENERAL',
            'title_ar' => 'إعلان هام للجميع',
            'body_ar' => 'تفاصيل الإعلان العام المنشور',
            'created_by' => $this->superAdmin->id,
        ], [
            ['target_type' => 'individual_user', 'target_id' => (string) $this->participantUser->id],
        ]);

        $service->dispatchNotification($notification);

        $userNotif = UserNotification::where('user_id', $this->participantUser->id)
            ->where('notification_id', $notification->id)
            ->firstOrFail();

        $this->assertEquals('DELIVERED', $userNotif->status);

        $userNotif->markAsRead();
        $this->assertEquals('READ', $userNotif->fresh()->status);
        $this->assertNotNull($userNotif->fresh()->read_at);
    }

    public function test_action_resolver_maps_typed_actions_to_safe_routes(): void
    {
        $url1 = NotificationActionResolver::resolveUrl('MEAL_SLOT', '12');
        $this->assertStringContainsString('meal-scanner', $url1);

        $url2 = NotificationActionResolver::resolveUrl('RESTAURANT', null);
        $this->assertStringContainsString('restaurants', $url2);

        $url3 = NotificationActionResolver::resolveUrl('ACCOMMODATION', null);
        $this->assertStringContainsString('accommodations', $url3);

        $urlFallback = NotificationActionResolver::resolveUrl('UNKNOWN', null);
        $this->assertStringContainsString('/notifications', $urlFallback);
    }

    public function test_notification_creation_via_livewire_builder(): void
    {
        Livewire::actingAs($this->superAdmin)
            ->test(\App\Livewire\Admin\Notifications\NotificationCreate::class)
            ->set('type', 'URGENT')
            ->set('priority', 'URGENT')
            ->set('title_ar', '🚨 تنبيه عاجل لاختبار النظام')
            ->set('body_ar', 'تفاصيل التنبيه العاجل الموجه من الإدارة العامة')
            ->set('targetRoles', ['PARTICIPANT'])
            ->call('saveAndDispatch')
            ->assertRedirect(route('admin.notifications.index'));

        $this->assertDatabaseHas('wsap_notifications', [
            'title_ar' => '🚨 تنبيه عاجل لاختبار النظام',
            'priority' => 'URGENT',
            'status' => 'SENT',
        ]);
    }
}
