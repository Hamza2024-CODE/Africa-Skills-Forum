<?php

namespace Database\Seeders;

use App\Models\Accommodation;
use App\Models\AccommodationRoom;
use App\Models\CompetitionEquipmentRequirement;
use App\Models\Edition;
use App\Models\Skill;
use App\Models\TransportRoute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LogisticsAndReadinessSeeder extends Seeder
{
    public function run(): void
    {
        $edition = Edition::where('is_active', true)->first();
        $skill = Skill::first();

        // 1. Equipment Requirement
        if ($skill) {
            CompetitionEquipmentRequirement::updateOrCreate(
                ['skill_id' => $skill->id, 'name_ar' => 'حقيبة أدوات التركيب الكهربائي'],
                [
                    'uuid' => (string) Str::uuid(),
                    'edition_id' => $edition ? $edition->id : null,
                    'name_fr' => 'Boîte d\'outils d\'installation électrique',
                    'name_en' => 'Electrical Installation Tool Kit',
                    'description_ar' => 'مجموعة أدوات قياسية معزولة 1000V معتمد عليها للتركيبات الصناعية.',
                    'quantity' => 1,
                    'unit' => 'set',
                    'is_mandatory' => true,
                    'is_ppe' => false,
                    'provided_by' => 'ORGANIZER',
                    'status' => 'active',
                ]
            );

            CompetitionEquipmentRequirement::updateOrCreate(
                ['skill_id' => $skill->id, 'name_ar' => 'حذاء السلامة الصناعي المعزول'],
                [
                    'uuid' => (string) Str::uuid(),
                    'edition_id' => $edition ? $edition->id : null,
                    'name_fr' => 'Chaussures de sécurité isolantes',
                    'name_en' => 'Safety Shoes Insulated',
                    'description_ar' => 'حذاء سلامة مقاوم للصدمات والكهرباء.',
                    'quantity' => 1,
                    'unit' => 'pair',
                    'is_mandatory' => true,
                    'is_ppe' => true,
                    'provided_by' => 'PARTICIPANT',
                    'status' => 'active',
                ]
            );
        }

        // 2. Accommodation & Rooms
        $accommodation = Accommodation::updateOrCreate(
            ['name_ar' => 'فندق المهرجان الإفريقي - الجزائر العاصمة'],
            [
                'uuid' => (string) Str::uuid(),
                'name_fr' => 'Hôtel du Festival Africain - Alger',
                'name_en' => 'African Festival Hotel - Algiers',
                'address' => 'بن عكنون، الجزائر العاصمة',
                'contact_phone' => '+213 21 000 111',
                'total_capacity' => 150,
                'status' => 'active',
            ]
        );

        AccommodationRoom::updateOrCreate(
            ['accommodation_id' => $accommodation->id, 'room_number' => '101'],
            ['capacity' => 2, 'gender' => 'male', 'status' => 'AVAILABLE']
        );

        AccommodationRoom::updateOrCreate(
            ['accommodation_id' => $accommodation->id, 'room_number' => '102'],
            ['capacity' => 2, 'gender' => 'female', 'status' => 'AVAILABLE']
        );

        // 3. Transport Route
        TransportRoute::updateOrCreate(
            ['name_ar' => 'خط مطار هواري بومدين ↔ فندق الإقامة'],
            [
                'uuid' => (string) Str::uuid(),
                'name_fr' => 'Ligne Aéroport Houari Boumediene ↔ Hôtel',
                'name_en' => 'Line Airport Houari Boumediene ↔ Hotel',
                'origin' => 'Aéroport Houari Boumediene',
                'destination' => 'Hôtel du Festival Africain',
                'vehicle_capacity' => 50,
                'status' => 'active',
            ]
        );
    }
}
