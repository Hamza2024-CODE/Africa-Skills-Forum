<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionAssessmentCriterion extends Model
{
    protected $fillable = ['module_id', 'title_ar', 'title_fr', 'type', 'max_score', 'description', 'sort_order'];

    public function module()
    {
        return $this->belongsTo(CompetitionAssessmentModule::class, 'module_id');
    }
}
