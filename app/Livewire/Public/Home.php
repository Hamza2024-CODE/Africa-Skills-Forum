<?php

namespace App\Livewire\Public;

use App\Models\Album;
use App\Models\Event;
use App\Models\NewsArticle;
use App\Models\Partner;
use App\Models\Skill;
use App\Models\Video;
use App\Services\DateEngine;
use App\Services\HomepageStatisticsService;
use App\Services\SettingsEngine;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.public')]
class Home extends Component
{
    public $activeEvent;
    public $eventCountdown = [];
    public $featuredVideoUrl;
    public $stats = [];

    // Dynamic 3D Countdown Controls V8.4 from Admin Settings
    public string $countdownTitleAr;
    public string $countdownTitleFr;
    public string $countdownTitleEn;
    public string $countdownTitlePt;
    public string $countdownSubtitleAr;
    public string $countdownSubtitleFr;
    public string $countdownSubtitleEn;
    public string $countdownSubtitlePt;
    public string $countdownTargetDate;
    public string $countdownTimezone;
    public string $countdownStatus;
    public string $countdownTheme;
    public string $countdownDigitStyle;
    public string $countdownColorSec;
    public string $countdownColorMin;
    public string $countdownColorHrs;
    public string $countdownColorDays;
    public bool   $countdownShowIcons;
    public bool   $countdownFlipAnimation;
    public bool   $countdownEnabled;

    // Dynamic Africa Skills Policy Forum Database Settings
    public array  $forumData = [];

    public function mount(
        DateEngine $dateEngine, 
        SettingsEngine $settings, 
        HomepageStatisticsService $statsService
    ) {
        $this->activeEvent = Event::where('is_active', true)->where('status', 'PUBLISHED')->first() 
            ?? Event::where('status', 'PUBLISHED')->orderBy('start_at')->first();

        $this->featuredVideoUrl = $settings->get('featured_video_url', 'https://www.youtube.com/embed/ee7fzNFUKIM');

        // Retrieve Admin Settings for Countdown Chronometer V8.4
        $this->countdownTitleAr     = $settings->get('countdown_title_ar', 'العد التنازلي لافتتاح منتدى السياسات الأفريقية للمهارات 2026');
        $this->countdownTitleFr     = $settings->get('countdown_title_fr', 'Décompte du Lancement du Forum des Politiques Africaines des Compétences 2026');
        $this->countdownTitleEn     = $settings->get('countdown_title_en', 'Countdown to African Skills Policy Forum 2026');
        $this->countdownTitlePt     = $settings->get('countdown_title_pt', 'Contagem Decrescente para a Abertura do Fórum de Políticas Africanas de Competências 2026');

        // Normalize if old title is cached or saved without "Policy"
        if (str_contains($this->countdownTitleEn, 'Africa Skills Forum 2026') && !str_contains($this->countdownTitleEn, 'Policy')) {
            $this->countdownTitleEn = str_replace('Africa Skills Forum 2026', 'African Skills Policy Forum 2026', $this->countdownTitleEn);
        }
        if (str_contains($this->countdownTitleAr, 'منتدى المهارات الإفريقية') && !str_contains($this->countdownTitleAr, 'السياسات')) {
            $this->countdownTitleAr = str_replace('منتدى المهارات الإفريقية', 'منتدى السياسات الأفريقية للمهارات', $this->countdownTitleAr);
        }

        $this->countdownSubtitleAr  = $settings->get('countdown_subtitle_ar', 'منتدى السياسات الأفريقية للمهارات 2026 — مركز المؤتمرات محمد بن أحمد - وهران');
        $this->countdownSubtitleFr  = $settings->get('countdown_subtitle_fr', 'Forum des Politiques Africaines des Compétences 2026 — Centre des Conventions Mohamed Ben Ahmed - Oran');
        $this->countdownSubtitleEn  = $settings->get('countdown_subtitle_en', 'African Skills Policy Forum 2026 — Mohamed Ben Ahmed Convention Center - Oran');
        $this->countdownSubtitlePt  = $settings->get('countdown_subtitle_pt', 'Fórum de Políticas Africanas de Competências 2026 — Centro de Convenções Mohamed Ben Ahmed - Orão');

        $this->countdownTargetDate  = $settings->get('countdown_target_date', '2026-11-16 09:00:00');
        $this->countdownTimezone     = $settings->get('countdown_timezone', 'Africa/Algiers');
        $this->countdownStatus       = $settings->get('countdown_status', 'COUNTDOWN');
        $this->countdownTheme        = $settings->get('countdown_theme', 'vintage_spiral_notebook');
        $this->countdownDigitStyle  = $settings->get('countdown_digit_style', 'classic_mono');

        $this->countdownColorSec    = $settings->get('countdown_color_sec', '#0284C7');
        $this->countdownColorMin    = $settings->get('countdown_color_min', '#059669');
        $this->countdownColorHrs    = $settings->get('countdown_color_hrs', '#D97706');
        $this->countdownColorDays   = $settings->get('countdown_color_days', '#7C3AED');

        $this->countdownShowIcons   = (bool) $settings->get('countdown_show_icons', true);
        $this->countdownFlipAnimation = (bool) $settings->get('countdown_flip_animation', true);
        $this->countdownEnabled      = (bool) $settings->get('countdown_enabled', true);

        // Calculate initial fallback difference
        $targetCarbon = \Carbon\Carbon::parse($this->countdownTargetDate);
        $diff = now()->diff($targetCarbon);

        $this->eventCountdown = [
            'days'     => str_pad($diff->days, 2, '0', STR_PAD_LEFT),
            'hours'    => str_pad($diff->h, 2, '0', STR_PAD_LEFT),
            'minutes'  => str_pad($diff->i, 2, '0', STR_PAD_LEFT),
            'seconds'  => str_pad($diff->s, 2, '0', STR_PAD_LEFT),
            'target_timestamp' => $targetCarbon->timestamp * 1000,
        ];

        $this->stats = $statsService->getStatistics();
    }

