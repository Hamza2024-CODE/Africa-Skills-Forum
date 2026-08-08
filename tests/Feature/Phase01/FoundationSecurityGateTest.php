<?php

namespace Tests\Feature\Phase01;

use App\Enums\RoleEnum;
use App\Models\Country;
use App\Models\CountryDelegation;
use App\Models\Edition;
use App\Models\User;
use Database\Seeders\RolesAndPermissionsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FoundationSecurityGateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RolesAndPermissionsSeeder::class);
    }

    public function test_country_admin_cannot_access_or_modify_other_country_delegation_idor_deny(): void
    {
        $edition = Edition::create(['year' => 2027, 'name_ar' => '2027', 'name_fr' => '2027', 'name_en' => '2027', 'is_active' => true]);

        $countryA = Country::create(['iso2' => 'DZ', 'iso3' => 'DZA', 'name_ar' => 'الجزائر', 'name_fr' => 'Algérie', 'name_en' => 'Algeria', 'is_algeria' => true]);
        $countryB = Country::create(['iso2' => 'TN', 'iso3' => 'TUN', 'name_ar' => 'تونس', 'name_fr' => 'Tunisie', 'name_en' => 'Tunisia', 'is_algeria' => false]);

        $delegationA = CountryDelegation::create(['edition_id' => $edition->id, 'country_id' => $countryA->id]);
        $delegationB = CountryDelegation::create(['edition_id' => $edition->id, 'country_id' => $countryB->id]);

        $adminA = User::create([
            'name' => 'Admin Country A',
            'email' => 'admina@worldskills.dz',
            'password' => bcrypt('password'),
            'country_id' => $countryA->id,
        ]);
        $adminA->assignRole(RoleEnum::COUNTRY_ADMIN->value);

        // Positive Check
        $this->assertTrue($adminA->can('view', $delegationA));
        $this->assertTrue($adminA->can('update', $delegationA));

        // Negative Check (Cross-country IDOR -> Deny 403)
        $this->assertFalse($adminA->can('view', $delegationB));
        $this->assertFalse($adminA->can('update', $delegationB));
        $this->assertFalse($adminA->can('delete', $delegationB));
    }

    public function test_country_admin_cannot_escalate_permissions_to_super_admin(): void
    {
        $countryA = Country::create(['iso2' => 'DZ', 'iso3' => 'DZA', 'name_ar' => 'الجزائر', 'name_fr' => 'Algérie', 'name_en' => 'Algeria', 'is_algeria' => true]);

        $adminA = User::create([
            'name' => 'Admin Country A',
            'email' => 'admina@worldskills.dz',
            'password' => bcrypt('password'),
            'country_id' => $countryA->id,
        ]);
        $adminA->assignRole(RoleEnum::COUNTRY_ADMIN->value);

        $this->assertFalse($adminA->hasRole(RoleEnum::SUPER_ADMIN->value));
        $this->assertFalse($adminA->can('settings.manage'));
        $this->assertFalse($adminA->can('audit.view'));
    }
}
