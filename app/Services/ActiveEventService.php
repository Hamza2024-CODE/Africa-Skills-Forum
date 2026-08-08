<?php

namespace App\Services;

use App\Models\Event;
use Illuminate\Support\Facades\Cache;

class ActiveEventService
{
    /**
     * Get the current active featured event from database with cache support.
     */
    public function getActiveEvent(): ?Event
    {
        return Cache::remember('wsap_active_event', 3600, function () {
            return Event::where('status', 'PUBLISHED')
                ->where('is_active', true)
                ->orderBy('start_at')
                ->first() ?: Event::where('status', 'PUBLISHED')->first();
        });
    }

    /**
     * Clear cached active event.
     */
    public function clearCache(): void
    {
        Cache::forget('wsap_active_event');
    }
}
