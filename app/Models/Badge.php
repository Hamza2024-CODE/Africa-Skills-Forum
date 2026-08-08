<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Badge extends Model
{
    protected $fillable = [
        'badge_uuid', 'access_token', 'user_id', 'role_title',
        'allowed_zone_ids', 'status', 'valid_until',
    ];

    protected $casts = [
        'allowed_zone_ids' => 'array',
        'valid_until'      => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($badge) {
            if (empty($badge->badge_uuid)) {
                $badge->badge_uuid = (string) Str::uuid();
            }
            if (empty($badge->access_token)) {
                $badge->access_token = Str::random(32);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAllowedZones()
    {
        if (empty($this->allowed_zone_ids)) {
            return collect();
        }
        return AccreditationZone::whereIn('id', $this->allowed_zone_ids)->get();
    }
}
