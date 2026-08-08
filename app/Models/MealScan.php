<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MealScan extends Model
{
    protected $fillable = [
        'uuid', 'meal_slot_id', 'user_id', 'scanned_by_user_id',
        'badge_code', 'status', 'denial_reason',
        'participant_name_snapshot', 'country_snapshot',
        'restaurant_snapshot', 'meal_type_snapshot', 'scanned_at',
    ];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(fn($m) => $m->uuid ??= (string) Str::uuid());
    }

    public function mealSlot()    { return $this->belongsTo(MealSlot::class); }
    public function user()        { return $this->belongsTo(User::class); }
    public function scannedBy()   { return $this->belongsTo(User::class, 'scanned_by_user_id'); }

    public function isAuthorized(): bool { return $this->status === 'AUTHORIZED'; }
    public function isDenied(): bool     { return $this->status === 'DENIED'; }
    public function isDuplicate(): bool  { return $this->status === 'DUPLICATE'; }
}
