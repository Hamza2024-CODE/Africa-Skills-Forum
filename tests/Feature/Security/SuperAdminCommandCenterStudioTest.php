<?php

namespace Tests\Feature\Security;

use App\Enums\RoleEnum;
use App\Models\AuditLog;
use App\Models\GlobalSetting;
use App\Models\User;
use App\Services\SettingsEngine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class SuperAdminCommandCenterStudioTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(\Database\Seeders\RolesAndPermissionsSeeder::class);
    }

    public function test_super_admin_can_access_command_center_and_switch_tabs(): void
    {
        /** @var User $admin */
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'sa.command@worldskills.dz',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole(RoleEnum::SUPER_ADMIN->value);

        $this->actingAs($admin);

        $response = $this->get('/admin/dashboard');
        $response->assertStatus(200);

        Livewire::test(\App\Livewire\Admin\SuperAdminDashboard::class)
            ->assertSee('مركز القيادة والتحكم')
            ->call('setTab', 'appearance')
            ->assertSet('activeTab', 'appearance')
            ->call('setTab', 'security_governance')
            ->assertSet('activeTab', 'security_governance');
    }

    public function test_super_admin_can_access_appearance_studio_and_save_tokens(): void
    {
        /** @var User $admin */
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'sa.appearance@worldskills.dz',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole(RoleEnum::SUPER_ADMIN->value);

        $this->actingAs($admin);

        $response = $this->get('/admin/appearance');
        $response->assertStatus(200);

        Livewire::test(\App\Livewire\Admin\PlatformAppearanceManager::class)
            ->set('primary_color', '#E11D48')
            ->set('accent_color', '#F59E0B')
            ->call('saveAppearance')
            ->assertSee('تم حفظ هوية ومظهر المنصة بنجاح');

        $this->assertEquals('#E11D48', app(SettingsEngine::class)->get('appearance.primary_color'));

        // Verify Audit Log Entry
        $this->assertDatabaseHas('audit_logs', [
            'event' => 'PLATFORM_APPEARANCE_UPDATED',
        ]);
    }

    public function test_settings_engine_generates_sanitized_design_tokens_css(): void
    {
        /** @var SettingsEngine $engine */
        $engine = app(SettingsEngine::class);
        $engine->set('appearance.primary_color', '#0066FF', 'string', 'appearance');

        $css = $engine->getDesignTokensCss();

        $this->assertStringContainsString('<style id="wsap-design-tokens">', $css);
        $this->assertStringContainsString('--color-brand-primary: #0066FF;', $css);
        $this->assertStringContainsString('--radius-lg: 1rem;', $css);
    }

    public function test_appearance_reset_defaults_restores_factory_tokens_and_logs_audit(): void
    {
        /** @var User $admin */
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'sa.reset@worldskills.dz',
            'password' => bcrypt('password'),
        ]);
        $admin->assignRole(RoleEnum::SUPER_ADMIN->value);

        $this->actingAs($admin);

        // Mutate token first
        app(SettingsEngine::class)->set('appearance.primary_color', '#990000', 'string', 'appearance');

        Livewire::test(\App\Livewire\Admin\PlatformAppearanceManager::class)
            ->call('resetDefaults')
            ->assertSee('تمت إعادة كافة رموز التصميم والهوية البصرية إلى افتراضيات المصنع');

        $this->assertEquals('#0066FF', app(SettingsEngine::class)->get('appearance.primary_color'));

        $this->assertDatabaseHas('audit_logs', [
            'event' => 'APPEARANCE_RESET',
        ]);
    }

    public function test_non_super_admin_roles_are_strictly_denied_access_to_appearance_studio(): void
    {
        /** @var User $countryAdmin */
        $countryAdmin = User::create([
            'name' => 'Country Admin User',
            'email' => 'ca.deny@worldskills.dz',
            'password' => bcrypt('password'),
        ]);
        $countryAdmin->assignRole(RoleEnum::COUNTRY_ADMIN->value);

        $this->actingAs($countryAdmin);
        $response = $this->get('/admin/appearance');
        $response->assertStatus(403);

        /** @var User $participant */
        $participant = User::create([
            'name' => 'Participant User',
            'email' => 'pt.deny@worldskills.dz',
            'password' => bcrypt('password'),
        ]);
        $participant->assignRole(RoleEnum::PARTICIPANT->value);

        $this->actingAs($participant);
        $response2 = $this->get('/admin/appearance');
        $response2->assertStatus(403);
    }
}
