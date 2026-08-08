<?php

namespace Tests\Feature\Phase01;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class MigrationSequenceTest extends TestCase
{
    use RefreshDatabase;

    public function test_all_23_phase_01_tables_exist_in_database(): void
    {
        $tables = [
            'users',
            'permissions',
            'roles',
            'model_has_permissions',
            'model_has_roles',
            'role_has_permissions',
            'editions',
            'global_settings',
            'edition_dates',
            'countries',
            'edition_countries',
            'regions',
            'wilayas',
            'communes',
            'organizations',
            'skill_categories',
            'skills',
            'equipment_categories',
            'equipment_items',
            'skill_equipment',
            'country_skill_selections',
            'country_delegations',
            'delegation_members',
            'competition_assignments',
            'notifications',
            'notification_preferences',
            'activity_log',
        ];

        foreach ($tables as $table) {
            $this->assertTrue(Schema::hasTable($table), "Table {$table} should exist in database.");
        }
    }
}
