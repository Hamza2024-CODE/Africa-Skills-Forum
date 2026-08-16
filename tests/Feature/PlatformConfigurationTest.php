<?php

namespace Tests\Feature;

use Tests\TestCase;

class PlatformConfigurationTest extends TestCase
{
    public function test_platform_config_file_exists_and_loads(): void
    {
        $this->assertNotNull(config('platform'));
        $this->assertEquals('Africa Skills Forum', config('platform.name'));
        $this->assertEquals('ASF', config('platform.short_name'));
        $this->assertEquals('africaskillsforum.org', config('platform.domain'));
    }

    public function test_fallback_branding_defaults_when_env_is_missing(): void
    {
        config(['platform.name' => 'Custom Forum Title']);
        $this->assertEquals('Custom Forum Title', platform()->name());
    }
}
