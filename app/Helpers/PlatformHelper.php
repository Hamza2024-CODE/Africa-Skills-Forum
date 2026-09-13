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

if (! function_exists('polyTrans')) {
    /**
     * Multilingual translation resolver supporting AR, FR, EN, and PT.
     *
     * @param string|null $ar
     * @param string|null $fr
     * @param string|null $en
     * @param string|null $pt
     * @return string
     */
    function polyTrans(?string $ar, ?string $fr = null, ?string $en = null, ?string $pt = null): string
    {
        $locale = app()->getLocale();

        if ($locale === 'fr') {
            return (string) ($fr ?? $ar ?? '');
        }

        if ($locale === 'en') {
            return (string) ($en ?? $ar ?? '');
        }

        if ($locale === 'pt') {
            if ($pt !== null && $pt !== '') {
                return $pt;
            }

            // 1. Lookup in pt.json by Arabic key
            if ($ar !== null && $ar !== '') {
                $transAr = __($ar);
                if ($transAr !== $ar) {
                    return $transAr;
                }
            }

            // 2. Lookup in pt.json by English key
            if ($en !== null && $en !== '') {
                $transEn = __($en);
                if ($transEn !== $en) {
                    return $transEn;
                }
            }

            // 3. Lookup in pt.json by French key
            if ($fr !== null && $fr !== '') {
                $transFr = __($fr);
                if ($transFr !== $fr) {
                    return $transFr;
                }
            }

            // 4. Return English rather than raw Arabic for Portuguese users
            return (string) ($en ?? $fr ?? $ar ?? '');
        }

        return (string) ($ar ?? '');
    }
}
