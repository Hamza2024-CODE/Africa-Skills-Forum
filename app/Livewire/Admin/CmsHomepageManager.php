<?php

namespace App\Livewire\Admin;

use App\Services\SettingsEngine;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;

#[Layout('components.dashboard.app-shell')]
class CmsHomepageManager extends Component
{
    use WithFileUploads;
    public $hero_title_ar;
    public $hero_title_fr;
    public $hero_title_en;
    public $hero_subtitle_ar;
    public $hero_subtitle_fr;
    public $hero_subtitle_en;
    public $cta_text_ar;
    public $cta_text_fr;
    public $cta_text_en;

    // Hero Slider Images — Admin-controlled (stored in GlobalSettings)
    public $hero_slide_1_url;
    public $hero_slide_2_url;
    public $hero_slide_3_url;
    public $hero_slide_4_url;
    public $hero_slide_5_url;

    // File uploads for hero slides
    public $hero_slide_1_file;
    public $hero_slide_2_file;
    public $hero_slide_3_file;
    public $hero_slide_4_file;
    public $hero_slide_5_file;

    public $featured_video_url;
    public $featured_video_title_ar;
    public $featured_video_title_fr;
    public $featured_video_title_en;

    // 3D Dynamic Countdown Chronometer V8.4 Settings
    public $countdown_title_ar;
    public $countdown_title_fr;
    public $countdown_title_en;
    public $countdown_subtitle_ar;
    public $countdown_subtitle_fr;
    public $countdown_subtitle_en;
    public $countdown_target_date;
    public $countdown_timezone;
    public $countdown_status;
    public $countdown_theme;
    public $countdown_digit_style;
    public $countdown_color_sec;
    public $countdown_color_min;
    public $countdown_color_hrs;
    public $countdown_color_days;
    public $countdown_show_icons = true;
    public $countdown_flip_animation = true;
    public $countdown_enabled = true;
    public $show_partners_section = true;

    // Africa Skills Policy Forum 2026 Admin Settings
    public $forum_name_ar;
    public $forum_name_fr;
    public $forum_name_en;

    public $forum_slogan_ar;
    public $forum_slogan_fr;
    public $forum_slogan_en;

    public $forum_dates_ar;
    public $forum_dates_fr;
    public $forum_dates_en;

    public $forum_principle_ar;
    public $forum_principle_fr;
    public $forum_principle_en;

    public $forum_description_ar;
    public $forum_description_fr;
    public $forum_description_en;

    public $forum_stat_countries;
    public $forum_stat_ministers;
    public $forum_stat_roundtables;
    public $forum_stat_panels;

    public $activeTab = 'countdown';
    public $savedMessage = '';

    public function setTab(string $tab)
    {
        $this->activeTab = $tab;
    }

