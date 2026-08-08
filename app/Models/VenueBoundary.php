<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VenueBoundary extends Model
{
    protected $table = 'venue_boundaries';
    protected $primaryKey = 'boundary_id';

    protected $fillable = [
        'venue_map_id',
        'code',
        'name_ar',
        'name_fr',
        'name_en',
        'boundary_type',
        'geometry_type',
        'geometry_json',
        'color_hex',
        'stroke_width',
        'fill_opacity',
        'is_active',
        'revision',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'geometry_json' => 'array',
        'stroke_width'  => 'float',
        'fill_opacity'  => 'float',
        'is_active'     => 'boolean',
        'revision'      => 'integer',
    ];

    public function venueMap(): BelongsTo
    {
        return $this->belongsTo(VenueMap::class, 'venue_map_id', 'id');
    }
}
