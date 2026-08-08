<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VenueMap extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name_ar',
        'name_fr',
        'name_en',
        'latitude',
        'longitude',
        'altitude',
        'zoom_level',
        'is_active',
    ];

    protected $casts = [
        'latitude'   => 'float',
        'longitude'  => 'float',
        'altitude'   => 'float',
        'zoom_level' => 'integer',
        'is_active'  => 'boolean',
    ];

    public function assets(): HasMany
    {
        return $this->hasMany(VenueMapAsset::class);
    }

    public function layers(): HasMany
    {
        return $this->hasMany(VenueMapLayer::class);
    }

    public function zones(): HasMany
    {
        return $this->hasMany(VenueZone::class);
    }
}
