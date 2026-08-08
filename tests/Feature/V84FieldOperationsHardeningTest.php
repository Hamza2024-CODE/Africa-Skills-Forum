<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\AccessDecisionLog;
use App\Models\Badge;
use App\Models\User;
use App\Services\Badges\BadgeManagementService;
use App\Services\Emergency\EmergencyControlService;
use App\Services\Offline\OfflineScannerSyncService;
use App\Services\Rules\AntiPassbackEngine;
use App\Services\Rules\WsapAccessRulesEngine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class V84FieldOperationsHardeningTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;
    protected User $participantUser;
    protected Badge $participantBadge;
    protected WsapAccessRulesEngine $rulesEngine;
    protected BadgeManagementService $badgeService;
    protected EmergencyControlService $emergencyService;
    protected OfflineScannerSyncService $syncService;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => RoleEnum::SUPER_ADMIN->value]);
        Role::firstOrCreate(['name' => RoleEnum::PARTICIPANT->value]);

        $this->superAdmin = User::factory()->create([
            'name'      => 'Field Super Admin',
            'email'     => 'field.admin@worldskills.dz',
            'is_active' => true,
        ]);
        $this->superAdmin->assignRole(RoleEnum::SUPER_ADMIN->value);

        $this->participantUser = User::factory()->create([
            'name'      => 'Competitor Beta',
            'email'     => 'comp.beta@worldskills.dz',
            'is_active' => true,
        ]);
        $this->participantUser->assignRole(RoleEnum::PARTICIPANT->value);

        $this->participantBadge = Badge::create([
            'user_id'    => $this->participantUser->id,
            'role_title' => 'COMPETITOR',
            'status'     => 'ACTIVE',
        ]);

        $this->emergencyService = app(EmergencyControlService::class);
        $this->badgeService     = app(BadgeManagementService::class);
        $this->rulesEngine      = app(WsapAccessRulesEngine::class);
        $this->syncService       = app(OfflineScannerSyncService::class);
    }

    public function test_badge_revocation_instantly_blocks_all_access(): void
    {
        $this->badgeService->revokeBadge($this->participantBadge, 'فقدان الشارة في الموقع', 'LOST');

        $res = $this->rulesEngine->evaluateAccess($this->participantBadge->access_token);

        $this->assertFalse($res['is_allowed']);
        $this->assertEquals('BADGE_REVOKED', $res['reason_code']);

        $this->assertDatabaseHas('wsap_badge_replacements', [
            'original_badge_id' => $this->participantBadge->id,
            'action_type'       => 'LOST',
        ]);
    }

    public function test_anti_passback_engine_blocks_duplicate_scans_within_buffer_window(): void
    {
        $restaurant = \App\Models\Restaurant::create(['name_ar' => 'مطعم A', 'is_active' => true]);
        $slot = \App\Models\MealSlot::create([
            'restaurant_id' => $restaurant->id,
            'meal_type'     => 'LUNCH',
            'meal_label'    => 'غداء غداء',
            'date'          => now()->toDateString(),
            'start_time'    => '12:00',
            'end_time'      => '14:00',
            'max_capacity'  => 10,
            'is_open'       => true,
        ]);

        \App\Models\MealEntitlement::create([
            'restaurant_id' => $restaurant->id,
            'meal_slot_id'  => $slot->id,
            'user_id'       => $this->participantUser->id,
        ]);

        // First scan allowed
        $res1 = $this->rulesEngine->evaluateAccess($this->participantBadge->access_token, 'MEAL_SLOT', (string) $slot->id);
        $this->assertTrue($res1['is_allowed']);

        // Second immediate scan must trigger Anti-Passback violation
        $res2 = $this->rulesEngine->evaluateAccess($this->participantBadge->access_token, 'MEAL_SLOT', (string) $slot->id);
        $this->assertFalse($res2['is_allowed']);
        $this->assertEquals('ANTI_PASSBACK_VIOLATION', $res2['reason_code']);
    }

    public function test_emergency_lockdown_blocks_access_to_target_scope(): void
    {
        $this->emergencyService->initiateLockdown('MEAL_SLOT', '1', 'إغلاق طارئ للمطعم A', 'دواعي أمنية عاجلة');

        $res = $this->rulesEngine->evaluateAccess($this->participantBadge->access_token, 'MEAL_SLOT', '1');

        $this->assertFalse($res['is_allowed']);
        $this->assertEquals('EMERGENCY_LOCKDOWN_ACTIVE', $res['reason_code']);
    }

    public function test_super_admin_emergency_override_grants_access_and_logs_audit(): void
    {
        $res = $this->rulesEngine->evaluateAccessWithOverride(
            $this->participantBadge->access_token,
            'إذن استثنائي صادر من اللجنة التنفيذية',
            'MEAL_SLOT',
            '1'
        );

        $this->assertTrue($res['is_allowed']);
        $this->assertEquals('SUPER_ADMIN_OVERRIDE', $res['reason_code']);

        $this->assertDatabaseHas('audit_logs', [
            'event' => 'SUPER_ADMIN_EMERGENCY_OVERRIDE',
        ]);
    }

    public function test_offline_scanner_sync_service_processes_queued_scans_idempotently(): void
    {
        $batch = [
            [
                'sync_uuid'          => 'SYNC-UUID-001',
                'badge_token'        => (string) $this->participantBadge->id,
                'service_type'       => 'MEAL_SLOT',
                'service_id'         => '1',
                'scanned_by'         => $this->superAdmin->id,
                'offline_scanned_at' => now()->toDateTimeString(),
            ],
        ];

        $result = $this->syncService->processOfflineBatch($batch);
        $this->assertEquals(1, $result['processed_count']);

        // Duplicate sync UUID must be skipped
        $result2 = $this->syncService->processOfflineBatch($batch);
        $this->assertEquals(0, $result2['processed_count']);
        $this->assertEquals(1, $result2['skipped_count']);
    }
}
