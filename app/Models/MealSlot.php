<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MealSlot extends Model
{
    protected $fillable = [
        'uuid', 'restaurant_id', 'date', 'meal_type',
        'start_time', 'end_time', 'max_capacity', 'is_open', 'notes',
    ];

    protected $casts = [
        'date'       => 'date',
        'is_open'    => 'boolean',
        'max_capacity' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->uuid ??= (string) Str::uuid());
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function entitlements()
    {
        return $this->hasMany(MealEntitlement::class);
    }

    public function scans()
    {
        return $this->hasMany(MealScan::class);
    }

    public function authorizedScans()
    {
        return $this->hasMany(MealScan::class)->where('status', 'AUTHORIZED');
    }

    // Remaining capacity based on actual authorized scans (source of truth)
    public function remainingCapacity(): int
    {
        return max(0, $this->max_capacity - $this->authorizedScans()->count());
    }

    public function getMealLabelAttribute(): string
    {
        return match($this->meal_type) {
            'BREAKFAST' => 'الإفطار (Breakfast)',
            'LUNCH'     => 'الغداء (Lunch)',
            'DINNER'    => 'العشاء (Dinner)',
            'SNACK'     => 'الوجبة الخفيفة (Snack)',
            default     => $this->meal_type,
        };
    }

    public function getMealIconAttribute(): string
    {
        return match($this->meal_type) {
            'BREAKFAST' => '🍳',
            'LUNCH'     => '🍽️',
            'DINNER'    => '🍲',
            'SNACK'     => '🥗',
            default     => '🍴',
        };
    }
}
