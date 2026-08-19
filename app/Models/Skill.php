<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Skill extends Model
{
    use HasTranslations;

    protected $fillable = [
        'uuid',
        'code',
        'category_id',
        'name_ar',
        'name_fr',
        'name_en',
        'description_ar',
        'description_fr',
        'description_en',
        'icon',
        'image_path',
        'min_age',
        'max_age',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'min_age' => 'integer',
        'max_age' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($skill) {
            if (empty($skill->uuid)) {
                $skill->uuid = (string) Str::uuid();
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(SkillCategory::class, 'category_id');
    }

    public function skillEquipments()
    {
        return $this->hasMany(SkillEquipment::class);
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function getPdfUrl(): ?string
    {
        if (preg_match('/(?:SKILL|TD)-?(\d+)/i', $this->code, $m)) {
            $num = str_pad($m[1], 2, '0', STR_PAD_LEFT);
            $filename = "WSC2026_TD{$num}_en.pdf";
            if (file_exists(public_path('docs/td/' . $filename))) {
                return asset('docs/td/' . $filename);
            }
        }

        return null;
    }

    public function getSkillIcon(): string
    {
        $catId = (int) $this->category_id;
        return match($catId) {
            1 => 'cog',
            2 => 'cpu',
            3 => 'office-building',
            4 => 'truck',
            5 => 'sparkles',
            6 => 'user-group',
            default => 'cog',
        };
    }

    public function getSkillImageUrl(): string
    {
        if (!$this->image_path) {
            return asset('images/skills/manufacturing.png');
        }
        if (str_starts_with($this->image_path, 'http://') || str_starts_with($this->image_path, 'https://')) {
            return $this->image_path;
        }
        return asset($this->image_path);
    }

    public function assessmentModules()
    {
        return $this->hasMany(CompetitionAssessmentModule::class);
    }
}
