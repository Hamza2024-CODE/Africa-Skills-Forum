<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class LegalContent extends Model
{
    use HasTranslations;

    protected $fillable = [
        'key',
        'title_ar',
        'title_fr',
        'title_en',
        'content_ar',
        'content_fr',
        'content_en',
        'is_published',
        'version',
        'last_updated_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'last_updated_at' => 'datetime',
    ];
}
