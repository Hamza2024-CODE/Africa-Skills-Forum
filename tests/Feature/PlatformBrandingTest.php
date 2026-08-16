<?php

namespace Tests\Feature;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformBrandingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_homepage_renders_with_status_200(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $this->assertStringContainsString('Africa Skills Forum', $response->getContent());
    }

    public function test_manifest_returns_valid_pwa_json(): void
    {
        $response = $this->get('/manifest.webmanifest');
        $response->assertStatus(200);
        $this->assertStringContainsString('Africa Skills Forum', $response->getContent());
    }
}
