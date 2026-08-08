<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleEventTarget extends Model
{
    protected $table = 'wsap_schedule_targets';

    protected $fillable = [
        'event_id',
        'target_type',
        'target_id',
    ];

    public function event()
    {
        return $this->belongsTo(ScheduleEvent::class, 'event_id');
    }
}
