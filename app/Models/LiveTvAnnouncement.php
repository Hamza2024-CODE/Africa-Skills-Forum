<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LiveTvAnnouncement extends Model
{
    protected $fillable = ['ticker_text_ar', 'ticker_text_fr', 'is_active'];
    protected $casts    = ['is_active' => 'boolean'];
}
