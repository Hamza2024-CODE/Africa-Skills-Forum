<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TransportRoute extends Model
{
    use HasTranslations;

    protected $fillable = [
        'uuid',
        'name_ar',
        'name_fr',
        'name_en',
        'origin',
        'destination',
        'vehicle_capacity',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($route) {
            if (empty($route->uuid)) {
                $route->uuid = (string) Str::uuid();
            }
        });
    }

    public function trips()
    {
        return $this->hasMany(TransportTrip::class, 'route_id');
    }
}
