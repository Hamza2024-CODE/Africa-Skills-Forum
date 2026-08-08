<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Livewire\Admin\CmsHomepageManager;
use App\Livewire\Public\Home;
use App\Models\User;
use App\Services\SettingsEngine;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class V84Dynamic3DCountdownCmsTest extends TestCase
{
    use RefreshDatabase;

    protected User $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();

        foreach (RoleEnum::cases() as $roleCase) {
            Role::firstOrCreate(['name' => $roleCase->value]);
        }

        $this->superAdmin = User::factory()->create([
            'email' => 'superadmin_v84@wordskills.dz',
            'is_active' => true,
        ]);
        $this->superAdmin->assignRole(RoleEnum::SUPER_ADMIN->value);
    }

    public function test_super_admin_can_update_v84_countdown_settings()
    {
        $this->actingAs($this->superAdmin);

        Livewire::test(CmsHomepageManager::class)
            ->set('countdown_title_ar', 'الحدث القادم - الاختبار الآلي V8.4')
            ->set('countdown_subtitle_ar', 'WorldSkills Algeria 2026')
            ->set('countdown_target_date', '2026-09-15 09:00:00')
            ->set('countdown_timezone', 'Africa/Algiers')
            ->set('countdown_status', 'COUNTDOWN')
            ->set('countdown_color_sec', '#0284C7')
            ->set('countdown_color_min', '#059669')
            ->set('countdown_color_hrs', '#D97706')
            ->set('countdown_color_days', '#7C3AED')
            ->set('countdown_show_icons', true)
            ->set('countdown_flip_animation', true)
            ->call('saveSettings')
            ->assertSet('savedMessage', 'تم حفظ كافة إعدادات العداد التنازلي التفاعلي (WSAP V8.4) والصفحة الرئيسية بنجاح، وتطبيق التعديلات بالمنصة.');

        $settings = app(SettingsEngine::class);

        $this->assertEquals('الحدث القادم - الاختبار الآلي V8.4', $settings->get('countdown_title_ar'));
        $this->assertEquals('2026-09-15 09:00:00', $settings->get('countdown_target_date'));
        $this->assertEquals('Africa/Algiers', $settings->get('countdown_timezone'));
        $this->assertEquals('#0284C7', $settings->get('countdown_color_sec'));
    }

    public function test_public_homepage_renders_vintage_spiral_3d_countdown_widget()
    {
        $settings = app(SettingsEngine::class);
        $settings->set('countdown_title_ar', 'الأولمبياد الإفريقي بالجزائر 2026');
        $settings->set('countdown_target_date', '2026-09-15 09:00:00');
        $settings->set('countdown_status', 'COUNTDOWN');
        $settings->set('countdown_enabled', true);

        Livewire::test(Home::class)
            ->assertSee('الأولمبياد الإفريقي بالجزائر 2026')
            ->assertSee('wsap-countdown-widget')
            ->assertSee('data-target-timestamp', false)
            ->assertSee('ALGERIA 2026')
            ->assertSee('logo.svg');
    }

    public function test_super_admin_can_reset_countdown_settings()
    {
        $this->actingAs($this->superAdmin);

        Livewire::test(CmsHomepageManager::class)
            ->set('countdown_title_ar', 'عنوان مؤقت')
            ->call('resetSettings')
            ->assertSet('countdown_title_ar', 'الحدث القادم - العد التنازلي لافتتاح الأولمبياد الإفريقي')
            ->assertSet('countdown_target_date', '2026-09-15 09:00:00');
    }
}
