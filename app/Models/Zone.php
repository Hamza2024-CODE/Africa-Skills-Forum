<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $table = 'wsap_zones';

    protected $fillable = [
        'code',
        'name_ar',
        'name_fr',
        'name_en',
        'description_ar',
        'is_active',
    ];

    public function badgePermissions()
    {
        return $this->hasMany(BadgeZonePermission::class, 'zone_id');
    }

    public function scheduleEvents()
    {
        return $this->hasMany(ScheduleEvent::class, 'zone_id');
    }
}
