<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentCategory extends Model
{
    protected $fillable = ['name_ar', 'name_fr', 'name_en', 'icon'];

    public function items()
    {
        return $this->hasMany(EquipmentItem::class, 'category_id');
    }
}
