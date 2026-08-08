<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Restaurant extends Model
{
    protected $fillable = [
        'uuid', 'name_ar', 'name_fr', 'name_en',
        'location', 'contact_phone', 'capacity', 'is_active', 'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($m) {
            if (empty($m->uuid)) $m->uuid = (string) Str::uuid();
        });
    }

    public function mealSlots()
    {
        return $this->hasMany(MealSlot::class);
    }

    public function todaySlots()
    {
        return $this->hasMany(MealSlot::class)->whereDate('date', today());
    }

    public function getNameAttribute(): string
    {
        return match(app()->getLocale()) {
            'fr'    => $this->name_fr ?? $this->name_ar,
            'en'    => $this->name_en ?? $this->name_ar,
            default => $this->name_ar,
        };
    }
}
