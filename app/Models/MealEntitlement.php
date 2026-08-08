<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MealEntitlement extends Model
{
    protected $fillable = [
        'uuid', 'meal_slot_id', 'restaurant_id',
        'user_id', 'country_id', 'status', 'created_by',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->uuid ??= (string) Str::uuid());
    }

    public function mealSlot()   { return $this->belongsTo(MealSlot::class); }
    public function restaurant() { return $this->belongsTo(Restaurant::class); }
    public function user()       { return $this->belongsTo(User::class); }
    public function country()    { return $this->belongsTo(Country::class); }
    public function creator()    { return $this->belongsTo(User::class, 'created_by'); }
}
