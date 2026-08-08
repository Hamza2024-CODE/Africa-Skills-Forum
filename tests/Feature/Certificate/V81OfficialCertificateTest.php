<?php

namespace Tests\Feature\Certificate;

use App\Models\User;
use App\Services\Certificate\CertificateRenderer;
use App\Services\Certificate\CertificateVerificationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class V81OfficialCertificateTest extends TestCase
{
    use RefreshDatabase;

    public function test_certificate_renderer_resolves_templates_and_names()
    {
        $user = User::factory()->create(['name' => 'محمد أحمد']);

        $renderer = new CertificateRenderer();
        $data = $renderer->renderData(null, null, 'PARTICIPATION', 'TEST-TOKEN-123');

        $this->assertArrayHasKey('template', $data);
        $this->assertArrayHasKey('background_url', $data);
        $this->assertArrayHasKey('recipient_name_ar', $data);
        $this->assertArrayHasKey('recipient_name_latin', $data);
        $this->assertArrayHasKey('date_formatted', $data);
        $this->assertArrayHasKey('serial_number', $data);
        $this->assertArrayHasKey('qr_code_url', $data);
    }

    public function test_official_certificate_route_returns_200_ok()
    {
        $user = User::factory()->create();
        $service = new CertificateVerificationService();
        $issued = $service->issue($user->id, 'PARTICIPATION');

        $response = $this->get(route('official.certificate', ['identifier' => $issued['certificate']->certificate_uuid, 'type' => 'PARTICIPATION']));

        $response->assertStatus(200);
        $response->assertSee('WSAP V8.1 Verified');
    }
}
