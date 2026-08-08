<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VenueMapAsset extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_map_id',
        'asset_type',
        'asset_key',
        'file_path',
        'file_hash',
        'file_size_bytes',
        'version',
        'is_active',
        'metadata_json',
    ];

    protected $casts = [
        'is_active'       => 'boolean',
        'file_size_bytes' => 'integer',
        'metadata_json'   => 'array',
    ];

    public function map(): BelongsTo
    {
        return $this->belongsTo(VenueMap::class, 'venue_map_id');
    }

    public function buildings(): HasMany
    {
        return $this->hasMany(VenueBuilding::class, 'asset_id');
    }
}
