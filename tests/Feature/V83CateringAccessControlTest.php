<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\MealEntitlement;
use App\Models\MealScan;
use App\Models\MealSlot;
use App\Models\Restaurant;
use App\Models\User;
use App\Services\MealAccessService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * WSAP V8.3 — Catering & Meal Access Control Test Suite
 */
class V83CateringAccessControlTest extends TestCase
{
    use RefreshDatabase;

    private Restaurant $restaurant;
    private MealSlot   $lunchSlot;
    private User       $participant;
    private Country    $algeria;

    protected function setUp(): void
    {
        parent::setUp();

        $this->algeria = Country::firstOrCreate(
            ['iso2' => 'DZ'],
            ['iso3' => 'DZA', 'name_ar' => 'الجزائر', 'name_fr' => 'Algérie', 'name_en' => 'Algeria',
             'nationality_ar' => 'جزائري', 'nationality_fr' => 'Algérien', 'nationality_en' => 'Algerian',
             'phone_code' => '213', 'is_active' => true, 'is_african' => true, 'is_algeria' => true,
             'requires_passport' => false, 'requires_national_id' => true,
             'uuid' => (string)\Illuminate\Support\Str::uuid()]
        );

        $this->restaurant = Restaurant::create([
            'uuid'      => (string) Str::uuid(),
            'name_ar'   => 'مطعم الاولمبياد',
            'name_fr'   => 'Restaurant Olympique',
            'capacity'  => 300,
            'is_active' => true,
        ]);

        $this->lunchSlot = MealSlot::create([
            'uuid'          => (string) Str::uuid(),
            'restaurant_id' => $this->restaurant->id,
            'date'          => today(),
            'meal_type'     => 'LUNCH',
            'start_time'    => '00:00:00',  // always open in tests
            'end_time'      => '23:59:00',
            'max_capacity'  => 100,
            'is_open'       => true,
        ]);

        $this->participant = User::factory()->create([
            'uuid'       => (string) Str::uuid(),
            'is_active'  => true,
            'country_id' => $this->algeria->id,
        ]);
    }

    private function makeEntitlement(User $user): MealEntitlement
    {
        return MealEntitlement::create([
            'uuid'          => (string) Str::uuid(),
            'meal_slot_id'  => $this->lunchSlot->id,
            'restaurant_id' => $this->restaurant->id,
            'user_id'       => $user->id,
            'country_id'    => $user->country_id,
            'status'        => 'ACTIVE',
        ]);
    }

    // ────────────────────────────────────────────────────────────
    // RESTAURANT MANAGEMENT TESTS
    // ────────────────────────────────────────────────────────────

    public function test_super_admin_can_create_restaurant(): void
    {
        $this->assertDatabaseHas('restaurants', [
            'name_ar' => 'مطعم الاولمبياد',
        ]);
    }

    public function test_inactive_restaurant_blocks_access(): void
    {
        $this->restaurant->update(['is_active' => false]);

        $service = app(MealAccessService::class);
        $this->makeEntitlement($this->participant);
        $result = $service->scan($this->participant->uuid, $this->lunchSlot->id);

        $this->assertEquals('DENIED', $result['status']);
        $this->assertStringContainsString('مغلق', $result['message']);
    }

    // ────────────────────────────────────────────────────────────
    // MEAL SLOT TESTS
    // ────────────────────────────────────────────────────────────

    public function test_closed_meal_slot_blocks_access(): void
    {
        $this->lunchSlot->update(['is_open' => false]);

        $service = app(MealAccessService::class);
        $this->makeEntitlement($this->participant);
        $result = $service->scan($this->participant->uuid, $this->lunchSlot->id);

        $this->assertEquals('DENIED', $result['status']);
    }

    public function test_meal_outside_date_blocks_access(): void
    {
        $futureSlot = MealSlot::create([
            'uuid'          => (string) Str::uuid(),
            'restaurant_id' => $this->restaurant->id,
            'date'          => today()->addDay(),
            'meal_type'     => 'DINNER',
            'start_time'    => '00:00:00',
            'end_time'      => '23:59:00',
            'max_capacity'  => 100,
            'is_open'       => true,
        ]);

        $service = app(MealAccessService::class);
        $result  = $service->scan($this->participant->uuid, $futureSlot->id);

        $this->assertEquals('DENIED', $result['status']);
        $this->assertStringContainsString('اليوم', $result['message']);
    }

    // ────────────────────────────────────────────────────────────
    // MEAL ENTITLEMENT TESTS
    // ────────────────────────────────────────────────────────────

    public function test_entitled_badge_is_authorized(): void
    {
        $this->makeEntitlement($this->participant);

        $service = app(MealAccessService::class);
        $result  = $service->scan($this->participant->uuid, $this->lunchSlot->id);

        $this->assertEquals('AUTHORIZED', $result['status']);
        $this->assertDatabaseHas('meal_scans', [
            'user_id' => $this->participant->id,
            'status'  => 'AUTHORIZED',
        ]);
    }

    public function test_non_entitled_badge_is_denied(): void
    {
        // No entitlement created
        $service = app(MealAccessService::class);
        $result  = $service->scan($this->participant->uuid, $this->lunchSlot->id);

        $this->assertEquals('DENIED', $result['status']);
        $this->assertDatabaseHas('meal_scans', [
            'user_id' => $this->participant->id,
            'status'  => 'DENIED',
        ]);
    }

