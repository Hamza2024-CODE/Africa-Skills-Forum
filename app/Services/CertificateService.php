<?php

namespace App\Services;

use App\Models\Certificate;
use App\Models\Registration;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * CertificateService
 *
 * Domain service for issuing, verifying, and tracking WSI registration certificates.
 */
class CertificateService
{
    /** Issue a new certificate. Returns raw public token. */
    public function issue(
        int    $userId,
        string $certificateType,
        ?int   $registrationId = null,
        ?int   $skillId = null,
        array  $metadata = []
    ): array {
        $rawToken  = Str::random(48);
        $tokenHash = hash('sha256', $rawToken);

        $certificate = Certificate::create([
            'certificate_uuid'        => (string) Str::uuid(),
            'verification_token_hash' => $tokenHash,
            'user_id'                 => $userId,
            'registration_id'         => $registrationId,
            'skill_id'                => $skillId,
            'certificate_type'        => $certificateType,
            'status'                  => 'VALID',
            'issued_at'               => now(),
            'metadata'                => $metadata,
        ]);

        return ['certificate' => $certificate, 'public_token' => $rawToken];
    }

    /** Verify registration by Token string */
    public function verifyByToken(string $token): ?Registration
    {
        return Registration::with(['participant.user', 'participant.wilaya', 'participant.organization', 'skill', 'country', 'documents'])
            ->where('verification_token', $token)
            ->orWhere('uuid', $token)
            ->first();
    }

    /** Verify registration by Registration Number, ID, Token, Email, NIN, or Passport */
    public function verifyByNumber(string $query): ?Registration
    {
        $clean = trim($query);

        // Extract numeric ID suffix if query is formatted like WSAP-2026-00007 or WSAP-2026-DZ-00007 or 7
        $idFromNumber = null;
        if (preg_match('/(\d+)$/', $clean, $matches)) {
            $num = (int) ltrim($matches[1], '0');
            if ($num > 0) {
                $idFromNumber = $num;
            }
        }

        return Registration::with(['participant.user', 'participant.wilaya', 'participant.organization', 'skill', 'country', 'documents'])
            ->where('registration_number', $clean)
            ->orWhere('verification_token', $clean)
            ->orWhere('uuid', $clean)
            ->when($idFromNumber, fn($q) => $q->orWhere('id', $idFromNumber))
            ->orWhereHas('user', fn($u) => $u->where('users.email', $clean))
            ->orWhereHas('participant', fn($p) => $p->where('national_id', $clean)->orWhere('passport_number', $clean))
            ->first();
    }

    /** Get lifecycle status string for Registration */
    public function getLifecycleStatus(Registration $reg): string
    {
        if ($reg->revoked_at) {
            return 'REVOKED';
        }

        $st = is_object($reg->status) ? $reg->status->value : $reg->status;

        if ($st === 'APPROVED') {
            return 'ACTIVE';
        } elseif ($st === 'REJECTED') {
            return 'REVOKED';
        }

        return 'PENDING';
    }

    /** Verify via raw public token → VALID | REVOKED | EXPIRED | NOT_FOUND */
    public function verify(string $publicToken): array
    {
        $hash        = hash('sha256', $publicToken);
        $certificate = Certificate::where('verification_token_hash', $hash)
            ->with(['user', 'skill'])
            ->first();

        if (! $certificate) {
            return ['status' => 'NOT_FOUND', 'certificate' => null];
        }

        return ['status' => $certificate->status, 'certificate' => $certificate];
    }

    /** Revoke a certificate */
    public function revoke(int $certificateId, string $reason, int $revokedByUserId): void
    {
        $certificate = Certificate::findOrFail($certificateId);

        if ($certificate->status === 'REVOKED') {
            throw new \DomainException('الشهادة ملغاة مسبقاً.');
        }

        $certificate->update([
            'status'            => 'REVOKED',
            'revoked_at'        => now(),
            'revocation_reason' => $reason,
        ]);
    }

    public function typeLabel(string $type): string
    {
        return match ($type) {
            'PARTICIPANT'          => 'شهادة مشارك ومترشح رسمي',
            'WINNER_GOLD'          => 'شهادة ميدالية ذهبية',
            'WINNER_SILVER'        => 'شهادة ميدالية فضية',
            'WINNER_BRONZE'        => 'شهادة ميدالية برونزية',
            'MEDALLION_EXCELLENCE' => 'شهادة تميز (Medallion for Excellence)',
            'EXPERT_JUDGE'         => 'شهادة محكم رسمي معتمد',
            'DELEGATION_OFFICIAL'  => 'شهادة مسؤول وفد رسمي',
            default                => 'شهادة رسمية',
        };
    }
}
