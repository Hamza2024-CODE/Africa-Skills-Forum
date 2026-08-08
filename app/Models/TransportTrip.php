<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TransportTrip extends Model
{
    protected $fillable = [
        'uuid',
        'route_id',
        'departure_at',
        'arrival_at',
        'vehicle_number',
        'driver_contact',
        'booked_passengers',
    ];

    protected $casts = [
        'departure_at' => 'datetime',
        'arrival_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($trip) {
            if (empty($trip->uuid)) {
                $trip->uuid = (string) Str::uuid();
            }
        });
    }

    public function route()
    {
        return $this->belongsTo(TransportRoute::class, 'route_id');
    }
}
