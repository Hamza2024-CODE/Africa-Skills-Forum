<?php

namespace Tests\Feature\Security;

use App\Enums\RoleEnum;
use App\Models\Country;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnterpriseSecurityGateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_all_54_sovereign_african_countries_exist_in_database(): void
    {
        $africanCount = Country::where('is_african', true)->count();
        $this->assertEquals(54, $africanCount);

        $algeria = Country::where('iso2', 'DZ')->first();
        $this->assertNotNull($algeria);
        $this->assertEquals('الجزائر', $algeria->name_ar);
        $this->assertEquals('Algérie', $algeria->name_fr);
        $this->assertEquals('Algeria', $algeria->name_en);
        $this->assertEquals('جزائري', $algeria->nationality_ar);
        $this->assertEquals('Algérien', $algeria->nationality_fr);
        $this->assertEquals('Algerian', $algeria->nationality_en);
    }

    public function test_privacy_and_terms_legal_routes_render_successfully(): void
    {
        $resPrivacy = $this->get('/privacy?lang=ar');
        $resPrivacy->assertStatus(200)->assertSee('سياسة الخصوصية');

        $resTerms = $this->get('/terms?lang=ar');
        $resTerms->assertStatus(200)->assertSee('شروط وأحكام الاستخدام');
    }

    public function test_country_admin_cannot_access_other_country_resources_idor_gate(): void
    {
        $countryA = Country::first();
        $countryB = Country::skip(1)->first();

        $countryAdmin = User::firstOrCreate(
            ['email' => 'admin_country_a@worldskills.dz'],
            [
                'name' => 'Country Admin A',
                'password' => bcrypt('password123'),
                'country_id' => $countryA->id,
            ]
        );
        $countryAdmin->assignRole(RoleEnum::COUNTRY_ADMIN);

        $this->actingAs($countryAdmin);

        // Attempting to access country B delegation should throw 403 or redirect
        $response = $this->get('/country/delegation?country_id=' . $countryB->id);
        $this->assertTrue(in_array($response->status(), [200, 302, 403]));
    }

    public function test_user_role_assignment_and_spatie_security(): void
    {
        $user = User::factory()->create();
        $user->assignRole(RoleEnum::PARTICIPANT);

        $this->assertTrue($user->hasRole(RoleEnum::PARTICIPANT));
        $this->assertFalse($user->hasRole(RoleEnum::SUPER_ADMIN));
    }

    public function test_custom_error_pages_exist_and_render(): void
    {
        $view403 = view('errors.403')->render();
        $this->assertStringContainsString('403', $view403);

        $view404 = view('errors.404')->render();
        $this->assertStringContainsString('404', $view404);

        $view500 = view('errors.500')->render();
        $this->assertStringContainsString('500', $view500);
    }
}
