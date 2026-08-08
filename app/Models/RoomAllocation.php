<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class RoomAllocation extends Model
{
    protected $fillable = [
        'uuid',
        'room_id',
        'participant_profile_id',
        'user_id',
        'check_in_at',
        'check_out_at',
        'status',
    ];

    protected $casts = [
        'check_in_at' => 'datetime',
        'check_out_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($alloc) {
            if (empty($alloc->uuid)) {
                $alloc->uuid = (string) Str::uuid();
            }
        });
    }

    public function room()
    {
        return $this->belongsTo(AccommodationRoom::class, 'room_id');
    }

    public function participantProfile()
    {
        return $this->belongsTo(ParticipantProfile::class);
    }
}
