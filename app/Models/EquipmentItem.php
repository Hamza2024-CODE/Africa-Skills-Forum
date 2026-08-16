<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentItem extends Model
{
    protected $fillable = [
        'category_id',
        'skill_id',
        'name_ar',
        'name_fr',
        'name_en',
        'item_type',
        'specification_details',
        'safety_level',
    ];

    public function category()
    {
        return $this->belongsTo(EquipmentCategory::class, 'category_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    public function getLocalized(string $attribute = 'name'): string
    {
        $locale = app()->getLocale();
        $field = "{$attribute}_{$locale}";

        if (!empty($this->$field)) {
            return $this->$field;
        }

        return $this->name_ar ?? $this->name_fr ?? $this->name_en ?? '';
    }
}