    public function mount(SettingsEngine $settings)
    {
        $this->hero_title_ar = $settings->get('home_hero_title_ar', 'أولمبياد المهن الإفريقي 2026');
        $this->hero_title_fr = $settings->get('home_hero_title_fr', 'Olympiades des Métiers Afrique 2026');
        $this->hero_title_en = $settings->get('home_hero_title_en', 'African Skills Competition 2026');

        $this->hero_subtitle_ar = $settings->get('home_hero_subtitle_ar', 'من 25 إلى 30 نوفمبر 2026 — الجزائر');
        $this->hero_subtitle_fr = $settings->get('home_hero_subtitle_fr', 'Du 25 au 30 Novembre 2026 — Alger');
        $this->hero_subtitle_en = $settings->get('home_hero_subtitle_en', '25 to 30 November 2026 — Algiers');

        $this->cta_text_ar = $settings->get('home_cta_text_ar', 'كن جزءاً من أكبر حدث للمهارات في إفريقيا!');
        $this->cta_text_fr = $settings->get('home_cta_text_fr', 'Faites partie du plus grand événement des compétences en Afrique!');
        $this->cta_text_en = $settings->get('home_cta_text_en', 'Be part of the largest skills event in Africa!');

        // Hero Slider image URLs from DB
        $this->hero_slide_1_url = $settings->get('hero_slide_1', '/image.png');
        $this->hero_slide_2_url = $settings->get('hero_slide_2', '');
        $this->hero_slide_3_url = $settings->get('hero_slide_3', '');
        $this->hero_slide_4_url = $settings->get('hero_slide_4', '');
        $this->hero_slide_5_url = $settings->get('hero_slide_5', '');

        $this->featured_video_url = $settings->get('featured_video_url', 'https://www.youtube.com/watch?v=ee7fzNFUKIM');
        $this->featured_video_title_ar = $settings->get('featured_video_title_ar', 'أجواء أولمبياد المهن العالمي بالجزائر');
        $this->featured_video_title_fr = $settings->get('featured_video_title_fr', 'Ambiance des Olympiades des Métiers en Algérie');
        $this->featured_video_title_en = $settings->get('featured_video_title_en', 'WorldSkills Competition Highlights Algeria');

        // Dynamic 3D Countdown Chronometer V8.4 Settings
        $this->countdown_title_ar      = $settings->get('countdown_title_ar', 'الحدث القادم - العد التنازلي لافتتاح الأولمبياد الإفريقي');
        $this->countdown_title_fr      = $settings->get('countdown_title_fr', 'Événement à venir — Décompte du Lancement des Olympiades Africaines 2026');
        $this->countdown_title_en      = $settings->get('countdown_title_en', 'Upcoming Event — Countdown to African Skills Competition 2026');

        $this->countdown_subtitle_ar   = $settings->get('countdown_subtitle_ar', 'WorldSkills Algeria 2026 – 2026');
        $this->countdown_subtitle_fr   = $settings->get('countdown_subtitle_fr', 'WorldSkills Algeria 2026 – 2026');
        $this->countdown_subtitle_en   = $settings->get('countdown_subtitle_en', 'WorldSkills Algeria 2026 – 2026');

        $this->countdown_target_date   = $settings->get('countdown_target_date', '2026-11-16 09:00:00');
        $this->countdown_timezone      = $settings->get('countdown_timezone', 'Africa/Algiers');
        $this->countdown_status        = $settings->get('countdown_status', 'COUNTDOWN'); // COUNTDOWN, LIVE, COMPLETED, DISABLED
        $this->countdown_theme         = $settings->get('countdown_theme', 'vintage_spiral_notebook');
        $this->countdown_digit_style   = $settings->get('countdown_digit_style', 'classic_mono');

        $this->countdown_color_sec     = $settings->get('countdown_color_sec', '#0284C7'); // Electric Blue
        $this->countdown_color_min     = $settings->get('countdown_color_min', '#059669'); // Emerald Teal
        $this->countdown_color_hrs     = $settings->get('countdown_color_hrs', '#D97706'); // Amber Gold
        $this->countdown_color_days    = $settings->get('countdown_color_days', '#7C3AED'); // Deep Purple

        $this->countdown_show_icons    = filter_var($settings->get('countdown_show_icons', true), FILTER_VALIDATE_BOOLEAN);
        $this->countdown_flip_animation = filter_var($settings->get('countdown_flip_animation', true), FILTER_VALIDATE_BOOLEAN);
        $this->countdown_enabled       = filter_var($settings->get('countdown_enabled', true), FILTER_VALIDATE_BOOLEAN);
        $this->show_partners_section   = filter_var($settings->get('show_partners_section', true), FILTER_VALIDATE_BOOLEAN);

        // Mount Africa Skills Policy Forum Database Settings
        $this->forum_name_ar        = $settings->get('forum.name_ar');
        $this->forum_name_fr        = $settings->get('forum.name_fr');
        $this->forum_name_en        = $settings->get('forum.name_en');

        $this->forum_slogan_ar      = $settings->get('forum.slogan_ar');
        $this->forum_slogan_fr      = $settings->get('forum.slogan_fr');
        $this->forum_slogan_en      = $settings->get('forum.slogan_en');

        $this->forum_dates_ar       = $settings->get('forum.dates_ar');
        $this->forum_dates_fr       = $settings->get('forum.dates_fr');
        $this->forum_dates_en       = $settings->get('forum.dates_en');

        $this->forum_principle_ar   = $settings->get('forum.principle_ar');
        $this->forum_principle_fr   = $settings->get('forum.principle_fr');
        $this->forum_principle_en   = $settings->get('forum.principle_en');

        $this->forum_description_ar = $settings->get('forum.description_ar');
        $this->forum_description_fr = $settings->get('forum.description_fr');
        $this->forum_description_en = $settings->get('forum.description_en');

        $this->forum_stat_countries  = $settings->get('forum.stat_countries');
        $this->forum_stat_ministers  = $settings->get('forum.stat_ministers');
        $this->forum_stat_roundtables = $settings->get('forum.stat_roundtables');
        $this->forum_stat_panels     = $settings->get('forum.stat_panels');
    }


