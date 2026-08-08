<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ScheduleEvent extends Model
{
    use HasFactory;

    protected $table = 'wsap_schedule_events';

    protected $fillable = [
        'uuid',
        'event_type',
        'source_type',
        'source_id',
        'title_ar',
        'title_fr',
        'title_en',
        'description_ar',
        'location_name',
        'zone_id',
        'skill_id',
        'country_id',
        'start_at',
        'end_at',
        'status',
        'reminder_offset_minutes',
        'auto_notify',
        'created_by',
    ];

    protected $casts = [
        'start_at'    => 'datetime',
        'end_at'      => 'datetime',
        'auto_notify' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($event) {
            if (empty($event->uuid)) {
                $event->uuid = (string) Str::uuid();
            }
        });
    }

    public function source()
    {
        return $this->morphTo(__FUNCTION__, 'source_type', 'source_id');
    }

    public function zone()
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class, 'skill_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function targets()
    {
        return $this->hasMany(ScheduleEventTarget::class, 'event_id');
    }

    public function reminders()
    {
        return $this->hasMany(ScheduleReminder::class, 'event_id');
    }

    /**
     * Transition event state following valid lifecycle rules and logging audit trail.
     */
    public function transitionTo(string $newStatus): bool
    {
        $validTransitions = [
            'DRAFT'       => ['SCHEDULED', 'CANCELLED'],
            'SCHEDULED'   => ['OPEN', 'IN_PROGRESS', 'POSTPONED', 'CANCELLED'],
            'OPEN'        => ['IN_PROGRESS', 'COMPLETED', 'POSTPONED', 'CANCELLED'],
            'IN_PROGRESS' => ['COMPLETED', 'CANCELLED'],
            'POSTPONED'   => ['SCHEDULED', 'CANCELLED'],
            'COMPLETED'   => ['ARCHIVED'],
            'CANCELLED'   => ['ARCHIVED'],
        ];

        $current = $this->status;

        if (!isset($validTransitions[$current]) || !in_array($newStatus, $validTransitions[$current], true)) {
            return false;
        }

        $oldStatus = $this->status;
        $this->update(['status' => $newStatus]);

        AuditLog::create([
            'event'       => 'SCHEDULE_EVENT_STATUS_TRANSITION',
            'user_id'     => auth()->id() ?? $this->created_by,
            'target_type' => self::class,
            'target_id'   => $this->id,
            'meta'        => [
                'uuid'       => $this->uuid,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'event_type' => $this->event_type,
            ],
        ]);

        return true;
    }
}
