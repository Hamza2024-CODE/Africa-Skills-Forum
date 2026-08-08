<?php

namespace Tests\Feature\Phase03;

use App\Enums\ParticipantStatus;
use App\Enums\RoleEnum;
use App\Models\Country;
use App\Models\Edition;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipantRegistrationEngineTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_participant_profile_and_registration_can_be_created_with_uuid(): void
    {
        $edition = Edition::first();
        $country = Country::where('iso2', 'DZ')->first();
        $skill = Skill::first();

        $profile = ParticipantProfile::create([
            'first_name_ar' => 'ياسين',
            'last_name_ar' => 'بن عمر',
            'phone' => '0555123456',
            'national_id' => '1234567890',
        ]);

        $this->assertNotNull($profile->uuid);

        $registration = Registration::create([
            'edition_id' => $edition->id,
            'participant_id' => $profile->id,
            'country_id' => $country->id,
            'skill_id' => $skill->id,
            'status' => ParticipantStatus::SUBMITTED,
        ]);

        $this->assertNotNull($registration->uuid);
        $this->assertStringStartsWith('WSAP-', $registration->registration_number);
        $this->assertEquals(ParticipantStatus::SUBMITTED, $registration->status);
    }

    public function test_participant_policy_denies_cross_country_idor_access(): void
    {
        $edition = Edition::first();
        $algeria = Country::where('iso2', 'DZ')->first();
        $tunisia = Country::where('iso2', 'TN')->first();
        $skill = Skill::first();

        // Create Country Admin for Tunisia
        $tunisiaAdmin = User::create([
            'name' => 'Tunisia Admin',
            'email' => 'tn.admin@worldskills.dz',
            'password' => bcrypt('password'),
            'country_id' => $tunisia->id,
        ]);
        $tunisiaAdmin->assignRole('COUNTRY_ADMIN');

        // Create Registration for Algeria
        $profileAlgeria = ParticipantProfile::create([
            'first_name_ar' => 'حمزة',
            'last_name_ar' => 'علي',
            'phone' => '0555998877',
        ]);

        $regAlgeria = Registration::create([
            'edition_id' => $edition->id,
            'participant_id' => $profileAlgeria->id,
            'country_id' => $algeria->id,
            'skill_id' => $skill->id,
        ]);

        // Tunisia Admin trying to view Algeria Registration MUST be denied
        $this->assertFalse($tunisiaAdmin->can('view', $regAlgeria));
    }

    public function test_participant_dashboard_renders_successfully(): void
    {
        $participant = User::factory()->create();
        $participant->assignRole(RoleEnum::PARTICIPANT);
        $this->actingAs($participant);

        session()->forget('locale');
        app()->setLocale('ar');

        $response = $this->get('/participant/dashboard?lang=ar');
        $response->assertStatus(200);
        $response->assertSee('مرحباً بك في فضاء المتنافس الأولمبي');
    }
}
