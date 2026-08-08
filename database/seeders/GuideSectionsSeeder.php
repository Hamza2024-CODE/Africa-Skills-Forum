<?php

namespace Database\Seeders;

use App\Models\GuideSection;
use Illuminate\Database\Seeder;

class GuideSectionsSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'section_key' => 'overview',
                'sort_order' => 1,
                'is_active' => true,
                'icon_svg' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'title_ar' => 'عن أولمبياد المهن WorldSkills Algeria',
                'title_fr' => 'À propos des Olympiades des Métiers WorldSkills Algeria',
                'title_en' => 'About WorldSkills Algeria Olympiad',
                'body_ar' => 'منظومة أولمبياد المهن الجزائرية تهدف إلى تعزيز التميز المهني والتكنولوجي والارتقاء بالكفاءات الوطنية إلى المستويات الدولية من خلال بيئة تنافسية قياسية بالقرية الأورومتوسطية بوهران.',
                'body_fr' => 'Le système des Olympiades des Métiers algériennes vise à promouvoir l\'excellence professionnelle et technologique et à élever les compétences nationales aux niveaux internationaux.',
                'body_en' => 'The Algerian Skills Olympiad system aims to promote professional and technological excellence and elevate national competencies to international levels.',
            ],
            [
                'section_key' => 'structure',
                'sort_order' => 2,
                'is_active' => true,
                'icon_svg' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                'title_ar' => 'الهيكل التنظيمي',
                'title_fr' => 'Structure Organisationnelle',
                'title_en' => 'Organizational Structure',
                'body_ar' => 'يقوم الأولمبياد على هيكل تنظيمي رباعي المستويات يضمن الحوكمة الرشيدة والنزاهة الكاملة في الإدارة والتنفيذ.',
                'body_fr' => 'Les Olympiades reposent sur une structure organisationnelle à quatre niveaux garantissant une gouvernance saine et une intégrité totale.',
                'body_en' => 'The Olympiad is built on a four-level organizational structure ensuring sound governance and complete integrity.',
            ],
            [
                'section_key' => 'skills',
                'sort_order' => 3,
                'is_active' => true,
                'icon_svg' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                'title_ar' => 'التخصصات والمهن',
                'title_fr' => 'Métiers & Compétences',
                'title_en' => 'Skills & Occupations',
                'body_ar' => 'تشمل المنافسة أكثر من 40 تخصصاً مصنفة وفق المجالات الدولية المعتمدة لدى WorldSkills International.',
                'body_fr' => 'La compétition comprend plus de 40 métiers classés selon les domaines internationaux homologués par WorldSkills International.',
                'body_en' => 'The competition includes more than 40 skills classified according to international domains approved by WorldSkills International.',
            ],
            [
                'section_key' => 'eligibility',
                'sort_order' => 4,
                'is_active' => true,
                'icon_svg' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                'title_ar' => 'شروط المشاركة',
                'title_fr' => 'Conditions de Participation',
                'title_en' => 'Participation Conditions',
                'body_ar' => 'تُحدد شروط المشاركة وفق ضوابط وطنية ودولية صارمة تضمن العدالة والكفاءة في المنافسة.',
                'body_fr' => 'Les conditions de participation sont définies selon des critères nationaux et internationaux stricts garantissant l\'équité et la compétence.',
                'body_en' => 'Participation conditions are defined according to strict national and international standards ensuring fairness and competence.',
            ],
            [
                'section_key' => 'rules',
                'sort_order' => 5,
                'is_active' => true,
                'icon_svg' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
                'title_ar' => 'قواعد المنافسة الرسمية',
                'title_fr' => 'Règles Officielles de la Compétition',
                'title_en' => 'Official Competition Rules',
                'body_ar' => 'تلتزم كافة المشاركات بالمعايير الفنية والزمنية لكل تخصص، وفق الضوابط الرسمية للوائح WorldSkills.',
                'body_fr' => 'Tous les participants sont tenus de respecter les normes techniques et temporelles de chaque spécialité, conformément aux règlements officiels WorldSkills.',
                'body_en' => 'All participants must comply with the technical and time standards for each skill, in accordance with official WorldSkills regulations.',
            ],
            [
                'section_key' => 'scoring',
                'sort_order' => 6,
                'is_active' => true,
                'icon_svg' => 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
                'title_ar' => 'نظام التنقيط والـ CIS',
                'title_fr' => 'Système de Notation & CIS',
                'title_en' => 'Scoring System & CIS',
                'body_ar' => 'يعتمد الأولمبياد نظام CIS (Competition Information System) الخاص بـ WorldSkills International لضمان الشفافية والدقة في التنقيط الآني.',
                'body_fr' => 'Les Olympiades utilisent le système CIS (Competition Information System) de WorldSkills International pour garantir transparence et précision.',
                'body_en' => 'The Olympiad uses the CIS (Competition Information System) by WorldSkills International to ensure transparency and accuracy in real-time scoring.',
            ],
            [
                'section_key' => 'jury',
                'sort_order' => 7,
                'is_active' => true,
                'icon_svg' => 'M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3',
                'title_ar' => 'نظام التحكيم والنزاهة',
                'title_fr' => 'Système d\'Arbitrage & Intégrité',
                'title_en' => 'Arbitration & Integrity System',
                'body_ar' => 'يقوم نظام التحكيم على مبادئ الحياد والاستقلالية والكفاءة وفق قواعد WorldSkills Technical Regulations.',
                'body_fr' => 'Le système d\'arbitrage repose sur les principes de neutralité, d\'indépendance et de compétence.',
                'body_en' => 'The arbitration system is built on principles of neutrality, independence and competence.',
            ],
            [
                'section_key' => 'appeals',
                'sort_order' => 8,
                'is_active' => true,
                'icon_svg' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
                'title_ar' => 'الطعون والتظلمات الفنية',
                'title_fr' => 'Appels & Réclamations Techniques',
                'title_en' => 'Technical Appeals & Complaints',
                'body_ar' => 'تخضع التظلمات لنظام حوكمة فني صارم (Technical Appeals Governance) يضمن المراجعة المحايدة عبر هيئة الحكام الرئيسية.',
                'body_fr' => 'Les réclamations sont soumises à un système strict de gouvernance technique (Technical Appeals Governance).',
                'body_en' => 'Complaints are subject to a strict Technical Appeals Governance system ensuring impartial review.',
            ],
            [
                'section_key' => 'accreditation',
                'sort_order' => 9,
                'is_active' => true,
                'icon_svg' => 'M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2',
                'title_ar' => 'الاعتماد والدخول الميداني',
                'title_fr' => 'Accréditation & Accès au Terrain',
                'title_en' => 'Accreditation & Field Access',
                'body_ar' => 'يُمنح الاعتماد الميداني وفق مستويات وصلاحيات محددة تضمن الأمن والسيطرة الكاملة على منطقة المنافسة.',
                'body_fr' => 'L\'accréditation de terrain est accordée selon des niveaux et des autorisations définis.',
                'body_en' => 'Field accreditation is granted according to defined levels and permissions.',
            ],
            [
                'section_key' => 'catering',
                'sort_order' => 10,
                'is_active' => true,
                'icon_svg' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
                'title_ar' => 'الإطعام والخدمات اللوجستية',
                'title_fr' => 'Restauration & Logistique',
                'title_en' => 'Catering & Logistics',
                'body_ar' => 'توفر اللجنة المنظمة خدمات الإطعام والإقامة والنقل لجميع الفئات المعتمدة وفق معايير الضيافة الدولية.',
                'body_fr' => 'Le comité organisateur fournit des services de restauration, d\'hébergement et de transport à toutes les catégories accréditées.',
                'body_en' => 'The organizing committee provides catering, accommodation and transportation services to all accredited categories.',
            ],
            [
                'section_key' => 'safety',
                'sort_order' => 11,
                'is_active' => true,
                'icon_svg' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                'title_ar' => 'الأمن والسلامة والصحة (HSE)',
                'title_fr' => 'Sécurité, Santé & Environnement (HSE)',
                'title_en' => 'Health, Safety & Environment (HSE)',
                'body_ar' => 'تُعدّ معايير الصحة والسلامة والبيئة (Health, Safety & Environment) ركيزة أساسية لا تقبل المساومة في جميع تخصصات الأولمبياد.',
                'body_fr' => 'Les normes HSE (Health, Safety & Environment) constituent un pilier fondamental non négociable dans toutes les spécialités.',
                'body_en' => 'HSE (Health, Safety & Environment) standards are a fundamental non-negotiable pillar in all Olympiad skills.',
            ],
            [
                'section_key' => 'faq',
                'sort_order' => 12,
                'is_active' => true,
                'icon_svg' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                'title_ar' => 'الأسئلة الشائعة',
                'title_fr' => 'Foire Aux Questions',
                'title_en' => 'Frequently Asked Questions',
                'body_ar' => 'إجابات رسمية على أكثر الأسئلة استفساراً حول التسجيل، شروط المشاركة، وآليات التنقيط.',
                'body_fr' => 'Réponses officielles aux questions les plus fréquentes sur l\'inscription, les conditions et la notation.',
                'body_en' => 'Official answers to the most frequently asked questions regarding registration, eligibility, and scoring.',
            ],
        ];

        foreach ($sections as $sec) {
            GuideSection::updateOrCreate(
                ['section_key' => $sec['section_key']],
                $sec
            );
        }
    }
}
