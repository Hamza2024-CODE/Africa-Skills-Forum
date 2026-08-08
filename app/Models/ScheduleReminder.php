<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleReminder extends Model
{
    protected $table = 'wsap_schedule_reminders';

    protected $fillable = [
        'event_id',
        'idempotency_key',
        'offset_minutes',
        'dispatched_at',
    ];

    protected $casts = [
        'dispatched_at' => 'datetime',
    ];

    public function event()
    {
        return $this->belongsTo(ScheduleEvent::class, 'event_id');
    }
}
