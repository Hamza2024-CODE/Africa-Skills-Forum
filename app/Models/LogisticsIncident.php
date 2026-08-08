<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LogisticsIncident extends Model
{
    protected $fillable = [
        'uuid',
        'reference',
        'category',
        'severity',
        'description',
        'reported_by_user_id',
        'assigned_to_user_id',
        'status',
        'resolved_at',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($inc) {
            if (empty($inc->uuid)) {
                $inc->uuid = (string) Str::uuid();
            }
            if (empty($inc->reference)) {
                $inc->reference = 'INC-' . strtoupper(Str::random(6));
            }
        });
    }
}
