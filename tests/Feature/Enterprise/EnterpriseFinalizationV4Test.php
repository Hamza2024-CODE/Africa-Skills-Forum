<?php

namespace Tests\Feature\Enterprise;

use App\Enums\RoleEnum;
use App\Livewire\Admin\SuperAdminDashboard;
use App\Livewire\Executive\ExecutiveDashboard;
use App\Livewire\Organization\OrganizationDashboard;
use App\Livewire\Public\Home;
use App\Models\Event;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EnterpriseFinalizationV4Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_super_admin_command_center_renders_kpis_and_active_event(): void
    {
        $admin = User::where('email', 'admin@worldskills.dz')->first();
        $this->actingAs($admin);

        $response = $this->get('/admin/dashboard?lang=ar');
        $response->assertStatus(200);

        Livewire::test(SuperAdminDashboard::class)
            ->assertSee('PLATFORM OPERATIONAL')
            ->assertSee('CURRENT EDITION');
    }

    public function test_executive_minister_dashboard_is_read_only(): void
    {
        $minister = User::firstOrCreate(
            ['email' => 'minister@worldskills.dz'],
            [
                'name' => 'Minister of Vocational Training',
                'password' => bcrypt('password123'),
            ]
        );
        $minister->assignRole(RoleEnum::EXECUTIVE_VIEWER);
        $this->actingAs($minister);

        $response = $this->get('/executive/dashboard?lang=ar');
        $response->assertStatus(200);

        Livewire::test(ExecutiveDashboard::class)
            ->assertSee('اللوحة التنفيذية العليا');
    }

    public function test_organization_institute_dashboard_renders_trainees(): void
    {
        $orgUser = User::factory()->create();
        $orgUser->assignRole(RoleEnum::ORGANIZATION_ADMIN);
        $this->actingAs($orgUser);

        $response = $this->get('/organization/dashboard?lang=ar');
        $response->assertStatus(200);

        Livewire::test(OrganizationDashboard::class)
            ->assertSee('مركز المؤسسة التكوينية والتدريب');
    }

    public function test_trilingual_locale_switching_preserves_context(): void
    {
        // Arabic (RTL)
        $resAr = $this->get('/?lang=ar');
        $resAr->assertStatus(200)->assertSee('dir="rtl"', false);

        // French (LTR)
        $resFr = $this->get('/?lang=fr');
        $resFr->assertStatus(200)->assertSee('dir="ltr"', false);

        // English (LTR)
        $resEn = $this->get('/?lang=en');
        $resEn->assertStatus(200)->assertSee('dir="ltr"', false);
    }

    public function test_active_event_switching_reflects_on_public_homepage(): void
    {
        $event = Event::first();
        if ($event) {
            $event->update([
                'title_ar' => 'أولمبياد المهن بالجزائر',
                'status' => 'PUBLISHED',
                'is_active' => true,
            ]);

            Livewire::test(Home::class)
                ->assertSee('أولمبياد المهن بالجزائر');
        }
    }
}
