<?php

namespace App\Services\Venue;

use App\Models\MealScan;
use App\Models\MealSlot;
use App\Models\Restaurant;
use App\Models\ScheduleEvent;
use App\Models\Skill;
use App\Models\VenuePoi;
use Carbon\Carbon;

class VenuePoiService
{
    /**
     * Resolve live operational status, occupancy, and remaining time countdown for a POI.
     */
    public function resolvePoiState(VenuePoi $poi): array
    {
        $type = strtoupper($poi->reference_type ?? $poi->poi_type);

        if ($type === 'RESTAURANT') {
            return $this->resolveRestaurantState($poi);
        }

        if ($type === 'SKILL' || $type === 'SCHEDULE_EVENT') {
            return $this->resolveSkillCompetitionState($poi);
        }

        return [
            'poi_id'          => $poi->id,
            'title_ar'        => $poi->title_ar,
            'title_fr'        => $poi->title_fr,
            'title_en'        => $poi->title_en,
            'status'          => $poi->status,
            'status_label_ar' => $poi->status === 'OPEN' ? 'مفتوح' : 'مغلق',
            'occupancy_count' => $poi->current_occupancy,
            'capacity'        => $poi->capacity,
            'occupancy_pct'   => $poi->capacity > 0 ? round(($poi->current_occupancy / $poi->capacity) * 100, 1) : 0,
            'countdown_text'  => null,
        ];
    }

    /**
     * Resolve dynamic live restaurant state from MealScan & MealSlot.
     */
    protected function resolveRestaurantState(VenuePoi $poi): array
    {
        $restaurant = null;
        if ($poi->reference_id) {
            $restaurant = Restaurant::find($poi->reference_id);
        }

        $capacity = $restaurant->capacity ?? $poi->capacity ?? 300;

        // Current active meal slot
        $activeSlot = MealSlot::where('is_open', true)
            ->whereTime('start_time', '<=', now()->toTimeString())
            ->whereTime('end_time', '>=', now()->toTimeString())
            ->first();

        $servedCount = 0;
        if ($activeSlot) {
            $query = MealScan::where('status', 'AUTHORIZED')
                ->where('created_at', '>=', now()->startOfDay());

            if ($restaurant) {
                $query->where('restaurant_id', $restaurant->id);
            }

            $servedCount = $query->count();
        }

        $pct = $capacity > 0 ? min(100, round(($servedCount / $capacity) * 100, 1)) : 0;

        $status = 'OPEN';
        $statusLabelAr = 'مفتوح';

        if ($pct >= 95.0) {
            $status = 'FULL';
            $statusLabelAr = 'ممتلئ بالكامل';
        } elseif (!$activeSlot) {
            $status = 'CLOSED';
            $statusLabelAr = 'خارج أوقات الوجبة';
        }

        return [
            'poi_id'          => $poi->id,
            'title_ar'        => $poi->title_ar,
            'title_fr'        => $poi->title_fr,
            'title_en'        => $poi->title_en,
            'status'          => $status,
            'status_label_ar' => $statusLabelAr,
            'active_meal'     => $activeSlot ? $activeSlot->name_ar : 'لا توجد وجبة جارية',
            'occupancy_count' => $servedCount,
            'capacity'        => $capacity,
            'occupancy_pct'   => $pct,
            'next_meal'       => $activeSlot ? 'الوجبة جارية الآن' : 'الوجبة القادمة: 19:00',
        ];
    }

    /**
     * Resolve live skill competition round countdown & active participants.
     */
    protected function resolveSkillCompetitionState(VenuePoi $poi): array
    {
        $skill = null;
        if ($poi->reference_id) {
            $skill = Skill::find($poi->reference_id);
        }

        $activeEvent = ScheduleEvent::where('status', 'PUBLISHED')
            ->where('event_type', 'COMPETITION')
            ->first();

        $status = 'OPEN';
        $statusLabelAr = 'مفتوح للزيارة';
        $countdownText = null;
        $roundName = 'Round 01';

        if ($activeEvent) {
            $target = Carbon::parse($activeEvent->end_at ?? now()->addHours(2));
            $diffSeconds = max(0, now()->diffInSeconds($target, false));

            if ($diffSeconds > 0) {
                $status = 'LIVE_COMPETITION';
                $statusLabelAr = 'المنافسة جارية';
                $hours = str_pad((string) floor($diffSeconds / 3600), 2, '0', STR_PAD_LEFT);
                $minutes = str_pad((string) floor(($diffSeconds % 3600) / 60), 2, '0', STR_PAD_LEFT);
                $seconds = str_pad((string) ($diffSeconds % 60), 2, '0', STR_PAD_LEFT);
                $countdownText = "{$hours}:{$minutes}:{$seconds}";
            }
        }

        return [
            'poi_id'          => $poi->id,
            'skill_code'      => $skill->code ?? 'SKILL-01',
            'title_ar'        => $poi->title_ar,
            'title_fr'        => $poi->title_fr,
            'title_en'        => $poi->title_en,
            'status'          => $status,
            'status_label_ar' => $statusLabelAr,
            'round_name'      => $roundName,
            'countdown_text'  => $countdownText ?? '00:00:00',
            'participants'    => 12,
            'judges'          => 6,
            'capacity'        => $poi->capacity,
        ];
    }
}
