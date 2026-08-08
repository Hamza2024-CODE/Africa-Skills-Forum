<?php

namespace Tests\Feature\Phase02;

use App\Enums\RoleEnum;
use App\Livewire\Country\CountryDashboard;
use App\Livewire\Country\DelegationManager;
use App\Livewire\Country\SkillSelectionManager;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class CountryDashboardTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_country_dashboard_renders_successfully(): void
    {
        $countryAdmin = User::factory()->create();
        $countryAdmin->assignRole(RoleEnum::COUNTRY_ADMIN);
        $this->actingAs($countryAdmin);

        $response = $this->get('/country/dashboard');
        $response->assertStatus(200);

        Livewire::test(CountryDashboard::class)
            ->assertSee('مركز إدارة الوفد والمشاركة الرسمية');
    }

    public function test_skill_selection_manager_renders_and_toggles_skill(): void
    {
        $countryAdmin = User::factory()->create();
        $countryAdmin->assignRole(RoleEnum::COUNTRY_ADMIN);
        $this->actingAs($countryAdmin);

        Livewire::test(SkillSelectionManager::class)
            ->assertSee('اختيار واعتماد التخصصات للدولة');
    }

    public function test_delegation_manager_renders_and_adds_member(): void
    {
        $countryAdmin = User::factory()->create();
        $countryAdmin->assignRole(RoleEnum::COUNTRY_ADMIN);
        $this->actingAs($countryAdmin);

        Livewire::test(DelegationManager::class)
            ->assertSee('إدارة الوفد الوطني وأعضائه')
            ->set('firstName', 'محمد')
            ->set('lastName', 'قاسمي')
            ->set('memberType', 'PARTICIPANT')
            ->call('addMember')
            ->assertSee('محمد');
    }
}
