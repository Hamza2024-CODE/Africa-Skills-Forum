<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipantAssessment extends Model
{
    protected $fillable = ['registration_id', 'module_id', 'total_score', 'is_locked', 'locked_at', 'locked_by_user_id'];

    protected $casts = [
        'is_locked' => 'boolean',
        'locked_at' => 'datetime',
    ];

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function module()
    {
        return $this->belongsTo(CompetitionAssessmentModule::class);
    }

    public function scores()
    {
        return $this->hasMany(ParticipantScore::class, 'assessment_id');
    }
}
