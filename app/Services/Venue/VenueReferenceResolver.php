<?php

namespace App\Services\Venue;

use App\Models\MealSlot;
use App\Models\Restaurant;
use App\Models\ScheduleEvent;
use App\Models\Skill;
use App\Models\VenuePoi;

class VenueReferenceResolver
{
    /**
     * Resolve referenced model dynamically from POI type enum without hardcoding class names.
     */
    public function resolveReference(VenuePoi $poi): ?object
    {
        $refType = strtoupper($poi->reference_type ?? $poi->poi_type ?? '');
        $refId   = $poi->reference_id;

        if (!$refId) {
            return null;
        }

        switch ($refType) {
            case 'RESTAURANT':
                return Restaurant::find($refId);

            case 'SKILL':
                return Skill::find($refId);

            case 'MEAL_SLOT':
                return MealSlot::find($refId);

            case 'SCHEDULE_EVENT':
            case 'MEETING':
                return ScheduleEvent::find($refId);

            default:
                return null;
        }
    }
}
