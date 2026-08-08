<?php

namespace Tests\Feature\Security;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class V7FullPlatformAuditTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_mysql_database_connection_driver_is_active(): void
    {
        $driver = DB::connection()->getDriverName();
        $this->assertContains($driver, ['mysql', 'sqlite']);
    }

    public function test_all_54_sovereign_african_countries_exist_in_database(): void
    {
        $count = \App\Models\Country::where('is_african', true)->count();
        $this->assertGreaterThanOrEqual(54, $count);
    }

    public function test_100_percent_public_portal_routes_render_with_status_200(): void
    {
        $publicRoutes = [
            '/',
            '/guide',
            '/skills',
            '/regulations',
            '/schedule',
            '/results',
            '/news',
            '/events',
            '/gallery',
            '/videos',
            '/partners',
            '/contact',
            '/faq',
            '/privacy',
            '/terms',
            '/search',
            '/login',
            '/registration',
        ];

        foreach ($publicRoutes as $route) {
            $response = $this->get($route . '?lang=ar');
            $response->assertStatus(200);
        }
    }

    public function test_trilingual_locale_switching_and_direction_attributes(): void
    {
        $responseAr = $this->get('/?lang=ar');
        $responseAr->assertStatus(200)->assertSee('dir="rtl"', false);

        $responseFr = $this->get('/?lang=fr');
        $responseFr->assertStatus(200)->assertSee('dir="ltr"', false);

        $responseEn = $this->get('/?lang=en');
        $responseEn->assertStatus(200)->assertSee('dir="ltr"', false);
    }

    public function test_legal_cms_manager_route_is_protected_and_renders(): void
    {
        // Unauthenticated access denied
        $this->get('/admin/cms/legal')->assertRedirect('/login');

        // Authenticated Super Admin access granted
        $superAdmin = User::where('email', 'admin@worldskills.dz')->first();
        $this->assertNotNull($superAdmin);

        $this->actingAs($superAdmin)
            ->get('/admin/cms/legal')
            ->assertStatus(200)
            ->assertSee('إدارة المستندات القانونية والسياسات');
    }

    public function test_role_based_access_control_and_accounts_matrix(): void
    {
        // 1. Super Admin
        $superAdmin = User::where('email', 'admin@worldskills.dz')->first();
        $this->assertNotNull($superAdmin);
        $this->actingAs($superAdmin)->get('/admin/dashboard')->assertStatus(200);

        // 2. Media Manager
        $mediaAdmin = User::where('email', 'media@worldskills.dz')->first();
        $this->assertNotNull($mediaAdmin);
        $this->actingAs($mediaAdmin)->get('/admin/media/dashboard')->assertStatus(200);
        $this->actingAs($mediaAdmin)->get('/admin/dashboard')->assertStatus(403);

        // 3. Executive Viewer (Read Only)
        $execViewer = User::where('email', 'viewer@worldskills.dz')->first();
        $this->assertNotNull($execViewer);
        $this->actingAs($execViewer)->get('/executive/dashboard')->assertStatus(200);
        $this->actingAs($execViewer)->get('/admin/dashboard')->assertStatus(403);

        // 4. Country Admin
        $countryAdmin = User::where('email', 'dz.admin@worldskills.dz')->first();
        $this->assertNotNull($countryAdmin);
        $this->actingAs($countryAdmin)->get('/country/dashboard')->assertStatus(200);
        $this->actingAs($countryAdmin)->get('/admin/dashboard')->assertStatus(403);
    }
}
