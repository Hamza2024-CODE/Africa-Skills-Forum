<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EditionCountry extends Model
{
    protected $fillable = [
        'edition_id',
        'country_id',
        'is_registration_open',
        'max_participants',
        'status',
    ];

    protected $casts = [
        'is_registration_open' => 'boolean',
    ];

    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
