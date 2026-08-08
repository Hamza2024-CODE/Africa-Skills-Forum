<?php

namespace App\Services\Notifications;

use App\Models\AuditLog;
use App\Models\NotificationTarget;
use App\Models\UserNotification;
use App\Models\WsapNotification;
use Illuminate\Support\Facades\DB;

class NotificationService
{
    protected NotificationTargetResolver $targetResolver;

    public function __construct(NotificationTargetResolver $targetResolver)
    {
        $this->targetResolver = $targetResolver;
    }

    /**
     * Create a new notification draft or scheduled notification.
     */
    public function createNotification(array $data, array $targets): WsapNotification
    {
        return DB::transaction(function () use ($data, $targets) {
            $notification = WsapNotification::create([
                'type'         => $data['type'] ?? 'GENERAL',
                'title_ar'     => $data['title_ar'],
                'title_fr'     => $data['title_fr'] ?? null,
                'title_en'     => $data['title_en'] ?? null,
                'body_ar'      => $data['body_ar'],
                'body_fr'      => $data['body_fr'] ?? null,
                'body_en'      => $data['body_en'] ?? null,
                'priority'     => $data['priority'] ?? 'NORMAL',
                'status'       => $data['status'] ?? 'DRAFT',
                'action_type'  => $data['action_type'] ?? null,
                'action_id'    => $data['action_id'] ?? null,
                'scheduled_at' => $data['scheduled_at'] ?? null,
                'expires_at'   => $data['expires_at'] ?? null,
                'created_by'   => $data['created_by'],
            ]);

            foreach ($targets as $target) {
                NotificationTarget::create([
                    'notification_id' => $notification->id,
                    'target_type'     => $target['target_type'],
                    'target_id'       => (string) $target['target_id'],
                ]);
            }

            $this->logAudit('NOTIFICATION_CREATED', $notification, ['targets_count' => count($targets)]);

            return $notification;
        });
    }

    /**
     * Dispatch notification: Resolve targets, Freeze recipient snapshot, and generate UserNotification records with Idempotency.
     */
    public function dispatchNotification(WsapNotification $notification): array
    {
        if ($notification->status === 'SENT') {
            return ['status' => 'already_sent', 'count' => $notification->userNotifications()->count()];
        }

        return DB::transaction(function () use ($notification) {
            // 1. Resolve recipients dynamically
            $recipientUserIds = $this->targetResolver->resolveUserIds($notification->targets);

            // 2. Freeze snapshot into user_notifications with Idempotency (ignore duplicates)
            $dispatchedCount = 0;
            $now = now();

            foreach ($recipientUserIds as $userId) {
                $created = UserNotification::firstOrCreate(
                    [
                        'notification_id' => $notification->id,
                        'user_id'         => $userId,
                        'channel'         => 'IN_APP',
                    ],
                    [
                        'status'       => 'DELIVERED',
                        'delivered_at' => $now,
                    ]
                );

                if ($created->wasRecentlyCreated) {
                    $dispatchedCount++;
                }
            }

            // 3. Mark notification as SENT
            $notification->update([
                'status'        => 'SENT',
                'dispatched_at' => $now,
            ]);

            $this->logAudit('NOTIFICATION_DISPATCHED', $notification, [
                'recipients_count' => count($recipientUserIds),
                'new_deliveries'   => $dispatchedCount,
            ]);

            return [
                'status'           => 'sent',
                'recipients_count' => count($recipientUserIds),
                'new_deliveries'   => $dispatchedCount,
            ];
        });
    }

    /**
     * Cancel a scheduled notification.
     */
    public function cancelNotification(WsapNotification $notification): void
    {
        $notification->update(['status' => 'CANCELLED']);
        $this->logAudit('NOTIFICATION_CANCELLED', $notification, []);
    }

    /**
     * Calculate delivery analytics for a given notification.
     */
    public function getDeliveryAnalytics(WsapNotification $notification): array
    {
        $total     = $notification->userNotifications()->count();
        $delivered = $notification->userNotifications()->whereNotNull('delivered_at')->count();
        $read      = $notification->userNotifications()->whereIn('status', ['READ', 'CLICKED'])->count();
        $clicked   = $notification->userNotifications()->where('status', 'CLICKED')->count();

        return [
            'total'     => $total,
            'delivered' => $delivered,
            'read'      => $read,
            'clicked'   => $clicked,
            'read_pct'  => $total > 0 ? round(($read / $total) * 100, 1) : 0,
        ];
    }

    private function logAudit(string $event, WsapNotification $notification, array $meta): void
    {
        AuditLog::create([
            'event'       => $event,
            'user_id'     => auth()->id() ?? $notification->created_by,
            'target_type' => WsapNotification::class,
            'target_id'   => $notification->id,
            'meta'        => array_merge(['uuid' => $notification->uuid, 'type' => $notification->type], $meta),
        ]);
    }
}
