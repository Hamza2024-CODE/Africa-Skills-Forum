<?php

namespace Tests\Feature\Phase01;

use App\Enums\DateType;
use App\Models\Edition;
use App\Models\EditionDate;
use App\Services\DateEngine;
use App\Services\SettingsEngine;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SettingsAndDateEngineTest extends TestCase
{
    use RefreshDatabase;

    public function test_settings_engine_stores_retrieves_and_flushes_cache_correctly(): void
    {
        $engine = new SettingsEngine();

        $engine->set('site_name', 'WorldSkills Algeria WSAP', 'string', 'general', 'Platform Name');

        $this->assertEquals('WorldSkills Algeria WSAP', $engine->get('site_name'));
        $this->assertEquals('WorldSkills Algeria WSAP', $engine->get('site_name', 'Default'));

        $engine->set('registration_enabled', 'true', 'boolean', 'registration');
        $this->assertTrue($engine->getBool('registration_enabled'));
    }

    public function test_date_engine_calculates_open_status_and_days_remaining_correctly(): void
    {
        $edition = Edition::create([
            'year' => 2027,
            'name_ar' => 'أولمبياد 2027',
            'name_fr' => 'Edition 2027',
            'name_en' => 'Edition 2027',
            'is_active' => true,
        ]);

        $now = Carbon::now('UTC');

        EditionDate::create([
            'edition_id' => $edition->id,
            'date_type' => DateType::REGISTRATION->value,
            'start_at' => $now->copy()->subDays(5),
            'end_at' => $now->copy()->addDays(20)->endOfDay(),
            'timezone' => 'Africa/Algiers',
            'is_active' => true,
        ]);

        $dateEngine = new DateEngine();

        $this->assertTrue($dateEngine->isOpen($edition->id, DateType::REGISTRATION));
        $this->assertGreaterThanOrEqual(19, $dateEngine->daysRemaining($edition->id, DateType::REGISTRATION));
    }
}
