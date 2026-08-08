<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\VenuePoi;

use Database\Seeders\WsapV90VenueDigitalTwinSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class V90ProductionSpatialIntelligenceTest extends TestCase
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

    public function test_admin_can_update_poi_transform_and_increment_revision()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['email' => 'admin_transform@wordskills.dz']);
        $admin->assignRole(RoleEnum::SUPER_ADMIN->value);

        $poi = VenuePoi::first();
        $initialRevision = $poi->revision;

        $response = $this->actingAs($admin)->postJson('/api/venue/poi/update-transform', [
            'poi_id'   => $poi->id,
            'revision' => $initialRevision,
            'transform'=> [
                'position' => ['x' => 25.50, 'y' => 2.00, 'z' => -10.00],
                'rotation' => ['x' => 0.00, 'y' => 1.57, 'z' => 0.00],
                'scale'    => ['x' => 1.00, 'y' => 1.00, 'z' => 1.00],
            ],
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonPath('new_revision', $initialRevision + 1);

        $poi->refresh();
        $this->assertEquals(25.50, $poi->pos_x);
        $this->assertEquals($initialRevision + 1, $poi->revision);
    }

    public function test_poi_transform_revision_conflict_returns_409()
    {
        /** @var User $admin */
        $admin = User::factory()->create(['email' => 'conflict_admin@wordskills.dz']);
        $admin->assignRole(RoleEnum::SUPER_ADMIN->value);

        $poi = VenuePoi::first();

        // Pass outdated revision 999
        $response = $this->actingAs($admin)->postJson('/api/venue/poi/update-transform', [
            'poi_id'   => $poi->id,
            'revision' => 999,
            'transform'=> [
                'position' => ['x' => 10.00, 'y' => 0.00, 'z' => 0.00],
            ],
        ]);

        $response->assertStatus(409)
            ->assertJsonPath('success', false)
            ->assertJsonPath('error_code', 'TRANSFORM_REVISION_CONFLICT');
    }

    public function test_navigation_dto_returns_turn_by_turn_steps()
    {
        $response = $this->getJson('/api/venue/route?origin=1&destination=2&accessible=1');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'result' => [
                    'found',
                    'total_distance_m',
                    'total_walk_sec',
                    'steps',
                ],
            ]);
    }

    public function test_strict_no_emoji_validation_across_all_phase4_payloads()
    {
        $response1 = $this->getJson('/api/venue/snapshot');
        $response2 = $this->getJson('/api/venue/pois');
        $response3 = $this->getJson('/api/venue/route?origin=1&destination=2');

        $regexEmoticons = '/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u';

        $this->assertEquals(0, preg_match($regexEmoticons, $response1->getContent()), 'Snapshot API payload must contain zero emojis.');
        $this->assertEquals(0, preg_match($regexEmoticons, $response2->getContent()), 'POIs API payload must contain zero emojis.');
        $this->assertEquals(0, preg_match($regexEmoticons, $response3->getContent()), 'Route API payload must contain zero emojis.');
    }
}
