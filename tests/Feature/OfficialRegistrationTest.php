<?php

namespace Tests\Feature;

use App\Models\Country;
use App\Models\GlobalSetting;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class OfficialRegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'JUDGE', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'COUNTRY_ADMIN', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'MEDIA_MANAGER', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'SUPER_ADMIN', 'guard_name' => 'web']);

        GlobalSetting::setByKey('official_registration_open', '1');

        Skill::firstOrCreate(['code' => 'WEB01'], ['name_ar' => 'تقنيات الويب', 'name_fr' => 'Technologies Web', 'name_en' => 'Web Technologies', 'is_active' => true]);
        Country::firstOrCreate(['iso2' => 'DZ'], ['iso3' => 'DZA', 'code' => 'DZA', 'name_ar' => 'الجزائر', 'name_fr' => 'Algérie', 'name_en' => 'Algeria', 'is_active' => true]);
    }

    public function test_official_registration_route_is_accessible()
    {
        $response = $this->get(route('official.registration'));
        $response->assertStatus(200);
    }

    public function test_official_can_register_and_account_remains_pending_activation()
    {
        $skill = Skill::first();
        $country = Country::first();
        $photo = UploadedFile::fake()->image('official.jpg');
        $idCard = UploadedFile::fake()->create('id_card.pdf', 500, 'application/pdf');

        Livewire::test(\App\Livewire\Public\OfficialRegistration::class)
            ->set('name', 'الخبير عبد القادر')
            ->set('email', 'judge.expert@worldskills.dz')
            ->set('national_id', '109283746501928374')
            ->set('phone', '0550000000')
            ->set('country_id', $country->id)
            ->set('skill_id', $skill->id)
            ->set('role', 'JUDGE')
            ->set('photo', $photo)
            ->set('id_card_file', $idCard)
            ->set('password', 'Secret123456!')
            ->set('password_confirmation', 'Secret123456!')
            ->call('registerOfficial')
            ->assertHasNoErrors();

        $user = User::where('email', 'judge.expert@worldskills.dz')->first();
        $this->assertNotNull($user);
        $this->assertFalse($user->is_active); // Must require Admin Activation
        $this->assertTrue($user->hasRole('JUDGE'));
    }

    public function test_media_press_can_register_without_password_and_with_press_card()
    {
        $country = Country::first();
        $photo = UploadedFile::fake()->image('press_photo.jpg');
        $pressCard = UploadedFile::fake()->create('press_card.pdf', 500, 'application/pdf');

        Livewire::test(\App\Livewire\Public\OfficialRegistration::class)
            ->set('role', 'MEDIA_MANAGER')
            ->set('name', 'صحفي التلفزيون الوطني')
            ->set('email', 'press.reporter@worldskills.dz')
            ->set('national_id', '109283746501928374')
            ->set('phone', '0661000000')
            ->set('country_id', $country->id)
            ->set('organization_name', 'المؤسسة العمومية للتلفزيون الجزائري')
            ->set('photo', $photo)
            ->set('press_card_file', $pressCard)
            ->call('registerOfficial')
            ->assertHasNoErrors();

        $user = User::where('email', 'press.reporter@worldskills.dz')->first();
        $this->assertNotNull($user);
        $this->assertFalse($user->is_active);
        $this->assertTrue($user->hasRole('MEDIA_MANAGER'));
    }

    public function test_super_admin_can_toggle_official_registration_off()
    {
        $admin = User::factory()->create();
        $admin->assignRole('SUPER_ADMIN');

        Livewire::actingAs($admin)
            ->test(\App\Livewire\Admin\AdminUserIndex::class)
            ->call('toggleOfficialRegistration')
            ->assertHasNoErrors();

        $this->assertEquals('0', GlobalSetting::getByKey('official_registration_open'));

        Livewire::test(\App\Livewire\Public\OfficialRegistration::class)
            ->assertSet('isOpen', false);
    }
}
