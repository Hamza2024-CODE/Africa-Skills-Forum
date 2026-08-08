<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Video extends Model
{
    use HasTranslations;

    protected $fillable = [
        'uuid',
        'title_ar',
        'title_fr',
        'title_en',
        'slug',
        'description_ar',
        'description_fr',
        'description_en',
        'video_type',
        'video_url',
        'embed_url',
        'thumbnail_path',
        'duration',
        'edition_id',
        'event_id',
        'skill_id',
        'is_featured',
        'status',
        'published_at',
    ];

    protected $casts = [
        'is_featured'  => 'boolean',
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($vid) {
            if (empty($vid->uuid)) {
                $vid->uuid = (string) Str::uuid();
            }
            if (empty($vid->slug)) {
                $vid->slug = Str::slug($vid->title_en ?: $vid->title_ar ?: 'video-' . rand(100, 999));
            }
        });
    }

    public function getYoutubeIdAttribute(): ?string
    {
        if (empty($this->video_url)) return null;
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $this->video_url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function getFormattedEmbedUrlAttribute(): string
    {
        $url = $this->embed_url ?: ($this->youtube_id ? "https://www.youtube.com/embed/{$this->youtube_id}" : $this->video_url);
        if (empty($url)) {
            $url = "https://www.youtube.com/embed/ee7fzNFUKIM";
        }
        return str_contains($url, '?') ? "{$url}&autoplay=1" : "{$url}?autoplay=1";
    }

    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail_path) {
            if (str_starts_with($this->thumbnail_path, 'http://') || str_starts_with($this->thumbnail_path, 'https://')) {
                return $this->thumbnail_path;
            }
            return asset(ltrim($this->thumbnail_path, '/'));
        }
        if ($yId = $this->youtube_id) {
            return "https://img.youtube.com/vi/{$yId}/hqdefault.jpg";
        }
        return 'https://images.unsplash.com/photo-1511578314322-379afb476865?w=600&auto=format&fit=crop&q=80';
    }
}
