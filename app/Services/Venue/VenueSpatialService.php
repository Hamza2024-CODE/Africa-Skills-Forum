<?php

namespace App\Services\Venue;

use App\Models\VenueBuilding;
use App\Models\VenueFloor;
use App\Models\VenueMap;
use App\Models\VenuePoi;
use App\Models\VenueRoom;
use App\Models\VenueZone;
use Illuminate\Support\Collection;

class VenueSpatialService
{
    /**
     * Transform Geo Latitude & Longitude to 3D Local World Vector (x, y, z).
     * Origin anchored at Master Venue Reference (Mediterranean Village Oran).
     */
    public function geoTo3dVector(float $latitude, float $longitude, float $altitude = 0.0): array
    {
        $originLat = 35.74718000;
        $originLong = -0.53518000;

        // Meters per degree latitude at Oran
        $latMetersPerDegree = 110940.0;
        // Meters per degree longitude at lat 35.74 deg
        $longMetersPerDegree = 90280.0;

        $x = ($longitude - $originLong) * $longMetersPerDegree;
        $z = -($latitude - $originLat) * $latMetersPerDegree; // Z axis points south
        $y = $altitude;

        return [
            'x' => round($x, 2),
            'y' => round($y, 2),
            'z' => round($z, 2),
        ];
    }

    /**
     * Get complete spatial hierarchy tree for a venue map.
     */
    public function getSpatialHierarchy(string $venueCode = 'ORAN_VILLAGE_2026'): ?array
    {
        $venue = VenueMap::where('code', $venueCode)->first();

        if (!$venue) {
            return null;
        }

        $zones = VenueZone::where('venue_map_id', $venue->id)
            ->with(['buildings.floors.rooms.pois.poiType'])
            ->get();

        return [
            'venue' => [
                'id'         => $venue->id,
                'code'       => $venue->code,
                'name_ar'    => $venue->name_ar,
                'name_fr'    => $venue->name_fr,
                'name_en'    => $venue->name_en,
                'latitude'   => $venue->latitude,
                'longitude'  => $venue->longitude,
                'altitude'   => $venue->altitude,
                'zoom_level' => $venue->zoom_level,
            ],
            'zones' => $zones->map(function ($zone) {
                return [
                    'id'               => $zone->id,
                    'code'             => $zone->code,
                    'name_ar'          => $zone->name_ar,
                    'name_fr'          => $zone->name_fr,
                    'name_en'          => $zone->name_en,
                    'zone_type'        => $zone->zone_type,
                    'color_hex'        => $zone->color_hex,
                    'access_rule_code' => $zone->access_rule_code,
                    'buildings'        => $zone->buildings->map(function ($building) {
                        return [
                            'id'       => $building->id,
                            'code'     => $building->code,
                            'name_ar'  => $building->name_ar,
                            'name_fr'  => $building->name_fr,
                            'name_en'  => $building->name_en,
                            'mesh_key' => $building->mesh_key,
                            'transform'=> [
                                'pos_x' => $building->pos_x,
                                'pos_y' => $building->pos_y,
                                'pos_z' => $building->pos_z,
                                'rot_x' => $building->rot_x,
                                'rot_y' => $building->rot_y,
                                'rot_z' => $building->rot_z,
                                'scale_x' => $building->scale_x,
                                'scale_y' => $building->scale_y,
                                'scale_z' => $building->scale_z,
                            ],
                            'floors'   => $building->floors->map(function ($floor) {
                                return [
                                    'id'           => $floor->id,
                                    'floor_number' => $floor->floor_number,
                                    'name_ar'      => $floor->name_ar,
                                    'name_fr'      => $floor->name_fr,
                                    'name_en'      => $floor->name_en,
                                    'rooms'        => $floor->rooms->map(function ($room) {
                                        return [
                                            'id'       => $room->id,
                                            'code'     => $room->code,
                                            'name_ar'  => $room->name_ar,
                                            'name_fr'  => $room->name_fr,
                                            'name_en'  => $room->name_en,
                                            'capacity' => $room->capacity,
                                            'area_sqm' => $room->area_sqm,
                                        ];
                                    }),
                                ];
                            }),
                        ];
                    }),
                ];
            }),
        ];
    }
}
