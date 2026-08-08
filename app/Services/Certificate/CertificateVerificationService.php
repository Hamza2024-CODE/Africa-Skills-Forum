<?php

namespace App\Services\Certificate;

use App\Models\Certificate;
use App\Models\Registration;
use Illuminate\Support\Str;

class CertificateVerificationService
{
    /**
     * Verify certificate status via secure token hash or UUID.
     */
    public function verifyToken(string $token): array
    {
        $tokenHash = hash('sha256', $token);

        $certificate = Certificate::where('verification_token_hash', $tokenHash)
            ->orWhere('certificate_uuid', $token)
            ->first();

        if ($certificate) {
            $lifecycle = $certificate->metadata['lifecycle_status'] ?? $certificate->status;
            if ($certificate->status === 'REVOKED' || $certificate->status === 'VOID' || $lifecycle === 'VOID') {
                return ['status' => 'VOID', 'certificate' => $certificate];
            }
            return ['status' => 'VALID', 'certificate' => $certificate];
        }

        $registration = Registration::where('verification_token', $token)
            ->orWhere('uuid', $token)
            ->first();

        if ($registration) {
            if ($registration->revoked_at || $registration->status === 'REJECTED') {
                return ['status' => 'VOID', 'registration' => $registration];
            }
            return ['status' => 'VALID', 'registration' => $registration];
        }

        return ['status' => 'NOT_FOUND'];
    }

    /**
     * Issue a new locked certificate with secure token.
     */
    public function issue(int $userId, string $certType, ?int $registrationId = null, array $metadata = []): array
    {
        $rawToken = Str::random(48);
        $tokenHash = hash('sha256', $rawToken);

        $serial = 'WSAP-' . date('Y') . '-' . strtoupper(substr($certType, 0, 4)) . '-' . str_pad((string) rand(1, 99999), 6, '0', STR_PAD_LEFT);

        $metadata['serial_number'] = $serial;
        $metadata['lifecycle_status'] = 'LOCKED';

        $certificate = Certificate::create([
            'certificate_uuid'        => (string) Str::uuid(),
            'verification_token_hash' => $tokenHash,
            'user_id'                 => $userId,
            'registration_id'         => $registrationId,
            'certificate_type'        => $certType,
            'status'                  => 'VALID',
            'issued_at'               => now(),
            'metadata'                => $metadata,
        ]);

        return ['certificate' => $certificate, 'token' => $rawToken];
    }

    /**
     * Revoke / Void a locked certificate.
     */
    public function void(Certificate $certificate, string $reason): void
    {
        if ($certificate->status === 'REVOKED' || ($certificate->metadata['lifecycle_status'] ?? '') === 'VOID') {
            throw new \DomainException('الشهادة ملغاة مسبقاً.');
        }

        $meta = $certificate->metadata ?? [];
        $meta['lifecycle_status'] = 'VOID';

        $certificate->update([
            'status'            => 'REVOKED',
            'revoked_at'        => now(),
            'revocation_reason' => $reason,
            'metadata'          => $meta,
        ]);
    }
}
