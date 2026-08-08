<?php

namespace App\Services\Venue;

use App\Models\User;
use App\Models\VenueMap;
use App\Models\VenuePoi;

class VenueOperationsService
{
    protected VenueSpatialService $spatialService;
    protected VenuePoiService $poiService;
    protected VenueAccessService $accessService;
    protected VenueIconRegistryService $iconRegistry;

    public function __construct(
        VenueSpatialService $spatialService,
        VenuePoiService $poiService,
        VenueAccessService $accessService,
        VenueIconRegistryService $iconRegistry
    ) {
        $this->spatialService = $spatialService;
        $this->poiService     = $poiService;
        $this->accessService  = $accessService;
        $this->iconRegistry   = $iconRegistry;
    }

    /**
     * Get live state DTOs for public digital twin view (/venue-map).
     */
    public function getPublicDigitalTwinData(): array
    {
        $hierarchy = $this->spatialService->getSpatialHierarchy();

        $pois = VenuePoi::with(['poiType', 'layer', 'building'])->get();

        $originLat  = 35.74718270;
        $originLong = -0.53517710;
        $latMetersPerDegree  = 110940.0;
        $longMetersPerDegree = 90280.0;

        $exactGpsMap = [
            'المطعم الرئيسي للقرية الأورومتوسطية' => ['lat' => 35.7468000, 'lng' => -0.5358000],
            'كافتيريا الاستراحة والمشروبات — Belgaid' => ['lat' => 35.7481000, 'lng' => -0.5362000],
            'المركز الطبي والخدمات الاستشفائية (Cabinet Médical)' => ['lat' => 35.7441000, 'lng' => -0.5365000],
            'الملعب الرياضي وخمسات الفوتبول (The Five Soccer)' => ['lat' => 35.7469000, 'lng' => -0.5332000],
            'حديقة الترفيه والتنزّه (Cool Park Zone)' => ['lat' => 35.7485000, 'lng' => -0.5320000],
            'مجمع الإقامة والسكن الطلابي والوفود' => ['lat' => 35.7476000, 'lng' => -0.5325000],
            'المدخل الرئيسي والمركز الأمني للقرية' => ['lat' => 35.7455000, 'lng' => -0.5358000],
            'ورشة ميكانيك السيارات والتطوير التكنولوجي' => ['lat' => 35.7488000, 'lng' => -0.5352000],
        ];

        $resolvedPois = $pois->map(function ($poi) use ($originLat, $originLong, $latMetersPerDegree, $longMetersPerDegree, $exactGpsMap) {
            $state = $this->poiService->resolvePoiState($poi);
            $svg   = $this->iconRegistry->getSvgIcon($poi->poiType->type_key ?? $poi->poi_type);

            if (isset($exactGpsMap[$poi->title_ar])) {
                $lat = $exactGpsMap[$poi->title_ar]['lat'];
                $lng = $exactGpsMap[$poi->title_ar]['lng'];
            } else {
                $lat = $originLat + ($poi->pos_z / $latMetersPerDegree);
                $lng = $originLong + ($poi->pos_x / $longMetersPerDegree);
            }

            return array_merge($state, [
                'poi_id'          => $poi->id,
                'poi_type'        => $poi->poi_type,
                'icon_name'       => $poi->poiType->icon_name ?? 'trophy',
                'svg_raw'         => $svg,
                'primary_color'   => $poi->poiType->primary_color_hex ?? '#0284C7',
                'bg_color'        => $poi->poiType->bg_color_hex ?? '#E0F2FE',
                'building_code'   => $poi->building->code ?? 'BUILDING',
                'pos_x'           => $poi->pos_x,
                'pos_y'           => $poi->pos_y,
                'pos_z'           => $poi->pos_z,
                'lat'             => round($lat, 8),
                'lng'             => round($lng, 8),
            ]);
        });

        $boundaryFile = storage_path('app/custom_venue_boundary.json');
        $customBoundary = null;
        if (file_exists($boundaryFile)) {
            $customBoundary = json_decode(file_get_contents($boundaryFile), true);
        }

        return [
            'venue'          => $hierarchy['venue'] ?? [],
            'zones'          => $hierarchy['zones'] ?? [],
            'pois'           => $resolvedPois,
            'customBoundary' => $customBoundary,
        ];
    }

