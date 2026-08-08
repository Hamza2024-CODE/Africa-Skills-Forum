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

class ScopedPolicyAuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_country_admin_can_access_own_country_delegation_but_denied_other_country_delegation(): void
    {
        $this->seed(RolesAndPermissionsSeeder::class);

        $edition = Edition::create([
            'year' => 2027,
            'name_ar' => 'الدورة 2027',
            'name_fr' => 'Edition 2027',
            'name_en' => 'Edition 2027',
            'is_active' => true,
        ]);

        $algeria = Country::create([
            'iso2' => 'DZ',
            'iso3' => 'DZA',
            'name_ar' => 'الجزائر',
            'name_fr' => 'Algérie',
            'name_en' => 'Algeria',
            'is_algeria' => true,
        ]);

        $tunisia = Country::create([
            'iso2' => 'TN',
            'iso3' => 'TUN',
            'name_ar' => 'تونس',
            'name_fr' => 'Tunisie',
            'name_en' => 'Tunisia',
            'is_algeria' => false,
        ]);

        // Delegations
        $algeriaDelegation = CountryDelegation::create([
            'edition_id' => $edition->id,
            'country_id' => $algeria->id,
        ]);

        $tunisiaDelegation = CountryDelegation::create([
            'edition_id' => $edition->id,
            'country_id' => $tunisia->id,
        ]);

        // Algeria Country Admin User
        $algeriaAdmin = User::create([
            'name' => 'Algeria Admin',
            'email' => 'dz.admin@worldskills.dz',
            'password' => bcrypt('password'),
            'country_id' => $algeria->id,
        ]);
        $algeriaAdmin->assignRole(RoleEnum::COUNTRY_ADMIN->value);

        // Policy Check Positive (Algeria Admin -> Algeria Delegation)
        $this->assertTrue($algeriaAdmin->can('view', $algeriaDelegation));
        $this->assertTrue($algeriaAdmin->can('update', $algeriaDelegation));

        // Policy Check Negative (Algeria Admin -> Tunisia Delegation -> DENY 403)
        $this->assertFalse($algeriaAdmin->can('view', $tunisiaDelegation));
        $this->assertFalse($algeriaAdmin->can('update', $tunisiaDelegation));
        $this->assertFalse($algeriaAdmin->can('delete', $tunisiaDelegation));
    }
}
