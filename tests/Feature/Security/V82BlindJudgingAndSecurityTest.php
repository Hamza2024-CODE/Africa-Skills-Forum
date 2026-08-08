<?php

namespace Tests\Feature\Security;

use App\Models\CompetitionAssessmentCriterion;
use App\Models\CompetitionAssessmentModule;
use App\Models\Country;
use App\Models\Edition;
use App\Models\ParticipantAssessment;
use App\Models\ParticipantProfile;
use App\Models\ParticipantScore;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\User;

use App\Services\CisScoringService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class V82BlindJudgingAndSecurityTest extends TestCase
{
    use RefreshDatabase;

    private function createParticipantRegistration(Skill $skill, Edition $edition, string $regNumber, string $token): Registration
    {
        $u = User::factory()->create();
        $c = Country::create(['iso2' => 'DZ', 'iso3' => 'DZA', 'name_ar' => 'الجزائر', 'name_fr' => 'Algérie', 'name_en' => 'Algeria']);
        $p = ParticipantProfile::create([
            'user_id'       => $u->id,
            'first_name_ar' => 'أحمد',
            'last_name_ar'  => 'علي',
            'first_name_fr' => 'Ahmed',
            'last_name_fr'  => 'Ali',
            'first_name_en' => 'Ahmed',
            'last_name_en'  => 'Ali',
            'phone'         => '0550000000',
            'gender'        => 'M',
        ]);

        return Registration::create([
            'user_id'             => $u->id,
            'participant_id'      => $p->id,
            'skill_id'            => $skill->id,
            'edition_id'          => $edition->id,
            'country_id'          => $c->id,
            'registration_number' => $regNumber,
            'verification_token'  => $token,
            'status'              => 'APPROVED',
        ]);
    }

    public function test_judge_cannot_access_unassigned_candidate_due_to_idor_protection()
    {
        $judge = User::factory()->create();
        $this->actingAs($judge);

        $skillAssigned = Skill::create(['code' => 'WEB', 'name_ar' => 'تقنيات الويب', 'name_fr' => 'Web Tech', 'name_en' => 'Web Tech', 'is_active' => false]);
        $skillUnassigned = Skill::create(['code' => 'AUTO', 'name_ar' => 'ميكانيك السيارات', 'name_fr' => 'Auto Tech', 'name_en' => 'Auto Tech', 'is_active' => false]);
        $edition = Edition::create(['name_ar' => 'دورة 2026', 'name_fr' => 'Edition 2026', 'name_en' => 'Edition 2026', 'year' => 2026, 'is_active' => true]);

        $candidateUnassigned = $this->createParticipantRegistration($skillUnassigned, $edition, 'REG-999', 'TOKEN-999');

        $this->expectException(AuthorizationException::class);

        $component = Livewire::test(\App\Livewire\Judge\JudgeDashboard::class);
        $component->set('assignedSkills', [$skillAssigned->toArray()]);
        $component->instance()->openEvaluation($candidateUnassigned->id);
    }

    public function test_discrepancy_detection_flags_score_spread_greater_than_one()
    {
        $skill = Skill::create(['code' => 'CYBER', 'name_ar' => 'الأمن السيبراني', 'name_fr' => 'Cyber Security', 'name_en' => 'Cyber Security', 'is_active' => true]);
        $edition = Edition::create(['name_ar' => 'دورة 2026', 'name_fr' => 'Edition 2026', 'name_en' => 'Edition 2026', 'year' => 2026, 'is_active' => true]);

        $module = CompetitionAssessmentModule::create([
            'skill_id'   => $skill->id,
            'edition_id' => $edition->id,
            'title_ar'   => 'وحدة البرمجة',
            'title_fr'   => 'Module Coding',
            'max_score'  => 100,
        ]);

        $criterion = CompetitionAssessmentCriterion::create([
            'module_id' => $module->id,
            'title_ar'  => 'جودة الكود',
            'title_fr'  => 'Code Quality',
            'type'      => 'JUDGEMENT',
            'max_score' => 10,
        ]);

        $reg = $this->createParticipantRegistration($skill, $edition, 'REG-888', 'TOKEN-888');

        $assessment = ParticipantAssessment::create([
            'registration_id' => $reg->id,
            'module_id'       => $module->id,
            'total_score'     => 0,
        ]);

        $j1 = User::factory()->create();
        $j2 = User::factory()->create();

        // Judge 1 gives 2.0, Judge 2 gives 8.0 (Range = 6.0 > 1.0)
        ParticipantScore::create([
            'assessment_id' => $assessment->id,
            'criterion_id'  => $criterion->id,
            'judge_user_id' => $j1->id,
            'score'         => 2.0,
        ]);

        ParticipantScore::create([
            'assessment_id' => $assessment->id,
            'criterion_id'  => $criterion->id,
            'judge_user_id' => $j2->id,
            'score'         => 8.0,
        ]);

        $service = new CisScoringService();
        $discrepancies = $service->detectDiscrepancies($assessment->id);

        $this->assertCount(1, $discrepancies);
        $this->assertEquals(6.0, $discrepancies[0]['range']);
    }

    public function test_locked_assessment_blocks_further_judge_scoring()
    {
        $skill = Skill::create(['code' => 'NET', 'name_ar' => 'شبكات الحاسوب', 'name_fr' => 'Networking', 'name_en' => 'Networking', 'is_active' => true]);
        $edition = Edition::create(['name_ar' => 'دورة 2026', 'name_fr' => 'Edition 2026', 'name_en' => 'Edition 2026', 'year' => 2026, 'is_active' => true]);

        $module = CompetitionAssessmentModule::create([
            'skill_id'   => $skill->id,
            'edition_id' => $edition->id,
            'title_ar'   => 'وحدة الشبكات',
            'title_fr'   => 'Networking Module',
            'max_score'  => 100,
        ]);

        $criterion = CompetitionAssessmentCriterion::create([
            'module_id' => $module->id,
            'title_ar'  => 'إعداد المحول',
            'title_fr'  => 'Switch Setup',
            'type'      => 'MEASUREMENT',
            'max_score' => 10,
        ]);

        $reg = $this->createParticipantRegistration($skill, $edition, 'REG-777', 'TOKEN-777');

        $chief = User::factory()->create();
        $judge = User::factory()->create();

        $assessment = ParticipantAssessment::create([
            'registration_id' => $reg->id,
            'module_id'       => $module->id,
            'total_score'     => 0,
        ]);

        $service = new CisScoringService();
        $service->lockAssessment($assessment->id, $chief->id);

        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('لا يمكن تعديل التقييم بعد قفله');

        $service->submitScore($assessment->id, $criterion->id, $judge->id, 8.5);
    }
}