    /**
     * Get personalized badge DTOs for My Map (/my/venue-map).
     */
    public function getPersonalizedDigitalTwinData(?User $user): array
    {
        $baseData = $this->getPublicDigitalTwinData();

        $pois = VenuePoi::with(['poiType', 'layer', 'building'])->get();

        $originLat  = 35.74718270;
        $originLong = -0.53517710;
        $latMetersPerDegree  = 110940.0;
        $longMetersPerDegree = 90280.0;

        $exactGpsMap = [
            'المطعم الرئيسي للقرية الأورومتوسطية' => ['lat' => 35.7468000, 'lng' => -0.5358000],
            'كافتيريا الاستراحة والمشروبات — Belgaid' => ['lat' => 35.7481000, 'lng' => -0.5362000],
            'المركز الطبي والخدمات الاستشفائية (Cabinet Médical)' => ['lat' => 35.7441000, 'lng' => -0.5365000],
            'الملعب الرياضي وخمسات الفوتبول (The Five Soccer)' => ['lat' => 35.7469000, 'lng' => -0.5332000],
            'حديقة الترفيه والتنزّه (Cool Park Zone)' => ['lat' => 35.7485000, 'lng' => -0.5320000],
            'مجمع الإقامة والسكن الطلابي والوفود' => ['lat' => 35.7476000, 'lng' => -0.5325000],
            'المدخل الرئيسي والمركز الأمني للقرية' => ['lat' => 35.7455000, 'lng' => -0.5358000],
            'ورشة ميكانيك السيارات والتطوير التكنولوجي' => ['lat' => 35.7488000, 'lng' => -0.5352000],
        ];

        $personalizedPois = $pois->map(function ($poi) use ($user, $originLat, $originLong, $latMetersPerDegree, $longMetersPerDegree, $exactGpsMap) {
            $state  = $this->poiService->resolvePoiState($poi);
            $access = $this->accessService->evaluateBadgeAccess($user, $poi);
            $svg    = $this->iconRegistry->getSvgIcon($poi->poiType->type_key ?? $poi->poi_type);

            if (isset($exactGpsMap[$poi->title_ar])) {
                $lat = $exactGpsMap[$poi->title_ar]['lat'];
                $lng = $exactGpsMap[$poi->title_ar]['lng'];
            } else {
                $lat = $originLat + ($poi->pos_z / $latMetersPerDegree);
                $lng = $originLong + ($poi->pos_x / $longMetersPerDegree);
            }

            return array_merge($state, [
                'poi_id'          => $poi->id,
                'poi_type'        => $poi->poi_type,
                'access_code'     => $access['status_code'],
                'access_label_ar' => $access['label_ar'],
                'is_allowed'      => $access['is_allowed'],
                'icon_name'       => $access['is_allowed'] ? ($poi->poiType->icon_name ?? 'trophy') : 'lock-keyhole',
                'svg_raw'         => $svg,
                'primary_color'   => $poi->poiType->primary_color_hex ?? '#0284C7',
                'bg_color'        => $poi->poiType->bg_color_hex ?? '#E0F2FE',
                'building_code'   => $poi->building->code ?? 'BUILDING',
                'pos_x'           => $poi->pos_x,
                'pos_y'           => $poi->pos_y,
                'pos_z'           => $poi->pos_z,
                'lat'             => round($lat, 8),
                'lng'             => round($lng, 8),
            ]);
        });

        return array_merge($baseData, [
            'user'            => $user ? ['id' => $user->id, 'name' => $user->name, 'email' => $user->email] : null,
            'personalizedPois'=> $personalizedPois,
        ]);
    }
}
