<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VenueRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_floor_id',
        'code',
        'name_ar',
        'name_fr',
        'name_en',
        'area_sqm',
        'capacity',
    ];

    protected $casts = [
        'area_sqm' => 'float',
        'capacity' => 'integer',
    ];

    public function floor(): BelongsTo
    {
        return $this->belongsTo(VenueFloor::class, 'venue_floor_id');
    }

    public function pois(): HasMany
    {
        return $this->hasMany(VenuePoi::class, 'venue_room_id');
    }
}
