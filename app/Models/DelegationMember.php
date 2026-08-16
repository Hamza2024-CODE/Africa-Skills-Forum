<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DelegationMember extends Model
{
    protected $fillable = [
        'uuid',
        'delegation_id',
        'user_id',
        'skill_id',
        'status',
        'member_type',
        'first_name',
        'last_name',
        'passport_number',
        'passport_expiry',
        'nin_number',
        'gender',
        'suit_size',
        'shoe_size',
        'dietary_requirements',
        'dietary_notes',
        'phone',
        'email',
        'arrival_flight',
        'departure_flight',
        'flight_ticket_path',
        'rejection_reason',
        'photo_path',
    ];

    protected $casts = [
        'passport_expiry'      => 'date',
        'dietary_requirements' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($member) {
            if (empty($member->uuid)) {
                $member->uuid = (string) Str::uuid();
            }
            if (empty($member->status)) {
                $member->status = 'APPROVED';
            }
        });
    }

    public function delegation()
    {
        return $this->belongsTo(CountryDelegation::class, 'delegation_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
}
