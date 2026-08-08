<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkillEquipment extends Model
{
    protected $fillable = [
        'skill_id',
        'equipment_item_id',
        'is_required',
        'quantity',
        'provided_by',
        'notes',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'quantity' => 'integer',
    ];

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function equipmentItem()
    {
        return $this->belongsTo(EquipmentItem::class);
    }
}
