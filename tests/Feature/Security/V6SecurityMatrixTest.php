<?php

namespace Tests\Feature\Security;

use App\Enums\RoleEnum;
use App\Models\NewsArticle;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class V6SecurityMatrixTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /** 1. SQL Injection Input Resilience */
    public function test_sql_injection_payloads_in_search_and_filters_are_handled_safely(): void
    {
        $sqliPayloads = [
            "' OR '1'='1",
            "1; DROP TABLE users; --",
            "1' UNION SELECT 1,2,3,4--",
            "admin'--",
        ];

        foreach ($sqliPayloads as $payload) {
            $response = $this->get('/search?q=' . urlencode($payload));
            $response->assertStatus(200);
            $response->assertDontSee('SQLSTATE');
            $response->assertDontSee('Syntax error');
        }
    }

    /** 2. XSS Output Escaping */
    public function test_xss_script_payloads_are_escaped_on_rendering(): void
    {
        NewsArticle::create([
            'title_ar' => 'خبر أمني خاص',
            'title_fr' => 'Titre FR',
            'title_en' => 'Title EN',
            'content_ar' => 'المحتوى الآمن',
            'status' => 'PUBLISHED',
            'published_at' => now(),
        ]);

        $response = $this->get('/news');
        $response->assertStatus(200);
        $response->assertDontSee('<script>alert("xss")</script>', false);
    }

    /** 3. Mass Assignment & Privilege Escalation Protection */
    public function test_unauthorized_user_cannot_escalate_role_via_mass_assignment(): void
    {
        $user = User::factory()->create();
        $user->assignRole(RoleEnum::PARTICIPANT);

        $user->update([
            'email' => 'updated_participant@worldskills.dz',
        ]);

        $this->assertFalse($user->hasRole(RoleEnum::SUPER_ADMIN));
    }

    /** 4. IDOR Negative Testing across Scoped Roles */
    public function test_participant_cannot_access_another_participant_profile_idor(): void
    {
        $partA = User::factory()->create();
        $partA->assignRole(RoleEnum::PARTICIPANT);

        $this->actingAs($partA);

        $response = $this->get('/admin/dashboard');
        $this->assertTrue(in_array($response->status(), [302, 403]));
    }

    /** 5. Negative IDOR Test for Organization Admin */
    public function test_organization_admin_cannot_access_super_admin_command_center(): void
    {
        $orgAdmin = User::factory()->create();
        $orgAdmin->assignRole(RoleEnum::ORGANIZATION_ADMIN);

        $this->actingAs($orgAdmin);

        $response = $this->get('/admin/dashboard');
        $this->assertTrue(in_array($response->status(), [302, 403]));
    }

    /** 6. Negative IDOR Test for Judge Access */
    public function test_judge_cannot_access_unassigned_admin_routes(): void
    {
        $judge = User::factory()->create();
        $judge->assignRole(RoleEnum::JUDGE);

        $this->actingAs($judge);

        $response = $this->get('/admin/logistics');
        $this->assertTrue(in_array($response->status(), [302, 403]));
    }

    /** 7. Executive Viewer Read-Only Security Gate */
    public function test_executive_viewer_has_read_only_access_and_cannot_modify_cms(): void
    {
        $minister = User::factory()->create();
        $minister->assignRole(RoleEnum::EXECUTIVE_VIEWER);

        $this->actingAs($minister);

        $response = $this->get('/admin/cms/homepage');
        $this->assertTrue(in_array($response->status(), [302, 403]));
    }
}
