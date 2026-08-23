@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $settings = app(\App\Services\SettingsEngine::class);

    $title = match($locale) {
        'fr' => $settings->get('coming_soon_title_fr', 'Bientôt disponible — Forum des Politiques Africaines des Compétences 2026'),
        'en' => $settings->get('coming_soon_title_en', 'Coming Soon — Africa Skills Policy Forum 2026'),
        default => $settings->get('coming_soon_title_ar', 'انتظرونا قريباً — منتدى السياسات الأفريقية للمهارات 2026'),
    };

    $targetDate = $settings->get('countdown_target_date', '2026-11-16 09:00:00');
    $targetCarbon = \Carbon\Carbon::parse($targetDate);
    $diff = now()->diff($targetCarbon);
    $days = str_pad($diff->days, 2, '0', STR_PAD_LEFT);
    $hours = str_pad($diff->h, 2, '0', STR_PAD_LEFT);
    $minutes = str_pad($diff->i, 2, '0', STR_PAD_LEFT);
    $seconds = str_pad($diff->s, 2, '0', STR_PAD_LEFT);
    $targetTimestamp = $targetCarbon->timestamp * 1000;
@endphp

<!DOCTYPE html>
<html lang="{{ $locale }}" dir="{{ $dir }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $title }} — Africa Skills Forum 2026</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        darkMode: 'class',
        theme: {
          extend: {
            colors: {
              forum: {
                navy: '#052D48',
                teal: '#24BDC3',
                gold: '#F5A800',
                green: '#35A536',
                darkBg: '#031420'
              }
            },
            fontFamily: {
              sans: ['Tajawal', 'Outfit', 'sans-serif'],
            }
          }
        }
      }
    </script>
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Tajawal', 'Outfit', sans-serif; }

        .btn-teal-gradient {
            background: linear-gradient(135deg, #24BDC3 0%, #052D48 100%);
            color: #ffffff;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .btn-teal-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px -5px rgba(36, 189, 195, 0.4);
        }

        .countdown-card {
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .countdown-card:hover {
            transform: translateY(-6px) scale(1.03);
            box-shadow: 0 25px 35px -10px rgba(36, 189, 195, 0.25);
        }
    </style>
    <script>
        (function() {
            var savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark' || (!savedTheme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>
</head>
<body x-data="{ 
        isDark: document.documentElement.classList.contains('dark'),
        toggleTheme() {
            this.isDark = !this.isDark;
            if (this.isDark) {
                document.documentElement.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            } else {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            }
        }
      }" 
      class="min-h-full bg-[#F4F7FC] dark:bg-[#02101b] text-slate-900 dark:text-slate-100 flex flex-col justify-between overflow-x-hidden relative selection:bg-[#24BDC3] selection:text-slate-950 antialiased transition-colors duration-300">

    <!-- High-Definition Cinematic Background Layer -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <img src="{{ asset('/image.png') }}" alt="Africa Skills Policy Forum Stage" class="w-full h-full object-cover object-center filter brightness-90 dark:brightness-40 scale-105 transition-all duration-700">
        <div class="absolute inset-0 bg-gradient-to-t from-[#F4F7FC] via-[#F4F7FC]/70 to-black/30 dark:from-[#02101b] dark:via-[#052D48]/85 dark:to-black/75"></div>
        <!-- Ambient Glowing Beams -->
        <div class="hidden sm:block absolute -top-24 -left-24 w-[36rem] h-[36rem] bg-[#24BDC3]/15 dark:bg-[#24BDC3]/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="hidden sm:block absolute -bottom-24 -right-24 w-[36rem] h-[36rem] bg-blue-500/10 dark:bg-[#052D48]/50 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- Header Section -->
    <header class="relative z-30 w-full max-w-6xl mx-auto p-4 sm:p-6 flex items-center justify-between gap-3">
        <!-- Dual Official Seals Container with Responsive Dark/Light Theme Support -->
        <div class="bg-white/90 dark:bg-[#031826]/80 backdrop-blur-xl p-2 sm:p-3 px-4 sm:px-6 rounded-2xl sm:rounded-3xl flex items-center gap-3 sm:gap-5 shadow-xl border border-slate-200/80 dark:border-[#24BDC3]/30 hover:border-[#24BDC3] transition duration-300">
            <img src="{{ asset('africa-logo-trimmed.png') }}" alt="Africa Skills Forum Logo" class="h-7 sm:h-10 w-auto object-contain">
            <div class="h-6 sm:h-8 w-px bg-slate-300 dark:bg-[#24BDC3]/40"></div>
            <!-- Light Mode Logo -->
            <img src="{{ asset('ministry-logo-trimmed.png') }}" alt="وزارة التكوين والتعليم المهنيين" class="h-7 sm:h-10 w-auto object-contain dark:hidden">
            <!-- Dark Mode Logo -->
            <img src="{{ asset('ministry-logo-white-trimmed.png') }}" alt="وزارة التكوين والتعليم المهنيين" class="h-7 sm:h-10 w-auto object-contain hidden dark:block">
        </div>

        <!-- Header Right Actions: Dark Mode Toggle & Language Switcher -->
        <div class="flex items-center gap-2.5">
            <!-- Dark Mode Toggle Button -->
            <button @click="toggleTheme()" type="button" class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-white/90 dark:bg-[#031826]/80 backdrop-blur-xl border border-slate-200/80 dark:border-[#24BDC3]/30 text-amber-500 dark:text-[#24BDC3] flex items-center justify-center shadow-md hover:scale-105 transition cursor-pointer" title="تبديل الوضع">
                <!-- Sun Icon for Dark Mode -->
                <svg x-show="isDark" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <!-- Moon Icon for Light Mode -->
                <svg x-show="!isDark" class="w-5 h-5 text-slate-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
            </button>

            <!-- Language Switcher Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.outside="open = false" type="button" class="bg-white/90 dark:bg-[#031826]/80 backdrop-blur-xl px-3.5 py-2.5 rounded-2xl text-xs font-black text-slate-800 dark:text-white hover:bg-white dark:hover:bg-white/20 transition flex items-center gap-2 shadow-md border border-slate-200/80 dark:border-[#24BDC3]/30 cursor-pointer">
                    <svg class="w-4 h-4 text-[#24BDC3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m6 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    <span class="uppercase font-mono font-black text-xs text-[#24BDC3] tracking-wider">{{ app()->getLocale() }}</span>
                    <svg class="w-3.5 h-3.5 text-slate-400 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <!-- Language Switcher Menu -->
                <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 scale-95 -translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 -translate-y-2" class="absolute top-full end-0 mt-2 w-44 rounded-2xl bg-white dark:bg-[#031826] text-slate-800 dark:text-white shadow-2xl border border-slate-200 dark:border-[#24BDC3]/40 py-2 z-50 overflow-hidden divide-y divide-slate-100 dark:divide-slate-800">
                    <a href="{{ route('lang.switch', 'ar') }}" class="flex items-center justify-between px-4 py-3 text-xs font-bold transition {{ app()->getLocale() === 'ar' ? 'bg-[#24BDC3] text-slate-950 font-black' : 'hover:bg-slate-50 dark:hover:bg-white/10 text-slate-700 dark:text-slate-200' }}">
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 {{ app()->getLocale() === 'ar' ? 'text-slate-950' : 'text-[#24BDC3]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>العربية</span>
                        </div>
                        <span class="text-[10px] font-mono {{ app()->getLocale() === 'ar' ? 'text-slate-950' : 'text-[#24BDC3]' }}">AR</span>
                    </a>
                    <a href="{{ route('lang.switch', 'fr') }}" class="flex items-center justify-between px-4 py-3 text-xs font-bold transition {{ app()->getLocale() === 'fr' ? 'bg-[#24BDC3] text-slate-950 font-black' : 'hover:bg-slate-50 dark:hover:bg-white/10 text-slate-700 dark:text-slate-200' }}">
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 {{ app()->getLocale() === 'fr' ? 'text-slate-950' : 'text-[#24BDC3]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>Français</span>
                        </div>
                        <span class="text-[10px] font-mono {{ app()->getLocale() === 'fr' ? 'text-slate-950' : 'text-[#24BDC3]' }}">FR</span>
                    </a>
                    <a href="{{ route('lang.switch', 'en') }}" class="flex items-center justify-between px-4 py-3 text-xs font-bold transition {{ app()->getLocale() === 'en' ? 'bg-[#24BDC3] text-slate-950 font-black' : 'hover:bg-slate-50 dark:hover:bg-white/10 text-slate-700 dark:text-slate-200' }}">
                        <div class="flex items-center gap-2">
                            <svg class="w-3.5 h-3.5 {{ app()->getLocale() === 'en' ? 'text-slate-950' : 'text-[#24BDC3]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>English</span>
                        </div>
                        <span class="text-[10px] font-mono {{ app()->getLocale() === 'en' ? 'text-slate-950' : 'text-[#24BDC3]' }}">EN</span>
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Card Stage -->
    <main class="relative z-20 my-auto py-6 sm:py-10 px-4 sm:px-6 max-w-5xl mx-auto text-center w-full">
        <div class="bg-white/95 dark:bg-[#031826]/90 backdrop-blur-2xl border border-slate-200/90 dark:border-[#24BDC3]/40 shadow-2xl dark:shadow-[0_25px_80px_rgba(0,0,0,0.6)] rounded-[28px] sm:rounded-[44px] p-6 sm:p-12 space-y-8 sm:space-y-10 relative overflow-hidden transition-colors duration-300">
            
            <!-- Ambient Glow Spots -->
            <div class="absolute -top-24 -right-24 w-64 h-64 bg-[#24BDC3]/15 dark:bg-[#24BDC3]/20 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-blue-500/10 dark:bg-[#052D48]/50 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Page Main Title & Vision Subtitle -->
            <div class="space-y-4 max-w-4xl mx-auto pt-2">
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-[#052D48] dark:text-white tracking-tight leading-snug sm:leading-tight">
                    {{ $title }}
                </h1>
                <p class="text-sm sm:text-lg text-[#24BDC3] dark:text-teal-100 font-bold max-w-2xl mx-auto italic">
                    "{{ $locale === 'fr' ? 'Façonner l\'avenir des compétences, autonomiser la jeunesse africaine' : ($locale === 'en' ? 'Shaping the Future of Skills, Empowering Africa\'s Youth' : 'صياغة مستقبل المهارات، تمكين الشباب الأفريقي') }}"
                </p>
            </div>

            <!-- Countdown Chronometer Cards Grid -->
            <div x-data="{
                    days: '{{ $days }}',
                    hours: '{{ $hours }}',
                    minutes: '{{ $minutes }}',
                    seconds: '{{ $seconds }}',
                    target: {{ $targetTimestamp }},
                    init() {
                        const update = () => {
                            const now = new Date().getTime();
                            const diff = this.target - now;
                            if (diff <= 0) {
                                this.days = '00'; this.hours = '00'; this.minutes = '00'; this.seconds = '00';
                                return;
                            }
                            this.days = String(Math.floor(diff / (1000 * 60 * 60 * 24))).padStart(2, '0');
                            this.hours = String(Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                            this.minutes = String(Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                            this.seconds = String(Math.floor((diff % (1000 * 60)) / 1000)).padStart(2, '0');
                        };
                        update();
                        setInterval(update, 1000);
                    }
                 }"
                 class="grid grid-cols-2 sm:grid-cols-4 gap-3.5 sm:gap-6 max-w-3xl mx-auto">
                
                <!-- Days Card (Gold Accent) -->
                <div class="countdown-card bg-white dark:bg-[#031420]/90 p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200/90 dark:border-[#24BDC3]/40 border-t-4 border-t-amber-400 shadow-md dark:shadow-2xl flex flex-col items-center justify-center relative overflow-hidden group">
                    <span class="text-3xl sm:text-5xl lg:text-6xl font-black text-amber-500 dark:text-amber-400 font-mono tracking-tight" x-text="days">{{ $days }}</span>
                    <span class="text-xs sm:text-sm font-bold text-slate-500 dark:text-slate-300 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Jours' : ($locale === 'en' ? 'Days' : 'أيام') }}</span>
                </div>

                <!-- Hours Card (Teal Accent) -->
                <div class="countdown-card bg-white dark:bg-[#031420]/90 p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200/90 dark:border-[#24BDC3]/40 border-t-4 border-t-[#24BDC3] shadow-md dark:shadow-2xl flex flex-col items-center justify-center relative overflow-hidden group">
                    <span class="text-3xl sm:text-5xl lg:text-6xl font-black text-[#052D48] dark:text-[#24BDC3] font-mono tracking-tight" x-text="hours">{{ $hours }}</span>
                    <span class="text-xs sm:text-sm font-bold text-slate-500 dark:text-slate-300 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Heures' : ($locale === 'en' ? 'Hours' : 'ساعات') }}</span>
                </div>

                <!-- Minutes Card (Green Accent) -->
                <div class="countdown-card bg-white dark:bg-[#031420]/90 p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200/90 dark:border-[#24BDC3]/40 border-t-4 border-t-emerald-500 shadow-md dark:shadow-2xl flex flex-col items-center justify-center relative overflow-hidden group">
                    <span class="text-3xl sm:text-5xl lg:text-6xl font-black text-emerald-600 dark:text-emerald-400 font-mono tracking-tight" x-text="minutes">{{ $minutes }}</span>
                    <span class="text-xs sm:text-sm font-bold text-slate-500 dark:text-slate-300 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Minutes' : ($locale === 'en' ? 'Minutes' : 'دقائق') }}</span>
                </div>

                <!-- Seconds Card (Sky Accent) -->
                <div class="countdown-card bg-white dark:bg-[#031420]/90 p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200/90 dark:border-[#24BDC3]/40 border-t-4 border-t-sky-500 shadow-md dark:shadow-2xl flex flex-col items-center justify-center relative overflow-hidden group">
                    <span class="text-3xl sm:text-5xl lg:text-6xl font-black text-sky-600 dark:text-sky-400 font-mono tracking-tight" x-text="seconds">{{ $seconds }}</span>
                    <span class="text-xs sm:text-sm font-bold text-slate-500 dark:text-slate-300 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Secondes' : ($locale === 'en' ? 'Seconds' : 'ثواني') }}</span>
                </div>
            </div>

            <!-- Summit Quick Stats Badges Grid with Pure Vector SVG Icons -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 max-w-3xl mx-auto pt-2">
                <div class="p-3 rounded-2xl bg-slate-100/90 dark:bg-white/5 border border-slate-200/90 dark:border-white/15 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-[#24BDC3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 012 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V14m-3 7c9 0 9-9 9-9s-9 0-9 9z"/></svg>
                    <span class="text-xs font-extrabold text-slate-800 dark:text-white">+30 {{ $locale === 'fr' ? 'Pays' : ($locale === 'en' ? 'Countries' : 'دولة أفريقية') }}</span>
                </div>
                <div class="p-3 rounded-2xl bg-slate-100/90 dark:bg-white/5 border border-slate-200/90 dark:border-white/15 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-amber-500 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="text-xs font-extrabold text-slate-800 dark:text-white">+20 {{ $locale === 'fr' ? 'Ministres' : ($locale === 'en' ? 'Ministers' : 'وزيراً متوقعاً') }}</span>
                </div>
                <div class="p-3 rounded-2xl bg-slate-100/90 dark:bg-white/5 border border-slate-200/90 dark:border-white/15 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span class="text-xs font-extrabold text-slate-800 dark:text-white">2 {{ $locale === 'fr' ? 'Tables rondes' : ($locale === 'en' ? 'Roundtables' : 'موائد وزارية') }}</span>
                </div>
                <div class="p-3 rounded-2xl bg-slate-100/90 dark:bg-white/5 border border-slate-200/90 dark:border-white/15 flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-sky-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 01-2 2h-0a2 2 0 01-2-2v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    <span class="text-xs font-extrabold text-slate-800 dark:text-white">7 {{ $locale === 'fr' ? 'Ateliers' : ($locale === 'en' ? 'Workshops' : 'ورشات تخصصية') }}</span>
                </div>
            </div>

            <!-- Action Buttons Grid -->
            <div class="flex flex-wrap items-center justify-center gap-3.5 pt-4">
                <a href="{{ route('registration') }}" class="px-6 py-3.5 rounded-2xl btn-teal-gradient font-black text-xs sm:text-sm flex items-center gap-2 shadow-xl">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>{{ $locale === 'fr' ? 'Pré-inscription au Forum' : ($locale === 'en' ? 'Forum Pre-Registration' : 'التسجيل المسبق في المنتدى') }}</span>
                </a>
                <a href="{{ route('guide') }}" class="px-6 py-3.5 rounded-2xl bg-[#052D48] dark:bg-white/10 hover:bg-[#031826] dark:hover:bg-white/20 text-white font-extrabold text-xs sm:text-sm border border-transparent dark:border-white/30 shadow-xl transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#24BDC3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    <span>{{ $locale === 'fr' ? 'Vision & Guide' : ($locale === 'en' ? 'Vision & Guide' : 'رؤية ودليل المنتدى') }}</span>
                </a>
            </div>

            <!-- Venue Location Badge -->
            <div class="pt-2 flex items-center justify-center gap-2.5 text-xs sm:text-sm font-bold text-slate-800 dark:text-teal-100 max-w-xl mx-auto bg-slate-100/90 dark:bg-white/5 border border-slate-200/90 dark:border-white/15 p-3.5 px-5 rounded-2xl shadow-xs">
                <svg class="w-5 h-5 text-[#24BDC3] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="leading-relaxed">{{ $locale === 'fr' ? '16 – 17 Novembre 2026 — Centre des Conventions Mohamed Ben Ahmed, Oran - Algérie' : ($locale === 'en' ? '16 – 17 November 2026 — Mohamed Ben Ahmed Convention Center, Oran - Algeria' : '16 – 17 نوفمبر 2026 — مركز المؤتمرات محمد بن أحمد، وهران - الجزائر') }}</span>
            </div>

        </div>
    </main>

    <!-- Footer Area -->
    <footer class="relative z-30 w-full max-w-5xl mx-auto p-4 sm:p-6 text-center text-xs font-medium text-slate-600 dark:text-slate-300/80">
        © 2026 {{ platform()->name() }}. {{ $locale === 'fr' ? 'Tous droits réservés — République Algérienne & Union Africaine' : ($locale === 'en' ? 'All rights reserved — Republic of Algeria & African Union' : 'جميع الحقوق محفوظة — الجمهورية الجزائرية الديمقراطية الشعبية ومفوضية الاتحاد الأفريقي') }}
    </footer>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