    public function render()
    {
        $locale = app()->getLocale();
        
        $cachedData = \Illuminate\Support\Facades\Cache::remember('asf_homepage_payload_' . $locale, 120, function () use ($locale) {
            $skills = Skill::where('is_active', true)->limit(6)->get();
            if ($skills->isEmpty()) {
                $skills = Skill::limit(6)->get();
            }

            $news = NewsArticle::where('status', 'PUBLISHED')->orderBy('published_at', 'desc')->limit(3)->get();
            if ($news->isEmpty()) {
                $news = NewsArticle::orderBy('created_at', 'desc')->limit(3)->get();
            }

            $albums = Album::with(['coverMedia', 'mediaItems'])->where('status', 'PUBLISHED')->orderBy('published_at', 'desc')->limit(3)->get();
            if ($albums->isEmpty()) {
                $albums = Album::with(['coverMedia', 'mediaItems'])->orderBy('created_at', 'desc')->limit(3)->get();
            }

            $videos = Video::where('status', 'PUBLISHED')->orderBy('published_at', 'desc')->limit(3)->get();
            if ($videos->isEmpty()) {
                $videos = Video::orderBy('created_at', 'desc')->limit(3)->get();
            }

            $featuredVideo = $videos->first();
            $featuredVideoThumbUrl = null;
            if ($featuredVideo) {
                if ($featuredVideo->thumbnail_path) {
                    $featuredVideoThumbUrl = $featuredVideo->thumbnail_path;
                } elseif ($featuredVideo->youtube_id) {
                    $featuredVideoThumbUrl = 'https://img.youtube.com/vi/' . $featuredVideo->youtube_id . '/mqdefault.jpg';
                }
            }

            $partners = Partner::where('status', 'ACTIVE')->where('is_featured', true)->orderBy('sort_order')->orderBy('name_ar')->get();

            $settings = app(SettingsEngine::class);

            // Dynamic Hero Slides managed from Admin Panel (/panel/cms/homepage)
            $defaultSlides = [
                1 => '/images/hero_slide_1.png',
                2 => '/images/hero_slide_2.png',
                3 => '/images/hero_slide_3.png',
                4 => '/images/blue_bg.jpg',
                5 => '/image.png',
            ];
            $heroSlides = [];
            for ($i = 1; $i <= 5; $i++) {
                $slideUrl = $settings->get("hero_slide_{$i}");
                if (!empty($slideUrl)) {
                    $heroSlides[] = $slideUrl;
                } elseif (!empty($defaultSlides[$i])) {
                    $heroSlides[] = $defaultSlides[$i];
                }
            }
            $heroSlides = array_values(array_unique(array_filter($heroSlides)));
            if (empty($heroSlides)) {
                $heroSlides = ['/images/hero_slide_1.png', '/images/hero_slide_2.png', '/images/hero_slide_3.png'];
            }

            $heroSlidesJson = json_encode($heroSlides);
            $heroMode = platform()->get("hero_bg_mode", "slider");


            $forumData = [
                'name'             => $settings->get("forum.name_{$locale}", polyTrans("منتدى السياسات الأفريقية للمهارات 2026", "Forum des Politiques Africaines des Compétences 2026", "African Skills Policy Forum 2026", "Fórum de Políticas Africanas de Competências 2026")),
                'slogan'           => $settings->get("forum.slogan_{$locale}", polyTrans("صياغة مستقبل المهارات، تمكين الشباب الأفريقي", "Façonner l'avenir des compétences, autonomiser la jeunesse africaine", "Shaping the Future of Skills, Empowering Africa's Youth", "Moldar o Futuro das Competências, Capacitar a Juventude Africana")),
                'dates'            => $settings->get("forum.dates_{$locale}", polyTrans("16 - 18 نوفمبر 2026", "16 - 18 Novembre 2026", "16 - 18 November 2026", "16 - 18 de Novembro de 2026")),
                'principle'        => $settings->get("forum.principle_{$locale}", polyTrans("صياغة مستقبل المهارات، تمكين الشباب الأفريقي", "Façonner l'avenir des compétences, autonomiser la jeunesse africaine", "Shaping the Future of Skills, Empowering Africa's Youth", "Moldar o Futuro das Competências, Capacitar a Juventude Africana")),
                'description'      => $settings->get("forum.description_{$locale}", polyTrans(
                    "يُنظَّم منتدى السياسات الأفريقية للمهارات بشراكة بين وزارة التكوين والتعليم المهنيين بالجزائر ومفوضية الاتحاد الأفريقي، ليكون الحدث السياسي الرفيع المستوى الرئيسي. يجمع المنتدى الوزراء الأفارقة المكلفين بالتكوين والتعليم المهنيين، إلى جانب الخبراء التقنيين والشركاء المؤسساتيين والدوليين، في برنامج عمل يقوم على الحوار الوزاري والتعاون القاري والالتزام السياسي المشترك.",
                    "Le Forum des Politiques Africaines des Compétences est co-organisé par le Ministère de la Formation et de l'Enseignement Professionnels d'Algérie et la Commission de l'Union Africaine, constituant le principal événement politique de haut niveau.",
                    "The African Skills Policy Forum is co-organized by Algeria's Ministry of Vocational Training and Education and the African Union Commission, serving as the principal high-level political summit.",
                    "O Fórum de Políticas Africanas de Competências é coorganizado pelo Ministério da Formação e Ensino Profissionais da Argélia e pela Comissão da União Africana, constituindo a principal cimeira política de alto nível. O Fórum reúne os ministros africanos responsáveis pela formação e ensino técnico-profissionais (EFTP), peritos e parceiros internacionais num programa centrado no diálogo ministerial, cooperação continental e compromisso político conjunto."
                )),
                'stat_countries'   => $settings->get('forum.stat_countries', '+30'),
                'stat_ministers'   => $settings->get('forum.stat_ministers', '+20'),
                'stat_roundtables' => $settings->get('forum.stat_roundtables', '2'),
                'stat_panels'      => $settings->get('forum.stat_panels', '5+'),
            ];

            return [
                'skills'                 => $skills,
                'news'                   => $news,
                'albums'                 => $albums,
                'videos'                 => $videos,
                'featuredVideoThumbUrl'  => $featuredVideoThumbUrl,
                'partners'               => $partners,
                'heroSlidesJson'         => $heroSlidesJson,
                'heroMode'               => $heroMode,
                'forumData'              => $forumData,
            ];
        });

        return view('livewire.public.home', $cachedData);
    }
}
