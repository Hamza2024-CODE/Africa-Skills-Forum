<?php

namespace Tests\Feature\Phase04;

use App\Enums\RoleEnum;
use App\Livewire\Admin\SuperAdminDashboard;
use App\Livewire\Executive\ExecutiveDashboard;
use App\Livewire\Organization\OrganizationDashboard;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CommandCenterAndMultiRoleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_super_admin_dashboard_renders_successfully(): void
    {
        $admin = User::where('email', 'admin@worldskills.dz')->first();
        $this->actingAs($admin);

        session()->forget('locale');
        app()->setLocale('ar');

        $response = $this->get('/admin/dashboard?lang=ar');
        $response->assertStatus(200);

        // V8.1: Heading is locale-dependent; assert stable UI anchors instead
        Livewire::test(SuperAdminDashboard::class)
            ->assertSee('PLATFORM OPERATIONAL')
            ->assertSee('CURRENT EDITION');
    }

    public function test_executive_dashboard_renders_read_only_view_for_minister(): void
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

        session()->forget('locale');
        app()->setLocale('ar');

        $response = $this->get('/executive/dashboard?lang=ar');
        $response->assertStatus(200);

        // V8.1: Assert actual heading text present in ExecutiveDashboard blade
        Livewire::test(ExecutiveDashboard::class)
            ->assertSee('اللوحة التنفيذية العليا');
    }

    public function test_organization_dashboard_renders_for_algerian_training_institutes(): void
    {
        $orgUser = User::factory()->create();
        $orgUser->assignRole(RoleEnum::ORGANIZATION_ADMIN);

        $this->actingAs($orgUser);

        session()->forget('locale');
        app()->setLocale('ar');

        $response = $this->get('/organization/dashboard?lang=ar');
        $response->assertStatus(200);

        // V8.1: Assert actual heading present in OrganizationDashboard blade
        Livewire::test(OrganizationDashboard::class)
            ->assertSee('مركز المؤسسة التكوينية والتدريب');
    }
}
