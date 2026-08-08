<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationTarget extends Model
{
    protected $table = 'notification_targets';

    protected $fillable = [
        'notification_id',
        'target_type',
        'target_id',
    ];

    public function notification()
    {
        return $this->belongsTo(WsapNotification::class, 'notification_id');
    }
}
