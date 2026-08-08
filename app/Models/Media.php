<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Media extends Model
{
    protected $fillable = [
        'uuid',
        'filename',
        'original_filename',
        'mime_type',
        'file_size',
        'width',
        'height',
        'duration',
        'alt_text',
        'title',
        'description',
        'storage_path',
        'visibility',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($m) {
            if (empty($m->uuid)) {
                $m->uuid = (string) Str::uuid();
            }
        });
    }

    public function getUrlAttribute(): string
    {
        if (!$this->storage_path) {
            return asset('placeholder-gallery.jpg');
        }
        if (str_starts_with($this->storage_path, 'http://') || str_starts_with($this->storage_path, 'https://')) {
            return $this->storage_path;
        }
        return asset(ltrim($this->storage_path, '/'));
    }
}