    public function saveSettings(SettingsEngine $settings)
    {
        $settings->set('home_hero_title_ar', $this->hero_title_ar);
        $settings->set('home_hero_title_fr', $this->hero_title_fr);
        $settings->set('home_hero_title_en', $this->hero_title_en);

        $settings->set('home_hero_subtitle_ar', $this->hero_subtitle_ar);
        $settings->set('home_hero_subtitle_fr', $this->hero_subtitle_fr);
        $settings->set('home_hero_subtitle_en', $this->hero_subtitle_en);

        // Sync with active Event model
        $activeEvent = \App\Models\Event::where('is_active', true)->first();
        if ($activeEvent) {
            $activeEvent->update([
                'title_ar'   => $this->hero_title_ar,
                'title_fr'   => $this->hero_title_fr,
                'title_en'   => $this->hero_title_en,
                'summary_ar' => $this->hero_subtitle_ar,
                'summary_fr' => $this->hero_subtitle_fr,
            ]);
        }

        $settings->set('home_cta_text_ar', $this->cta_text_ar);
        $settings->set('home_cta_text_fr', $this->cta_text_fr);
        $settings->set('home_cta_text_en', $this->cta_text_en);

        // Save hero slide image URLs (upload or keep existing URL)
        for ($i = 1; $i <= 5; $i++) {
            $fileKey  = "hero_slide_{$i}_file";
            $urlKey   = "hero_slide_{$i}_url";
            $settingKey = "hero_slide_{$i}";

            if (!empty($this->$fileKey)) {
                $path = $this->$fileKey->store('images/hero-slides', 'public');
                $this->$urlKey = '/storage/' . $path;
            }

            $settings->set($settingKey, $this->$urlKey ?? '');
        }

        $settings->set('featured_video_url', $this->featured_video_url);
        $settings->set('featured_video_title_ar', $this->featured_video_title_ar);
        $settings->set('featured_video_title_fr', $this->featured_video_title_fr);
        $settings->set('featured_video_title_en', $this->featured_video_title_en);

        // Save Dynamic 3D Countdown Chronometer V8.4 Settings
        $settings->set('countdown_title_ar', $this->countdown_title_ar);
        $settings->set('countdown_title_fr', $this->countdown_title_fr);
        $settings->set('countdown_title_en', $this->countdown_title_en);

        $settings->set('countdown_subtitle_ar', $this->countdown_subtitle_ar);
        $settings->set('countdown_subtitle_fr', $this->countdown_subtitle_fr);
        $settings->set('countdown_subtitle_en', $this->countdown_subtitle_en);

        $settings->set('countdown_target_date', $this->countdown_target_date);
        $settings->set('countdown_timezone', $this->countdown_timezone);
        $settings->set('countdown_status', $this->countdown_status);
        $settings->set('countdown_theme', $this->countdown_theme);
        $settings->set('countdown_digit_style', $this->countdown_digit_style);

        $settings->set('countdown_color_sec', $this->countdown_color_sec);
        $settings->set('countdown_color_min', $this->countdown_color_min);
        $settings->set('countdown_color_hrs', $this->countdown_color_hrs);
        $settings->set('countdown_color_days', $this->countdown_color_days);

        $settings->set('countdown_show_icons', $this->countdown_show_icons);
        $settings->set('countdown_flip_animation', $this->countdown_flip_animation);
        $settings->set('countdown_enabled', $this->countdown_enabled);
        $settings->set('show_partners_section', $this->show_partners_section);

        // Save Africa Skills Policy Forum 2026 Admin Settings
        $settings->set('forum.name_ar', $this->forum_name_ar);
        $settings->set('forum.name_fr', $this->forum_name_fr);
        $settings->set('forum.name_en', $this->forum_name_en);

        $settings->set('forum.slogan_ar', $this->forum_slogan_ar);
        $settings->set('forum.slogan_fr', $this->forum_slogan_fr);
        $settings->set('forum.slogan_en', $this->forum_slogan_en);

        $settings->set('forum.dates_ar', $this->forum_dates_ar);
        $settings->set('forum.dates_fr', $this->forum_dates_fr);
        $settings->set('forum.dates_en', $this->forum_dates_en);

        $settings->set('forum.principle_ar', $this->forum_principle_ar);
        $settings->set('forum.principle_fr', $this->forum_principle_fr);
        $settings->set('forum.principle_en', $this->forum_principle_en);

        $settings->set('forum.description_ar', $this->forum_description_ar);
        $settings->set('forum.description_fr', $this->forum_description_fr);
        $settings->set('forum.description_en', $this->forum_description_en);

        $settings->set('forum.stat_countries', $this->forum_stat_countries);
        $settings->set('forum.stat_ministers', $this->forum_stat_ministers);
        $settings->set('forum.stat_roundtables', $this->forum_stat_roundtables);
        $settings->set('forum.stat_panels', $this->forum_stat_panels);

        $this->savedMessage = 'تم حفظ كافة إعدادات منتدى السياسات والمحتوى الرئيسي بنجاح، وتحديث قاعدة البيانات بالكامل.';
    }


    public function resetSettings(SettingsEngine $settings)
    {
        $this->countdown_title_ar    = 'الحدث القادم - العد التنازلي لافتتاح الأولمبياد الإفريقي';
        $this->countdown_subtitle_ar = 'WorldSkills Algeria 2026 – 2026';
        $this->countdown_target_date = '2026-09-15 09:00:00';
        $this->countdown_timezone    = 'Africa/Algiers';
        $this->countdown_status      = 'COUNTDOWN';
        $this->countdown_theme       = 'vintage_spiral_notebook';
        $this->countdown_color_sec   = '#0284C7';
        $this->countdown_color_min   = '#059669';
        $this->countdown_color_hrs   = '#D97706';
        $this->countdown_color_days  = '#7C3AED';
        $this->countdown_show_icons  = true;
        $this->countdown_flip_animation = true;

        $this->saveSettings($settings);
        $this->savedMessage = 'تمت إعادة ضبط إعدادات العداد التنازلي الميكانيكي إلى القيم الافتراضية الرسمية.';
    }

    public function render()
    {
        return view('livewire.admin.cms-homepage-manager');
    }
}
