<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VenuePoiType extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_key',
        'name_ar',
        'name_fr',
        'name_en',
        'icon_name',
        'svg_raw',
        'primary_color_hex',
        'bg_color_hex',
        'marker_style_preset',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function pois(): HasMany
    {
        return $this->hasMany(VenuePoi::class);
    }
}
