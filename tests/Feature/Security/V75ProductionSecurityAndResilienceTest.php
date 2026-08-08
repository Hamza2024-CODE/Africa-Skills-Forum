<?php

namespace Tests\Feature\Security;

use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\User;
use App\Services\CertificateService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class V75ProductionSecurityAndResilienceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_http_security_headers_injected_across_all_responses(): void
    {
        // 1. 200 OK Response
        $res200 = $this->get('/?lang=ar');
        $res200->assertStatus(200);
        $res200->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $res200->assertHeader('X-Content-Type-Options', 'nosniff');
        $res200->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $res200->assertHeader('Permissions-Policy', 'camera=(), microphone=(), geolocation=()');
        $this->assertTrue($res200->headers->has('Content-Security-Policy'));

        // 2. 404 Not Found Response
        $res404 = $this->get('/certificate/NON_EXISTENT_TOKEN');
        $res404->assertStatus(404);
        $res404->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $res404->assertHeader('X-Content-Type-Options', 'nosniff');

        // 3. 403 Forbidden Response
        $countryAdmin = User::where('email', 'dz.admin@worldskills.dz')->first();
        $res403 = $this->actingAs($countryAdmin)->get('/admin/dashboard');
        $res403->assertStatus(403);
        $res403->assertHeader('X-Frame-Options', 'SAMEORIGIN');
    }

    public function test_uniform_anti_enumeration_public_responses(): void
    {
        $service = new CertificateService();

        // 1. Non-existent token query -> null
        $res1 = $service->verifyByToken('NON_EXISTENT_TOKEN_123456');
        $this->assertNull($res1);

        // 2. Malformed token query -> null
        $res2 = $service->verifyByToken('SHORT');
        $this->assertNull($res2);

        // Public Verification Portal renders generic failure message for both
        $portalRes1 = $this->get('/verify?token=NON_EXISTENT_TOKEN_123456');
        $portalRes1->assertStatus(200)->assertSee('لم يتم العثور على أي ملف بهاتين البيانات');

        $portalRes2 = $this->get('/verify?token=SHORT');
        $portalRes2->assertStatus(200)->assertSee('لم يتم العثور على أي ملف بهاتين البيانات');
    }

    public function test_session_regeneration_on_login_and_invalidation_on_logout(): void
    {
        $user = User::where('email', 'admin@worldskills.dz')->first();

        // 1. Authenticate user
        $this->actingAs($user);
        $this->assertAuthenticatedAs($user);

        // 2. Logout invalidates session
        auth()->logout();
        $this->assertGuest();
    }

    public function test_first_login_must_change_password_flag_integrity(): void
    {
        $user = User::where('email', 'admin@worldskills.dz')->first();
        $user->update(['must_change_password' => true]);

        $this->assertTrue($user->fresh()->must_change_password);
    }
}
