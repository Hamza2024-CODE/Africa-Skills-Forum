<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class WsapNotification extends Model
{
    use HasFactory;

    protected $table = 'wsap_notifications';

    protected $fillable = [
        'uuid',
        'type',
        'title_ar',
        'title_fr',
        'title_en',
        'body_ar',
        'body_fr',
        'body_en',
        'priority',
        'status',
        'action_type',
        'action_id',
        'scheduled_at',
        'dispatched_at',
        'expires_at',
        'created_by',
    ];

    protected $casts = [
        'scheduled_at'  => 'datetime',
        'dispatched_at' => 'datetime',
        'expires_at'    => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($n) {
            if (empty($n->uuid)) {
                $n->uuid = (string) Str::uuid();
            }
        });
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function targets()
    {
        return $this->hasMany(NotificationTarget::class, 'notification_id');
    }

    public function userNotifications()
    {
        return $this->hasMany(UserNotification::class, 'notification_id');
    }

    public function getLocalizedTitle(string $locale = 'ar'): string
    {
        return match ($locale) {
            'fr' => $this->title_fr ?: $this->title_ar,
            'en' => $this->title_en ?: $this->title_ar,
            default => $this->title_ar,
        };
    }

    public function getLocalizedBody(string $locale = 'ar'): string
    {
        return match ($locale) {
            'fr' => $this->body_fr ?: $this->body_ar,
            'en' => $this->body_en ?: $this->body_ar,
            default => $this->body_ar,
        };
    }

    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }
}
