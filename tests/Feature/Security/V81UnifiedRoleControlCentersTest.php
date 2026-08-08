<?php

namespace Tests\Feature\Security;

use App\Enums\RoleEnum;
use App\Livewire\Admin\MediaManagerDashboard;
use App\Livewire\Admin\SuperAdminDashboard;
use App\Livewire\Country\CountryDashboard;
use App\Livewire\Executive\ExecutiveDashboard;
use App\Livewire\Judge\JudgeDashboard;
use App\Livewire\Organization\OrganizationDashboard;
use App\Livewire\Participant\ParticipantDashboard;
use App\Models\Country;
use App\Models\Organization;
use App\Models\User;
use App\Services\DashboardNavigationService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class V81UnifiedRoleControlCentersTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    // ─── Navigation ────────────────────────────────────────────────────────────

    public function test_dashboard_navigation_service_returns_role_isolated_menus(): void
    {
        $navService = app(DashboardNavigationService::class);

        /** @var User $superAdmin */
        $superAdmin = User::create(['name' => 'SA', 'email' => 'sa.nav@ws.dz', 'password' => bcrypt('password')]);
        $superAdmin->assignRole(RoleEnum::SUPER_ADMIN->value);

        /** @var User $mediaManager */
        $mediaManager = User::create(['name' => 'MM', 'email' => 'mm.nav@ws.dz', 'password' => bcrypt('password')]);
        $mediaManager->assignRole(RoleEnum::MEDIA_MANAGER->value);

        /** @var User $judge */
        $judge = User::create(['name' => 'JU', 'email' => 'ju.nav@ws.dz', 'password' => bcrypt('password')]);
        $judge->assignRole(RoleEnum::JUDGE->value);

        $this->assertGreaterThanOrEqual(8, count($navService->getNavigation($superAdmin)));
        $this->assertCount(4, $navService->getNavigation($mediaManager));
        $this->assertCount(2, $navService->getNavigation($judge));
    }

    // ─── Super Admin ────────────────────────────────────────────────────────────

    public function test_super_admin_command_center_renders_successfully(): void
    {
        /** @var User $user */
        $user = User::create(['name' => 'SA', 'email' => 'sa@ws.dz', 'password' => bcrypt('password')]);
        $user->assignRole(RoleEnum::SUPER_ADMIN->value);
        $this->actingAs($user);

        $this->get('/admin/dashboard?lang=ar')->assertStatus(200);

        Livewire::test(SuperAdminDashboard::class)
            ->assertSee('PLATFORM OPERATIONAL')
            ->assertSee('CURRENT EDITION');
    }

    // ─── Media Manager ──────────────────────────────────────────────────────────

    public function test_media_manager_center_renders_successfully(): void
    {
        /** @var User $user */
        $user = User::create(['name' => 'MM', 'email' => 'mm@ws.dz', 'password' => bcrypt('password')]);
        $user->assignRole(RoleEnum::MEDIA_MANAGER->value);
        $this->actingAs($user);

        $this->get('/admin/media/dashboard?lang=ar')->assertStatus(200);

        Livewire::test(MediaManagerDashboard::class)
            ->assertSee('لوحة إدارة الإعلام والأخبار والمحتوى الرقمي');
    }

    // ─── Executive Viewer ───────────────────────────────────────────────────────

    public function test_executive_viewer_renders_read_only(): void
    {
        /** @var User $user */
        $user = User::create(['name' => 'EX', 'email' => 'ex@ws.dz', 'password' => bcrypt('password')]);
        $user->assignRole(RoleEnum::EXECUTIVE_VIEWER->value);
        $this->actingAs($user);

        $this->get('/executive/dashboard?lang=ar')->assertStatus(200);

        Livewire::test(ExecutiveDashboard::class)
            ->assertSee('اللوحة التنفيذية العليا');
    }

    public function test_executive_viewer_blocks_mutative_delete_action(): void
    {
        /** @var User $user */
        $user = User::create(['name' => 'EX2', 'email' => 'ex2@ws.dz', 'password' => bcrypt('password')]);
        $user->assignRole(RoleEnum::EXECUTIVE_VIEWER->value);
        $this->actingAs($user);

        // deleteRecord() throws AuthorizationException → Livewire returns 403
        Livewire::test(ExecutiveDashboard::class)
            ->call('deleteRecord')
            ->assertForbidden();
    }

    // ─── Country Admin ──────────────────────────────────────────────────────────

    public function test_country_admin_center_renders_own_country(): void
    {
        $country = Country::where('iso2', 'DZ')->first() ?? Country::first();

        /** @var User $user */
        $user = User::create(['name' => 'CA', 'email' => 'ca@ws.dz', 'password' => bcrypt('password'), 'country_id' => $country->id]);
        $user->assignRole(RoleEnum::COUNTRY_ADMIN->value);
        $this->actingAs($user);

        Livewire::test(CountryDashboard::class)
            ->assertSee('مركز إدارة الوفد والمشاركة الرسمية');
    }

    public function test_country_admin_center_blocks_cross_country_idor(): void
    {
        $countryA = Country::where('iso2', 'DZ')->first() ?? Country::first();
        $countryB = Country::where('iso2', 'TN')->first() ?? Country::whereKeyNot($countryA->id)->first();

        /** @var User $user */
        $user = User::create(['name' => 'CA2', 'email' => 'ca2@ws.dz', 'password' => bcrypt('password'), 'country_id' => $countryA->id]);
        $user->assignRole(RoleEnum::COUNTRY_ADMIN->value);
        $this->actingAs($user);

        // Cross-country mount → AuthorizationException → 403
        Livewire::test(CountryDashboard::class, ['targetCountryId' => $countryB?->id ?? 9999])
            ->assertForbidden();
    }

    // ─── Organization Admin ─────────────────────────────────────────────────────

    public function test_organization_admin_center_renders_own_org(): void
    {
        $country = Country::first();
        $org = Organization::first() ?? Organization::create(['country_id' => $country->id, 'code' => 'TST-001', 'name_ar' => 'معهد أول', 'name_fr' => 'Inst A', 'is_active' => true]);

        /** @var User $user */
        $user = User::create(['name' => 'OA', 'email' => 'oa@ws.dz', 'password' => bcrypt('password'), 'organization_id' => $org->id]);
        $user->assignRole(RoleEnum::ORGANIZATION_ADMIN->value);
        $this->actingAs($user);

        Livewire::test(OrganizationDashboard::class)
            ->assertSee('مركز المؤسسة التكوينية والتدريب');
    }

    public function test_organization_admin_center_blocks_cross_org_idor(): void
    {
        $country = Country::first();
        $orgA = Organization::first() ?? Organization::create(['country_id' => $country->id, 'code' => 'TST-A', 'name_ar' => 'معهد أول', 'name_fr' => 'Inst A', 'is_active' => true]);
        $orgB = Organization::whereKeyNot($orgA->id)->first() ?? Organization::create(['country_id' => $country->id, 'code' => 'TST-B', 'name_ar' => 'معهد ثان', 'name_fr' => 'Inst B', 'is_active' => true]);

        /** @var User $user */
        $user = User::create(['name' => 'OA2', 'email' => 'oa2@ws.dz', 'password' => bcrypt('password'), 'organization_id' => $orgA->id]);
        $user->assignRole(RoleEnum::ORGANIZATION_ADMIN->value);
        $this->actingAs($user);

        // Cross-org mount → AuthorizationException → 403
        Livewire::test(OrganizationDashboard::class, ['targetOrgId' => $orgB?->id ?? 9999])
            ->assertForbidden();
    }

    // ─── Judge ──────────────────────────────────────────────────────────────────

    public function test_judge_center_renders_successfully(): void
    {
        /** @var User $user */
        $user = User::create(['name' => 'JU', 'email' => 'ju@ws.dz', 'password' => bcrypt('password')]);
        $user->assignRole(RoleEnum::JUDGE->value);
        $this->actingAs($user);

        Livewire::test(JudgeDashboard::class)
            ->assertSee('مركز لجنة التحكيم وتقييم المتنافسين');
    }

    public function test_judge_center_blocks_unassigned_candidate_evaluation(): void
    {
        /** @var User $user */
        $user = User::create(['name' => 'JU2', 'email' => 'ju2@ws.dz', 'password' => bcrypt('password')]);
        $user->assignRole(RoleEnum::JUDGE->value);
        $this->actingAs($user);

        // openEvaluation with non-existent ID → AuthorizationException → 403
        Livewire::test(JudgeDashboard::class)
            ->call('openEvaluation', 999999999)
            ->assertForbidden();
    }

    // ─── Participant ─────────────────────────────────────────────────────────────

    public function test_participant_space_renders_5_step_competition_journey(): void
    {
        /** @var User $user */
        $user = User::create(['name' => 'PT', 'email' => 'pt@ws.dz', 'password' => bcrypt('password')]);
        $user->assignRole(RoleEnum::PARTICIPANT->value);
        $this->actingAs($user);

        Livewire::test(ParticipantDashboard::class)
            ->assertSee('مرحباً بك في فضاء المتنافس الأولمبي')
            ->assertSee('تقديم الطلب')
            ->assertSee('الاعتماد والجاهزية');
    }
}
