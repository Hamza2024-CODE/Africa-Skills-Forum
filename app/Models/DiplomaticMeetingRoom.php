<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DiplomaticMeetingRoom extends Model
{
    use HasTranslations;

    protected $table = 'diplomatic_meeting_rooms';

    protected $fillable = [
        'uuid',
        'name_ar',
        'name_fr',
        'name_en',
        'capacity',
        'location_zone',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($room) {
            if (empty($room->uuid)) {
                $room->uuid = (string) Str::uuid();
            }
        });
    }

    public function meetings()
    {
        return $this->hasMany(DiplomaticMeeting::class, 'room_id');
    }
}
