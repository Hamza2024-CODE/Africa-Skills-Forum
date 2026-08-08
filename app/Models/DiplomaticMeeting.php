<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DiplomaticMeeting extends Model
{
    protected $table = 'diplomatic_meetings';

    protected $fillable = [
        'uuid',
        'host_minister_id',
        'guest_minister_id',
        'room_id',
        'title',
        'purpose',
        'start_time',
        'end_time',
        'status',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time'   => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($m) {
            if (empty($m->uuid)) {
                $m->uuid = (string) Str::uuid();
            }
        });
    }

    public function hostMinister()
    {
        return $this->belongsTo(MinisterialOfficial::class, 'host_minister_id');
    }

    public function guestMinister()
    {
        return $this->belongsTo(MinisterialOfficial::class, 'guest_minister_id');
    }

    public function room()
    {
        return $this->belongsTo(DiplomaticMeetingRoom::class, 'room_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
