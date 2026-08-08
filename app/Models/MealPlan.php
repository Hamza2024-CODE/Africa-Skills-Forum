<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MealPlan extends Model
{
    protected $fillable = [
        'uuid',
        'participant_profile_id',
        'country_id',
        'date',
        'meal_type',
        'dietary_notes',
        'is_served',
    ];

    protected $casts = [
        'date' => 'date',
        'is_served' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($mp) {
            if (empty($mp->uuid)) {
                $mp->uuid = (string) Str::uuid();
            }
        });
    }

    public function participantProfile()
    {
        return $this->belongsTo(ParticipantProfile::class);
    }
}
