<?php

namespace Tests\Feature;

use App\Enums\RoleEnum;
use App\Events\Venue\EmergencyModeActivated;
use App\Events\Venue\VenuePoiStatusChanged;
use App\Models\VenuePoi;
use App\Services\Venue\VenueAnalyticsService;
use Database\Seeders\WsapV90VenueDigitalTwinSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class V90RealTimeSpatialCommandCenterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        foreach (RoleEnum::cases() as $roleCase) {
            Role::firstOrCreate(['name' => $roleCase->value]);
        }

        $this->seed(WsapV90VenueDigitalTwinSeeder::class);
    }

    public function test_rest_api_venue_analytics_endpoint_returns_kpis_and_heatmap_dtos()
    {
        $response = $this->getJson('/api/venue/analytics');

        $response->assertStatus(200)
            ->assertJsonPath('success', true)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'kpis' => [
                        'active_competitions_count',
                        'overall_catering_occupancy_pct',
                        'security_scans',
                        'high_density_zones_count',
                    ],
                    'high_density_zones',
                    'recent_events_feed',
                ],
            ]);
    }

    public function test_spatial_event_contracts_can_be_dispatched()
    {
        Event::fake();

        $poi = VenuePoi::first();
        VenuePoiStatusChanged::dispatch($poi, 'CLOSED');
        EmergencyModeActivated::dispatch(true, 'تفعيل وضع الإخلاء الطارئ');

        Event::assertDispatched(VenuePoiStatusChanged::class);
        Event::assertDispatched(EmergencyModeActivated::class);
    }

    public function test_spatial_analytics_service_calculates_valid_kpi_dtos()
    {
        $service = app(VenueAnalyticsService::class);
        $analytics = $service->getCommandCenterAnalytics();

        $this->assertArrayHasKey('kpis', $analytics);
        $this->assertGreaterThanOrEqual(1, $analytics['kpis']['active_competitions_count']);
        $this->assertArrayHasKey('high_density_zones', $analytics);
    }

    public function test_strict_no_emoji_validation_across_analytics_payload()
    {
        $response = $this->getJson('/api/venue/analytics');
        $json = $response->getContent();

        $regexEmoticons = '/[\x{1F600}-\x{1F64F}\x{1F300}-\x{1F5FF}\x{1F680}-\x{1F6FF}\x{1F700}-\x{1F77F}\x{1F780}-\x{1F7FF}\x{1F800}-\x{1F8FF}\x{1F900}-\x{1F9FF}\x{1FA00}-\x{1FA6F}\x{2600}-\x{26FF}\x{2700}-\x{27BF}]/u';

        $this->assertEquals(0, preg_match($regexEmoticons, $json), 'Analytics API JSON payload must strictly contain zero emojis.');
    }
}
