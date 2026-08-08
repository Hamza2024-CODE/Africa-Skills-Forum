<?php

namespace App\Services;

use App\Enums\DateType;
use App\Models\Edition;
use App\Models\EditionDate;
use Carbon\Carbon;

class DateEngine
{
    public function getDateRecord(int $editionId, DateType $dateType): ?EditionDate
    {
        return EditionDate::where('edition_id', $editionId)
            ->where('date_type', $dateType->value)
            ->where('is_active', true)
            ->first();
    }

    public function isOpen(int $editionId, DateType $dateType): bool
    {
        $record = $this->getDateRecord($editionId, $dateType);

        if (!$record || !$record->start_at || !$record->end_at) {
            return false;
        }

        $now = Carbon::now('UTC');
        return $now->between($record->start_at, $record->end_at);
    }

    public function daysRemaining(int $editionId, DateType $dateType): int
    {
        $record = $this->getDateRecord($editionId, $dateType);

        if (!$record || !$record->end_at) {
            return 0;
        }

        $now = Carbon::now('UTC');
        if ($now->greaterThanOrEqualTo($record->end_at)) {
            return 0;
        }

        return (int) $now->diffInDays($record->end_at);
    }

    public function timeRemainingFormatted(int $editionId, DateType $dateType): array
    {
        $record = $this->getDateRecord($editionId, $dateType);

        if (!$record || !$record->end_at) {
            return ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0, 'is_open' => false];
        }

        $now = Carbon::now('UTC');
        if ($now->greaterThanOrEqualTo($record->end_at)) {
            return ['days' => 0, 'hours' => 0, 'minutes' => 0, 'seconds' => 0, 'is_open' => false];
        }

        $diff = $now->diff($record->end_at);

        return [
            'days' => $diff->d,
            'hours' => $diff->h,
            'minutes' => $diff->i,
            'seconds' => $diff->s,
            'is_open' => $now->greaterThanOrEqualTo($record->start_at),
        ];
    }
}
