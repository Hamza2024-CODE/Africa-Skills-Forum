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
    public string $countdownSubtitleAr;
    public string $countdownSubtitleFr;
    public string $countdownSubtitleEn;
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
        $this->countdownTitleAr     = $settings->get('countdown_title_ar', 'الحدث القادم - العد التنازلي لافتتاح منتدى المهارات الإفريقية 2026');
        $this->countdownTitleFr     = $settings->get('countdown_title_fr', 'Événement à venir — Décompte du Lancement d\'Africa Skills Forum 2026');
        $this->countdownTitleEn     = $settings->get('countdown_title_en', 'Upcoming Event — Countdown to Africa Skills Forum 2026');

        $this->countdownSubtitleAr  = $settings->get('countdown_subtitle_ar', 'Africa Skills Forum 2026 — مركز المؤتمرات محمد بن أحمد - وهران');
        $this->countdownSubtitleFr  = $settings->get('countdown_subtitle_fr', 'Africa Skills Forum 2026 — Centre des Conventions Mohamed Ben Ahmed - Oran');
        $this->countdownSubtitleEn  = $settings->get('countdown_subtitle_en', 'Africa Skills Forum 2026 — Mohamed Ben Ahmed Convention Center - Oran');

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

        // Load Dynamic Database Forum Settings with Multi-Lingual Fallback
        $locale = app()->getLocale();
        $this->forumData = [
            'name'             => $settings->get("forum.name_{$locale}") ?: $settings->get('forum.name_ar'),
            'slogan'           => $settings->get("forum.slogan_{$locale}") ?: $settings->get('forum.slogan_ar'),
            'dates'            => $settings->get("forum.dates_{$locale}") ?: $settings->get('forum.dates_ar'),
            'principle'        => $settings->get("forum.principle_{$locale}") ?: $settings->get('forum.principle_ar'),
            'description'      => $settings->get("forum.description_{$locale}") ?: $settings->get('forum.description_ar'),
            'stat_countries'   => $settings->get('forum.stat_countries', '+30'),
            'stat_ministers'   => $settings->get('forum.stat_ministers', '+20'),
            'stat_roundtables' => $settings->get('forum.stat_roundtables', '2'),
            'stat_panels'      => $settings->get('forum.stat_panels', '5+'),
        ];

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

        $partners = Partner::where('status', 'ACTIVE')->where('is_featured', true)->orderBy('sort_order')->orderBy('name_ar')->get();

        $heroSlide1 = platform()->get('hero_slide_1', '/image.png');
        $heroSlides = collect([!empty($heroSlide1) ? $heroSlide1 : '/image.png'])
            ->filter(function($s) { return !empty($s); })
            ->values()
            ->all();
        $heroSlidesJson = json_encode(array_map('url', $heroSlides));
        $heroMode = platform()->get('hero_bg_mode', 'image');

        return view('livewire.public.home', [
            'skills'         => $skills,
            'news'           => $news,
            'albums'         => $albums,
            'videos'         => $videos,
            'partners'       => $partners,
            'heroSlidesJson' => $heroSlidesJson,
            'heroMode'       => $heroMode,
        ]);
    }
}