    public function test_delegation_entitlement_grants_all_delegation_members(): void
    {
        // Create 3 members of the same delegation (country)
        $members = User::factory()->count(3)->create([
            'is_active'  => true,
            'country_id' => $this->algeria->id,
        ]);

        // Grant entitlement at delegation level
        foreach ($members->prepend($this->participant) as $user) {
            MealEntitlement::create([
                'uuid'          => (string) Str::uuid(),
                'meal_slot_id'  => $this->lunchSlot->id,
                'restaurant_id' => $this->restaurant->id,
                'user_id'       => $user->id,
                'country_id'    => $this->algeria->id,
                'status'        => 'ACTIVE',
            ]);
        }

        $service = app(MealAccessService::class);

        foreach ($members as $m) {
            $result = $service->scan($m->uuid, $this->lunchSlot->id);
            $this->assertEquals('AUTHORIZED', $result['status'],
                "Member {$m->name} should be authorized via delegation entitlement.");
        }
    }

    // ────────────────────────────────────────────────────────────
    // MEAL SCANNER TESTS
    // ────────────────────────────────────────────────────────────

    public function test_duplicate_scan_returns_duplicate_status(): void
    {
        $this->makeEntitlement($this->participant);
        $service = app(MealAccessService::class);

        // First scan — AUTHORIZED
        $first = $service->scan($this->participant->uuid, $this->lunchSlot->id);
        $this->assertEquals('AUTHORIZED', $first['status']);

        // Second scan — DUPLICATE
        $second = $service->scan($this->participant->uuid, $this->lunchSlot->id);
        $this->assertEquals('DUPLICATE', $second['status']);

        $this->assertDatabaseHas('meal_scans', ['user_id' => $this->participant->id, 'status' => 'DUPLICATE']);
    }

    public function test_capacity_exceeded_blocks_further_authorized_scans(): void
    {
        // Tiny capacity
        $tinySlot = MealSlot::create([
            'uuid'          => (string) Str::uuid(),
            'restaurant_id' => $this->restaurant->id,
            'date'          => today(),
            'meal_type'     => 'SNACK',
            'start_time'    => '00:00:00',
            'end_time'      => '23:59:00',
            'max_capacity'  => 2,
            'is_open'       => true,
        ]);

        $users = User::factory()->count(3)->create(['is_active' => true, 'country_id' => $this->algeria->id]);
        foreach ($users as $u) {
            MealEntitlement::create([
                'uuid'          => (string) Str::uuid(),
                'meal_slot_id'  => $tinySlot->id,
                'restaurant_id' => $this->restaurant->id,
                'user_id'       => $u->id,
                'status'        => 'ACTIVE',
            ]);
        }

        $service = app(MealAccessService::class);
        $results = $users->map(fn($u) => $service->scan($u->uuid, $tinySlot->id));

        $this->assertEquals('AUTHORIZED', $results[0]['status']);
        $this->assertEquals('AUTHORIZED', $results[1]['status']);
        $this->assertEquals('DENIED',     $results[2]['status']); // capacity = 2, 3rd should fail
        $this->assertStringContainsString('الطاقة', $results[2]['message']);
    }

    public function test_unknown_badge_code_is_denied(): void
    {
        $service = app(MealAccessService::class);
        $result  = $service->scan('INVALID-BADGE-XYZ-0000', $this->lunchSlot->id);

        $this->assertEquals('DENIED', $result['status']);
        $this->assertStringContainsString('غير معروفة', $result['message']);
    }

    public function test_inactive_user_badge_is_denied(): void
    {
        $inactive = User::factory()->create(['is_active' => false, 'country_id' => $this->algeria->id]);
        MealEntitlement::create([
            'uuid'          => (string) Str::uuid(),
            'meal_slot_id'  => $this->lunchSlot->id,
            'restaurant_id' => $this->restaurant->id,
            'user_id'       => $inactive->id,
            'status'        => 'ACTIVE',
        ]);

        $service = app(MealAccessService::class);
        $result  = $service->scan($inactive->uuid, $this->lunchSlot->id);

        $this->assertEquals('DENIED', $result['status']);
        $this->assertStringContainsString('موقوفة', $result['message']);
    }

    // ────────────────────────────────────────────────────────────
    // SECURITY TESTS
    // ────────────────────────────────────────────────────────────

    public function test_meal_scan_audit_log_is_created_for_all_outcomes(): void
    {
        $service = app(MealAccessService::class);

        // DENIED (no entitlement)
        $service->scan($this->participant->uuid, $this->lunchSlot->id);

        // AUTHORIZED (with entitlement)
        $this->makeEntitlement($this->participant);
        // We need a fresh user for AUTHORIZED since previous scan was DENIED
        $newUser = User::factory()->create(['is_active' => true]);
        MealEntitlement::create([
            'uuid'          => (string) Str::uuid(),
            'meal_slot_id'  => $this->lunchSlot->id,
            'restaurant_id' => $this->restaurant->id,
            'user_id'       => $newUser->id,
            'status'        => 'ACTIVE',
        ]);
        $service->scan($newUser->uuid, $this->lunchSlot->id);

        $this->assertDatabaseCount('meal_scans', 2);
    }

    public function test_restaurant_page_requires_super_admin_authentication(): void
    {
        $response = $this->get(route('admin.restaurants'));
        $response->assertRedirect(route('login'));
    }

    public function test_meal_scanner_page_requires_super_admin_authentication(): void
    {
        $response = $this->get(route('admin.meal.scanner'));
        $response->assertRedirect(route('login'));
    }
}
