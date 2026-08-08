<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VenuePoi extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_poi_type_id',
        'venue_layer_id',
        'venue_building_id',
        'venue_room_id',
        'poi_type',
        'reference_type',
        'reference_id',
        'title_ar',
        'title_fr',
        'title_en',
        'status',
        'capacity',
        'access_role',
        'pos_x',
        'pos_y',
        'pos_z',
        'rot_x',
        'rot_y',
        'rot_z',
        'scale_x',
        'scale_y',
        'scale_z',
        'revision',
    ];

    protected $casts = [
        'capacity'     => 'integer',
        'reference_id' => 'integer',
        'revision'     => 'integer',
        'pos_x'        => 'float',
        'pos_y'        => 'float',
        'pos_z'        => 'float',
        'rot_x'        => 'float',
        'rot_y'        => 'float',
        'rot_z'        => 'float',
        'scale_x'      => 'float',
        'scale_y'      => 'float',
        'scale_z'      => 'float',
    ];

    public function poiType(): BelongsTo
    {
        return $this->belongsTo(VenuePoiType::class, 'venue_poi_type_id');
    }

    public function layer(): BelongsTo
    {
        return $this->belongsTo(VenueMapLayer::class, 'venue_layer_id');
    }

    public function building(): BelongsTo
    {
        return $this->belongsTo(VenueBuilding::class, 'venue_building_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(VenueRoom::class, 'venue_room_id');
    }
}
