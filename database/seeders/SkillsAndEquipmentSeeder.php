<?php

namespace Database\Seeders;

use App\Models\EquipmentCategory;
use App\Models\EquipmentItem;
use App\Models\Skill;
use App\Models\SkillCategory;
use App\Models\SkillEquipment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SkillsAndEquipmentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Skill Categories
        $catIT = SkillCategory::updateOrCreate(
            ['code' => 'ICT'],
            ['name_ar' => 'تكنولوجيا المعلومات والاتصال', 'name_fr' => 'Technologies de l\'Information et de la Communication', 'name_en' => 'Information and Communication Technology', 'icon' => 'server']
        );

        $catIndustrial = SkillCategory::updateOrCreate(
            ['code' => 'IND'],
            ['name_ar' => 'التكنولوجيا الصناعية والإنتاج', 'name_fr' => 'Technologies de Fabrication et d\'Ingénierie', 'name_en' => 'Manufacturing and Engineering Technology', 'icon' => 'cog']
        );

        $catConstruction = SkillCategory::updateOrCreate(
            ['code' => 'CON'],
            ['name_ar' => 'البناء وتكنولوجيا البناء', 'name_fr' => 'Technologies du Bâtiment', 'name_en' => 'Construction and Building Technology', 'icon' => 'home']
        );

        // 2. Core Skills
        $skills = [
            ['code' => 'SKILL-39', 'cat' => $catIT->id, 'ar' => 'تطوير تقنيات الويب', 'fr' => 'Technologies Web', 'en' => 'Web Technologies'],
            ['code' => 'SKILL-09', 'cat' => $catIT->id, 'ar' => 'حلول البرمجيات للأعمال', 'fr' => 'Solutions Logicielles pour l\'Entreprise', 'en' => 'IT Software Solutions for Business'],
            ['code' => 'SKILL-54', 'cat' => $catIT->id, 'ar' => 'الأمن السيبراني', 'fr' => 'Cybersécurité', 'en' => 'Cyber Security'],
            ['code' => 'SKILL-10', 'cat' => $catIndustrial->id, 'ar' => 'اللحام والربط المعدني', 'fr' => 'Soudage', 'en' => 'Welding'],
            ['code' => 'SKILL-16', 'cat' => $catIndustrial->id, 'ar' => 'الميكاترونكس والتحكم الآلي', 'fr' => 'Mécatronique', 'en' => 'Mechatronics'],
            ['code' => 'SKILL-33', 'cat' => $catIndustrial->id, 'ar' => 'تكنولوجيا السيارات', 'fr' => 'Technologie Automobile', 'en' => 'Automobile Technology'],
            ['code' => 'SKILL-18', 'cat' => $catConstruction->id, 'ar' => 'التركيبات الكهربائية', 'fr' => 'Installations Électriques', 'en' => 'Electrical Installations'],
            ['code' => 'SKILL-40', 'cat' => $catIT->id, 'ar' => 'التصميم الجرافيكي والاتصال البصري', 'fr' => 'Design Graphique', 'en' => 'Graphic Design Technology'],
        ];

        foreach ($skills as $s) {
            Skill::updateOrCreate(
                ['code' => $s['code']],
                [
                    'uuid' => (string) Str::uuid(),
                    'category_id' => $s['cat'],
                    'name_ar' => $s['ar'],
                    'name_fr' => $s['fr'],
                    'name_en' => $s['en'],
                    'description_ar' => 'منافسة رسمية ضمن أولمبياد المهن لتقييم المهارات التقنية والتطبيقية العالية.',
                    'min_age' => 16,
                    'max_age' => 25,
                    'is_active' => true,
                ]
            );
        }

        // 3. Equipment Categories
        $eqCatPPE = EquipmentCategory::updateOrCreate(
            ['name_ar' => 'معدات الحماية الشخصية (PPE)'],
            ['name_fr' => 'Équipements de Protection Individuelle', 'name_en' => 'Personal Protective Equipment']
        );

        $eqItemGlasses = EquipmentItem::updateOrCreate(
            ['name_ar' => 'نظارات الحماية الشخصية'],
            ['category_id' => $eqCatPPE->id, 'name_fr' => 'Lunettes de sécurité', 'name_en' => 'Safety Glasses', 'item_type' => 'ppe', 'safety_level' => 'high']
        );

        $eqItemShoes = EquipmentItem::updateOrCreate(
            ['name_ar' => 'حذاء السلامة الصناعي S3'],
            ['category_id' => $eqCatPPE->id, 'name_fr' => 'Chaussures de sécurité S3', 'name_en' => 'S3 Safety Shoes', 'item_type' => 'ppe', 'safety_level' => 'high']
        );

        $weldingSkill = Skill::where('code', 'SKILL-10')->first();
        if ($weldingSkill) {
            SkillEquipment::updateOrCreate(
                ['skill_id' => $weldingSkill->id, 'equipment_item_id' => $eqItemGlasses->id],
                ['is_required' => true, 'quantity' => 1, 'provided_by' => 'ORGANIZER']
            );
            SkillEquipment::updateOrCreate(
                ['skill_id' => $weldingSkill->id, 'equipment_item_id' => $eqItemShoes->id],
                ['is_required' => true, 'quantity' => 1, 'provided_by' => 'COUNTRY']
            );
        }
    }
}
