<?php

namespace Tests\Feature\Public;

use App\Livewire\Auth\Login;
use App\Livewire\Public\Home;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PublicPortalV2Test extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login?lang=ar');
        $response->assertStatus(200);

        Livewire::test(Login::class)
            ->assertSee('تسجيل الدخول إلى المنصة الوطنية');
    }

    public function test_login_authenticates_and_redirects_based_on_user_role(): void
    {
        $superAdmin = User::where('email', 'admin@worldskills.dz')->first();
        $this->assertNotNull($superAdmin);

        Livewire::test(Login::class)
            ->set('email', 'admin@worldskills.dz')
            ->set('password', 'password123')
            ->call('login')
            ->assertRedirect(route('admin.dashboard'));
    }

    public function test_homepage_renders_active_event_and_dual_countdowns(): void
    {
        session()->forget('locale');
        app()->setLocale('ar');

        $response = $this->get('/?lang=ar');
        $response->assertStatus(200);

        Livewire::test(Home::class)
            ->assertSee('الحدث القادم')
            ->assertSee('أولمبياد المهن');
    }
}
