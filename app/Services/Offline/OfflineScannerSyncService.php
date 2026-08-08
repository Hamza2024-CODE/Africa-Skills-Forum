<?php

namespace App\Services\Offline;

use App\Models\OfflineScan;
use App\Services\Rules\WsapAccessRulesEngine;
use Illuminate\Support\Facades\DB;

class OfflineScannerSyncService
{
    protected WsapAccessRulesEngine $accessEngine;

    public function __construct(WsapAccessRulesEngine $accessEngine)
    {
        $this->accessEngine = $accessEngine;
    }

    /**
     * Process an array of offline scans safely with idempotency on sync_uuid.
     */
    public function processOfflineBatch(array $scans): array
    {
        $processedCount = 0;
        $skippedCount   = 0;
        $results        = [];

        foreach ($scans as $scanData) {
            $syncUuid    = $scanData['sync_uuid'] ?? null;
            $badgeToken  = $scanData['badge_token'] ?? null;
            $serviceType = $scanData['service_type'] ?? 'GENERAL';
            $serviceId   = $scanData['service_id'] ?? null;
            $scannedBy   = $scanData['scanned_by'] ?? (auth()->id() ?: 1);
            $scannedAt   = $scanData['offline_scanned_at'] ?? now()->toDateTimeString();

            if (!$syncUuid || !$badgeToken) {
                continue;
            }

            // Check Idempotency
            if (OfflineScan::where('sync_uuid', $syncUuid)->exists()) {
                $skippedCount++;
                continue;
            }

            DB::transaction(function () use ($syncUuid, $badgeToken, $serviceType, $serviceId, $scannedBy, $scannedAt, &$results, &$processedCount) {
                $record = OfflineScan::create([
                    'sync_uuid'          => $syncUuid,
                    'badge_token'        => $badgeToken,
                    'service_type'       => $serviceType,
                    'service_id'         => $serviceId,
                    'scanned_by'         => $scannedBy,
                    'offline_scanned_at' => $scannedAt,
                    'sync_status'        => 'PROCESSED',
                    'processed_at'       => now(),
                ]);

                $decision = $this->accessEngine->evaluateAccess($badgeToken, $serviceType, $serviceId, null, (string) $scannedBy);

                $results[] = [
                    'sync_uuid' => $syncUuid,
                    'decision'  => $decision,
                ];

                $processedCount++;
            });
        }

        return [
            'processed_count' => $processedCount,
            'skipped_count'   => $skippedCount,
            'results'         => $results,
        ];
    }
}
