<?php

namespace App\Services;

use App\Models\GlobalSetting;
use Illuminate\Support\Facades\Cache;

class SettingsEngine
{
    protected const CACHE_KEY = 'wsap_global_settings';
    protected const CACHE_TTL = 86400; // 24 hours

    public const DEFAULTS = [
        'appearance.primary_color' => '#0066FF',
        'appearance.primary_dark' => '#063B8F',
        'appearance.accent_color' => '#00B8FF',
        'appearance.background_color' => '#F4F7FC',
        'appearance.surface_color' => '#FFFFFF',
        'appearance.text_color' => '#0F172A',
        'appearance.muted_text_color' => '#64748B',

        'appearance.success_color' => '#16A34A',
        'appearance.warning_color' => '#F59E0B',
        'appearance.danger_color' => '#DC2626',
        'appearance.info_color' => '#0EA5E9',

        'appearance.radius_sm' => '0.375rem',
        'appearance.radius_md' => '0.75rem',
        'appearance.radius_lg' => '1rem',
        'appearance.radius_xl' => '1.5rem',

        'appearance.glassmorphism_enabled' => 'true',
        'appearance.animation_level' => 'full',

        'branding.site_name' => 'Africa Skills Forum',
        'branding.site_logo' => '/AFRICA.png',
        'branding.site_logo_dark' => '/AFRICA.png',
        'branding.favicon' => '/AFRICA.png',
        'branding.hero_banner' => '/banner.png',
        'branding.footer_logo' => '/AFRICA.png',
        'hero_slide_1' => '/image.png',
        'hero_slide_2' => '',
        'hero_slide_3' => '',
        'hero_slide_4' => '',
        'hero_slide_5' => '',

        // Maintenance / Coming Soon Mode Global Settings
        'maintenance_mode' => 'false',
        'coming_soon_title_ar' => 'انتظرونا قريباً — منتدى السياسات الأفريقية للمهارات 2026',
        'coming_soon_title_fr' => 'Bientôt disponible — Forum des Politiques Africaines des Compétences 2026',
        'coming_soon_title_en' => 'Coming Soon — Africa Skills Policy Forum 2026',
        'coming_soon_subtitle_ar' => 'المنصة الرسمية تحت التحديث والتجهيز حالياً استعداداً للانطلاق الرسمي بوهران.',
        'coming_soon_subtitle_fr' => 'La plateforme officielle est actuellement en cours de préparation pour le lancement à Oran.',
        'coming_soon_subtitle_en' => 'The official platform is currently being prepared for launch in Oran.',

        // Africa Skills Policy Forum 2026 Global Database Settings
        'forum.name_ar' => 'منتدى السياسات الأفريقية للمهارات 2026',
        'forum.name_fr' => 'Forum des Politiques Africaines des Compétences 2026',
        'forum.name_en' => 'Africa Skills Policy Forum 2026',

        'forum.slogan_ar' => 'صياغة مستقبل المهارات، تمكين الشباب الأفريقي',
        'forum.slogan_fr' => 'Façonner l\'avenir des compétences, autonomiser la jeunesse africaine',
        'forum.slogan_en' => 'Shaping the Future of Skills, Empowering Africa\'s Youth',

        'forum.dates_ar' => '16 - 18 نوفمبر 2026',
        'forum.dates_fr' => '16 - 18 Novembre 2026',
        'forum.dates_en' => '16 - 18 November 2026',

        'forum.principle_ar' => 'مستقبل المهارات في إفريقيا يجب أن يُصاغ من قِبل الأفارقة أنفسهم.',
        'forum.principle_fr' => 'L\'avenir des compétences en Afrique doit être façonné par les Africains eux-mêmes.',
        'forum.principle_en' => 'Africa\'s skills future must be shaped by Africans.',

        'forum.description_ar' => 'يُنظَّم منتدى السياسات الأفريقية للمهارات بشراكة بين وزارة التكوين والتعليم المهنيين بالجزائر ومفوضية الاتحاد الأفريقي، ليكون الحدث السياسي الرفيع المستوى الرئيسي. يجمع المنتدى الوزراء الأفارقة المكلفين بالتكوين والتعليم المهنيين، إلى جانب الخبراء التقنيين والشركاء المؤسساتيين والدوليين، في برنامج عمل يقوم على الحوار الوزاري والتعاون القاري والالتزام السياسي المشترك.',
        'forum.description_fr' => 'Le Forum des Politiques Africaines des Compétences est co-organisé par le Ministère de la Formation et de l\'Enseignement Professionnels d\'Algérie et la Commission de l\'Union Africaine, constituant le principal événement politique de haut niveau. Le Forum réunit les ministres africains chargés de l\'EFTP, des experts techniques et des partenaires institutionnels internationaux pour un programme d\'action fondé sur le dialogue ministériel, la coopération continentale et l\'engagement politique conjoint.',
        'forum.description_en' => 'The African Skills Policy Forum is co-organized by Algeria\'s Ministry of Vocational Training and Education and the African Union Commission, serving as the principal high-level political summit. The Forum brings together African Ministers responsible for technical and vocational education and training, together with technical experts and institutional and international partners, for a working programme of ministerial dialogue, continental cooperation, and shared political commitment.',

        'forum.stat_countries' => '+30',
        'forum.stat_ministers' => '+20',
        'forum.stat_roundtables' => '2',
        'forum.stat_panels' => '5+',
    ];

