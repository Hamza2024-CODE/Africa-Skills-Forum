<?php

namespace App\Services;

use App\Models\Country;
use App\Models\Organization;
use App\Models\Partner;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class HomepageStatisticsService
{
    /**
     * Get real dynamic homepage statistics directly from the database.
     */
    public function getStatistics(): array
    {
        return Cache::remember('wsap_homepage_statistics', 30, function () {
            $partners     = Partner::count();
            $orgs         = Organization::count();
            $experts      = User::role(['JUDGE', 'SUPER_ADMIN'])->count() ?: User::count();
            $participants = Registration::count() ?: ParticipantProfile::count();
            $skills       = Skill::count();
            $countries    = Country::count();

            return [
                'partners'      => $partners,
                'organizations' => $orgs,
                'experts'       => $experts,
                'participants'  => $participants,
                'skills'        => $skills,
                'countries'     => $countries,
            ];
        });
    }

    /**
     * Flush statistics cache on DB changes.
     */
    public function flushCache(): void
    {
        Cache::forget('wsap_homepage_statistics');
    }
}
