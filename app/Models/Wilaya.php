<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wilaya extends Model
{
    protected $fillable = ['code', 'name_ar', 'name_fr', 'region_id'];

    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    public function communes()
    {
        return $this->hasMany(Commune::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function participants()
    {
        return $this->hasMany(ParticipantProfile::class);
    }

    public function registrations()
    {
        return $this->hasManyThrough(Registration::class, ParticipantProfile::class, 'wilaya_id', 'participant_id');
    }
}
