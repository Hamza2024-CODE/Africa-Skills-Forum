<?php

namespace App\Services\Schedule;

use App\Models\ScheduleEvent;
use App\Models\ScheduleReminder;
use App\Services\Notifications\NotificationService;

class ScheduleNotificationDispatcher
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Dispatch smart alert when a schedule event is rescheduled.
     */
    public function dispatchReschedulingAlert(ScheduleEvent $event, string $oldTime, ?string $oldLocation = null): void
    {
        if (!$event->auto_notify) {
            return;
        }

        $targets = $this->buildTargetsFromEvent($event);
        $titleAr = "🔔 تعديل موعد: {$event->title_ar}";
        $bodyAr = "تم تعديل الموعد المحدد لـ ({$event->title_ar}). الموعد الجديد: {$event->start_at?->format('Y-m-d H:i')}";
        if ($oldTime) {
            $bodyAr .= " (الموعد السابق: {$oldTime})";
        }

        $notification = $this->notificationService->createNotification([
            'type'        => $event->event_type,
            'title_ar'    => $titleAr,
            'body_ar'     => $bodyAr,
            'priority'    => 'HIGH',
            'action_type' => $event->event_type,
            'action_id'   => (string) $event->id,
            'created_by'  => auth()->id() ?? $event->created_by,
        ], $targets);

        $this->notificationService->dispatchNotification($notification);
    }

    /**
     * Dispatch cancellation alert when a schedule event is cancelled.
     */
    public function dispatchCancellationAlert(ScheduleEvent $event): void
    {
        if (!$event->auto_notify) {
            return;
        }

        $targets = $this->buildTargetsFromEvent($event);
        $titleAr = "🚨 إلغاء حدث: {$event->title_ar}";
        $bodyAr = "نحيطكم علماً بأنه قد تقرر إلغاء الحدث المحدد ({$event->title_ar}). يرجى تعديل جدول أعمالكم بناءً على ذلك.";

        $notification = $this->notificationService->createNotification([
            'type'        => 'URGENT',
            'title_ar'    => $titleAr,
            'body_ar'     => $bodyAr,
            'priority'    => 'URGENT',
            'action_type' => 'SCHEDULE',
            'action_id'   => (string) $event->id,
            'created_by'  => auth()->id() ?? $event->created_by,
        ], $targets);

        $this->notificationService->dispatchNotification($notification);
    }

    /**
     * Dispatch idempotent reminder notification for schedule event.
     */
    public function dispatchReminderIfNeeded(ScheduleEvent $event, int $offsetMinutes): bool
    {
        $key = "event:{$event->uuid}:reminder:{$offsetMinutes}";

        if (ScheduleReminder::where('idempotency_key', $key)->exists()) {
            return false;
        }

        $targets = $this->buildTargetsFromEvent($event);
        $titleAr = "⏰ تذكير: {$event->title_ar}";
        $bodyAr = "تذكير: ينطلق حدث ({$event->title_ar}) بعد {$offsetMinutes} دقيقة في الموقع: {$event->location_name}.";

        $notification = $this->notificationService->createNotification([
            'type'        => $event->event_type,
            'title_ar'    => $titleAr,
            'body_ar'     => $bodyAr,
            'priority'    => 'HIGH',
            'action_type' => $event->event_type,
            'action_id'   => (string) $event->id,
            'created_by'  => $event->created_by,
        ], $targets);

        $this->notificationService->dispatchNotification($notification);

        ScheduleReminder::create([
            'event_id'        => $event->id,
            'idempotency_key' => $key,
            'offset_minutes'  => $offsetMinutes,
            'dispatched_at'   => now(),
        ]);

        return true;
    }

    private function buildTargetsFromEvent(ScheduleEvent $event): array
    {
        $targets = [];

        foreach ($event->targets as $t) {
            $targets[] = [
                'target_type' => $t->target_type,
                'target_id'   => $t->target_id,
            ];
        }

        if (empty($targets)) {
            if ($event->skill_id) {
                $targets[] = ['target_type' => 'skill', 'target_id' => (string) $event->skill_id];
            }
            if ($event->country_id) {
                $targets[] = ['target_type' => 'country', 'target_id' => (string) $event->country_id];
            }
        }

        if (empty($targets)) {
            $targets[] = ['target_type' => 'role', 'target_id' => 'PARTICIPANT'];
            $targets[] = ['target_type' => 'role', 'target_id' => 'JUDGE'];
            $targets[] = ['target_type' => 'role', 'target_id' => 'COUNTRY_ADMIN'];
        }

        return $targets;
    }
}
