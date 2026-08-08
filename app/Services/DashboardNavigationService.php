<?php

namespace App\Services;

use App\Enums\RoleEnum;
use App\Models\User;

class DashboardNavigationService
{
    public function getNavigation(?User $user = null): array
    {
        // Default fallback to SUPER_ADMIN if user is guest in admin area
        if (!$user || $user->hasRole(RoleEnum::SUPER_ADMIN->value)) {
            return [
                // WORKSPACE (indices 0-8)
                ['key' => 'dashboard',     'label' => $this->t('مركز القيادة',          'Commandement',        'Command Center'),    'icon' => 'home',           'route' => 'admin.dashboard'],
                ['key' => 'venue_map',     'label' => $this->t('التوأم الرقمي 3D وغرفة العمليات', 'Digital Twin 3D', '3D Digital Twin Command Center'), 'icon' => 'globe-alt', 'route' => 'admin.venue-map'],
                ['key' => 'users',         'label' => $this->t('المستخدمون والحسابات',  'Utilisateurs',        'Users & Roles'),     'icon' => 'users',          'route' => 'admin.users'],
                ['key' => 'participants',  'label' => $this->t('المشاركون والمتنافسون', 'Participants',        'Participants'),      'icon' => 'clipboard-list', 'route' => 'admin.participants'],
                ['key' => 'registrations', 'label' => $this->t('إدارة التسجيلات',       'Inscriptions',        'Registrations'),     'icon' => 'document-check', 'route' => 'admin.registrations'],
                ['key' => 'organizations', 'label' => $this->t('المؤسسات والمنظمات',   'Établissements',      'Organizations'),     'icon' => 'building-office', 'route' => 'admin.organizations'],
                ['key' => 'countries',     'label' => $this->t('الوفود والدول',          'Délégations',         'Delegations'),       'icon' => 'globe-alt',      'route' => 'admin.countries'],
                ['key' => 'delegation_invitations', 'label' => $this->t('دعوات الوفود الإفريقية الرسمية', 'Invitations des Délégations', 'Delegation Invitations & Credentials'), 'icon' => 'document-check', 'route' => 'admin.delegation.invitations'],
                ['key' => 'skills',        'label' => $this->t('التخصصات الأولمبية',   'Compétences',         'Olympic Skills'),    'icon' => 'trophy',         'route' => 'admin.skills'],
                ['key' => 'partners',      'label' => $this->t('الرعاة والشركاء',       'Partenaires',         'Sponsors & Partners'),'icon' => 'sparkles',      'route' => 'admin.partners'],
                ['key' => 'editions',      'label' => $this->t('الدورات والطبعات',      'Éditions',            'Editions'),          'icon' => 'calendar',       'route' => 'admin.editions'],
                ['key' => 'schedule',      'label' => $this->t('محرك الجدولة والعمليات', 'Master Schedule',     'Master Schedule Engine'), 'icon' => 'clock',   'route' => 'admin.schedule.index'],
                ['key' => 'operations',    'label' => $this->t('العمليات المباشرة',     'Opérations Directes', 'Field Operations'),      'icon' => 'bolt',    'route' => 'admin.operations'],

                // MANAGEMENT (indices 9-16)
                ['key' => 'wilayas',       'label' => $this->t('الولايات الجغرافية',    'Wilayas',             'Wilayas'),           'icon' => 'map-pin',           'route' => 'admin.wilayas'],
                ['key' => 'judges',        'label' => $this->t('المحكمون والتحكيم',     'Jury & Arbitrage',    'Judges & Jury'),     'icon' => 'scale',             'route' => 'admin.judges'],
                ['key' => 'logistics',     'label' => $this->t('مركز اللوجستيات',       'Logistique',          'Logistics Center'),  'icon' => 'archive-box',       'route' => 'admin.logistics'],
                ['key' => 'logistics_arrivals', 'label' => $this->t('وصول الوفود وتذاكر الطيران', 'Arrivées & Billets d\'Avion', 'Delegation Arrivals & Flight Tickets'), 'icon' => 'truck', 'route' => 'admin.logistics.arrivals'],
                ['key' => 'equipment',     'label' => $this->t('المعدات والتجهيزات',   'Équipements',         'Equipment'),         'icon' => 'wrench-screwdriver','route' => 'admin.equipment'],
                ['key' => 'accommodations','label' => $this->t('السكن والإقامة',       'Hébergements',        'Accommodations'),    'icon' => 'building-office',   'route' => 'admin.accommodations'],
                ['key' => 'transport',     'label' => $this->t('النقل والمواصلات',     'Transports',          'Transports'),        'icon' => 'truck',             'route' => 'admin.transport'],
                ['key' => 'restaurants',   'label' => $this->t('المطاعم والوجبات',     'Restauration',        'Catering & Meals'),  'icon' => 'cake',              'route' => 'admin.restaurants'],
                ['key' => 'meal_scanner',  'label' => $this->t('ماسح شارة المطعم',    'Scanner Repas',       'Meal Scanner'),      'icon' => 'qr-code',           'route' => 'admin.meal.scanner'],
                ['key' => 'dietary',       'label' => $this->t('حساسيات الطعام والأنظمة', 'Allergies Alimentaires', 'Dietary & Food Allergies'), 'icon' => 'heart', 'route' => 'admin.dietary'],
                ['key' => 'notifications', 'label' => $this->t('مركز التواصل والتنبيهات', 'Communication', 'Communication Center'), 'icon' => 'bell', 'route' => 'admin.notifications.index'],

                // ADMINISTRATION (indices 15+)
                ['key' => 'cms_homepage',  'label' => $this->t('إدارة الواجهة والبانر الرئيسي (CMS)', 'CMS Page d\'Accueil', 'CMS Homepage Manager'), 'icon' => 'home', 'route' => 'admin.cms.homepage'],
                ['key' => 'cms_news',      'label' => $this->t('الأخبار والمقالات',     'Actualités',          'News Articles'),     'icon' => 'newspaper',      'route' => 'admin.cms.news'],
                ['key' => 'cms_gallery',   'label' => $this->t('معرض الصور',          'Galerie Photos',      'Photo Gallery'),     'icon' => 'photo',          'route' => 'admin.cms.gallery'],
                ['key' => 'cms_videos',    'label' => $this->t('مكتبة الفيديو',        'Vidéothèque',         'Video Library'),     'icon' => 'video-camera',   'route' => 'admin.cms.videos'],
                ['key' => 'reports',       'label' => $this->t('التقارير والإحصائيات', 'Rapports',            'Reports'),           'icon' => 'chart-bar',      'route' => 'admin.reports'],
                ['key' => 'appearance',    'label' => $this->t('استوديو المظهر',         'Apparence',           'Appearance'),        'icon' => 'paint-brush',    'route' => 'admin.appearance'],
                ['key' => 'legal',         'label' => $this->t('الشروط القانونية',       'Mentions Légales',    'Legal'),             'icon' => 'document-text',  'route' => 'admin.cms.legal'],
                ['key' => 'guide_reg',     'label' => $this->t('إدارة دليل اللوائح والشروط', 'Guide & Règlements CMS', 'Guide & Regulations CMS'), 'icon' => 'book-open', 'route' => 'admin.cms.guide'],
                ['key' => 'security',      'label' => $this->t('الأمان والرقابة',        'Sécurité & Audit',    'Security & Audit'),  'icon' => 'shield-check',   'route' => 'admin.audit'],

                // COMPETITION GOVERNANCE LAYER (indices 22+)
                ['key' => 'cis',           'label' => $this->t('نظام التقييم الميداني (CIS)', 'CIS Évaluation',      'CIS Evaluation'),    'icon' => 'chart-bar',      'route' => 'admin.cis'],
                ['key' => 'certificates',  'label' => $this->t('الشهادات والتوثيق QR',   'Certificats QR',      'QR Certificates'),   'icon' => 'document-check', 'route' => 'admin.certificates'],
                ['key' => 'accreditations','label' => $this->t('بطاقات الاعتماد والمناطق','Accréditations',      'Accreditations'),    'icon' => 'identification', 'route' => 'admin.accreditations'],
                ['key' => 'scanner',       'label' => $this->t('ماسح الـ QR الأمني المباشر','Scanner QR Sécurisé', 'Security QR Scanner'), 'icon' => 'camera',         'route' => 'admin.scanner'],
                ['key' => 'appeals',       'label' => $this->t('الطعون الفنية',           'Appels Techniques',   'Technical Appeals'), 'icon' => 'scale',          'route' => 'admin.appeals'],
                ['key' => 'integrity',     'label' => $this->t('مركز النزاهة والحوكمة',   'Intégrité & Audit',   'Integrity Center'),  'icon' => 'shield-check',   'route' => 'admin.integrity'],
                ['key' => 'diplomatic',    'label' => $this->t('القيادة الدبلوماسية والتبادل الوزاري', 'Commandement Diplomatique', 'Diplomatic Command Center'), 'icon' => 'building-office', 'route' => 'admin.diplomatic'],
            ];
        }

        if ($user->hasRole(RoleEnum::MEDIA_MANAGER->value)) {
            return [
                ['key' => 'media_dash', 'label' => $this->t('مركز الصحافة والإعلام', 'Centre Presse & Média', 'Press & Media Center'), 'icon' => 'video-camera', 'route' => 'admin.media.dashboard'],
                ['key' => 'news',       'label' => $this->t('الأخبار والتغطيات الصحفية', 'Actualités & Presse', 'News & Press Releases'), 'icon' => 'newspaper', 'route' => 'admin.cms.news'],
                ['key' => 'gallery',    'label' => $this->t('معرض الصور والتغطية الميدانية', 'Galerie Photos', 'Photo Gallery'), 'icon' => 'photo', 'route' => 'admin.cms.gallery'],
                ['key' => 'videos',     'label' => $this->t('مكتبة التغطية الفيديو', 'Vidéothèque Presse', 'Video Coverage'), 'icon' => 'video-camera', 'route' => 'admin.cms.videos'],
                ['key' => 'appearance', 'label' => $this->t('الهوية البصرية والهيدر', 'Identité Visuelle', 'Visual Identity'), 'icon' => 'paint-brush', 'route' => 'admin.appearance'],
            ];
        }

        if ($user->hasRole(RoleEnum::EXECUTIVE_VIEWER->value)) {
            return [
                ['key' => 'exec_dash',   'label' => $this->t('اللوحة الوزارية المصغرة', 'Aperçu Ministériel', 'Ministerial Overview'), 'icon' => 'chart-bar', 'route' => 'executive.dashboard'],
                ['key' => 'profile',     'label' => $this->t('الملف الشخصي والوزاري',   'Mon Profil',        'My Profile'),            'icon' => 'user',      'route' => 'profile'],
                ['key' => 'dietary',     'label' => $this->t('الملف الغذائي والحساسيات',  'Régime Alimentaire', 'Dietary & Allergies'),   'icon' => 'sparkles',  'route' => 'executive.dietary'],
                ['key' => 'diplomatic',  'label' => $this->t('حجز قاعات المباحثات',     'Réservation Salons', 'Lounge Booking'),       'icon' => 'building-office', 'route' => 'executive.diplomatic'],
            ];
        }

        if ($user->hasRole(RoleEnum::COUNTRY_ADMIN->value)) {
            return [
                ['key' => 'country_dash','label' => $this->t('مركز الوفد الوطني',   'Centre Délégation',  'Delegation Dashboard'), 'icon' => 'flag',         'route' => 'country.dashboard'],
                ['key' => 'delegation',  'label' => $this->t('كشف الوفد الموحد',     'Membres Délégation', 'Full Roster'),         'icon' => 'users',        'route' => 'country.delegation'],
                ['key' => 'participants','label' => $this->t('المتنافسون والمترشحون',  'Compétiteurs',       'Competitors'),          'icon' => 'user',         'route' => 'country.participants'],
                ['key' => 'judges',      'label' => $this->t('الحكام والخبراء',      'Juges & Experts',    'Judges & Experts'),     'icon' => 'scale',        'route' => 'country.judges'],
                ['key' => 'press',       'label' => $this->t('الصحافة والإعلام',     'Presse & Médias',    'Press & Media'),        'icon' => 'newspaper',    'route' => 'country.press'],
                ['key' => 'supervisors', 'label' => $this->t('المؤطرون وقادة الفرق', 'Encadrants',         'Supervisors'),          'icon' => 'academic-cap', 'route' => 'country.supervisors'],
                ['key' => 'vips',        'label' => $this->t('الوفود الرسمية و VIP',  'Délégations & VIP',  'VIPs & Officials'),     'icon' => 'sparkles',     'route' => 'country.vips'],
                ['key' => 'appeals',     'label' => $this->t('الطعون الفنية',         'Recours Techniques', 'Technical Appeals'),    'icon' => 'document-text','route' => 'country.appeals'],
                ['key' => 'dietary',     'label' => $this->t('حساسية الطعام والإطعام', 'Allergies & Restauration', 'Dietary & Food Allergies'), 'icon' => 'sparkles',     'route' => 'country.dietary'],
                ['key' => 'arrivals',    'label' => $this->t('تذاكر الطيران وتوقيت الوصول', 'Billets d\'Avion & Arrivée', 'Flight Tickets & Arrival'), 'icon' => 'truck', 'route' => 'country.arrivals'],
                ['key' => 'skills_sel',  'label' => $this->t('اختيار التخصصات',      'Sélection Métiers',  'Skill Selection'),     'icon' => 'check-circle', 'route' => 'country.skills'],
                ['key' => 'venue_map',   'label' => $this->t('خريطة القرية 3D',     'Carte du Village',   'Venue 3D Map'),         'icon' => 'map-pin',      'route' => 'country.venue-map'],
                ['key' => 'regulations', 'label' => $this->t('الشروط واللوائح',       'Règlements',         'Rules & Regulations'),  'icon' => 'shield-check', 'route' => 'country.regulations'],
            ];
        }

        if ($user->hasRole(RoleEnum::ORGANIZATION_ADMIN->value)) {
            return [
                ['key' => 'org_dash',   'label' => $this->t('مركز المؤسسة',       'Centre Institution', 'Institution Center'), 'icon' => 'building-office', 'route' => 'organization.dashboard'],
                ['key' => 'candidates', 'label' => $this->t('المترشحون',          'Candidats',          'Candidates'),         'icon' => 'users',           'route' => 'organization.dashboard'],
                ['key' => 'trainers',   'label' => $this->t('المدربون',            'Formateurs',         'Trainers'),           'icon' => 'academic-cap',    'route' => 'organization.dashboard'],
            ];
        }

        if ($user->hasRole(RoleEnum::JUDGE->value)) {
            return [
                ['key' => 'judge_dash', 'label' => $this->t('مركز التحكيم',  'Centre du Jury',  'Jury Center'),      'icon' => 'scale',         'route' => 'judge.dashboard'],
                ['key' => 'assigned',   'label' => $this->t('التخصصات المُسندة', 'Métiers Assignés', 'Assigned Skills'), 'icon' => 'clipboard-list','route' => 'judge.dashboard'],
            ];
        }

        if ($user->hasRole(RoleEnum::PARTICIPANT->value)) {
            return [
                ['key' => 'part_space', 'label' => $this->t('فضائي الشخصي',  'Mon Espace',          'My Space'),       'icon' => 'user',          'route' => 'participant.dashboard'],
                ['key' => 'my_map',      'label' => $this->t('خريطتي المكانية 3D', 'Ma Carte 3D',     'My 3D Map'),      'icon' => 'globe-alt',     'route' => 'my.venue-map'],
                ['key' => 'reg_journey','label' => $this->t('مسار التسجيل',  'Parcours Inscription', 'Registration'),   'icon' => 'clipboard-list','route' => 'participant.dashboard'],
            ];
        }

        if ($user->hasRole(RoleEnum::SPONSOR->value)) {
            return [
                ['key' => 'sponsor',    'label' => $this->t('فضاء الراعي',   'Espace Partenaire', 'Sponsor Space'),  'icon' => 'sparkles',      'route' => 'partners'],
            ];
        }

        return [];
    }

    private function t(string $ar, string $fr, string $en): string
    {
        return match(app()->getLocale()) {
            'fr'    => $fr,
            'en'    => $en,
            default => $ar,
        };
    }
}
