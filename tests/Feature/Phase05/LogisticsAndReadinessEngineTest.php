<?php

namespace Tests\Feature\Phase05;

use App\Enums\RoleEnum;
use App\Livewire\Admin\AdminLogisticsCenter;
use App\Livewire\Admin\ReadinessCenter;
use App\Models\Accommodation;
use App\Models\AccommodationRoom;
use App\Models\CompetitionEquipmentRequirement;
use App\Models\ParticipantProfile;
use App\Models\User;
use App\Services\ParticipantReadinessService;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class LogisticsAndReadinessEngineTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_equipment_requirements_and_checklists_can_be_created(): void
    {
        $requirement = CompetitionEquipmentRequirement::where('provided_by', 'ORGANIZER')->first();
        $this->assertNotNull($requirement);

        app()->setLocale('ar');
        $this->assertEquals($requirement->name_ar, $requirement->getLocalized('name'));
    }

    public function test_participant_readiness_service_calculates_dynamic_score(): void
    {
        $participant = ParticipantProfile::create([
            'first_name_ar' => 'سامي',
            'last_name_ar' => 'بلحسن',
            'phone' => '+213555000111',
            'gender' => 'male',
        ]);

        $service = new ParticipantReadinessService();
        $calc = $service->calculateReadiness($participant);

        $this->assertIsArray($calc);
        $this->assertArrayHasKey('overall_score', $calc);
        $this->assertGreaterThanOrEqual(0, $calc['overall_score']);
        $this->assertLessThanOrEqual(100, $calc['overall_score']);
    }

    public function test_accommodation_room_capacity_management(): void
    {
        $acc = Accommodation::where('name_ar', 'like', '%إفريقي%')->first();
        $this->assertNotNull($acc);

        $room = AccommodationRoom::where('accommodation_id', $acc->id)->first();
        $this->assertNotNull($room);
        $this->assertEquals(2, $room->capacity);
    }

    public function test_admin_logistics_center_renders_successfully(): void
    {
        $admin = User::where('email', 'admin@worldskills.dz')->first();
        $this->actingAs($admin);

        session()->forget('locale');
        app()->setLocale('ar');

        $response = $this->get('/admin/logistics?lang=ar');
        $response->assertStatus(200);

        Livewire::test(AdminLogisticsCenter::class)
            ->assertSee('مركز القيادة والتحكم اللوجستي والتجهيزات');
    }

    public function test_readiness_center_renders_successfully(): void
    {
        $admin = User::where('email', 'admin@worldskills.dz')->first();
        $this->actingAs($admin);

        session()->forget('locale');
        app()->setLocale('ar');

        $response = $this->get('/admin/readiness?lang=ar');
        $response->assertStatus(200);

        Livewire::test(ReadinessCenter::class)
            ->assertSee('مركز متابعة الجاهزية الرقمية للمشاركين');
    }
}
