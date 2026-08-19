@php
    $locale = app()->getLocale();
    $dir = $locale === 'ar' ? 'rtl' : 'ltr';
    $settings = app(\App\Services\SettingsEngine::class);

    $title = match($locale) {
        'fr' => $settings->get('coming_soon_title_fr', 'Bientôt disponible — Forum des Politiques Africaines des Compétences 2026'),
        'en' => $settings->get('coming_soon_title_en', 'Coming Soon — Africa Skills Policy Forum 2026'),
        default => $settings->get('coming_soon_title_ar', 'انتظرونا قريباً — منتدى السياسات الأفريقية للمهارات 2026'),
    };

    $subtitle = match($locale) {
        'fr' => $settings->get('coming_soon_subtitle_fr', 'La plateforme officielle est actuellement en cours de préparation pour le lancement officiel à Oran.'),
        'en' => $settings->get('coming_soon_subtitle_en', 'The official platform is currently being prepared for the official launch in Oran.'),
        default => $settings->get('coming_soon_subtitle_ar', 'المنصة الرسمية تحت التحديث والتجهيز حالياً استعداداً للانطلاق الرسمي بوهران.'),
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
<html lang="{{ $locale }}" dir="{{ $dir }}" class="h-full bg-[#040E26]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $title }} — Africa Skills Forum</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;800;900&family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
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
    </style>
</head>
<body class="h-full bg-gradient-to-br from-[#0B2A6F] via-[#081F54] to-[#040E26] text-white flex flex-col justify-between overflow-x-hidden relative select-none">

    <!-- Ambient Glowing Background Stars & Accents -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-blue-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-1/2 right-0 w-[30rem] h-[30rem] bg-emerald-500/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-amber-500/15 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Header Bar (Ministry & AU Logos + Language Switcher) -->
    <header class="relative z-20 w-full max-w-7xl mx-auto p-4 sm:p-6 flex items-center justify-between gap-4">
        <!-- Dual Official Logos -->
        <div class="flex items-center gap-2 sm:gap-3 bg-white/95 backdrop-blur-md p-2 sm:p-2.5 px-3 sm:px-4 rounded-2xl shadow-xl border border-white/20">
            <img src="{{ asset('ministry-logo-trimmed.png') }}" alt="وزارة التكوين والتعليم المهنيين" class="h-7 sm:h-9 w-auto object-contain">
            <div class="h-6 w-px bg-slate-300"></div>
            <img src="{{ asset('africa-logo-trimmed.png') }}" alt="Africa Skills Forum Logo" class="h-7 sm:h-9 w-auto object-contain">
        </div>

        <!-- Language Switcher Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.outside="open = false" type="button" class="px-3.5 py-2 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-md text-xs font-bold text-white transition flex items-center gap-2 border border-white/20 shadow-md">
                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 11.37 9.198 15.357 6 17.555"/></svg>
                <span class="uppercase font-mono font-black text-xs text-amber-400">{{ app()->getLocale() }}</span>
                <svg class="w-3.5 h-3.5 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-cloak x-transition class="absolute top-full end-0 mt-2 w-36 rounded-2xl bg-slate-900 text-white shadow-2xl border border-white/20 py-2 z-50 overflow-hidden">
                <a href="{{ route('lang.switch', 'ar') }}" @click.prevent="window.location.href = '{{ route('lang.switch', 'ar') }}'" class="flex items-center justify-between px-4 py-2.5 text-xs font-bold transition {{ app()->getLocale() === 'ar' ? 'bg-blue-600 text-white font-black' : 'hover:bg-white/10 text-slate-200' }}">
                    <span>العربية</span>
                    <span class="text-[10px] font-mono text-amber-400">AR</span>
                </a>
                <a href="{{ route('lang.switch', 'fr') }}" @click.prevent="window.location.href = '{{ route('lang.switch', 'fr') }}'" class="flex items-center justify-between px-4 py-2.5 text-xs font-bold transition {{ app()->getLocale() === 'fr' ? 'bg-blue-600 text-white font-black' : 'hover:bg-white/10 text-slate-200' }}">
                    <span>Français</span>
                    <span class="text-[10px] font-mono text-amber-400">FR</span>
                </a>
                <a href="{{ route('lang.switch', 'en') }}" @click.prevent="window.location.href = '{{ route('lang.switch', 'en') }}'" class="flex items-center justify-between px-4 py-2.5 text-xs font-bold transition {{ app()->getLocale() === 'en' ? 'bg-blue-600 text-white font-black' : 'hover:bg-white/10 text-slate-200' }}">
                    <span>English</span>
                    <span class="text-[10px] font-mono text-amber-400">EN</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Central Stage -->
    <main class="relative z-10 my-auto py-8 sm:py-12 px-4 sm:px-6 max-w-4xl mx-auto text-center space-y-8 sm:space-y-12">
        
        <!-- Coming Soon Animated Badge -->
        <div class="inline-flex items-center gap-2.5 px-5 py-2 rounded-full bg-white/10 backdrop-blur-xl border border-white/20 text-xs font-black text-emerald-400 shadow-xl tracking-wider">
            <span class="w-2.5 h-2.5 rounded-full bg-[#35A536] animate-ping"></span>
            <span>{{ $locale === 'fr' ? 'ÉVÉNEMENT OFFICIEL EN PRÉPARATION' : ($locale === 'en' ? 'OFFICIAL EVENT PREPARATION IN PROGRESS' : 'الحدث القاري الأفريقي قريباً') }}</span>
        </div>

        <!-- Main Title & Subtitle -->
        <div class="space-y-4 sm:space-y-6">
            <h1 class="text-3xl sm:text-5xl md:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-2xl">
                {{ $title }}
            </h1>
            <p class="text-sm sm:text-lg text-slate-300 font-medium leading-relaxed max-w-2xl mx-auto drop-shadow-md">
                {{ $subtitle }}
            </p>
        </div>

        <!-- Dynamic 3D Countdown Chronometer -->
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
             class="grid grid-cols-4 gap-3 sm:gap-6 max-w-2xl mx-auto">
            
            <!-- Days -->
            <div class="bg-white/10 backdrop-blur-2xl p-3 sm:p-5 rounded-2xl sm:rounded-3xl border border-white/20 shadow-2xl flex flex-col items-center justify-center">
                <span class="text-2xl sm:text-5xl font-black text-amber-400 font-mono tracking-tight" x-text="days">00</span>
                <span class="text-[10px] sm:text-xs font-bold text-slate-300 mt-1 uppercase">{{ $locale === 'fr' ? 'Jours' : ($locale === 'en' ? 'Days' : 'أيام') }}</span>
            </div>

            <!-- Hours -->
            <div class="bg-white/10 backdrop-blur-2xl p-3 sm:p-5 rounded-2xl sm:rounded-3xl border border-white/20 shadow-2xl flex flex-col items-center justify-center">
                <span class="text-2xl sm:text-5xl font-black text-emerald-400 font-mono tracking-tight" x-text="hours">00</span>
                <span class="text-[10px] sm:text-xs font-bold text-slate-300 mt-1 uppercase">{{ $locale === 'fr' ? 'Heures' : ($locale === 'en' ? 'Hours' : 'ساعات') }}</span>
            </div>

            <!-- Minutes -->
            <div class="bg-white/10 backdrop-blur-2xl p-3 sm:p-5 rounded-2xl sm:rounded-3xl border border-white/20 shadow-2xl flex flex-col items-center justify-center">
                <span class="text-2xl sm:text-5xl font-black text-sky-400 font-mono tracking-tight" x-text="minutes">00</span>
                <span class="text-[10px] sm:text-xs font-bold text-slate-300 mt-1 uppercase">{{ $locale === 'fr' ? 'Minutes' : ($locale === 'en' ? 'Minutes' : 'دقائق') }}</span>
            </div>

            <!-- Seconds -->
            <div class="bg-white/10 backdrop-blur-2xl p-3 sm:p-5 rounded-2xl sm:rounded-3xl border border-white/20 shadow-2xl flex flex-col items-center justify-center">
                <span class="text-2xl sm:text-5xl font-black text-purple-400 font-mono tracking-tight" x-text="seconds">00</span>
                <span class="text-[10px] sm:text-xs font-bold text-slate-300 mt-1 uppercase">{{ $locale === 'fr' ? 'Secondes' : ($locale === 'en' ? 'Seconds' : 'ثواني') }}</span>
            </div>
        </div>

        <!-- Venue Location Info Tag -->
        <div class="pt-2 flex items-center justify-center gap-2 text-xs font-bold text-slate-300">
            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span>{{ $locale === 'fr' ? '16 – 17 Novembre 2026 — Centre des Conventions Mohamed Ben Ahmed, Oran - Algérie' : ($locale === 'en' ? '16 – 17 November 2026 — Mohamed Ben Ahmed Convention Center, Oran - Algeria' : '16 – 17 نوفمبر 2026 — مركز المؤتمرات محمد بن أحمد، وهران - الجزائر') }}</span>
        </div>

    </main>

    <!-- Footer Bar with Admin Portal Access Link -->
    <footer class="relative z-20 w-full max-w-7xl mx-auto p-4 sm:p-6 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-medium text-slate-400">
        <div>
            © 2026 {{ platform()->name() }}. {{ $locale === 'fr' ? 'Tous droits réservés — République Algérienne & Union Africaine' : ($locale === 'en' ? 'All rights reserved — Republic of Algeria & African Union' : 'جميع الحقوق محفوظة — الجمهورية الجزائرية الديمقراطية الشعبية ومفوضية الاتحاد الأفريقي') }}
        </div>

        <!-- Admin Portal Gateway Link -->
        <div class="flex items-center gap-4">
            <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs transition flex items-center gap-1.5 border border-white/15">
                <svg class="w-3.5 h-3.5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span>{{ $locale === 'fr' ? 'Espace Administrateurs' : ($locale === 'en' ? 'Admin Portal' : 'بوابة الإدارة والتنظيم') }}</span>
            </a>
        </div>
    </footer>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
