<?php

namespace Tests\Feature\Public;

use App\Livewire\Public\Certificate;
use App\Livewire\Public\Registration;
use App\Livewire\Public\Verification;
use App\Models\ParticipantProfile;
use App\Models\Registration as RegistrationModel;
use App\Models\Skill;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class RegistrationValidationAndCertificateTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_candidate_older_than_25_years_is_rejected_by_age_constraint(): void
    {
        $tooOldDate = date('Y-m-d', strtotime('-26 years')); // 26 years old

        Livewire::test(Registration::class)
            ->set('firstNameAr', 'أحمد')
            ->set('lastNameAr', 'بن علي')
            ->set('email', 'too.old@example.com')
            ->set('phone', '0555112233')
            ->set('dateOfBirth', $tooOldDate)
            ->call('nextStep')
            ->assertHasErrors(['dateOfBirth']);
    }

    public function test_candidate_aged_25_or_younger_is_accepted(): void
    {
        $validDate = date('Y-m-d', strtotime('-22 years')); // 22 years old

        Livewire::test(Registration::class)
            ->set('firstNameAr', 'أحمد')
            ->set('lastNameAr', 'بن علي')
            ->set('email', 'valid.candidate@example.com')
            ->set('phone', '0555112233')
            ->set('dateOfBirth', $validDate)
            ->call('nextStep')
            ->assertHasNoErrors();
    }

    public function test_nin_and_passport_must_be_exactly_18_numeric_digits(): void
    {
        // 17 digits (too short) -> REJECT
        Livewire::test(Registration::class)
            ->set('step', 2)
            ->set('isAlgeria', true)
            ->set('nationalId', '12345678901234567')
            ->call('nextStep')
            ->assertHasErrors(['nationalId']);

        // 18 digits containing letters -> REJECT
        Livewire::test(Registration::class)
            ->set('step', 2)
            ->set('isAlgeria', true)
            ->set('nationalId', '12345678901234567A')
            ->call('nextStep')
            ->assertHasErrors(['nationalId']);

        // 18 numeric digits -> ACCEPT
        Livewire::test(Registration::class)
            ->set('step', 2)
            ->set('isAlgeria', true)
            ->set('nationalId', '123456789012345678')
            ->call('nextStep')
            ->assertHasNoErrors(['nationalId']);
    }

    public function test_file_upload_must_be_pdf_format_only(): void
    {
        Storage::fake('local');

        // Fake image renamed to .pdf or jpg file -> REJECT
        $jpgFile = UploadedFile::fake()->create('id_card.jpg', 500, 'image/jpeg');

        Livewire::test(Registration::class)
            ->set('step', 2)
            ->set('isAlgeria', true)
            ->set('nationalId', '123456789012345678')
            ->set('nationalIdFile', $jpgFile)
            ->call('nextStep')
            ->assertHasErrors(['nationalIdFile']);
    }

    public function test_verification_portal_queries_registration_by_token_and_masks_sensitive_data(): void
    {
        $skill = Skill::first();
        $profile = ParticipantProfile::create([
            'first_name_ar' => 'أسامة',
            'last_name_ar' => 'بوعزيز',
            'email' => 'osama@example.com',
            'phone' => '0555998877',
        ]);

        $reg = RegistrationModel::create([
            'edition_id' => 1,
            'participant_id' => $profile->id,
            'country_id' => 1,
            'skill_id' => $skill->id,
            'registration_number' => 'WSAP-2026-DZ-999999',
            'verification_token' => 'SECRET_TOKEN_999999',
            'status' => \App\Enums\ParticipantStatus::APPROVED,
        ]);

        Livewire::test(Verification::class)
            ->set('query', 'SECRET_TOKEN_999999')
            ->call('verify')
            ->assertSee('WSAP-2026-DZ-999999')
            ->assertSee('مقبول رسمياً');
    }

    public function test_trilingual_certificate_renders_successfully(): void
    {
        $skill = Skill::first();
        $profile = ParticipantProfile::create([
            'first_name_ar' => 'ياسين',
            'last_name_ar' => 'طاهري',
            'email' => 'yassine@example.com',
            'phone' => '0555998877',
        ]);

        $reg = RegistrationModel::create([
            'edition_id' => 1,
            'participant_id' => $profile->id,
            'country_id' => 1,
            'skill_id' => $skill->id,
            'registration_number' => 'WSAP-2026-DZ-888888',
            'verification_token' => 'SECRET_TOKEN_888888',
            'status' => \App\Enums\ParticipantStatus::APPROVED,
        ]);

        $response = $this->get('/certificate/WSAP-2026-DZ-888888');
        $response->assertStatus(200);

        Livewire::test(Certificate::class, ['number' => 'WSAP-2026-DZ-888888'])
            ->assertSee('WSAP-2026-DZ-888888')
            ->assertSee('شهادة تسجيل وتأهيل أولية رسمية')
            ->assertSee('Official Registration Certificate');
    }
}
