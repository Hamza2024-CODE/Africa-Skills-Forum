<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VenueFloor extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_building_id',
        'floor_number',
        'name_ar',
        'name_fr',
        'name_en',
        'plan_svg_path',
    ];

    protected $casts = [
        'floor_number' => 'integer',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(VenueBuilding::class, 'venue_building_id');
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(VenueRoom::class, 'venue_floor_id');
    }
}
