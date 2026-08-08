<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\User;
use Database\Seeders\WsapV90VenueDigitalTwinSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class V90VenueDigitalTwinUiTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        foreach (RoleEnum::cases() as $roleCase) {
            Role::firstOrCreate(['name' => $roleCase->value]);
        }

        $this->seed(WsapV90VenueDigitalTwinSeeder::class);
    }

    public function test_rest_api_venue_snapshot_endpoint()
    {
        $response = $this->getJson('/api/venue/snapshot');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('code', 'ORAN_VILLAGE_2026');
    }

    public function test_rest_api_venue_pois_endpoint()
    {
        $response = $this->getJson('/api/venue/pois');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure(['success', 'count', 'pois']);
    }

    public function test_rest_api_venue_route_endpoint_dijkstra()
    {
        $response = $this->getJson('/api/venue/route?origin=1&destination=2&accessible=1');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('result.found', true);
    }

    public function test_public_venue_map_page_renders_successfully()
    {
        $response = $this->get('/venue-map');

        $response->assertStatus(200);
        $response->assertSee('القرية الأورومتوسطية بوهران');
    }

    public function test_kiosk_venue_map_page_renders_successfully()
    {
        $response = $this->get('/kiosk/venue-map');

        $response->assertStatus(200);
        Livewire::test(\App\Livewire\Public\KioskVenueMap::class)
            ->assertSee('شاشة الاستعلامات الكبرى');
    }

    public function test_super_admin_venue_map_manager_page()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['email' => 'admin_v90@wordskills.dz']);
        $admin->assignRole(RoleEnum::SUPER_ADMIN->value);

        $response = $this->actingAs($admin)->get('/admin/venue-map');

        $response->assertStatus(200);
        Livewire::test(\App\Livewire\Admin\VenueMapManager::class)
            ->assertSee('3D Venue Builder');
    }

    public function test_my_personalized_venue_map_page()
    {
        /** @var User $user */
        $user = User::factory()->create(['email' => 'participant_v90@wordskills.dz']);
        $user->assignRole(RoleEnum::PARTICIPANT->value);

        $response = $this->actingAs($user)->get('/my/venue-map');

        $response->assertStatus(200);
        app()->setLocale('en');
        Livewire::test(\App\Livewire\Public\MyVenueMap::class)
            ->assertSee('My Operational Map');
    }

    public function test_no_emoji_ui_policy_enforcement_in_api_payload()
    {
        $response = $this->getJson('/api/venue/pois');
        $json = $response->getContent();

        $regexEmoticons = '/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u';

        $this->assertEquals(0, preg_match($regexEmoticons, $json), 'REST API payloads must strictly contain ZERO emojis.');
    }
}
