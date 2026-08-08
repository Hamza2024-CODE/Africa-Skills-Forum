<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyLockdown extends Model
{
    protected $table = 'wsap_emergency_lockdowns';

    protected $fillable = [
        'lockdown_scope',
        'target_id',
        'title_ar',
        'reason_ar',
        'is_active',
        'initiated_by',
        'initiated_at',
        'lifted_at',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'initiated_at' => 'datetime',
        'lifted_at'    => 'datetime',
    ];

    public function initiator()
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }
}
