<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsArticle extends Model
{
    use HasTranslations;

    protected $fillable = [
        'uuid',
        'title_ar',
        'title_fr',
        'title_en',
        'slug',
        'excerpt_ar',
        'excerpt_fr',
        'excerpt_en',
        'content_ar',
        'content_fr',
        'content_en',
        'featured_image',
        'author_id',
        'edition_id',
        'event_id',
        'category',
        'status',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($article) {
            if (empty($article->uuid)) {
                $article->uuid = (string) Str::uuid();
            }
            if (empty($article->slug)) {
                $article->slug = Str::slug($article->title_en ?: $article->title_ar ?: 'news-' . rand(100, 999));
            }
        });
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function getCoverUrlAttribute(): string
    {
        if ($this->featured_image) {
            $path = $this->featured_image;
            if (str_contains($path, 'localhost/')) {
                $path = substr($path, strpos($path, 'localhost/') + 10);
            }
            if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
                return $path;
            }
            return asset(ltrim($path, '/'));
        }
        return 'https://images.unsplash.com/photo-1517048676732-d65bc937f952?w=600&auto=format&fit=crop&q=80';
    }
}
