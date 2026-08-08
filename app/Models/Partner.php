<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Partner extends Model
{
    use HasTranslations;

    protected $fillable = [
        'uuid',
        'name_ar',
        'name_fr',
        'name_en',
        'logo_path',
        'website_url',
        'description_ar',
        'description_fr',
        'description_en',
        'partner_type',
        'level',
        'sort_order',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($partner) {
            if (empty($partner->uuid)) {
                $partner->uuid = (string) Str::uuid();
            }
        });
    }
}
