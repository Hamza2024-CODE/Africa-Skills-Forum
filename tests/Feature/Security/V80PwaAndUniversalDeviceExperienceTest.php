<?php

namespace Tests\Feature\Security;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class V80PwaAndUniversalDeviceExperienceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_pwa_manifest_webmanifest_exists_and_returns_valid_json(): void
    {
        $response = $this->get('/manifest.webmanifest');
        $response->assertStatus(200);

        $json = $response->json();
        $this->assertEquals('WorldSkills Algeria 2026 / 2027', $json['name']);
        $this->assertEquals('WSAP 2026', $json['short_name']);
        $this->assertEquals('standalone', $json['display']);
        $this->assertEquals('#020A24', $json['theme_color']);
        $this->assertCount(3, $json['icons']);
    }

    public function test_pwa_service_worker_script_exists_and_contains_allowlist_default_deny_rules(): void
    {
        $response = $this->get('/sw.js');
        $response->assertStatus(200);

        $content = $response->getContent();
        $this->assertStringContainsString('wsap-static-v8.0', $content);
        $this->assertStringContainsString('wsap-pages-v8.0', $content);
        $this->assertStringContainsString('STATIC_ALLOWLIST', $content);
        $this->assertStringContainsString('NETWORK_ONLY_PATTERNS', $content);
        $this->assertStringContainsString('SKIP_WAITING', $content);
    }

    public function test_pwa_offline_fallback_html_renders_branding_and_zero_trust_notice(): void
    {
        $response = $this->get('/offline.html');
        $response->assertStatus(200);
        $response->assertSee('لا يوجد اتصال بالإنترنت');
        $response->assertSee('Zero-Trust Security');
    }

    public function test_public_layout_includes_pwa_meta_tags_and_sw_registration(): void
    {
        $response = $this->get('/?lang=ar');
        $response->assertStatus(200);
        $response->assertSee('manifest.webmanifest');
        $response->assertSee('theme-color');
        $response->assertSee('apple-touch-icon');
        $response->assertSee('/sw.js');
        $response->assertSee('SKIP_WAITING');
    }
}
