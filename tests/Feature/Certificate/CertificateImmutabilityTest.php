<?php

namespace Tests\Feature\Certificate;

use App\Models\User;
use App\Services\Certificate\CertificateVerificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CertificateImmutabilityTest extends TestCase
{
    use RefreshDatabase;

    protected CertificateVerificationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CertificateVerificationService();
    }

    public function test_issued_certificate_transitions_to_locked_state()
    {
        $user = User::factory()->create();

        $result = $this->service->issue($user->id, 'PARTICIPATION');

        $this->assertNotNull($result['certificate']);
        $this->assertEquals('VALID', $result['certificate']->fresh()->status);
        $this->assertEquals('LOCKED', $result['certificate']->fresh()->metadata['lifecycle_status']);
    }

    public function test_voiding_locked_certificate_changes_status_to_void()
    {
        $user = User::factory()->create();
        $result = $this->service->issue($user->id, 'PARTICIPATION');

        $cert = $result['certificate']->fresh();

        $this->service->void($cert, 'إلغاء تنظيمي');

        $this->assertEquals('REVOKED', $cert->fresh()->status);
        $this->assertEquals('VOID', $cert->fresh()->metadata['lifecycle_status']);
        $this->assertEquals('إلغاء تنظيمي', $cert->fresh()->revocation_reason);
    }

    public function test_voided_certificate_is_rejected_on_verification()
    {
        $user = User::factory()->create();
        $result = $this->service->issue($user->id, 'PARTICIPATION');

        $cert = $result['certificate']->fresh();
        $this->service->void($cert, 'إلغاء تنظيمي');

        $verification = $this->service->verifyToken($result['token']);

        $this->assertEquals('VOID', $verification['status']);
    }
}
