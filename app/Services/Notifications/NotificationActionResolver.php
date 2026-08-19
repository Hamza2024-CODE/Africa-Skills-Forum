<?php

namespace App\Services\Notifications;

use Illuminate\Support\Facades\Route;

class NotificationActionResolver
{
    public static function resolveUrl(?string $actionType, ?string $actionId): string
    {
        if (empty($actionType)) {
            return Route::has('user.notifications') ? route('user.notifications') : url('/notifications');
        }

        $routeName = match ($actionType) {
            'MEAL_SLOT' => 'admin.meal.scanner',
            'RESTAURANT' => 'admin.restaurants',
            'ACCOMMODATION' => 'admin.accommodations',
            'COMPETITION', 'CIS' => 'admin.dashboard',
            'SCHEDULE' => 'admin.editions',
            'TECHNICAL_MEETING' => 'admin.dashboard',
            'ACCREDITATION' => 'admin.accreditations',
            default => 'user.notifications',
        };

        if (Route::has($routeName)) {
            $params = ($actionType === 'MEAL_SLOT' && $actionId) ? ['slot' => $actionId] : [];
            return route($routeName, $params);
        }

        return match ($actionType) {
            'MEAL_SLOT' => url('/admin/meal-scanner' . ($actionId ? "?slot={$actionId}" : '')),
            'RESTAURANT' => url('/admin/restaurants'),
            'ACCOMMODATION' => url('/admin/accommodations'),
            default => Route::has('user.notifications') ? route('user.notifications') : url('/notifications'),
        };
    }
}
