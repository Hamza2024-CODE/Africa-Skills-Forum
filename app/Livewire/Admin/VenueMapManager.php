<?php

namespace App\Livewire\Admin;

use App\Events\Venue\EmergencyModeActivated;
use App\Events\Venue\VenuePoiStatusChanged;
use App\Models\VenuePoi;
use App\Models\VenuePoiType;
use App\Services\Venue\VenueOperationsService;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class VenueMapManager extends Component
{
    public string $activeMode = 'BUILDER'; // BUILDER | LIVE_OPERATIONS | EMERGENCY
    public bool $emergencyActive = false;

    // Editing POI state
    public ?int $selectedPoiId = null;
    public string $editTitleAr = '';
    public string $editStatus = 'OPEN';
    public float $editPosX = 0.0;
    public float $editPosZ = 0.0;

    // New POI creation
    public string $newPoiTitleAr = '';
    public string $newPoiTypeKey = 'SKILL';
    public float $newPoiPosX = 10.0;
    public float $newPoiPosZ = -10.0;

    public function selectPoi(int $poiId): void
    {
        $poi = VenuePoi::find($poiId);
        if ($poi) {
            $this->selectedPoiId = $poi->id;
            $this->editTitleAr   = $poi->title_ar;
            $this->editStatus    = $poi->status;
            $this->editPosX      = (float) $poi->pos_x;
            $this->editPosZ      = (float) $poi->pos_z;
        }
    }

    public function savePoiTransform(): void
    {
        if (!$this->selectedPoiId) return;

        $poi = VenuePoi::find($this->selectedPoiId);
        if ($poi) {
            $poi->update([
                'title_ar' => $this->editTitleAr,
                'status'   => $this->editStatus,
                'pos_x'    => $this->editPosX,
                'pos_z'    => $this->editPosZ,
                'revision' => $poi->revision + 1,
            ]);

            VenuePoiStatusChanged::dispatch($poi, $this->editStatus);
            session()->flash('message', 'تم حفظ وتحديث البيانات في قاعدة البيانات بنجاح!');
        }
    }

    public function updatePoiCoordinates(int $poiId, float $posX, float $posZ): void
    {
        $poi = VenuePoi::find($poiId);
        if ($poi) {
            $poi->update([
                'pos_x'    => $posX,
                'pos_z'    => $posZ,
                'revision' => $poi->revision + 1,
            ]);
            VenuePoiStatusChanged::dispatch($poi, $poi->status);
        }
    }

    public function updatePoiLatLng(int $poiId, float $lat, float $lng): void
    {
        $originLat  = 35.74718270;
        $originLong = -0.53517710;
        $posZ = round(($lat - $originLat) * 110940.0, 2);
        $posX = round(($lng - $originLong) * 90280.0, 2);

        $poi = VenuePoi::find($poiId);
        if ($poi) {
            $poi->update([
                'pos_x'    => $posX,
                'pos_z'    => $posZ,
                'revision' => $poi->revision + 1,
            ]);
            VenuePoiStatusChanged::dispatch($poi, $poi->status);
            session()->flash('message', "تم تحديث موقع '{$poi->title_ar}' على الإحداثيات ($lat, $lng) بنجاح!");
        }
    }

    public function updatePoiLatLngWithRevision(int $poiId, float $lat, float $lng, int $expectedRevision): void
    {
        $poi = VenuePoi::find($poiId);
        if (!$poi || (int)$poi->revision !== (int)$expectedRevision) {
            abort(409, 'تعارض في التحديث التزامني: هناك تعديل أحدث لهذا المعلم (409 Conflict).');
        }

        $this->updatePoiLatLng($poiId, $lat, $lng);
    }

    public function saveBoundaryPolygon(array $vertices, string $color = '#EAB308'): void
    {
        $venueMap = \App\Models\VenueMap::first();
        if ($venueMap) {
            \App\Models\VenueBoundary::updateOrCreate(
                ['code' => 'PRIMARY_PERIMETER'],
                [
                    'venue_map_id'  => $venueMap->id,
                    'name_ar'       => 'حرم القرية الأورومتوسطية',
                    'boundary_type' => 'COMPETITION',
                    'geometry_type' => 'POLYGON',
                    'geometry_json' => $vertices,
                    'color_hex'     => $color,
                ]
            );
        }

        $filePath = storage_path('app/custom_venue_boundary.json');
        file_put_contents($filePath, json_encode([
            'color'    => $color,
            'vertices' => $vertices,
            'updated'  => now()->toIso8601String(),
        ], JSON_PRETTY_PRINT));

        session()->flash('message', 'تم رسم وحفظ حدود حرم القرية الميدانية في قاعدة البيانات بنجاح!');
    }

    public function toggleEmergencyMode(): void
    {
        $this->emergencyActive = !$this->emergencyActive;
        $this->activeMode = $this->emergencyActive ? 'EMERGENCY' : 'BUILDER';
        EmergencyModeActivated::dispatch($this->emergencyActive, 'تحديث نمط الإخلاء الميداني');
    }

    public function setMode(string $mode): void
    {
        $this->activeMode = $mode;
        $this->emergencyActive = ($mode === 'EMERGENCY');
    }

    public function render()
    {
        $opsData = app(VenueOperationsService::class)->getPublicDigitalTwinData();

        return view('livewire.admin.venue-map-manager', [
            'venue'          => $opsData['venue'] ?? [],
            'zones'          => $opsData['zones'] ?? [],
            'pois'           => $opsData['pois'] ?? [],
            'customBoundary' => $opsData['customBoundary'] ?? null,
        ]);
    }
}
