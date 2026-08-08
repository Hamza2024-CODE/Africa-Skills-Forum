<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VenueMapLayer extends Model
{
    use HasFactory;

    protected $fillable = [
        'venue_map_id',
        'layer_key',
        'name_ar',
        'name_fr',
        'name_en',
        'icon_name',
        'color_hex',
        'sort_order',
        'is_visible_public',
        'is_visible_personal',
    ];

    protected $casts = [
        'sort_order'          => 'integer',
        'is_visible_public'   => 'boolean',
        'is_visible_personal' => 'boolean',
    ];

    public function map(): BelongsTo
    {
        return $this->belongsTo(VenueMap::class, 'venue_map_id');
    }

    public function pois(): HasMany
    {
        return $this->hasMany(VenuePoi::class, 'venue_layer_id');
    }
}
