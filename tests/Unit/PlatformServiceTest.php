<?php

namespace Tests\Unit;

use App\Services\EventContextService;
use App\Services\PlatformService;
use Tests\TestCase;

class PlatformServiceTest extends TestCase
{
    public function test_platform_service_returns_configured_branding_values(): void
    {
        /** @var PlatformService $service */
        $service = app(PlatformService::class);

        $this->assertEquals('Africa Skills Forum', $service->name());
        $this->assertEquals('ASF', $service->shortName());
        $this->assertEquals('africaskillsforum.org', $service->domain());
        $this->assertEquals('contact@africaskillsforum.org', $service->email());
    }

    public function test_platform_global_helper_resolves_instance(): void
    {
        $this->assertInstanceOf(PlatformService::class, platform());
        $this->assertEquals('Africa Skills Forum', platform()->name());
        $this->assertEquals('ASF', platform()->shortName());
    }

    public function test_event_context_service_tracks_runtime_context(): void
    {
        /** @var EventContextService $context */
        $context = eventContext();
        $context->setContext(1, 2, 3, 4, 'COMPETITION');

        $this->assertEquals(1, $context->getCountryId());
        $this->assertEquals(2, $context->getOrganizationId());
        $this->assertEquals(3, $context->getEventId());
        $this->assertEquals(4, $context->getEditionId());
        $this->assertEquals('COMPETITION', $context->getActiveModule());
    }
}
