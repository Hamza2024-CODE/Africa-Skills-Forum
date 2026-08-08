<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class GuideSection extends Model
{
    use HasTranslations;

    protected $fillable = [
        'section_key',
        'sort_order',
        'is_active',
        'icon_svg',
        'title_ar',
        'title_fr',
        'title_en',
        'body_ar',
        'body_fr',
        'body_en',
        'meta',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'meta'      => 'array',
    ];

    /**
     * Get the title for the current locale.
     */
    public function getLocalizedTitle(): string
    {
        return $this->getLocalized('title');
    }

    /**
     * Get the body for the current locale.
     */
    public function getLocalizedBody(): string
    {
        return $this->getLocalized('body');
    }

    /**
     * Scope: only active sections, ordered by sort_order.
     */
    public function scopeActive(\Illuminate\Database\Eloquent\Builder $query): \Illuminate\Database\Eloquent\Builder
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }
}
