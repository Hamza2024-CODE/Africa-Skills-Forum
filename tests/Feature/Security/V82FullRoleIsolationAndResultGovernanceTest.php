<?php

namespace Tests\Feature\Security;

use App\Enums\RoleEnum;
use App\Models\CompetitionAssessmentCriterion;
use App\Models\CompetitionAssessmentModule;
use App\Models\CompetitionResult;
use App\Models\Country;
use App\Models\Edition;
use App\Models\ParticipantAssessment;
use App\Models\ParticipantProfile;
use App\Models\ParticipantScore;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\User;

use App\Services\CisScoringService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class V82FullRoleIsolationAndResultGovernanceTest extends TestCase
{
    use RefreshDatabase;

    private function createRole(RoleEnum $roleEnum): Role
    {
        return Role::firstOrCreate(['name' => $roleEnum->value, 'guard_name' => 'web']);
    }

    private function createFullRegistration(Skill $skill, Edition $edition, Country $country, string $regNumber, string $token): Registration
    {
        $u = User::factory()->create();
        $p = ParticipantProfile::create([
            'user_id'       => $u->id,
            'first_name_ar' => 'أحمد',
            'last_name_ar'  => 'محمد',
            'first_name_fr' => 'Ahmed',
            'last_name_fr'  => 'Mohamed',
            'first_name_en' => 'Ahmed',
            'last_name_en'  => 'Mohamed',
            'phone'         => '0660000000',
            'gender'        => 'M',
        ]);

        return Registration::create([
            'user_id'             => $u->id,
            'participant_id'      => $p->id,
            'skill_id'            => $skill->id,
            'edition_id'          => $edition->id,
            'country_id'          => $country->id,
            'registration_number' => $regNumber,
            'verification_token'  => $token,
            'status'              => 'APPROVED',
        ]);
    }

    public function test_judge_cannot_see_other_judges_scores_or_averages()
    {
        $judge1 = User::factory()->create();
        $judge2 = User::factory()->create();
        $this->actingAs($judge1);

        $skill = Skill::create(['code' => 'ROB', 'name_ar' => 'الروبوتات البرمجية', 'name_fr' => 'Robotics', 'name_en' => 'Robotics', 'is_active' => true]);
        $edition = Edition::create(['name_ar' => 'دورة 2026', 'name_fr' => 'Edition 2026', 'name_en' => 'Edition 2026', 'year' => 2026, 'is_active' => true]);
        $country = Country::create(['iso2' => 'DZ', 'iso3' => 'DZA', 'name_ar' => 'الجزائر', 'name_fr' => 'Algérie', 'name_en' => 'Algeria']);

        $module = CompetitionAssessmentModule::create([
            'skill_id'   => $skill->id,
            'edition_id' => $edition->id,
            'title_ar'   => 'وحدة التحكم',
            'title_fr'   => 'Control Module',
            'max_score'  => 100,
        ]);

        $criterion = CompetitionAssessmentCriterion::create([
            'module_id' => $module->id,
            'title_ar'  => 'البرمجة الحركية',
            'title_fr'  => 'Kinematics',
            'type'      => 'JUDGEMENT',
            'max_score' => 10,
        ]);

        $reg = $this->createFullRegistration($skill, $edition, $country, 'REG-ROB-01', 'TOK-ROB-01');

        $assessment = ParticipantAssessment::create([
            'registration_id' => $reg->id,
            'module_id'       => $module->id,
            'total_score'     => 0,
        ]);

        // Judge 2 submits a score
        ParticipantScore::create([
            'assessment_id' => $assessment->id,
            'criterion_id'  => $criterion->id,
            'judge_user_id' => $judge2->id,
            'score'         => 9.5,
        ]);

        $component = Livewire::test(\App\Livewire\Judge\JudgeDashboard::class);
        $component->set('assignedSkills', [$skill->toArray()]);
        $component->call('openEvaluation', $reg->id);

        // Verify judge 1 dashboard HTML contains ZERO mention of judge 2's score 9.5 or averages
        $component->assertDontSee('9.5');
        $component->assertDontSee('المتوسط');
        $component->assertDontSee('النتيجة النهائية');
    }

    public function test_judge_cannot_access_super_admin_results_center()
    {
        $this->createRole(RoleEnum::JUDGE);
        $judge = User::factory()->create();
        $judge->assignRole(RoleEnum::JUDGE->value);
        $this->actingAs($judge);

        $response = $this->get(route('admin.cis'));

        // Route protection rejects Judge role with 403 Forbidden
        $response->assertStatus(403);
    }

    public function test_country_admin_cannot_access_other_countries_candidates()
    {
        $this->createRole(RoleEnum::COUNTRY_ADMIN);
        $countryA = Country::create(['iso2' => 'DZ', 'iso3' => 'DZA', 'name_ar' => 'الجزائر', 'name_fr' => 'Algérie', 'name_en' => 'Algeria']);
        $countryB = Country::create(['iso2' => 'TN', 'iso3' => 'TUN', 'name_ar' => 'تونس', 'name_fr' => 'Tunisie', 'name_en' => 'Tunisia']);

        $countryAdminA = User::factory()->create(['country_id' => $countryA->id]);
        $countryAdminA->assignRole(RoleEnum::COUNTRY_ADMIN->value);

        $this->actingAs($countryAdminA);

        $skill = Skill::create(['code' => 'WELD', 'name_ar' => 'اللحام', 'name_fr' => 'Welding', 'name_en' => 'Welding', 'is_active' => true]);
        $edition = Edition::create(['name_ar' => 'دورة 2026', 'name_fr' => 'Edition 2026', 'name_en' => 'Edition 2026', 'year' => 2026, 'is_active' => true]);

        $candidateB = $this->createFullRegistration($skill, $edition, $countryB, 'REG-TUN-01', 'TOK-TUN-01');

        $component = Livewire::test(\App\Livewire\Country\DelegationManager::class);

        // DelegationManager scopes candidates strictly to Country A
        $component->assertDontSee($candidateB->registration_number);
    }

    public function test_participant_cannot_access_unpublished_final_score()
    {
        $this->createRole(RoleEnum::PARTICIPANT);
        $participantUser = User::factory()->create();
        $participantUser->assignRole(RoleEnum::PARTICIPANT->value);
        $this->actingAs($participantUser);

        $skill = Skill::create(['code' => 'COOK', 'name_ar' => 'الطبخ', 'name_fr' => 'Cooking', 'name_en' => 'Cooking', 'is_active' => true]);
        $edition = Edition::create(['name_ar' => 'دورة 2026', 'name_fr' => 'Edition 2026', 'name_en' => 'Edition 2026', 'year' => 2026, 'is_active' => true]);
        $country = Country::create(['iso2' => 'DZ', 'iso3' => 'DZA', 'name_ar' => 'الجزائر', 'name_fr' => 'Algérie', 'name_en' => 'Algeria']);

        $reg = $this->createFullRegistration($skill, $edition, $country, 'REG-COOK-01', 'TOK-COOK-01');

        // Create unpublished competition result (is_published = false)
        CompetitionResult::create([
            'registration_id' => $reg->id,
            'skill_id'        => $skill->id,
            'final_score'     => 94.50,
            'rank'            => 1,
            'award'           => 'GOLD',
            'is_published'    => false,
        ]);

        $response = $this->get(route('results'));

        // Public results route excludes unpublished results
        $response->assertDontSee('94.50');
        $response->assertDontSee('GOLD');
    }

    public function test_submitted_assessment_score_cannot_be_overwritten_by_judge()
    {
        $skill = Skill::create(['code' => 'ELEC', 'name_ar' => 'الكهرباء', 'name_fr' => 'Electrical', 'name_en' => 'Electrical', 'is_active' => true]);
        $edition = Edition::create(['name_ar' => 'دورة 2026', 'name_fr' => 'Edition 2026', 'name_en' => 'Edition 2026', 'year' => 2026, 'is_active' => true]);
        $country = Country::create(['iso2' => 'DZ', 'iso3' => 'DZA', 'name_ar' => 'الجزائر', 'name_fr' => 'Algérie', 'name_en' => 'Algeria']);

        $module = CompetitionAssessmentModule::create([
            'skill_id'   => $skill->id,
            'edition_id' => $edition->id,
            'title_ar'   => 'وحدة التوصيل',
            'title_fr'   => 'Wiring Module',
            'max_score'  => 100,
        ]);

        $criterion = CompetitionAssessmentCriterion::create([
            'module_id' => $module->id,
            'title_ar'  => 'السلامة الكهربائية',
            'title_fr'  => 'Electrical Safety',
            'type'      => 'MEASUREMENT',
            'max_score' => 10,
        ]);

        $reg = $this->createFullRegistration($skill, $edition, $country, 'REG-ELEC-01', 'TOK-ELEC-01');
        $chief = User::factory()->create();
        $judge = User::factory()->create();

        $assessment = ParticipantAssessment::create([
            'registration_id' => $reg->id,
            'module_id'       => $module->id,
            'total_score'     => 0,
        ]);

        $service = new CisScoringService();
        $service->submitScore($assessment->id, $criterion->id, $judge->id, 9.0);
        $service->lockAssessment($assessment->id, $chief->id);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('لا يمكن تعديل التقييم بعد قفله');

        $service->submitScore($assessment->id, $criterion->id, $judge->id, 10.0);
    }

    public function test_only_super_admin_can_publish_competition_results()
    {
        $this->createRole(RoleEnum::JUDGE);
        $this->createRole(RoleEnum::SUPER_ADMIN);

        $judge = User::factory()->create();
        $judge->assignRole(RoleEnum::JUDGE->value);
        $this->actingAs($judge);

        $response = $this->get(route('admin.cis'));
        $response->assertStatus(403);

        $superAdmin = User::factory()->create();
        $superAdmin->assignRole(RoleEnum::SUPER_ADMIN->value);
        $this->actingAs($superAdmin);

        $response2 = $this->get(route('admin.cis'));
        $response2->assertStatus(200);
    }
}
