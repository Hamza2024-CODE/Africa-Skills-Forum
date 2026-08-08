<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TechnicalAppeal extends Model
{
    protected $fillable = [
        'appeal_uuid', 'skill_id', 'submitted_by_user_id',
        'participant_registration_id', 'subject', 'description',
        'status', 'priority',
        'submitted_at', 'reviewed_at', 'decided_at', 'closed_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'reviewed_at'  => 'datetime',
        'decided_at'   => 'datetime',
        'closed_at'    => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($appeal) {
            if (empty($appeal->appeal_uuid)) {
                $appeal->appeal_uuid = (string) Str::uuid();
            }
        });
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'submitted_by_user_id');
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class, 'participant_registration_id');
    }

    public function events()
    {
        return $this->hasMany(TechnicalAppealEvent::class, 'appeal_id')->orderBy('created_at');
    }

    public function decision()
    {
        return $this->hasOne(TechnicalAppealDecision::class, 'appeal_id');
    }
}
