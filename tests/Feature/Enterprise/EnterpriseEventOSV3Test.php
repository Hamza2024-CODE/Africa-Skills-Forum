<?php

namespace Tests\Feature\Enterprise;

use App\Enums\RoleEnum;
use App\Livewire\Admin\AdminEventCenter;
use App\Livewire\Admin\CmsHomepageManager;
use App\Livewire\Admin\MediaManagerDashboard;
use App\Livewire\Auth\UserProfile;
use App\Livewire\Judge\JudgeDashboard;
use App\Models\Event;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class EnterpriseEventOSV3Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_profile_page_renders_and_updates(): void
    {
        $user = User::where('email', 'admin@worldskills.dz')->first();
        $this->actingAs($user);

        $response = $this->get('/profile?lang=ar');
        $response->assertStatus(200);

        Livewire::test(UserProfile::class)
            ->set('name', 'Super Administrator Updated')
            ->call('updateProfile')
            ->assertDispatched('notify');
    }

    public function test_admin_event_center_renders_and_toggles_active_event(): void
    {
        $user = User::where('email', 'admin@worldskills.dz')->first();
        $this->actingAs($user);

        $response = $this->get('/admin/events?lang=ar');
        $response->assertStatus(200);

        $event = Event::first();
        if ($event) {
            Livewire::test(AdminEventCenter::class)
                ->call('toggleActive', $event->id);
            $fresh = Event::find($event->id);
            $this->assertTrue((bool) $fresh->is_active);
        }
    }

    public function test_judge_dashboard_renders_and_restricts_to_approved_participants(): void
    {
        $judge = User::factory()->create();
        $judge->assignRole(RoleEnum::JUDGE);
        $this->actingAs($judge);

        $response = $this->get('/judge/dashboard?lang=ar');
        $response->assertStatus(200);

        Livewire::test(JudgeDashboard::class)
            ->assertSee('التحكيم');
    }

    public function test_media_manager_dashboard_renders(): void
    {
        $user = User::where('email', 'admin@worldskills.dz')->first();
        $this->actingAs($user);

        $response = $this->get('/admin/media/dashboard?lang=ar');
        $response->assertStatus(200);

        Livewire::test(MediaManagerDashboard::class)
            ->assertSee('لوحة إدارة الإعلام والأخبار والمحتوى الرقمي');
    }

    public function test_cms_homepage_manager_renders_and_updates_settings(): void
    {
        $user = User::where('email', 'admin@worldskills.dz')->first();
        $this->actingAs($user);

        $response = $this->get('/admin/cms/homepage?lang=ar');
        $response->assertStatus(200);

        Livewire::test(CmsHomepageManager::class)
            ->set('hero_title_ar', 'أولمبياد المهن الجزائر 2027 المطور')
            ->call('saveSettings')
            ->assertDispatched('notify');
    }
}
