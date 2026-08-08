<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Models\User;
use App\Models\VenueBoundary;
use App\Models\VenueBuilding;
use App\Models\VenueMap;
use App\Models\VenueMapLayer;
use App\Models\VenuePoi;
use App\Models\VenuePoiType;
use App\Models\VenueZone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class V90FinalHardeningTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function test_venue_map_guest_behavior_renders_read_only_digital_twin()
    {
        $response = $this->get('/venue-map');

        $response->assertStatus(200);
        $response->assertSee('القرية الأورومتوسطية بوهران');
    }

    public function test_venue_map_admin_behavior_redirects_to_admin_command_center()
    {
        /** @var User $admin */
        $admin = User::whereHas('roles', fn ($q) => $q->where('name', RoleEnum::SUPER_ADMIN->value))->first();

        $response = $this->actingAs($admin)->get('/venue-map');
        $response->assertRedirect(route('admin.venue-map'));
    }

    public function test_guide_and_regulations_pages_render_successfully()
    {
        $res1 = $this->get('/guide');
        $res1->assertStatus(200);

        $res2 = $this->get('/regulations');
        $res2->assertStatus(200);
    }

    public function test_unauthorized_user_accessing_batch_print_returns_403_forbidden()
    {
        /** @var User $user */
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/accreditations/batch-print');
        $response->assertStatus(403);
    }

    public function test_authorized_admin_accessing_batch_print_returns_200_ok()
    {
        /** @var User $admin */
        $admin = User::whereHas('roles', fn ($q) => $q->where('name', RoleEnum::SUPER_ADMIN->value))->first();

        $response = $this->actingAs($admin)->get('/admin/accreditations/batch-print');
        $response->assertStatus(200);
    }

    public function test_boundary_polygon_persists_to_venue_boundaries_database_table()
    {
        /** @var User $admin */
        $admin = User::whereHas('roles', fn ($q) => $q->where('name', RoleEnum::SUPER_ADMIN->value))->first();

        $venueMap = VenueMap::firstOrCreate(
            ['code' => 'ORAN_VILLAGE_2026'],
            [
                'name_ar' => 'القرية الأورومتوسطية بوهران',
                'name_fr' => 'Village Méditerranéen Oran',
                'name_en' => 'Mediterranean Village Oran',
                'latitude' => 35.74718270,
                'longitude' => -0.53517710,
            ]
        );

        $coords = [
            [35.74950, -0.53620],
            [35.74400, -0.53720],
            [35.74350, -0.53200],
        ];

        Livewire::actingAs($admin)
            ->test(\App\Livewire\Admin\VenueMapManager::class)
            ->call('saveBoundaryPolygon', $coords, '#EF4444');

        $this->assertDatabaseHas('venue_boundaries', [
            'code'          => 'PRIMARY_PERIMETER',
            'boundary_type' => 'COMPETITION',
            'color_hex'     => '#EF4444',
        ]);
    }

    public function test_poi_update_with_stale_revision_returns_409_conflict()
    {
        /** @var User $admin */
        $admin = User::whereHas('roles', fn ($q) => $q->where('name', RoleEnum::SUPER_ADMIN->value))->first();
        
        $venueMap = VenueMap::firstOrCreate(
            ['code' => 'ORAN_VILLAGE_2026'],
            [
                'name_ar' => 'القرية الأورومتوسطية بوهران',
                'name_fr' => 'Village Méditerranéen Oran',
                'name_en' => 'Mediterranean Village Oran',
                'latitude' => 35.74718270,
                'longitude' => -0.53517710,
            ]
        );

        $poiType = VenuePoiType::firstOrCreate(
            ['type_key' => 'SKILL'],
            ['name_ar' => 'ورشة مهنية', 'name_fr' => 'Skill Workshop', 'name_en' => 'Skill Workshop', 'svg_raw' => '<svg></svg>']
        );

        $layer = VenueMapLayer::firstOrCreate(
            ['layer_key' => 'WORKSHOPS'],
            ['venue_map_id' => $venueMap->id, 'name_ar' => 'طبقة الورشات', 'name_fr' => 'Workshops Layer', 'name_en' => 'Workshops Layer']
        );

        $zone = VenueZone::firstOrCreate(
            ['code' => 'COMPETITION_ZONE'],
            ['venue_map_id' => $venueMap->id, 'name_ar' => 'منطقة المنافسات', 'name_fr' => 'Competition Zone', 'name_en' => 'Competition Zone', 'zone_type' => 'competition']
        );

        $building = VenueBuilding::firstOrCreate(
            ['code' => 'HALL_A'],
            ['venue_zone_id' => $zone->id, 'name_ar' => 'القاعة A', 'name_fr' => 'Hall A', 'name_en' => 'Hall A']
        );

        $poi = VenuePoi::create([
            'venue_map_id'      => $venueMap->id,
            'venue_building_id' => $building->id,
            'venue_layer_id'    => $layer->id,
            'venue_poi_type_id' => $poiType->id,
            'poi_type'          => 'SKILL',
            'code'              => 'TEST_POI_01',
            'title_ar'          => 'معلم تجريبي',
            'title_fr'          => 'Test POI',
            'title_en'          => 'Test POI',
            'pos_x'             => 0.0,
            'pos_y'             => 0.0,
            'pos_z'             => 0.0,
            'revision'          => 1,
        ]);

        $staleRevision = $poi->revision + 99;

        $component = Livewire::actingAs($admin)
            ->test(\App\Livewire\Admin\VenueMapManager::class);

        $this->expectException(\Symfony\Component\HttpKernel\Exception\HttpException::class);
        $component->instance()->updatePoiLatLngWithRevision((int)$poi->id, 35.7475, -0.5352, $staleRevision);
    }
}
