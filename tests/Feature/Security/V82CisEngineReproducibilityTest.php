<?php

namespace Tests\Feature\Security;

use App\Models\CompetitionAssessmentCriterion;
use App\Models\CompetitionAssessmentModule;
use App\Models\CompetitionResult;
use App\Models\Country;
use App\Models\Edition;
use App\Models\ParticipantAssessment;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\User;

use App\Services\CisScoringService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class V82CisEngineReproducibilityTest extends TestCase
{
    use RefreshDatabase;

    private function createFullRegistration(Skill $skill, Edition $edition, Country $country, string $regNumber, string $token): Registration
    {
        $u = User::factory()->create();
        $p = ParticipantProfile::create([
            'user_id'       => $u->id,
            'first_name_ar' => 'متنافس',
            'last_name_ar'  => 'مطابق',
            'first_name_fr' => 'Competitor',
            'last_name_fr'  => 'Reproducible',
            'first_name_en' => 'Competitor',
            'last_name_en'  => 'Reproducible',
            'phone'         => '0661112233',
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

    public function test_cis_engine_reproducibility_yields_exact_same_deterministic_results()
    {
        $skill = Skill::create(['code' => 'IND4', 'name_ar' => 'الثورة الصناعية 4.0', 'name_fr' => 'Industry 4.0', 'name_en' => 'Industry 4.0', 'is_active' => true]);
        $edition = Edition::create(['name_ar' => 'دورة 2026', 'name_fr' => 'Edition 2026', 'name_en' => 'Edition 2026', 'year' => 2026, 'is_active' => true]);
        $country = Country::create(['iso2' => 'DZ', 'iso3' => 'DZA', 'name_ar' => 'الجزائر', 'name_fr' => 'Algérie', 'name_en' => 'Algeria']);

        $module = CompetitionAssessmentModule::create([
            'skill_id'   => $skill->id,
            'edition_id' => $edition->id,
            'title_ar'   => 'وحدة الأتمتة',
            'title_fr'   => 'Automation Module',
            'max_score'  => 100,
        ]);

        $reg1 = $this->createFullRegistration($skill, $edition, $country, 'REG-IND-01', 'TOK-IND-01');
        $reg2 = $this->createFullRegistration($skill, $edition, $country, 'REG-IND-02', 'TOK-IND-02');

        $chief = User::factory()->create();

        ParticipantAssessment::create(['registration_id' => $reg1->id, 'module_id' => $module->id, 'total_score' => 91.25, 'is_locked' => true, 'locked_at' => now(), 'locked_by_user_id' => $chief->id]);
        ParticipantAssessment::create(['registration_id' => $reg2->id, 'module_id' => $module->id, 'total_score' => 83.50, 'is_locked' => true, 'locked_at' => now(), 'locked_by_user_id' => $chief->id]);

        $service = new CisScoringService();

        // 1st Calculation Run
        $service->calculateResultsForSkill($skill->id, $edition->id);
        $run1Reg1 = CompetitionResult::where('registration_id', $reg1->id)->first();
        $run1Reg2 = CompetitionResult::where('registration_id', $reg2->id)->first();

        // 2nd Calculation Run with same inputs
        $service->calculateResultsForSkill($skill->id, $edition->id);
        $run2Reg1 = CompetitionResult::where('registration_id', $reg1->id)->first();
        $run2Reg2 = CompetitionResult::where('registration_id', $reg2->id)->first();

        // Verify 100% deterministic reproducibility
        $this->assertEquals($run1Reg1->final_score, $run2Reg1->final_score);
        $this->assertEquals($run1Reg1->rank, $run2Reg1->rank);
        $this->assertEquals($run1Reg1->award, $run2Reg1->award);

        $this->assertEquals($run1Reg2->final_score, $run2Reg2->final_score);
        $this->assertEquals($run1Reg2->rank, $run2Reg2->rank);
        $this->assertEquals($run1Reg2->award, $run2Reg2->award);
    }
}
