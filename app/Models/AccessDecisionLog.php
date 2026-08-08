<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessDecisionLog extends Model
{
    protected $table = 'wsap_access_decisions';

    protected $fillable = [
        'badge_id',
        'user_id',
        'service_type',
        'service_id',
        'location_name',
        'zone_id',
        'decision',
        'reason_code',
        'reason_message_ar',
        'scanned_by',
        'is_offline_sync',
        'scanned_at',
    ];

    protected $casts = [
        'scanned_at'      => 'datetime',
        'is_offline_sync' => 'boolean',
    ];

    public function badge()
    {
        return $this->belongsTo(Badge::class, 'badge_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
