<?php

namespace Tests\Feature;

use App\Models\Skill;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CompetitionRegressionTest extends TestCase
{
    use RefreshDatabase;

    public function test_skills_catalog_route_renders_successfully(): void
    {
        $response = $this->get('/skills');
        $response->assertStatus(200);
    }

    public function test_results_and_td_viewer_routes_remain_accessible(): void
    {
        $response = $this->get('/results');
        $response->assertStatus(200);

        $guideResponse = $this->get('/guide');
        $guideResponse->assertStatus(200);
    }
}