    public function get(string $key, mixed $default = null): mixed
    {
        $settings = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
            return GlobalSetting::all()->pluck('value', 'key')->toArray();
        });

        if (!array_key_exists($key, $settings)) {
            return $default ?? (self::DEFAULTS[$key] ?? null);
        }

        return $settings[$key];
    }

    public function set(string $key, mixed $value, string $type = 'string', string $group = 'general', ?string $description = null): void
    {
        $oldValue = $this->get($key);

        GlobalSetting::updateOrCreate(
            ['key' => $key],
            [
                'value' => is_array($value) ? json_encode($value) : (string) $value,
                'type' => $type,
                'group' => $group,
                'description' => $description,
            ]
        );

        $this->flushCache();

        if (class_exists(AuditService::class) && (string)$oldValue !== (string)$value) {
            AuditService::log('SETTING_UPDATED', null, [
                'key' => $key,
                'group' => $group,
                'old_value' => $oldValue,
                'new_value' => $value,
            ]);
        }
    }

    public function getBool(string $key, bool $default = false): bool
    {
        $val = $this->get($key, $default);
        return filter_var($val, FILTER_VALIDATE_BOOLEAN);
    }

    public function getInt(string $key, int $default = 0): int
    {
        return (int) $this->get($key, $default);
    }

    public function resetToDefaults(): void
    {
        foreach (self::DEFAULTS as $key => $defaultValue) {
            GlobalSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $defaultValue, 'group' => 'appearance']
            );
        }

        $this->flushCache();

        if (class_exists(AuditService::class)) {
            AuditService::log('APPEARANCE_RESET', null, [
                'action' => 'appearance.reset',
                'module' => 'appearance',
                'message' => 'Appearance tokens restored to factory defaults.',
            ]);
        }
    }

    /**
     * Generate safe, sanitized CSS Custom Properties (:root) for Design Tokens
     */
    public function getDesignTokensCss(): string
    {
        $primary = $this->sanitizeHex($this->get('appearance.primary_color', '#0066FF'));
        $primaryDark = $this->sanitizeHex($this->get('appearance.primary_dark', '#063B8F'));
        $accent = $this->sanitizeHex($this->get('appearance.accent_color', '#00B8FF'));
        $bg = $this->sanitizeHex($this->get('appearance.background_color', '#F4F7FC'));
        $surface = $this->sanitizeHex($this->get('appearance.surface_color', '#FFFFFF'));
        $text = $this->sanitizeHex($this->get('appearance.text_color', '#0F172A'));
        $mutedText = $this->sanitizeHex($this->get('appearance.muted_text_color', '#64748B'));

        $success = $this->sanitizeHex($this->get('appearance.success_color', '#16A34A'));
        $warning = $this->sanitizeHex($this->get('appearance.warning_color', '#F59E0B'));
        $danger = $this->sanitizeHex($this->get('appearance.danger_color', '#DC2626'));
        $info = $this->sanitizeHex($this->get('appearance.info_color', '#0EA5E9'));

        $radiusSm = $this->sanitizeRadius($this->get('appearance.radius_sm', '0.375rem'));
        $radiusMd = $this->sanitizeRadius($this->get('appearance.radius_md', '0.75rem'));
        $radiusLg = $this->sanitizeRadius($this->get('appearance.radius_lg', '1rem'));
        $radiusXl = $this->sanitizeRadius($this->get('appearance.radius_xl', '1.5rem'));

        return "<style id=\"wsap-design-tokens\">
:root {
    --color-brand-primary: {$primary};
    --color-brand-primary-dark: {$primaryDark};
    --color-brand-accent: {$accent};

    --color-background: {$bg};
    --color-surface: {$surface};
    --color-text: {$text};
    --color-muted-text: {$mutedText};

    --color-success: {$success};
    --color-warning: {$warning};
    --color-danger: {$danger};
    --color-info: {$info};

    --radius-sm: {$radiusSm};
    --radius-md: {$radiusMd};
    --radius-lg: {$radiusLg};
    --radius-xl: {$radiusXl};
}
</style>";
    }

    private function sanitizeHex(mixed $val): string
    {
        $val = trim((string) $val);
        if (preg_match('/^#[0-9A-Fa-f]{3,8}$/', $val)) {
            return $val;
        }
        return '#0066FF';
    }

    private function sanitizeRadius(mixed $val): string
    {
        $allowed = ['0', '0.25rem', '0.375rem', '0.5rem', '0.75rem', '1rem', '1.5rem', '2rem', '9999px'];
        $val = trim((string) $val);
        if (in_array($val, $allowed, true)) {
            return $val;
        }
        return '1rem';
    }

    public function flushCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
