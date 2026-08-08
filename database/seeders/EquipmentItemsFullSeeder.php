<?php

namespace Database\Seeders;

use App\Models\EquipmentCategory;
use App\Models\EquipmentItem;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class EquipmentItemsFullSeeder extends Seeder
{
    public function run(): void
    {
        $catTools = EquipmentCategory::firstOrCreate(['name_ar' => 'أدوات وآلات التخصص', 'name_fr' => 'Outillage et Machines'], ['icon' => 'wrench']);
        $catIT = EquipmentCategory::firstOrCreate(['name_ar' => 'تجهيزات الإعلام الآلي والشبكات', 'name_fr' => 'Équipements Informatiques'], ['icon' => 'desktop-computer']);
        $catSafety = EquipmentCategory::firstOrCreate(['name_ar' => 'معدات الحماية والسلامة الفردية', 'name_fr' => 'Équipements de Sécurité'], ['icon' => 'shield-check']);

        $skills = Skill::where('is_active', true)->get();

        foreach ($skills as $skill) {
            $code = strtoupper($skill->code);

            if (str_contains($code, 'WEB') || str_contains($skill->name_ar, 'ويب')) {
                EquipmentItem::create([
                    'skill_id' => $skill->id,
                    'category_id' => $catIT->id,
                    'name_ar' => 'محطة عمل مجهزة لشاشتين وشبكة عالية السرعة',
                    'name_fr' => 'Station de travail double écran HD',
                    'name_en' => 'Dual Screen Developer Workstation',
                    'item_type' => 'workstation',
                    'specification_details' => 'معالج Intel Core i9 RAM 32GB SSD 1TB وشاشتان IPS 27 بوصة بدقة 4K للمنافسة الرسمية',
                    'safety_level' => 'STANDARD',
                ]);
                EquipmentItem::create([
                    'skill_id' => $skill->id,
                    'category_id' => $catIT->id,
                    'name_ar' => 'موزع شبكة معزول وسيرفر اختبار محلي خادم حماية',
                    'name_fr' => 'Serveur de test local sécurisé',
                    'name_en' => 'Isolated Local Test Server',
                    'item_type' => 'tool',
                    'specification_details' => 'سيرفر اختبار محلي معزول 10Gbps بدون اتصال خارجي لتقييم الـ Frontend و Backend',
                    'safety_level' => 'STANDARD',
                ]);
            } elseif (str_contains($code, 'WELD') || str_contains($skill->name_ar, 'لحام')) {
                EquipmentItem::create([
                    'skill_id' => $skill->id,
                    'category_id' => $catTools->id,
                    'name_ar' => 'آلة لحام متعددة الإجراءات إلكترونية رقمية high-performance',
                    'name_fr' => 'Poste de soudage multi-procédés numérique',
                    'name_en' => 'Multi-Process Digital Welding Machine',
                    'item_type' => 'machine',
                    'specification_details' => 'آلة لحام TIG / MIG / MAG بقدرة 400 أمبير مع نظام تبريد بالماء وضبط المعلمات الرقمية',
                    'safety_level' => 'HIGH_HAZARD',
                ]);
                EquipmentItem::create([
                    'skill_id' => $skill->id,
                    'category_id' => $catSafety->id,
                    'name_ar' => 'قناع لحام إلكتروني ذكي ذاتي التظليل مع سحب الدخان',
                    'name_fr' => 'Masque de soudage optoélectronique avec ventilation',
                    'name_en' => 'Auto-Darkening Helmet with PAPR Ventilation',
                    'item_type' => 'ppe',
                    'specification_details' => 'قناع حماية العينين والوجه مع نظام تصفية وسحب الهواء الملوث PAPR للسلامة التامة',
                    'safety_level' => 'STRICT_PPE_REQUIRED',
                ]);
            } else {
                EquipmentItem::create([
                    'skill_id' => $skill->id,
                    'category_id' => $catTools->id,
                    'name_ar' => 'منصة عمل تقنية متكاملة ومعدات القياس والمعايرة الفردية - ' . $skill->name_ar,
                    'name_fr' => 'Poste de travail et équipement technique - ' . $skill->name_fr,
                    'name_en' => 'Technical Workstation & Measurement Suite',
                    'item_type' => 'workstation',
                    'specification_details' => 'طاولة عمل صناعية مضادة للاهتزاز مع كافة الأدوات اليدوية وأجهزة المعايرة الرقمية المعتمدة لمهنة ' . $skill->name_ar,
                    'safety_level' => 'STANDARD',
                ]);
            }
        }
    }
}
