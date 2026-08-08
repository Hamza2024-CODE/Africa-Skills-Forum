<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CompetitionEquipmentRequirement extends Model
{
    use HasTranslations;

    protected $fillable = [
        'uuid',
        'skill_id',
        'edition_id',
        'name_ar',
        'name_fr',
        'name_en',
        'description_ar',
        'description_fr',
        'description_en',
        'quantity',
        'unit',
        'is_mandatory',
        'is_ppe',
        'provided_by',
        'technical_specifications',
        'safety_notes',
        'status',
    ];

    protected $casts = [
        'is_mandatory' => 'boolean',
        'is_ppe' => 'boolean',
        'quantity' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($req) {
            if (empty($req->uuid)) {
                $req->uuid = (string) Str::uuid();
            }
        });
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
