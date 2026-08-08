<?php

namespace Tests\Feature\Certificate;

use App\Services\Certificate\CertificateTemplateService;
use Tests\TestCase;

class TemplateIntegrityTest extends TestCase
{
    protected CertificateTemplateService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CertificateTemplateService();
    }

    public function test_participation_template_exists_and_matches_sha256_hash()
    {
        $this->assertTrue(
            $this->service->verifyIntegrity('PARTICIPATION'),
            'OFFICIAL TEMPLATE INTEGRITY FAILURE: participation_bg.png missing or hash mismatched.'
        );
    }

    public function test_partner_template_exists_and_matches_sha256_hash()
    {
        $this->assertTrue(
            $this->service->verifyIntegrity('PARTNER'),
            'OFFICIAL TEMPLATE INTEGRITY FAILURE: partner_bg.png missing or hash mismatched.'
        );
    }

    public function test_appreciation_template_exists_and_matches_sha256_hash()
    {
        $this->assertTrue(
            $this->service->verifyIntegrity('APPRECIATION'),
            'OFFICIAL TEMPLATE INTEGRITY FAILURE: appreciation_bg.png missing or hash mismatched.'
        );
    }
}
