<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Certificate extends Model
{
    protected $fillable = [
        'certificate_uuid',
        'verification_token_hash',
        'user_id',
        'registration_id',
        'skill_id',
        'certificate_type',
        'status',
        'issued_at',
        'revoked_at',
        'revocation_reason',
        'metadata',
    ];

    protected $casts = [
        'metadata'   => 'array',
        'issued_at'  => 'datetime',
        'revoked_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($cert) {
            if (empty($cert->certificate_uuid)) {
                $cert->certificate_uuid = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function registration()
    {
        return $this->belongsTo(Registration::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
