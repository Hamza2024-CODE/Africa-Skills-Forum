<?php

namespace Tests\Feature\Security;

use App\Livewire\Public\Certificate;
use App\Livewire\Public\Skills;
use App\Models\AuditLog;
use App\Models\EquipmentItem;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\SkillEquipment;
use App\Models\User;
use App\Services\AuditService;
use App\Services\CertificateService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class V73ZeroTrustAndSkillDetailsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_skill_details_modal_opens_and_loads_equipment_checklist(): void
    {
        $skill = Skill::first();
        $equipmentItem = EquipmentItem::create([
            'name_ar' => 'جهاز قياس رقمي',
            'name_fr' => 'Multimètre Numérique',
            'item_type' => 'TOOL',
        ]);

        SkillEquipment::create([
            'skill_id' => $skill->id,
            'equipment_item_id' => $equipmentItem->id,
            'quantity' => 1,
        ]);

        Livewire::test(Skills::class)
            ->call('openSkillDetails', $skill->id)
            ->assertSet('showModal', true)
            ->assertSee($skill->code)
            ->assertSee('جهاز قياس رقمي');
    }

    public function test_certificate_lifecycle_statuses_derived_correctly(): void
    {
        $skill = Skill::first();
        $profile = ParticipantProfile::create([
            'first_name_ar' => 'مراد',
            'last_name_ar' => 'سعيد',
            'email' => 'mourad@example.com',
            'phone' => '0555112233',
        ]);

        $reg = Registration::create([
            'edition_id' => 1,
            'participant_id' => $profile->id,
            'country_id' => 1,
            'skill_id' => $skill->id,
            'registration_number' => 'WSAP-2026-DZ-777777',
            'verification_token' => 'VALID_TOKEN_777777',
            'status' => \App\Enums\ParticipantStatus::APPROVED,
        ]);

        $service = new CertificateService();

        // 1. ACTIVE State
        $this->assertEquals('ACTIVE', $service->getLifecycleStatus($reg->fresh()));

        // 2. EXPIRED State
        $reg->update(['expires_at' => now()->subDay()]);
        $this->assertEquals('EXPIRED', $service->getLifecycleStatus($reg->fresh()));

        // 3. REVOKED State
        $reg->update(['revoked_at' => now()]);
        $this->assertEquals('REVOKED', $service->getLifecycleStatus($reg->fresh()));
    }

    public function test_certificate_atomic_revocation_creates_audit_log(): void
    {
        $superAdmin = User::where('email', 'admin@worldskills.dz')->first();
        $skill = Skill::first();
        $profile = ParticipantProfile::create([
            'first_name_ar' => 'فؤاد',
            'last_name_ar' => 'خالد',
            'email' => 'fouad@example.com',
            'phone' => '0555112233',
        ]);

        $reg = Registration::create([
            'edition_id' => 1,
            'participant_id' => $profile->id,
            'country_id' => 1,
            'skill_id' => $skill->id,
            'registration_number' => 'WSAP-2026-DZ-666666',
            'verification_token' => 'VALID_TOKEN_666666',
            'status' => \App\Enums\ParticipantStatus::APPROVED,
        ]);

        $service = new CertificateService();
        $revoked = $service->revoke($reg, $superAdmin, 'إلغاء تنظيمي');

        $this->assertTrue($revoked);
        $this->assertNotNull($reg->fresh()->revoked_at);

        $auditLog = AuditLog::where('event', 'CERTIFICATE_REVOKED')->first();
        $this->assertNotNull($auditLog);
        $this->assertEquals('CERTIFICATE_REVOKED', $auditLog->event);
    }

    public function test_audit_service_sanitizes_sensitive_metadata(): void
    {
        $dirtyMetadata = [
            'candidate_name' => 'أحمد',
            'national_id' => '123456789012345678',
            'passport' => '123456789012345678',
            'password' => 'secret123',
        ];

        $sanitized = AuditService::sanitizeMetadata($dirtyMetadata);

        $this->assertEquals('أحمد', $sanitized['candidate_name']);
        $this->assertEquals('[REDACTED_SENSITIVE_DATA]', $sanitized['national_id']);
        $this->assertEquals('[REDACTED_SENSITIVE_DATA]', $sanitized['passport']);
        $this->assertEquals('[REDACTED_SENSITIVE_DATA]', $sanitized['password']);
    }

    public function test_invalid_or_malicious_certificate_number_returns_404(): void
    {
        $this->get('/certificate/INVALID_NUMBER')->assertStatus(404);
        $this->get('/certificate/../../etc/passwd')->assertStatus(404);
    }
}
