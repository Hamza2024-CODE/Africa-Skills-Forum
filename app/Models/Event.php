<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasTranslations;

    protected $fillable = [
        'uuid',
        'edition_id',
        'title_ar',
        'title_fr',
        'title_en',
        'slug',
        'summary_ar',
        'summary_fr',
        'summary_en',
        'description_ar',
        'description_fr',
        'description_en',
        'start_at',
        'end_at',
        'venue',
        'address',
        'wilaya_id',
        'cover_media_id',
        'is_featured',
        'status',
        'published_at',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($event) {
            if (empty($event->uuid)) {
                $event->uuid = (string) Str::uuid();
            }
            if (empty($event->slug)) {
                $event->slug = Str::slug($event->title_en ?: $event->title_ar ?: 'event-' . rand(100, 999));
            }
        });
    }

    public function scheduleItems()
    {
        return $this->hasMany(EventScheduleItem::class)->orderBy('sort_order');
    }

    public function coverMedia()
    {
        return $this->belongsTo(Media::class, 'cover_media_id');
    }
}
