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
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class V82CisScoringCalculationTest extends TestCase
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
            'first_name_ar' => 'متنافس',
            'last_name_ar'  => 'تجريبي',
            'first_name_fr' => 'Competitor',
            'last_name_fr'  => 'Test',
            'first_name_en' => 'Competitor',
            'last_name_en'  => 'Test',
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

    public function test_marking_scheme_modules_sum_up_to_100_points()
    {
        $skill = Skill::create(['code' => 'AUTO', 'name_ar' => 'تكنولوجيا السيارات', 'name_fr' => 'Auto Tech', 'name_en' => 'Auto Tech', 'is_active' => true]);
        $edition = Edition::create(['name_ar' => 'دورة 2026', 'name_fr' => 'Edition 2026', 'name_en' => 'Edition 2026', 'year' => 2026, 'is_active' => true]);

        CompetitionAssessmentModule::create([
            'skill_id'   => $skill->id,
            'edition_id' => $edition->id,
            'code'       => 'Module A',
            'title_ar'   => 'التشخيص',
            'title_fr'   => 'Diagnosis',
            'max_score'  => 40.00,
        ]);

        CompetitionAssessmentModule::create([
            'skill_id'   => $skill->id,
            'edition_id' => $edition->id,
            'code'       => 'Module B',
            'title_ar'   => 'الإصلاح الميكانيكي',
            'title_fr'   => 'Mechanical Repair',
            'max_score'  => 60.00,
        ]);

        $modulesSum = CompetitionAssessmentModule::where('skill_id', $skill->id)->sum('max_score');

        $this->assertEquals(100.00, $modulesSum);
    }

    public function test_score_bounds_validation_rejects_negative_or_exceeding_scores()
    {
        $skill = Skill::create(['code' => 'CAD', 'name_ar' => 'التصميم الهندسي', 'name_fr' => 'CAD Design', 'name_en' => 'CAD Design', 'is_active' => true]);
        $edition = Edition::create(['name_ar' => 'دورة 2026', 'name_fr' => 'Edition 2026', 'name_en' => 'Edition 2026', 'year' => 2026, 'is_active' => true]);
        $country = Country::create(['iso2' => 'DZ', 'iso3' => 'DZA', 'name_ar' => 'الجزائر', 'name_fr' => 'Algérie', 'name_en' => 'Algeria']);

        $module = CompetitionAssessmentModule::create([
            'skill_id'   => $skill->id,
            'edition_id' => $edition->id,
            'title_ar'   => 'وحدة النمذجة',
            'title_fr'   => 'Modeling Module',
            'max_score'  => 100,
        ]);

        $criterion = CompetitionAssessmentCriterion::create([
            'module_id' => $module->id,
            'title_ar'  => 'دقة الرسم',
            'title_fr'  => 'Drawing Precision',
            'type'      => 'MEASUREMENT',
            'max_score' => 10.00,
        ]);

        $reg = $this->createFullRegistration($skill, $edition, $country, 'REG-CAD-01', 'TOK-CAD-01');
        $judge = User::factory()->create();

        $assessment = ParticipantAssessment::create([
            'registration_id' => $reg->id,
            'module_id'       => $module->id,
            'total_score'     => 0,
        ]);

        $service = new CisScoringService();

        // Reject exceeding score (15 > max 10)
        $this->expectException(\DomainException::class);
        $service->submitScore($assessment->id, $criterion->id, $judge->id, 15.00);
    }

    public function test_discrepancy_range_greater_than_one_is_detected()
    {
        $skill = Skill::create(['code' => 'CNC', 'name_ar' => 'الخراطة والفرز', 'name_fr' => 'CNC Milling', 'name_en' => 'CNC Milling', 'is_active' => true]);
        $edition = Edition::create(['name_ar' => 'دورة 2026', 'name_fr' => 'Edition 2026', 'name_en' => 'Edition 2026', 'year' => 2026, 'is_active' => true]);
        $country = Country::create(['iso2' => 'DZ', 'iso3' => 'DZA', 'name_ar' => 'الجزائر', 'name_fr' => 'Algérie', 'name_en' => 'Algeria']);

        $module = CompetitionAssessmentModule::create([
            'skill_id'   => $skill->id,
            'edition_id' => $edition->id,
            'title_ar'   => 'وحدة القطع',
            'title_fr'   => 'Cutting Module',
            'max_score'  => 100,
        ]);

        $criterion = CompetitionAssessmentCriterion::create([
            'module_id' => $module->id,
            'title_ar'  => 'إنهاء السطح',
            'title_fr'  => 'Surface Finish',
            'type'      => 'JUDGEMENT',
            'max_score' => 10,
        ]);

        $reg = $this->createFullRegistration($skill, $edition, $country, 'REG-CNC-01', 'TOK-CNC-01');

        $assessment = ParticipantAssessment::create([
            'registration_id' => $reg->id,
            'module_id'       => $module->id,
            'total_score'     => 0,
        ]);

        $j1 = User::factory()->create();
        $j2 = User::factory()->create();

        ParticipantScore::create([
            'assessment_id' => $assessment->id,
            'criterion_id'  => $criterion->id,
            'judge_user_id' => $j1->id,
            'score'         => 3.0,
        ]);

        ParticipantScore::create([
            'assessment_id' => $assessment->id,
            'criterion_id'  => $criterion->id,
            'judge_user_id' => $j2->id,
            'score'         => 7.5,
        ]);

        $service = new CisScoringService();
        $discrepancies = $service->detectDiscrepancies($assessment->id);

        $this->assertCount(1, $discrepancies);
        $this->assertEquals(4.5, $discrepancies[0]['range']);
    }

    public function test_results_calculation_engine_assigns_ranks_and_medals_correctly()
    {
        $skill = Skill::create(['code' => 'MECH', 'name_ar' => 'الصيانة الصناعية', 'name_fr' => 'Industrial Maintenance', 'name_en' => 'Industrial Maintenance', 'is_active' => true]);
        $edition = Edition::create(['name_ar' => 'دورة 2026', 'name_fr' => 'Edition 2026', 'name_en' => 'Edition 2026', 'year' => 2026, 'is_active' => true]);
        $country = Country::create(['iso2' => 'DZ', 'iso3' => 'DZA', 'name_ar' => 'الجزائر', 'name_fr' => 'Algérie', 'name_en' => 'Algeria']);

        $module = CompetitionAssessmentModule::create([
            'skill_id'   => $skill->id,
            'edition_id' => $edition->id,
            'title_ar'   => 'الوحدة الشاملة',
            'title_fr'   => 'Global Module',
            'max_score'  => 100,
        ]);

        $chief = User::factory()->create();

        $reg1 = $this->createFullRegistration($skill, $edition, $country, 'REG-MECH-01', 'TOK-MECH-01');
        $reg2 = $this->createFullRegistration($skill, $edition, $country, 'REG-MECH-02', 'TOK-MECH-02');

        $asm1 = ParticipantAssessment::create(['registration_id' => $reg1->id, 'module_id' => $module->id, 'total_score' => 92.50, 'is_locked' => true, 'locked_at' => now(), 'locked_by_user_id' => $chief->id]);
        $asm2 = ParticipantAssessment::create(['registration_id' => $reg2->id, 'module_id' => $module->id, 'total_score' => 86.00, 'is_locked' => true, 'locked_at' => now(), 'locked_by_user_id' => $chief->id]);

        $service = new CisScoringService();
        $service->calculateResultsForSkill($skill->id, $edition->id);

        $res1 = CompetitionResult::where('registration_id', $reg1->id)->first();
        $res2 = CompetitionResult::where('registration_id', $reg2->id)->first();

        $this->assertEquals(1, $res1->rank);
        $this->assertEquals('GOLD', $res1->award);

        $this->assertEquals(2, $res2->rank);
        $this->assertEquals('SILVER', $res2->award);
    }
}
