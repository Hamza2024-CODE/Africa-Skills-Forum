<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompetitionAssessmentModule extends Model
{
    protected $fillable = ['skill_id', 'edition_id', 'code', 'title_ar', 'title_fr', 'title_en', 'max_score', 'sort_order'];

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function criteria()
    {
        return $this->hasMany(CompetitionAssessmentCriterion::class, 'module_id')->orderBy('sort_order');
    }
}
