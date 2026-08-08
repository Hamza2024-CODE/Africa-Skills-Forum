<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveTvSlide extends Model
{
    protected $fillable = [
        'title_ar', 'title_fr', 'slide_type', 'content',
        'image_url', 'display_duration_sec', 'is_active', 'sort_order',
    ];

    protected $casts = ['is_active' => 'boolean'];
}
