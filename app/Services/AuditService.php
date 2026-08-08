<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class AuditService
{
    private static array $sensitiveKeys = [
        'nin',
        'national_id',
        'passport',
        'passport_number',
        'password',
        'token',
        'verification_token',
        'secret',
    ];

    public static function log(string $event, ?Model $subject = null, array $metadata = []): AuditLog
    {
        $cleanMetadata = self::sanitizeMetadata($metadata);

        return AuditLog::create([
            'user_id' => Auth::id(),
            'event' => strtoupper($event),
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject ? $subject->getKey() : null,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
            'metadata' => $cleanMetadata,
        ]);
    }

    public static function sanitizeMetadata(array $data): array
    {
        $sanitized = [];
        foreach ($data as $key => $value) {
            $lowerKey = strtolower((string) $key);
            if (in_array($lowerKey, self::$sensitiveKeys, true)) {
                $sanitized[$key] = '[REDACTED_SENSITIVE_DATA]';
            } elseif (is_array($value)) {
                $sanitized[$key] = self::sanitizeMetadata($value);
            } else {
                $sanitized[$key] = $value;
            }
        }
        return $sanitized;
    }
}
