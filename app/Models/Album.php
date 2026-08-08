<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Album extends Model
{
    use HasTranslations;

    protected $fillable = [
        'uuid',
        'edition_id',
        'title_ar',
        'title_fr',
        'title_en',
        'slug',
        'description_ar',
        'description_fr',
        'description_en',
        'cover_media_id',
        'is_featured',
        'status',
        'published_at',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($album) {
            if (empty($album->uuid)) {
                $album->uuid = (string) Str::uuid();
            }
            if (empty($album->slug)) {
                $album->slug = Str::slug($album->title_en ?: $album->title_ar ?: 'album-' . rand(100, 999));
            }
        });
    }

    public function coverMedia()
    {
        return $this->belongsTo(Media::class, 'cover_media_id');
    }

    public function mediaItems()
    {
        return $this->belongsToMany(Media::class, 'album_media')->withPivot('sort_order')->orderBy('sort_order');
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->coverMedia && $this->coverMedia->storage_path) {
            return asset(ltrim($this->coverMedia->storage_path, '/'));
        }
        $firstItem = $this->mediaItems->first();
        if ($firstItem && $firstItem->storage_path) {
            return asset(ltrim($firstItem->storage_path, '/'));
        }
        return 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&auto=format&fit=crop&q=80';
    }
}
