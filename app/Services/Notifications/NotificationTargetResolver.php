<?php

namespace App\Services\Notifications;

use App\Models\MealEntitlement;
use App\Models\NotificationTarget;
use App\Models\User;
use Illuminate\Support\Collection;

class NotificationTargetResolver
{
    /**
     * Resolve and deduplicate user IDs from a collection of NotificationTarget models or raw target arrays.
     */
    public function resolveUserIds(iterable $targets): array
    {
        $userIds = collect();

        foreach ($targets as $target) {
            $type = is_array($target) ? ($target['target_type'] ?? '') : $target->target_type;
            $id   = is_array($target) ? ($target['target_id'] ?? '') : $target->target_id;

            if (empty($type)) {
                continue;
            }

            $resolved = match ($type) {
                'role' => $this->resolveRoleUserIds((string) $id),

                'delegation', 'country' => User::where('country_id', $id)
                    ->orWhereHas('participant.registrations', fn($r) => $r->where('country_id', $id))
                    ->pluck('id'),

                'skill' => User::whereHas('participant.registrations', fn($r) => $r->where('skill_id', $id))
                    ->pluck('id'),

                'meal_slot' => $this->resolveMealSlotUserIds((int) $id),

                'individual_user', 'user' => collect([(int) $id]),

                'all', 'global', 'everyone' => User::pluck('id'),

                default => collect(),
            };

            $userIds = $userIds->merge($resolved);
        }

        if ($userIds->isEmpty()) {
            return User::pluck('id')->all();
        }

        return $userIds->unique()->filter()->values()->all();
    }

    private function resolveRoleUserIds(string $roleId): Collection
    {
        $normalized = match (strtoupper(trim($roleId))) {
            'EXPERT JUDGE', 'EXPERT', 'JUDGE' => ['JUDGE', 'EXPERT'],
            'DELEGATION HEAD', 'DELEGATION', 'COUNTRY_ADMIN' => ['COUNTRY_ADMIN'],
            'MEDIA', 'PRESS', 'MEDIA_MANAGER' => ['MEDIA_MANAGER'],
            'ORGANIZER', 'SUPER_ADMIN', 'ADMIN', 'ORGANIZATION_ADMIN' => ['SUPER_ADMIN', 'ORGANIZATION_ADMIN'],
            'VIP', 'EXECUTIVE_VIEWER' => ['EXECUTIVE_VIEWER'],
            'COMPETITOR', 'PARTICIPANT' => ['PARTICIPANT'],
            default => [$roleId],
        };

        return User::whereHas('roles', fn($r) => $r->whereIn('name', $normalized))->pluck('id');
    }

    private function resolveMealSlotUserIds(int $slotId): Collection
    {
        if (!\Illuminate\Support\Facades\Schema::hasTable('meal_entitlements')) {
            return collect();
        }

        $entitlements = MealEntitlement::where('meal_slot_id', $slotId)->get();
        $userIds = collect();

        foreach ($entitlements as $ent) {
            if ($ent->user_id) {
                $userIds->push($ent->user_id);
            } elseif ($ent->country_id) {
                $countryUserIds = User::where('country_id', $ent->country_id)
                    ->orWhereHas('participant.registrations', fn($r) => $r->where('country_id', $ent->country_id))
                    ->pluck('id');
                $userIds = $userIds->merge($countryUserIds);
            }
        }

        return $userIds;
    }
}
