<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditionDate extends Model
{
    protected $fillable = [
        'edition_id',
        'stage_id',
        'date_type',
        'start_at',
        'end_at',
        'timezone',
        'location_ar',
        'location_fr',
        'location_id',
        'is_active',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }
}
