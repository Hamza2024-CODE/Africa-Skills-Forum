<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ParticipantEquipmentChecklist extends Model
{
    protected $fillable = [
        'uuid',
        'participant_profile_id',
        'requirement_id',
        'status',
        'notes',
        'verified_at',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($chk) {
            if (empty($chk->uuid)) {
                $chk->uuid = (string) Str::uuid();
            }
        });
    }

    public function participantProfile()
    {
        return $this->belongsTo(ParticipantProfile::class);
    }

    public function requirement()
    {
        return $this->belongsTo(CompetitionEquipmentRequirement::class, 'requirement_id');
    }
}
