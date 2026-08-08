<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountrySkillSelection extends Model
{
    protected $fillable = [
        'edition_id',
        'country_id',
        'skill_id',
        'status',
        'requested_by',
        'reviewed_by',
        'requested_at',
        'reviewed_at',
        'rejection_reason',
        'admin_note',
    ];

    protected $casts = [
        'requested_at' => 'datetime',
        'reviewed_at' => 'datetime',
    ];

    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
