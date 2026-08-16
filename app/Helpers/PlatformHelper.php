<?php

use App\Services\PlatformService;
use App\Services\EventContextService;

if (! function_exists('platform')) {
    /**
     * Get the global PlatformService instance.
     */
    function platform(): PlatformService
    {
        return app(PlatformService::class);
    }
}

if (! function_exists('eventContext')) {
    /**
     * Get the global EventContextService instance.
     */
    function eventContext(): EventContextService
    {
        return app(EventContextService::class);
    }
}
