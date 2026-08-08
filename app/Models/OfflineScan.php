<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfflineScan extends Model
{
    protected $table = 'wsap_offline_scans';

    protected $fillable = [
        'sync_uuid',
        'badge_token',
        'service_type',
        'service_id',
        'scanned_by',
        'offline_scanned_at',
        'sync_status',
        'processed_at',
    ];

    protected $casts = [
        'offline_scanned_at' => 'datetime',
        'processed_at'       => 'datetime',
    ];

    public function operator()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
