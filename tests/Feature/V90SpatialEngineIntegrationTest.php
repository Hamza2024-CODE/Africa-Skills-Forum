<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\VenueMap;
use App\Models\VenuePoi;
use App\Services\Venue\VenueAccessService;
use App\Services\Venue\VenueIconRegistryService;
use App\Services\Venue\VenueOperationsService;
use App\Services\Venue\VenuePathfindingService;
use App\Services\Venue\VenuePoiService;
use App\Services\Venue\VenueSpatialService;
use Database\Seeders\WsapV90VenueDigitalTwinSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class V90SpatialEngineIntegrationTest extends TestCase
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

    public function test_no_emoji_design_rule_enforcement_in_icon_registry()
    {
        $registry = app(VenueIconRegistryService::class);

        $this->assertTrue($registry->validateNoEmoji('Automobile Technology Workshop'));
        $this->assertTrue($registry->validateNoEmoji('Trophy Icon System'));
        $this->assertFalse($registry->validateNoEmoji('Restaurant 🍽️ Area'));
        $this->assertFalse($registry->validateNoEmoji('Security Zone 🔒'));

        $svg = $registry->getSvgIcon('SKILL');
        $this->assertStringContainsString('<svg', $svg);
        $this->assertStringNotContainsString('🏆', $svg);
    }

    public function test_spatial_hierarchy_resolution_for_mediterranean_village()
    {
        $spatialService = app(VenueSpatialService::class);
        $hierarchy = $spatialService->getSpatialHierarchy('ORAN_VILLAGE_2026');

        $this->assertNotNull($hierarchy);
        $this->assertEquals('ORAN_VILLAGE_2026', $hierarchy['venue']['code']);
        $this->assertGreaterThanOrEqual(1, count($hierarchy['zones']));
    }

    public function test_geo_to_3d_vector_transformation()
    {
        $spatialService = app(VenueSpatialService::class);

        // Mediterranean Village Oran exact coordinates
        $vector = $spatialService->geoTo3dVector(35.74718000, -0.53518000, 120.00);

        $this->assertEquals(0.0, $vector['x']);
        $this->assertEquals(120.0, $vector['y']);
        $this->assertEquals(0.0, $vector['z']);
    }

    public function test_dijkstra_pathfinding_route_calculation()
    {
        $pathfinder = app(VenuePathfindingService::class);

        $result = $pathfinder->findPath(1, 2, true, false);

        $this->assertTrue($result['found']);
        $this->assertGreaterThan(0, $result['total_distance_m']);
        $this->assertGreaterThan(0, $result['total_walk_sec']);
        $this->assertGreaterThanOrEqual(2, count($result['path_nodes']));
    }

    public function test_poi_operational_state_resolution()
    {
        $poiService = app(VenuePoiService::class);
        $poi = VenuePoi::first();

        $this->assertNotNull($poi);
        $state = $poiService->resolvePoiState($poi);

        $this->assertArrayHasKey('status', $state);
        $this->assertArrayHasKey('title_ar', $state);
        $this->assertArrayHasKey('capacity', $state);
    }

    public function test_badge_access_entitlement_evaluation()
    {
        $accessService = app(VenueAccessService::class);
        $poi = VenuePoi::first();

        $user = User::factory()->create(['email' => 'competitor_v90@wordskills.dz']);
        $user->assignRole(RoleEnum::PARTICIPANT->value);

        $decision = $accessService->evaluateBadgeAccess($user, $poi);

        $this->assertArrayHasKey('is_allowed', $decision);
        $this->assertArrayHasKey('status_code', $decision);
    }

    public function test_master_operations_aggregator_supplies_public_and_personal_dtos()
    {
        $opsService = app(VenueOperationsService::class);

        $publicData = $opsService->getPublicDigitalTwinData();

        $this->assertArrayHasKey('venue', $publicData);
        $this->assertArrayHasKey('zones', $publicData);
        $this->assertArrayHasKey('pois', $publicData);
        $this->assertGreaterThanOrEqual(1, count($publicData['pois']));

        $user = User::factory()->create(['email' => 'judge_v90@wordskills.dz']);
        $user->assignRole(RoleEnum::JUDGE->value);

        $personalData = $opsService->getPersonalizedDigitalTwinData($user);

        $this->assertArrayHasKey('user', $personalData);
        $this->assertArrayHasKey('personalizedPois', $personalData);
    }
}
