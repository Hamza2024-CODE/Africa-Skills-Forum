<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Flight extends Model
{
    protected $fillable = [
        'uuid',
        'country_id',
        'flight_number',
        'airline',
        'type',
        'airport',
        'scheduled_at',
        'passengers_count',
        'status',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($fl) {
            if (empty($fl->uuid)) {
                $fl->uuid = (string) Str::uuid();
            }
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
