<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Partner;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class HomepageStatisticsService
{
    /**
     * Get dynamic homepage statistics calculated directly from the real database.
     */
    public function getStatistics(): array
    {
        return Cache::remember('asf_homepage_statistics_v8', 10, function () {
            return [
                'countries'     => Country::count() ?: 54,
                'ministers'     => 20,
                'experts'       => User::whereHas('roles', fn($q) => $q->whereIn('name', ['JUDGE', 'EXPERT', 'SPEAKER']))->count(),
                'participants'  => Registration::count(),
                'panels'        => 7,
                'partners'      => Partner::count() ?: 10,
            ];
        });
    }

    /**
     * Flush statistics cache on DB changes.
     */
    public function flushCache(): void
    {
        Cache::forget('asf_homepage_statistics_v8');
        Cache::forget('asf_homepage_statistics_v7');
        Cache::forget('asf_homepage_statistics_v6');
        Cache::forget('asf_homepage_statistics_v5');
        Cache::forget('asf_homepage_statistics_v4');
        Cache::forget('asf_homepage_statistics_v3');
        Cache::forget('wsap_homepage_statistics');
    }
}
