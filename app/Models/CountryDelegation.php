<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CountryDelegation extends Model
{
    protected $fillable = [
        'uuid',
        'edition_id',
        'country_id',
        'head_of_delegation_user_id',
        'total_members_count',
        'status',
        'notes',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($delegation) {
            if (empty($delegation->uuid)) {
                $delegation->uuid = (string) Str::uuid();
            }
        });
    }

    public function edition()
    {
        return $this->belongsTo(Edition::class);
    }

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function headOfDelegation()
    {
        return $this->belongsTo(User::class, 'head_of_delegation_user_id');
    }

    public function members()
    {
        return $this->hasMany(DelegationMember::class, 'delegation_id');
    }
}
