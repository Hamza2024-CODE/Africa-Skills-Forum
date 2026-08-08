<?php

namespace Database\Seeders;

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
use App\Services\Venue\VenueIconRegistryService;
use Illuminate\Database\Seeder;

class WsapV90VenueDigitalTwinSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed SVG Icon Registry (No-Emoji Policy)
        app(VenueIconRegistryService::class)->seedStandardTypes();

        // 2. Create Master Venue Definition for Mediterranean Village Oran
        $venue = VenueMap::firstOrCreate(
            ['code' => 'ORAN_VILLAGE_2026'],
            [
                'name_ar'    => 'القرية الأورومتوسطية بوهران',
                'name_fr'    => 'Village Méditerranéen d\'Oran',
                'name_en'    => 'Mediterranean Village Oran',
                'latitude'   => 35.74718000,
                'longitude'  => -0.53518000,
                'altitude'   => 120.00,
                'zoom_level' => 18,
                'is_active'  => true,
            ]
        );

        // 3. Create 7 Visual Layers
        $layerCompetition = VenueMapLayer::firstOrCreate(
            ['layer_key' => 'COMPETITION'],
            [
                'venue_map_id'        => $venue->id,
                'name_ar'             => 'منافسات وورش المهن',
                'name_fr'             => 'Compétitions des Métiers',
                'name_en'             => 'Skill Competitions',
                'icon_name'           => 'trophy',
                'color_hex'           => '#0284C7',
                'sort_order'          => 1,
                'is_visible_public'   => true,
                'is_visible_personal' => true,
            ]
        );

        $layerCatering = VenueMapLayer::firstOrCreate(
            ['layer_key' => 'CATERING'],
            [
                'venue_map_id'        => $venue->id,
                'name_ar'             => 'المطاعم والإطعام',
                'name_fr'             => 'Restauration',
                'name_en'             => 'Dining & Catering',
                'icon_name'           => 'utensils',
                'color_hex'           => '#059669',
                'sort_order'          => 2,
                'is_visible_public'   => true,
                'is_visible_personal' => true,
            ]
        );

        // 4. Create Spatial Zones
        $zoneComp = VenueZone::firstOrCreate(
            ['code' => 'ZONE_COMPETITION'],
            [
                'venue_map_id'     => $venue->id,
                'name_ar'          => 'منطقة منافسات المهن',
                'name_fr'          => 'Zone des Compétitions',
                'name_en'          => 'Competitions Zone',
                'zone_type'        => 'competition',
                'color_hex'        => '#0284C7',
                'access_rule_code' => 'ALL',
            ]
        );

        $zoneResidential = VenueZone::firstOrCreate(
            ['code' => 'ZONE_RESIDENTIAL'],
            [
                'venue_map_id'     => $venue->id,
                'name_ar'          => 'منطقة السكن والإقامة',
                'name_fr'          => 'Zone Résidentielle',
                'name_en'          => 'Residential Zone',
                'zone_type'        => 'residential',
                'color_hex'        => '#7C3AED',
                'access_rule_code' => 'DELEGATION_ONLY',
            ]
        );

        // 5. Create Building
        $buildingA = VenueBuilding::firstOrCreate(
            ['code' => 'HALL_A'],
            [
                'venue_zone_id' => $zoneComp->id,
                'name_ar'       => 'قاعة المعارض والمأوى A',
                'name_fr'       => 'Hall d\'Exposition A',
                'name_en'       => 'Exhibition Hall A',
                'mesh_key'      => 'building_a',
                'pos_x'         => 15.00,
                'pos_y'         => 0.00,
                'pos_z'         => -30.00,
                'is_active'     => true,
            ]
        );

        // 6. Create Floor & Room
        $floor0 = VenueFloor::firstOrCreate(
            ['venue_building_id' => $buildingA->id, 'floor_number' => 0],
            [
                'name_ar' => 'الطابق الأرضي',
                'name_fr' => 'Rez-de-chaussée',
                'name_en' => 'Ground Floor',
            ]
        );

        $roomA12 = VenueRoom::firstOrCreate(
            ['code' => 'WORKSHOP_A12'],
            [
                'venue_floor_id' => $floor0->id,
                'name_ar'        => 'ورشة ميكانيك السيارات A12',
                'name_fr'        => 'Atelier Automobile A12',
                'name_en'        => 'Automobile Workshop A12',
                'area_sqm'       => 300.00,
                'capacity'       => 50,
            ]
        );

        // 7. Seed POIs with Icon Registry Types
        $poiTypeSkill = VenuePoiType::where('type_key', 'SKILL')->first();
        $poiTypeRest  = VenuePoiType::where('type_key', 'RESTAURANT')->first();

        if ($poiTypeSkill) {
            VenuePoi::firstOrCreate(
                ['title_ar' => 'ورشة ميكانيك السيارات — Automobile Technology'],
                [
                    'venue_poi_type_id' => $poiTypeSkill->id,
                    'venue_layer_id'    => $layerCompetition->id,
                    'venue_building_id' => $buildingA->id,
                    'venue_room_id'     => $roomA12->id,
                    'poi_type'          => 'SKILL',
                    'reference_type'    => 'SKILL',
                    'reference_id'      => 1,
                    'title_fr'          => 'Automobile Technology Workshop',
                    'title_en'          => 'Automobile Technology Workshop',
                    'status'            => 'LIVE_COMPETITION',
                    'capacity'          => 50,
                    'access_role'       => 'ALL',
                    'pos_x'             => 15.00,
                    'pos_y'             => 1.50,
                    'pos_z'             => -30.00,
                ]
            );
        }

        if ($poiTypeRest) {
            VenuePoi::firstOrCreate(
                ['title_ar' => 'المطعم الرئيسي للقرية الأورومتوسطية'],
                [
                    'venue_poi_type_id' => $poiTypeRest->id,
                    'venue_layer_id'    => $layerCatering->id,
                    'venue_building_id' => $buildingA->id,
                    'venue_room_id'     => null,
                    'poi_type'          => 'RESTAURANT',
                    'reference_type'    => 'RESTAURANT',
                    'reference_id'      => 1,
                    'title_fr'          => 'Restaurant Principal du Village',
                    'title_en'          => 'Main Mediterranean Dining Hall',
                    'status'            => 'OPEN',
                    'capacity'          => 300,
                    'access_role'       => 'ALL',
                    'pos_x'             => -20.00,
                    'pos_y'             => 0.00,
                    'pos_z'             => 10.00,
                ]
            );
        }

        // 8. Spatial Graph Nodes & Edges
        $nodeGate = VenueNode::firstOrCreate(
            ['node_code' => 'NODE_GATE_MAIN'],
            [
                'venue_building_id' => $buildingA->id,
                'pos_x'             => 0.00,
                'pos_y'             => 0.00,
                'pos_z'             => 0.00,
                'is_accessible'     => true,
                'is_emergency_exit' => true,
            ]
        );

        $nodeWorkshop = VenueNode::firstOrCreate(
            ['node_code' => 'NODE_WORKSHOP_A12'],
            [
                'venue_building_id' => $buildingA->id,
                'pos_x'             => 15.00,
                'pos_y'             => 0.00,
                'pos_z'             => -30.00,
                'is_accessible'     => true,
                'is_emergency_exit' => false,
            ]
        );

        VenueEdge::firstOrCreate(
            ['from_node_id' => $nodeGate->id, 'to_node_id' => $nodeWorkshop->id],
            [
                'distance_meters' => 150.00,
                'walk_seconds'    => 110,
                'is_accessible'   => true,
            ]
        );
    }
}
