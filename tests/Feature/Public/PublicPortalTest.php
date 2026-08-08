<?php

namespace Tests\Feature\Public;

use App\Livewire\Public\Contact;
use App\Livewire\Public\Home;
use App\Livewire\Public\Registration;
use App\Livewire\Public\Skills;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PublicPortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_public_homepage_renders_successfully(): void
    {
        session()->forget('locale');
        app()->setLocale('ar');

        $response = $this->get('/?lang=ar');
        $response->assertStatus(200);

        Livewire::test(Home::class)
            ->assertSee('أولمبياد المهن بالجزائر');
    }

    public function test_public_skills_page_renders(): void
    {
        $response = $this->get('/skills?lang=ar');
        $response->assertStatus(200);

        Livewire::test(Skills::class)
            ->assertSee('دليل المهن والتخصصات الرسمية');
    }

    public function test_all_public_portal_pages_render_with_status_200(): void
    {
        $routes = [
            '/guide',
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
        ];

        foreach ($routes as $route) {
            $response = $this->get($route . '?lang=ar');
            $response->assertStatus(200);
        }
    }

    public function test_public_registration_wizard_submits(): void
    {
        $response = $this->get('/registration?lang=ar');
        $response->assertStatus(200);

        Livewire::test(Registration::class)
            ->set('firstNameAr', 'علي')
            ->set('lastNameAr', 'عمراني')
            ->set('email', 'ali.omrani@example.com')
            ->set('phone', '0555112233')
            ->call('nextStep')
            ->set('nationalId', '123456789012345678')
            ->call('nextStep')
            ->set('suitSize', 'L')
            ->set('shoeSize', '42')
            ->call('nextStep')
            ->set('skillId', 1)
            ->call('submitRegistration')
            ->assertSee('تم إرسال وتسجيل طلبك بنجاح');
    }
}
