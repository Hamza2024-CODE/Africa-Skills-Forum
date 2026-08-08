<?php

namespace Tests\Feature;

use App\Models\VenueBuilding;
use App\Models\VenueEdge;
use App\Models\VenueFloor;
use App\Models\VenueMap;
use App\Models\VenueMapAsset;
use App\Models\VenueMapLayer;
use App\Models\VenueNode;
use App\Models\VenuePoi;
use App\Models\VenuePoiType;
use App\Models\VenueRoom;
use App\Models\VenueZone;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class V90DigitalTwinSpatialEngineTest extends TestCase
{
    use RefreshDatabase;

    public function test_phase1_venue_digital_twin_database_schema_and_relations()
    {
        // 1. Create Venue Map Master
        $venue = VenueMap::create([
            'code'        => 'ORAN_VILLAGE_2026',
            'name_ar'     => 'القرية الأورومتوسطية بوهران',
            'name_fr'     => 'Village Méditerranéen d\'Oran',
            'name_en'     => 'Mediterranean Village Oran',
            'latitude'    => 35.74718000,
            'longitude'   => -0.53518000,
            'altitude'    => 120.00,
            'zoom_level'  => 18,
            'is_active'   => true,
        ]);

        $this->assertDatabaseHas('venue_maps', ['code' => 'ORAN_VILLAGE_2026']);

        // 2. Create Dynamic SVG Icon Registry (No-Emoji Rule)
        $poiType = VenuePoiType::create([
            'type_key'            => 'SKILL',
            'name_ar'             => 'ورشة المنافسة',
            'name_fr'             => 'Atelier de Compétition',
            'name_en'             => 'Skill Competition Workshop',
            'icon_name'           => 'trophy',
            'svg_raw'             => '<svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 9H4.5a2.5 2.5 0 0 1 0-5H6"/></svg>',
            'primary_color_hex'   => '#D97706',
            'bg_color_hex'        => '#FEF3C7',
            'marker_style_preset' => 'glass_floating_badge',
            'is_active'           => true,
        ]);

        $this->assertDatabaseHas('venue_poi_types', ['type_key' => 'SKILL', 'icon_name' => 'trophy']);

        // 3. Create Map Layer
        $layer = VenueMapLayer::create([
            'venue_map_id'        => $venue->id,
            'layer_key'           => 'COMPETITION',
            'name_ar'             => 'منافسات المهن',
            'name_fr'             => 'Compétitions',
            'name_en'             => 'Competitions',
            'icon_name'           => 'trophy',
            'color_hex'           => '#0284C7',
            'sort_order'          => 1,
            'is_visible_public'   => true,
            'is_visible_personal' => true,
        ]);

        // 4. Create Spatial Zone
        $zone = VenueZone::create([
            'venue_map_id'     => $venue->id,
            'code'             => 'ZONE_COMPETITION_A',
            'name_ar'          => 'منطقة المنافسات أ',
            'name_fr'          => 'Zone de Compétition A',
            'name_en'          => 'Competition Zone A',
            'zone_type'        => 'competition',
            'color_hex'        => '#0284C7',
            'access_rule_code' => 'ALL',
        ]);

        // 5. Create Asset
        $asset = VenueMapAsset::create([
            'venue_map_id'   => $venue->id,
            'asset_type'     => 'BUILDING_MODEL',
            'asset_key'      => 'building_a_mesh',
            'file_path'      => '/venue3d/models/building-a.glb',
            'file_size_bytes'=> 2048500,
            'version'        => '1.0.0',
            'is_active'      => true,
        ]);

        // 6. Create Building
        $building = VenueBuilding::create([
            'venue_zone_id' => $zone->id,
            'asset_id'      => $asset->id,
            'code'          => 'HALL_A1',
            'name_ar'       => 'قاعة المعارض الرئيسية A1',
            'name_fr'       => 'Hall d\'Exposition Principal A1',
            'name_en'       => 'Main Exhibition Hall A1',
            'mesh_key'      => 'building_a',
            'pos_x'         => 12.50,
            'pos_y'         => 0.00,
            'pos_z'         => -45.20,
            'is_active'     => true,
        ]);

        // 7. Create Floor & Room
        $floor = VenueFloor::create([
            'venue_building_id' => $building->id,
            'floor_number'      => 0,
            'name_ar'           => 'الطابق الأرضي',
            'name_fr'           => 'Rez-de-chaussée',
            'name_en'           => 'Ground Floor',
        ]);

        $room = VenueRoom::create([
            'venue_floor_id' => $floor->id,
            'code'           => 'WORKSHOP_A12',
            'name_ar'        => 'ورشة ميكانيك السيارات A12',
            'name_fr'        => 'Atelier Technologie Automobile A12',
            'name_en'        => 'Automobile Technology Workshop A12',
            'area_sqm'       => 350.00,
            'capacity'       => 60,
        ]);

        // 8. Create POI
        $poi = VenuePoi::create([
            'venue_poi_type_id' => $poiType->id,
            'venue_layer_id'    => $layer->id,
            'venue_building_id' => $building->id,
            'venue_room_id'     => $room->id,
            'poi_type'          => 'SKILL',
            'reference_type'    => 'SKILL',
            'reference_id'      => 101,
            'title_ar'          => 'Automobile Technology',
            'title_fr'          => 'Technologie Automobile',
            'title_en'          => 'Automobile Technology',
            'status'            => 'LIVE_COMPETITION',
            'capacity'          => 60,
            'access_role'       => 'ALL',
            'pos_x'             => 12.50,
            'pos_y'             => 1.80,
            'pos_z'             => -45.20,
        ]);

        // 9. Create Graph Pathfinding Nodes & Edges
        $nodeA = VenueNode::create([
            'venue_building_id' => $building->id,
            'node_code'         => 'NODE_MAIN_GATE',
            'pos_x'             => 0.00,
            'pos_y'             => 0.00,
            'pos_z'             => 0.00,
            'is_accessible'     => true,
            'is_emergency_exit' => true,
        ]);

        $nodeB = VenueNode::create([
            'venue_building_id' => $building->id,
            'node_code'         => 'NODE_WORKSHOP_A12',
            'pos_x'             => 12.50,
            'pos_y'             => 0.00,
            'pos_z'             => -45.20,
            'is_accessible'     => true,
            'is_emergency_exit' => false,
        ]);

        $edge = VenueEdge::create([
            'from_node_id'    => $nodeA->id,
            'to_node_id'      => $nodeB->id,
            'distance_meters' => 120.00,
            'walk_seconds'    => 90,
            'is_accessible'   => true,
        ]);

        // Eloquent Relations Assertions
        $this->assertEquals(1, $venue->zones()->count());
        $this->assertEquals('HALL_A1', $zone->buildings->first()->code);
        $this->assertEquals('WORKSHOP_A12', $building->floors->first()->rooms->first()->code);
        $this->assertEquals('trophy', $poi->poiType->icon_name);
        $this->assertEquals(90, $nodeA->outgoingEdges->first()->walk_seconds);
    }
}
