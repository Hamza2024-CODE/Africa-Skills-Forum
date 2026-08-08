<?php

namespace Tests\Feature\Security;

use App\Models\Country;
use App\Models\Edition;
use App\Models\ParticipantProfile;
use App\Models\Skill;
use App\Models\User;
use App\Services\HomepageStatisticsService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class V71FullFunctionalAuditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_mysql_database_integrity_and_real_data_counts(): void
    {
        $driver = DB::connection()->getDriverName();
        $this->assertContains($driver, ['mysql', 'sqlite']);

        $africanCount = Country::where('is_african', true)->count();
        $this->assertGreaterThanOrEqual(54, $africanCount);

        $statsService = new HomepageStatisticsService();
        $stats = $statsService->getStatistics();

        $this->assertIsInt($stats['countries']);
        $this->assertGreaterThanOrEqual(54, $stats['countries']);
        $this->assertIsInt($stats['skills']);
    }

    public function test_users_have_must_change_password_flag_for_first_login_security(): void
    {
        $superAdmin = User::where('email', 'admin@worldskills.dz')->first();
        $this->assertNotNull($superAdmin);
        $this->assertTrue(isset($superAdmin->must_change_password));
    }

    public function test_full_role_isolation_matrix_across_all_roles(): void
    {
        // 1. Super Admin
        $superAdmin = User::where('email', 'admin@worldskills.dz')->first();
        $this->actingAs($superAdmin)->get('/admin/dashboard')->assertStatus(200);

        // 2. Media Manager
        $mediaAdmin = User::where('email', 'media@worldskills.dz')->first();
        $this->actingAs($mediaAdmin)->get('/admin/media/dashboard')->assertStatus(200);
        $this->actingAs($mediaAdmin)->get('/admin/dashboard')->assertStatus(403);

        // 3. Executive Viewer (Read Only)
        $execViewer = User::where('email', 'viewer@worldskills.dz')->first();
        $this->actingAs($execViewer)->get('/executive/dashboard')->assertStatus(200);
        $this->actingAs($execViewer)->get('/admin/dashboard')->assertStatus(403);

        // 4. Country Admin
        $countryAdmin = User::where('email', 'dz.admin@worldskills.dz')->first();
        $this->actingAs($countryAdmin)->get('/country/dashboard')->assertStatus(200);
        $this->actingAs($countryAdmin)->get('/admin/dashboard')->assertStatus(403);
    }
}
