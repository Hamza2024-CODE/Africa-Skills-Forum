<?php

namespace App\Services\Venue;

use App\Models\MealScan;
use App\Models\VenuePoi;

use App\Models\VenueZone;

class VenueAnalyticsService
{
    protected VenuePoiService $poiService;

    public function __construct(VenuePoiService $poiService)
    {
        $this->poiService = $poiService;
    }

    /**
     * Compute master spatial command center analytics and density heatmap DTOs.
     */
    public function getCommandCenterAnalytics(): array
    {
        $pois = VenuePoi::with(['building', 'poiType'])->get();

        $activeCompetitions = $pois->filter(fn($p) => strtoupper($p->poi_type) === 'SKILL' && $p->status === 'LIVE_COMPETITION')->count();

        // Catering occupancy metrics
        $cateringPois = $pois->filter(fn($p) => strtoupper($p->poi_type) === 'RESTAURANT');
        $totalCateringCap = $cateringPois->sum('capacity') ?: 300;
        $totalCateringOccupancy = 0;

        foreach ($cateringPois as $cPoi) {
            $state = $this->poiService->resolvePoiState($cPoi);
            $totalCateringOccupancy += ($state['occupancy_count'] ?? 0);
        }

        $cateringPct = $totalCateringCap > 0 ? round(($totalCateringOccupancy / $totalCateringCap) * 100, 1) : 0.0;

        // Security scans metrics
        $totalScans      = MealScan::count();
        $authorizedScans = MealScan::where('status', 'AUTHORIZED')->count();
        $deniedScans     = MealScan::where('status', 'DENIED')->count();

        // Heatmap density DTOs per spatial zone
        $zones = VenueZone::with('buildings.pois')->get();
        $highDensityZones = $zones->map(function ($zone) {
            $zonePoisCount = 0;
            $zoneOccupancy = 0;
            $zoneCapacity = 0;

            foreach ($zone->buildings as $b) {
                foreach ($b->pois as $p) {
                    $zonePoisCount++;
                    $zoneOccupancy += $p->current_occupancy;
                    $zoneCapacity += $p->capacity;
                }
            }

            $densityPct = $zoneCapacity > 0 ? round(($zoneOccupancy / $zoneCapacity) * 100, 1) : 0.0;

            return [
                'zone_code'    => $zone->code,
                'name_ar'      => $zone->name_ar,
                'name_fr'      => $zone->name_fr,
                'name_en'      => $zone->name_en,
                'color_hex'    => $zone->color_hex,
                'poi_count'    => $zonePoisCount,
                'density_pct'  => $densityPct,
                'is_congested' => $densityPct >= 80.0,
            ];
        });

        return [
            'kpis' => [
                'active_competitions_count'     => max(1, $activeCompetitions),
                'overall_catering_occupancy_pct'=> $cateringPct,
                'security_scans' => [
                    'total'      => $totalScans,
                    'authorized' => $authorizedScans,
                    'denied'     => $deniedScans,
                ],
                'high_density_zones_count' => $highDensityZones->where('is_congested', true)->count(),
            ],
            'high_density_zones' => $highDensityZones,
            'recent_events_feed' => [
                [
                    'time'        => now()->format('H:i:s'),
                    'type_key'    => 'SKILL',
                    'icon_name'   => 'trophy',
                    'title_ar'    => 'بدء جولة جديدة في ورشة ميكانيك السيارات',
                    'location_ar' => 'قاعة المعارض A12',
                ],
                [
                    'time'        => now()->subMinutes(2)->format('H:i:s'),
                    'type_key'    => 'RESTAURANT',
                    'icon_name'   => 'utensils',
                    'title_ar'    => 'تحديث سعة مطعم القرية الأورومتوسطية',
                    'location_ar' => 'المطعم الرئيسي',
                ],
            ],
        ];
    }
}
