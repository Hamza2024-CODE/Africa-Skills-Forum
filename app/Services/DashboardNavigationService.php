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
                // SECTION 1: EXECUTIVE COMMAND & CONTROL CENTERS (مراكز التحكم والقيادة العامة)
                ['key' => 'cmd_overview',          'section' => 1, 'label' => $this->t('مركز القيادة العليا والتحكم', 'Centre de Commandement', 'Executive Command Center'), 'icon' => 'home', 'route' => 'admin.dashboard'],
                ['key' => 'registrations',         'section' => 1, 'label' => $this->t('إدارة طلبات التسجيل والاعتماد الموحدة', 'Gestion الموحدة des Inscriptions & Accréditations', 'Master Registrations & Accreditations Hub'), 'icon' => 'document-check', 'route' => 'admin.registrations'],
                ['key' => 'delegation_invitations','section' => 1, 'label' => $this->t('دعوات الوفود الإفريقية الرسمية', 'Invitations des Délégations', 'Delegation Invitations'), 'icon' => 'document-check', 'route' => 'admin.delegation.invitations'],
                ['key' => 'admin_arrivals',        'section' => 1, 'label' => $this->t('تذاكر الطيران ومواعيد الوصول ✈️', 'Billets de Vol & Arrivées ✈️', 'Flight Tickets & Arrivals Control ✈️'), 'icon' => 'truck', 'route' => 'admin.arrivals'],
                ['key' => 'editions',              'section' => 1, 'label' => $this->t('الدورة والفعالية الحالية', 'Édition Active', 'Active Forum Edition'), 'icon' => 'calendar', 'route' => 'admin.editions'],

                // SECTION 2: DELEGATIONS & INSTITUTES (إدارة الحسابات والوفود والمؤسسات)
                ['key' => 'users',                 'section' => 2, 'label' => $this->t('مركز إدارة الحسابات والأدوار', 'Gestion des Rôles & Accès', 'Users & Roles Command Center'), 'icon' => 'user', 'route' => 'admin.users'],
                ['key' => 'countries',             'section' => 2, 'label' => $this->t('الوفود الرسمية والدول', 'Délégations & Pays', 'Delegations & Nations'), 'icon' => 'globe-alt', 'route' => 'admin.countries'],
                ['key' => 'diplomatic',            'section' => 2, 'label' => $this->t('القيادة الدبلوماسية والتبادل الوزاري', 'Commandement Diplomatique', 'Diplomatic Command Center'), 'icon' => 'building-office', 'route' => 'admin.diplomatic'],
                ['key' => 'organizations',         'section' => 2, 'label' => $this->t('المؤسسات والمنظمات', 'Établissements', 'Organizations & Institutes'), 'icon' => 'building-office', 'route' => 'admin.organizations'],
                ['key' => 'wilayas',               'section' => 2, 'label' => $this->t('الولايات الجغرافية', 'Wilayas', 'Wilayas'), 'icon' => 'map-pin', 'route' => 'admin.wilayas'],

                // SECTION 3: MEDIA, CMS & COMMUNICATIONS (الإعلام والمحتوى والـ CMS)
                ['key' => 'cms_homepage',          'section' => 3, 'label' => $this->t('إدارة الواجهة والبانر الرئيسي (CMS)', 'CMS Page d\'Accueil', 'CMS Homepage Manager'), 'icon' => 'home', 'route' => 'admin.cms.homepage'],
                ['key' => 'live_tv',               'section' => 3, 'label' => $this->t('إعداد البث المباشر والشاشات (Live TV)', 'Live TV & Écrans', 'Live TV & Screen Stage'), 'icon' => 'video-camera', 'route' => 'admin.live-tv'],
                ['key' => 'cms_news',              'section' => 3, 'label' => $this->t('الأخبار والمقالات الصحفية', 'Actualités & Presse', 'News & Articles'), 'icon' => 'newspaper', 'route' => 'admin.cms.news'],
                ['key' => 'cms_gallery',           'section' => 3, 'label' => $this->t('معرض الصور والتغطية', 'Galerie Photos', 'Photo Gallery'), 'icon' => 'photo', 'route' => 'admin.cms.gallery'],
                ['key' => 'cms_videos',            'section' => 3, 'label' => $this->t('مكتبة الفيديو والتغطيات', 'Vidéothèque', 'Video Library'), 'icon' => 'video-camera', 'route' => 'admin.cms.videos'],
                ['key' => 'appearance',            'section' => 3, 'label' => $this->t('استوديو المظهر والهوية', 'Apparence & Thème', 'Visual Identity & Theme'), 'icon' => 'paint-brush', 'route' => 'admin.appearance'],
                ['key' => 'notifications',         'section' => 3, 'label' => $this->t('مركز التواصل والتنبيهات', 'Centre de Communication', 'Communication Center'), 'icon' => 'bell', 'route' => 'admin.notifications.index'],
                ['key' => 'guide_reg',             'section' => 3, 'label' => $this->t('إدارة دليل اللوائح والشروط', 'Guide & Règlements CMS', 'Guide & Regulations CMS'), 'icon' => 'document-text', 'route' => 'admin.cms.guide'],
                ['key' => 'reports',               'section' => 3, 'label' => $this->t('التقارير والإحصائيات', 'Rapports & Statistiques', 'Reports & Analytics'), 'icon' => 'chart-bar', 'route' => 'admin.reports'],

                // SECTION 4: ACCREDITATIONS, SECURITY & GOVERNANCE (الاعتمادات والأمان والحوكمة)
                ['key' => 'accreditations',        'section' => 4, 'label' => $this->t('بطاقات الاعتماد والمناطق الأمنية', 'Accréditations & Zones', 'Accreditations & Badges'), 'icon' => 'identification', 'route' => 'admin.accreditations'],
                ['key' => 'scanner',               'section' => 4, 'label' => $this->t('ماسح الـ QR الأمني المباشر', 'Scanner QR Sécurisé', 'Security QR Scanner'), 'icon' => 'camera', 'route' => 'admin.scanner'],
                ['key' => 'certificates',          'section' => 4, 'label' => $this->t('الشهادات والتوثيق QR', 'Certificats QR', 'QR Certificates'), 'icon' => 'document-check', 'route' => 'admin.certificates'],
                ['key' => 'skills',                'section' => 4, 'label' => $this->t('مجالات الفعالية والتخصصات', 'Compétences & Métiers', 'Skills & Disciplines'), 'icon' => 'trophy', 'route' => 'admin.skills'],
                ['key' => 'partners',              'section' => 4, 'label' => $this->t('الرعاة والشركاء', 'Partenaires & Sponsors', 'Sponsors & Partners'), 'icon' => 'sparkles', 'route' => 'admin.partners'],
                ['key' => 'legal',                 'section' => 4, 'label' => $this->t('الشروط القانونية', 'Mentions Légales', 'Legal & Policy'), 'icon' => 'document-text', 'route' => 'admin.cms.legal'],
                ['key' => 'security',              'section' => 4, 'label' => $this->t('الأمان وسجلات الرقابة الحية', 'Sécurité & Audit', 'Security & Audit Logs'), 'icon' => 'shield-check', 'route' => 'admin.audit'],
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
                ['key' => 'diplomatic',  'label' => $this->t('حجز قاعات المباحثات',     'Réservation Salons', 'Lounge Booking'),       'icon' => 'building-office', 'route' => 'executive.diplomatic'],
            ];
        }

        if ($user->hasRole(RoleEnum::COUNTRY_ADMIN->value)) {
            return [
                ['key' => 'country_dash','label' => $this->t('كشف الوفد الموحد والتحكم',   'Centre Délégation',  'Delegation Command Center'), 'icon' => 'flag',         'route' => 'country.dashboard'],
                ['key' => 'dietary',     'label' => $this->t('إدارة الإطعام والحساسية',    'Restauration',       'Dietary & Catering'),       'icon' => 'cake',         'route' => 'country.dietary'],
                ['key' => 'arrivals',    'label' => $this->t('وصول الوفد وتذاكر الطيران',   'Arrivées & Vols',    'Arrivals & Flight Tickets'), 'icon' => 'truck',        'route' => 'country.arrivals'],
            ];
        }

        if ($user->hasRole(RoleEnum::ORGANIZATION_ADMIN->value)) {
            return [
                ['key' => 'org_dash',   'label' => $this->t('مركز المؤسسة',       'Centre Institution', 'Institution Center'), 'icon' => 'building-office', 'route' => 'organization.dashboard'],
            ];
        }

        if ($user->hasRole(RoleEnum::JUDGE->value)) {
            return [
                ['key' => 'judge_dash', 'label' => $this->t('مركز الجلسات والورشات', 'Centre des Sessions', 'Sessions Center'), 'icon' => 'scale', 'route' => 'judge.dashboard'],
            ];
        }

        if ($user->hasRole(RoleEnum::PARTICIPANT->value)) {
            return [
                ['key' => 'part_space', 'label' => $this->t('فضائي الشخصي',  'Mon Espace',          'My Space'),       'icon' => 'user',          'route' => 'participant.dashboard'],
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
