<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\VenueBuilding;
use App\Models\VenuePoi;
use App\Services\Venue\VenueIconRegistryService;
use App\Services\Venue\VenueOperationsService;
use App\Services\Venue\VenuePathfindingService;
use App\Services\Venue\VenueSpatialService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VenueApiController extends Controller
{
    protected VenueOperationsService $operationsService;
    protected VenueSpatialService $spatialService;
    protected VenuePathfindingService $pathfindingService;
    protected VenueIconRegistryService $iconRegistry;

    public function __construct(
        VenueOperationsService $operationsService,
        VenueSpatialService $spatialService,
        VenuePathfindingService $pathfindingService,
        VenueIconRegistryService $iconRegistry
    ) {
        $this->operationsService  = $operationsService;
        $this->spatialService     = $spatialService;
        $this->pathfindingService  = $pathfindingService;
        $this->iconRegistry       = $iconRegistry;
    }

    /**
     * GET /api/venue/snapshot
     */
    public function snapshot(): JsonResponse
    {
        $hierarchy = $this->spatialService->getSpatialHierarchy('ORAN_VILLAGE_2026');
        $publicData = $this->operationsService->getPublicDigitalTwinData();

        return response()->json([
            'success' => true,
            'code'    => 'ORAN_VILLAGE_2026',
            'venue'   => $hierarchy['venue'] ?? [],
            'zones'   => $hierarchy['zones'] ?? [],
            'pois'    => $publicData['pois'] ?? [],
        ]);
    }

    /**
     * GET /api/venue/pois
     */
    public function pois(): JsonResponse
    {
        $publicData = $this->operationsService->getPublicDigitalTwinData();

        return response()->json([
            'success' => true,
            'count'   => count($publicData['pois']),
            'pois'    => $publicData['pois'],
        ]);
    }

    /**
     * GET /api/venue/operations
     */
    public function operations(Request $request): JsonResponse
    {
        $user = $request->user();
        $data = $this->operationsService->getPersonalizedDigitalTwinData($user);

        return response()->json([
            'success'          => true,
            'live_competitions'=> 1,
            'active_restaurants'=> 1,
            'data'             => $data,
        ]);
    }

    /**
     * GET /api/venue/route?origin=1&destination=2&accessible=0&emergency=0
     */
    public function route(Request $request): JsonResponse
    {
        $origin      = (int) $request->query('origin', 1);
        $destination = (int) $request->query('destination', 2);
        $accessible  = (bool) $request->query('accessible', false);
        $emergency   = (bool) $request->query('emergency', false);

        $result = $this->pathfindingService->findPath($origin, $destination, $accessible, $emergency);

        return response()->json([
            'success' => $result['found'],
            'result'  => $result,
        ]);
    }

    /**
     * POST /api/venue/poi/update-transform
     * Production 3D Builder Persistence with Revision Control
     */
    public function updatePoiTransform(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'poi_id'                 => 'required|integer|exists:venue_pois,id',
            'revision'               => 'required|integer',
            'transform'              => 'required|array',
            'transform.position.x'   => 'required|numeric',
            'transform.position.y'   => 'required|numeric',
            'transform.position.z'   => 'required|numeric',
            'transform.rotation.x'   => 'nullable|numeric',
            'transform.rotation.y'   => 'nullable|numeric',
            'transform.rotation.z'   => 'nullable|numeric',
            'transform.scale.x'      => 'nullable|numeric',
            'transform.scale.y'      => 'nullable|numeric',
            'transform.scale.z'      => 'nullable|numeric',
        ]);

        $poi = VenuePoi::findOrFail($validated['poi_id']);

        if ($poi->revision !== $validated['revision']) {
            return response()->json([
                'success'       => false,
                'error_code'    => 'TRANSFORM_REVISION_CONFLICT',
                'message'       => 'تعارض في إصدار الإحداثيات! قام مسؤول آخر بتحديث هذا المكون المكانـي مؤخراً.',
                'current_revision' => $poi->revision,
            ], 409);
        }

        $pos = $validated['transform']['position'];
        $rot = $validated['transform']['rotation'] ?? ['x' => 0, 'y' => 0, 'z' => 0];
        $scale = $validated['transform']['scale'] ?? ['x' => 1, 'y' => 1, 'z' => 1];

        $poi->update([
            'pos_x'    => $pos['x'],
            'pos_y'    => $pos['y'],
            'pos_z'    => $pos['z'],
            'rot_x'    => $rot['x'] ?? 0.0,
            'rot_y'    => $rot['y'] ?? 0.0,
            'rot_z'    => $rot['z'] ?? 0.0,
            'scale_x'  => $scale['x'] ?? 1.0,
            'scale_y'  => $scale['y'] ?? 1.0,
            'scale_z'  => $scale['z'] ?? 1.0,
            'revision' => $poi->revision + 1,
        ]);

        return response()->json([
            'success'      => true,
            'poi_id'       => $poi->id,
            'new_revision' => $poi->revision,
            'message'      => 'تم حفظ وإعادة تحويل الإحداثيات ثلاثية الأبعاد بنجاح في قاعدة البيانات.',
        ]);
    }

    /**
     * GET /api/venue/analytics
     * Spatial Command Center KPIs & Heatmap DTOs
     */
    public function analytics(Request $request): JsonResponse
    {
        $analyticsService = app(\App\Services\Venue\VenueAnalyticsService::class);
        $data = $analyticsService->getCommandCenterAnalytics();

        return response()->json([
            'success' => true,
            'data'    => $data,
        ]);
    }
}
