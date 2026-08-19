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
<html lang="{{ $locale }}" dir="{{ $dir }}" class="h-full bg-[#F4F7FC]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>{{ $title }} — Africa Skills Forum</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              forum: {
                navy: '#0B2A6F',
                gold: '#F5A800',
                green: '#35A536',
                blue: '#0066FF'
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
    </style>
</head>
<body class="h-full bg-[#F4F7FC] text-[#0B2A6F] flex flex-col justify-between overflow-x-hidden relative selection:bg-[#0066FF] selection:text-white antialiased">

    <!-- Ambient Gradient Backdrops -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[30rem] bg-gradient-to-b from-[#0B2A6F]/8 via-blue-500/5 to-transparent pointer-events-none"></div>
    <div class="fixed bottom-0 right-0 w-[30rem] h-[30rem] bg-emerald-500/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed top-1/4 left-0 w-[25rem] h-[25rem] bg-amber-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Header Bar (Dual Official Seals in High Contrast White Container) -->
    <header class="relative z-30 w-full max-w-6xl mx-auto p-4 sm:p-6 lg:p-8 flex items-center justify-between gap-4">
        <!-- Dual Official Seals -->
        <div class="bg-white/95 backdrop-blur-md p-2.5 px-4 sm:px-6 rounded-2xl sm:rounded-3xl flex items-center gap-3 sm:gap-4 shadow-md border border-slate-200/80">
            <img src="{{ asset('ministry-logo-trimmed.png') }}" alt="وزارة التكوين والتعليم المهنيين" class="h-9 sm:h-12 w-auto object-contain">
            <div class="h-7 w-px bg-slate-200"></div>
            <img src="{{ asset('africa-logo-trimmed.png') }}" alt="Africa Skills Forum Logo" class="h-9 sm:h-12 w-auto object-contain">
        </div>

        <!-- Vector SVG Language Switcher -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.outside="open = false" type="button" class="bg-white/95 backdrop-blur-md px-4 py-2.5 rounded-2xl text-xs font-black text-[#0B2A6F] hover:bg-slate-50 transition flex items-center gap-2.5 shadow-md border border-slate-200/80 group">
                <svg class="w-4 h-4 text-[#35A536] group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m6 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                <span class="uppercase font-mono font-black text-xs text-[#0066FF] tracking-wider">{{ app()->getLocale() }}</span>
                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-700 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <!-- Language Menu -->
            <div x-show="open" x-cloak x-transition class="absolute top-full end-0 mt-2 w-44 rounded-2xl bg-white text-[#0B2A6F] shadow-2xl border border-slate-200 py-2 z-50 overflow-hidden divide-y divide-slate-100">
                <a href="{{ route('lang.switch', 'ar') }}" @click.prevent="window.location.href = '{{ route('lang.switch', 'ar') }}'" class="flex items-center justify-between px-4 py-3 text-xs font-bold transition {{ app()->getLocale() === 'ar' ? 'bg-[#0066FF] text-white font-black' : 'hover:bg-slate-50 text-slate-700' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ app()->getLocale() === 'ar' ? 'text-white' : 'text-[#35A536]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>العربية</span>
                    </div>
                    <span class="text-[10px] font-mono {{ app()->getLocale() === 'ar' ? 'text-white' : 'text-[#F5A800]' }}">AR</span>
                </a>
                <a href="{{ route('lang.switch', 'fr') }}" @click.prevent="window.location.href = '{{ route('lang.switch', 'fr') }}'" class="flex items-center justify-between px-4 py-3 text-xs font-bold transition {{ app()->getLocale() === 'fr' ? 'bg-[#0066FF] text-white font-black' : 'hover:bg-slate-50 text-slate-700' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ app()->getLocale() === 'fr' ? 'text-white' : 'text-[#35A536]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Français</span>
                    </div>
                    <span class="text-[10px] font-mono {{ app()->getLocale() === 'fr' ? 'text-white' : 'text-[#F5A800]' }}">FR</span>
                </a>
                <a href="{{ route('lang.switch', 'en') }}" @click.prevent="window.location.href = '{{ route('lang.switch', 'en') }}'" class="flex items-center justify-between px-4 py-3 text-xs font-bold transition {{ app()->getLocale() === 'en' ? 'bg-[#0066FF] text-white font-black' : 'hover:bg-slate-50 text-slate-700' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ app()->getLocale() === 'en' ? 'text-white' : 'text-[#35A536]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>English</span>
                    </div>
                    <span class="text-[10px] font-mono {{ app()->getLocale() === 'en' ? 'text-white' : 'text-[#F5A800]' }}">EN</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Stage Content Card -->
    <main class="relative z-20 my-auto py-8 sm:py-12 px-4 sm:px-6 max-w-5xl mx-auto text-center">
        <div class="bg-white/90 backdrop-blur-xl border border-slate-200/90 shadow-2xl rounded-[32px] sm:rounded-[40px] p-6 sm:p-12 lg:p-16 space-y-8 sm:space-y-12 relative overflow-hidden">
            
            <!-- Glow Accents inside Card -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Status Pill Badge with Vector SVG Icon -->
            <div class="inline-flex items-center gap-2.5 px-5 py-2.5 rounded-full bg-blue-50 border border-blue-200/80 text-xs font-black text-[#0066FF] shadow-xs tracking-wider">
                <svg class="w-4 h-4 text-[#F5A800] animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $locale === 'fr' ? 'ÉVÉNEMENT OFFICIEL PANAFRICAIN EN PRÉPARATION' : ($locale === 'en' ? 'OFFICIAL PAN-AFRICAN EVENT PREPARATION IN PROGRESS' : 'الحدث القاري الأفريقي قريباً بوهران') }}</span>
            </div>

            <!-- Main Title & Subtitle -->
            <div class="space-y-4 sm:space-y-6 max-w-4xl mx-auto">
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-[#0B2A6F] tracking-tight leading-tight drop-shadow-xs">
                    {{ $title }}
                </h1>
                <p class="text-sm sm:text-lg text-slate-600 font-medium leading-relaxed max-w-2xl mx-auto">
                    {{ $subtitle }}
                </p>
            </div>

            <!-- 3D Vector Countdown Chronometer Cards -->
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
                 class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 max-w-3xl mx-auto pt-2">
                
                <!-- Days Card -->
                <div class="bg-gradient-to-b from-white to-slate-50 p-4 sm:p-6 rounded-3xl border border-slate-200/90 border-t-4 border-t-[#F5A800] shadow-lg flex flex-col items-center justify-center relative overflow-hidden group">
                    <span class="text-3xl sm:text-6xl font-black text-[#0B2A6F] font-mono tracking-tight" x-text="days">00</span>
                    <span class="text-xs font-bold text-slate-500 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Jours' : ($locale === 'en' ? 'Days' : 'أيام') }}</span>
                </div>

                <!-- Hours Card -->
                <div class="bg-gradient-to-b from-white to-slate-50 p-4 sm:p-6 rounded-3xl border border-slate-200/90 border-t-4 border-t-[#35A536] shadow-lg flex flex-col items-center justify-center relative overflow-hidden group">
                    <span class="text-3xl sm:text-6xl font-black text-[#35A536] font-mono tracking-tight" x-text="hours">00</span>
                    <span class="text-xs font-bold text-slate-500 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Heures' : ($locale === 'en' ? 'Hours' : 'ساعات') }}</span>
                </div>

                <!-- Minutes Card -->
                <div class="bg-gradient-to-b from-white to-slate-50 p-4 sm:p-6 rounded-3xl border border-slate-200/90 border-t-4 border-t-[#0066FF] shadow-lg flex flex-col items-center justify-center relative overflow-hidden group">
                    <span class="text-3xl sm:text-6xl font-black text-[#0066FF] font-mono tracking-tight" x-text="minutes">00</span>
                    <span class="text-xs font-bold text-slate-500 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Minutes' : ($locale === 'en' ? 'Minutes' : 'دقائق') }}</span>
                </div>

                <!-- Seconds Card -->
                <div class="bg-gradient-to-b from-white to-slate-50 p-4 sm:p-6 rounded-3xl border border-slate-200/90 border-t-4 border-t-purple-600 shadow-lg flex flex-col items-center justify-center relative overflow-hidden group">
                    <span class="text-3xl sm:text-6xl font-black text-purple-600 font-mono tracking-tight" x-text="seconds">00</span>
                    <span class="text-xs font-bold text-slate-500 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Secondes' : ($locale === 'en' ? 'Seconds' : 'ثواني') }}</span>
                </div>
            </div>

            <!-- Venue Location Tag with Vector SVG Pin -->
            <div class="pt-2 flex items-center justify-center gap-2.5 text-xs sm:text-sm font-bold text-slate-700 max-w-xl mx-auto bg-emerald-50/80 border border-emerald-200/80 p-3.5 px-6 rounded-2xl shadow-xs">
                <svg class="w-5 h-5 text-[#35A536] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="leading-relaxed">{{ $locale === 'fr' ? '16 – 17 Novembre 2026 — Centre des Conventions Mohamed Ben Ahmed, Oran - Algérie' : ($locale === 'en' ? '16 – 17 November 2026 — Mohamed Ben Ahmed Convention Center, Oran - Algeria' : '16 – 17 نوفمبر 2026 — مركز المؤتمرات محمد بن أحمد، وهران - الجزائر') }}</span>
            </div>

        </div>
    </main>

    <!-- Footer Area (ONLY COPYRIGHT - NO ADMIN LINKS AT ALL!) -->
    <footer class="relative z-30 w-full max-w-6xl mx-auto p-4 sm:p-6 text-center text-xs font-medium text-slate-500">
        © 2026 {{ platform()->name() }}. {{ $locale === 'fr' ? 'Tous droits réservés — République Algérienne & Union Africaine' : ($locale === 'en' ? 'All rights reserved — Republic of Algeria & African Union' : 'جميع الحقوق محفوظة — الجمهورية الجزائرية الديمقراطية الشعبية ومفوضية الاتحاد الأفريقي') }}
    </footer>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
