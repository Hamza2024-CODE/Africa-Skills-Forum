<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNotification extends Model
{
    protected $table = 'user_notifications';

    protected $fillable = [
        'notification_id',
        'user_id',
        'channel',
        'status',
        'delivered_at',
        'read_at',
        'clicked_at',
    ];

    protected $casts = [
        'delivered_at' => 'datetime',
        'read_at'      => 'datetime',
        'clicked_at'   => 'datetime',
    ];

    public function notification()
    {
        return $this->belongsTo(WsapNotification::class, 'notification_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function markAsRead(): void
    {
        if ($this->status !== 'READ' && $this->status !== 'CLICKED') {
            $this->update([
                'status'  => 'READ',
                'read_at' => now(),
            ]);
        }
    }

    public function markAsClicked(): void
    {
        $this->update([
            'status'     => 'CLICKED',
            'read_at'    => $this->read_at ?: now(),
            'clicked_at' => now(),
        ]);
    }
}
