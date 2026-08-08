<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Accommodation extends Model
{
    use HasTranslations;

    protected $fillable = [
        'uuid',
        'name_ar',
        'name_fr',
        'name_en',
        'address',
        'contact_phone',
        'total_capacity',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($acc) {
            if (empty($acc->uuid)) {
                $acc->uuid = (string) Str::uuid();
            }
        });
    }

    public function rooms()
    {
        return $this->hasMany(AccommodationRoom::class);
    }
}
