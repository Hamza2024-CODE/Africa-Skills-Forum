<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VenueBuilding extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_zone_id',
        'asset_id',
        'code',
        'name_ar',
        'name_fr',
        'name_en',
        'mesh_key',
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
        'is_active',
    ];

    protected $casts = [
        'pos_x'     => 'float',
        'pos_y'     => 'float',
        'pos_z'     => 'float',
        'rot_x'     => 'float',
        'rot_y'     => 'float',
        'rot_z'     => 'float',
        'scale_x'   => 'float',
        'scale_y'   => 'float',
        'scale_z'   => 'float',
        'revision'  => 'integer',
        'is_active' => 'boolean',
    ];

    public function zone(): BelongsTo
    {
        return $this->belongsTo(VenueZone::class, 'venue_zone_id');
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(VenueMapAsset::class, 'asset_id');
    }

    public function floors(): HasMany
    {
        return $this->hasMany(VenueFloor::class, 'venue_building_id');
    }

    public function pois(): HasMany
    {
        return $this->hasMany(VenuePoi::class, 'venue_building_id');
    }
}
