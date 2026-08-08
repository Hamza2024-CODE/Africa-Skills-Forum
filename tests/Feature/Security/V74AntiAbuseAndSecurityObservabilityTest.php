<?php

namespace Tests\Feature\Security;

use App\Models\AuditLog;
use App\Models\Country;
use App\Models\Organization;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\User;
use App\Services\AuditService;
use App\Services\CertificateService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class V74AntiAbuseAndSecurityObservabilityTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_route_rate_limiters_enforced_on_public_endpoints(): void
    {
        // Registration endpoint limiter (5 requests / min)
        for ($i = 0; $i < 5; $i++) {
            $this->get('/registration')->assertStatus(200);
        }
        $this->get('/registration')->assertStatus(429); // 6th request throttled
    }

    public function test_security_events_are_logged_for_successful_and_failed_verifications(): void
    {
        $skill = Skill::first();
        $profile = ParticipantProfile::create([
            'first_name_ar' => 'سامي',
            'last_name_ar' => 'جمال',
            'email' => 'sami@example.com',
            'phone' => '0555112233',
        ]);

        $reg = Registration::create([
            'edition_id' => 1,
            'participant_id' => $profile->id,
            'country_id' => 1,
            'skill_id' => $skill->id,
            'registration_number' => 'WSAP-2026-DZ-111111',
            'verification_token' => 'VALID_TOKEN_111111',
            'status' => \App\Enums\ParticipantStatus::APPROVED,
        ]);

        $service = new CertificateService();

        // 1. Success Event
        $service->verifyByToken('VALID_TOKEN_111111');
        $this->assertDatabaseHas('audit_logs', ['event' => 'VERIFICATION_SUCCESS']);

        // 2. Not Found Event
        $service->verifyByToken('UNKNOWN_TOKEN_000000');
        $this->assertDatabaseHas('audit_logs', ['event' => 'CERTIFICATE_NOT_FOUND']);

        // 3. Invalid Format Event
        $service->verifyByToken('INVALID');
        $this->assertDatabaseHas('audit_logs', ['event' => 'VERIFICATION_FAILED']);
    }

    public function test_unauthorized_revocation_attempt_is_blocked_and_logged(): void
    {
        $countryAdmin = User::where('email', 'dz.admin@worldskills.dz')->first();
        $skill = Skill::first();
        $profile = ParticipantProfile::create([
            'first_name_ar' => 'كمال',
            'last_name_ar' => 'ربيع',
            'email' => 'kamal@example.com',
            'phone' => '0555112233',
        ]);

        $reg = Registration::create([
            'edition_id' => 1,
            'participant_id' => $profile->id,
            'country_id' => 1,
            'skill_id' => $skill->id,
            'registration_number' => 'WSAP-2026-DZ-222222',
            'verification_token' => 'VALID_TOKEN_222222',
            'status' => \App\Enums\ParticipantStatus::APPROVED,
        ]);

        $service = new CertificateService();
        $revoked = $service->revoke($reg, $countryAdmin, 'محاولة غير مصرح بها');

        $this->assertFalse($revoked);
        $this->assertNull($reg->fresh()->revoked_at);
        $this->assertDatabaseHas('audit_logs', ['event' => 'UNAUTHORIZED_REVOCATION_ATTEMPT']);
    }

    public function test_cross_scope_idor_isolation_matrix(): void
    {
        $countryAdminDZ = User::where('email', 'dz.admin@worldskills.dz')->first();

        // Country Admin DZ accessing Algerian delegation -> 200
        $this->actingAs($countryAdminDZ)->get('/country/dashboard')->assertStatus(200);

        // Country Admin DZ attempting to access Super Admin dashboard -> 403
        $this->actingAs($countryAdminDZ)->get('/admin/dashboard')->assertStatus(403);
    }
}
