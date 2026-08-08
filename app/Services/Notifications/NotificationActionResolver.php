<?php

namespace App\Services\Notifications;

class NotificationActionResolver
{
    public static function resolveUrl(?string $actionType, ?string $actionId): string
    {
        if (empty($actionType)) {
            return route('user.notifications');
        }

        return match ($actionType) {
            'MEAL_SLOT' => route('admin.meal.scanner', array_filter(['slot' => $actionId])),
            'RESTAURANT' => route('admin.restaurants'),
            'ACCOMMODATION' => route('admin.accommodations'),
            'COMPETITION', 'CIS' => route('admin.dashboard'),
            'SCHEDULE' => route('admin.editions'),
            'TECHNICAL_MEETING' => route('admin.dashboard'),
            'ACCREDITATION' => route('admin.accreditations'),
            default => route('user.notifications'),
        };
    }
}
