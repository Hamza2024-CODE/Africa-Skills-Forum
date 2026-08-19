<?php

namespace App\Services;

use App\Models\Badge;
use App\Models\Certificate;
use App\Models\DelegationMember;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Support\Str;

/**
 * CertificateService
 *
 * Domain service for issuing, verifying, and tracking accreditation certificates and badges.
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
        return $this->verifyByNumber($token);
    }

    /** Verify registration or accreditation by Registration Number, Token, Badge, User, NIN, or Passport */
    public function verifyByNumber(string $query): ?Registration
    {
        $clean = trim($query);
        if (empty($clean)) {
            return null;
        }

        // Extract token or identifier if a full URL is provided
        if (str_contains($clean, 'http://') || str_contains($clean, 'https://')) {
            $parsedUrl = parse_url($clean);
            if (isset($parsedUrl['query'])) {
                parse_str($parsedUrl['query'], $queryParams);
                $extracted = $queryParams['token'] ?? $queryParams['query'] ?? $queryParams['reg'] ?? $queryParams['identifier'] ?? null;
                if (!empty($extracted)) {
                    $clean = trim($extracted);
                }
            }
            if (isset($parsedUrl['path'])) {
                $segments = array_filter(explode('/', $parsedUrl['path']));
                $lastSegment = end($segments);
                if ($lastSegment && !in_array($lastSegment, ['verify', 'badge', 'certificate', 'accreditation'])) {
                    $clean = rawurldecode($lastSegment);
                }
            }
        }

        // 1. Check direct Registration lookup first
        $idFromNumber = null;
        if (preg_match('/(\d+)$/', $clean, $matches)) {
            $num = (int) ltrim($matches[1], '0');
            if ($num > 0) {
                $idFromNumber = $num;
            }
        }

        $reg = Registration::with(['participant.user', 'participant.wilaya', 'participant.organization', 'skill', 'country', 'documents'])
            ->where('registration_number', $clean)
            ->orWhere('verification_token', $clean)
            ->orWhere('uuid', $clean)
            ->when($idFromNumber, fn($q) => $q->orWhere('id', $idFromNumber))
            ->orWhereHas('participant', fn($p) => $p->where('national_id', $clean)->orWhere('passport_number', $clean))
            ->first();

        if ($reg) {
            return $reg;
        }

        // 2. Check Badge access_token or badge_uuid
        $badge = Badge::with(['user.roles', 'user.country', 'user.organization'])
            ->where('access_token', $clean)
            ->orWhere('badge_uuid', $clean)
            ->first();

        if ($badge && $badge->user) {
            $existingReg = Registration::with(['participant.user', 'participant.wilaya', 'participant.organization', 'skill', 'country', 'documents'])
                ->whereHas('participant', fn($p) => $p->where('user_id', $badge->user_id))
                ->first();

            if ($existingReg) {
                return $existingReg;
            }

            return $this->buildVirtualRegistrationForUser($badge->user, 'WSAP-BDG-' . $badge->id);
        }

        // 3. Check User directly by uuid, id, or email
        $user = User::with(['roles', 'country', 'organization', 'participant'])
            ->where('uuid', $clean)
            ->orWhere('id', $clean)
            ->orWhere('email', $clean)
            ->first();

        if ($user) {
            $existingReg = Registration::with(['participant.user', 'participant.wilaya', 'participant.organization', 'skill', 'country', 'documents'])
                ->whereHas('participant', fn($p) => $p->where('user_id', $user->id))
                ->first();

            if ($existingReg) {
                return $existingReg;
            }

            return $this->buildVirtualRegistrationForUser($user, 'WSAP-USR-' . $user->id);
        }

        // 4. Check DelegationMember by uuid, passport_number, nin_number, or email
        $delMember = DelegationMember::with(['delegation.country', 'skill', 'user'])
            ->where('uuid', $clean)
            ->orWhere('passport_number', $clean)
            ->orWhere('nin_number', $clean)
            ->orWhere('email', $clean)
            ->first();

        if ($delMember) {
            $virtualReg = new Registration([
                'registration_number' => 'WSAP-DEL-' . $delMember->id,
                'status'              => 'APPROVED',
            ]);
            $participant = new ParticipantProfile([
                'first_name_ar'    => $delMember->first_name,
                'last_name_ar'     => $delMember->last_name,
                'first_name_latin' => $delMember->first_name,
                'last_name_latin'  => $delMember->last_name,
            ]);
            $virtualReg->setRelation('participant', $participant);
            $virtualReg->setRelation('country', $delMember->delegation?->country);
            $virtualReg->setRelation('skill', $delMember->skill);
            return $virtualReg;
        }

        return null;
    }

    private function buildVirtualRegistrationForUser(User $user, string $regNum): Registration
    {
        $virtualReg = new Registration([
            'registration_number' => $regNum,
            'status'              => 'APPROVED',
        ]);
        $participant = new ParticipantProfile([
            'first_name_ar'    => $user->name,
            'last_name_ar'     => '',
            'first_name_latin' => $user->name,
            'last_name_latin'  => '',
        ]);
        $virtualReg->setRelation('participant', $participant);
        $virtualReg->setRelation('user', $user);
        $virtualReg->setRelation('country', $user->country);
        return $virtualReg;
    }

    /** Get lifecycle status string for Registration */
    public function getLifecycleStatus(Registration $reg): string
    {
        if ($reg->revoked_at) {
            return 'REVOKED';
        }

        $st = is_object($reg->status) ? $reg->status->value : $reg->status;

        if ($st === 'APPROVED' || empty($st)) {
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
