<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    use HasTranslations;

    protected $fillable = ['code', 'name_ar', 'name_fr', 'name_en', 'icon', 'sort_order'];

    public function skills()
    {
        return $this->hasMany(Skill::class, 'category_id');
    }
}
