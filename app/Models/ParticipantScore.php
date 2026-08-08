<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParticipantScore extends Model
{
    protected $fillable = ['assessment_id', 'criterion_id', 'judge_user_id', 'score', 'notes'];

    public function assessment()
    {
        return $this->belongsTo(ParticipantAssessment::class);
    }

    public function criterion()
    {
        return $this->belongsTo(CompetitionAssessmentCriterion::class);
    }

    public function judge()
    {
        return $this->belongsTo(User::class, 'judge_user_id');
    }
}
