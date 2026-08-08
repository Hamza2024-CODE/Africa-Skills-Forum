<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class EventScheduleItem extends Model
{
    use HasTranslations;

    protected $fillable = [
        'event_id',
        'title_ar',
        'title_fr',
        'title_en',
        'description_ar',
        'description_fr',
        'description_en',
        'start_time',
        'end_time',
        'sort_order',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
