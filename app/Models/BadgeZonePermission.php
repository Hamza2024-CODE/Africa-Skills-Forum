<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BadgeZonePermission extends Model
{
    protected $table = 'badge_zone_permissions';

    protected $fillable = [
        'badge_id',
        'zone_id',
        'valid_from',
        'valid_until',
        'permission',
    ];

    protected $casts = [
        'valid_from'  => 'datetime',
        'valid_until' => 'datetime',
    ];

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'badge_id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function isValidAt(?\DateTimeInterface $time = null): bool
    {
        $checkTime = $time ?: now();

        if ($this->permission !== 'ALLOW') {
            return false;
        }

        if ($this->valid_from && $checkTime < $this->valid_from) {
            return false;
        }

        if ($this->valid_until && $checkTime > $this->valid_until) {
            return false;
        }

        return true;
    }
}
