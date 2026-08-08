<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VenueZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_map_id',
        'code',
        'name_ar',
        'name_fr',
        'name_en',
        'zone_type',
        'color_hex',
        'access_rule_code',
    ];

    public function map(): BelongsTo
    {
        return $this->belongsTo(VenueMap::class, 'venue_map_id');
    }

    public function buildings(): HasMany
    {
        return $this->hasMany(VenueBuilding::class, 'venue_zone_id');
    }
}
