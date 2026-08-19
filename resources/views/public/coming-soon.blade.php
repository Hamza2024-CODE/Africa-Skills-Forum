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
<html lang="{{ $locale }}" dir="{{ $dir }}" class="h-full bg-[#02091A]">
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
                navy: '#06163A',
                dark: '#02091A',
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
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }
        
        .glass-card-glow {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.08) 0%, rgba(255, 255, 255, 0.02) 100%);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }

        .gold-glow-text {
            background: linear-gradient(135deg, #FFFFFF 0%, #E2E8F0 50%, #F5A800 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="h-full bg-[#02091A] text-white flex flex-col justify-between overflow-x-hidden relative selection:bg-[#0066FF] selection:text-white">

    <!-- High-Tech Animated Ambient Light Circles -->
    <div class="fixed top-0 left-1/4 w-[40rem] h-[40rem] bg-gradient-to-br from-blue-600/20 to-indigo-600/0 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="fixed bottom-0 right-1/4 w-[35rem] h-[35rem] bg-gradient-to-tl from-[#35A536]/20 to-emerald-600/0 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="fixed top-1/3 right-10 w-[25rem] h-[25rem] bg-gradient-to-l from-[#F5A800]/15 to-amber-500/0 rounded-full blur-[100px] pointer-events-none"></div>

    <!-- Header Navigation Bar -->
    <header class="relative z-30 w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 flex items-center justify-between gap-4">
        <!-- Dual Official Seals Container -->
        <div class="glass-panel p-2.5 px-4 rounded-2xl flex items-center gap-3 shadow-2xl">
            <img src="{{ asset('ministry-logo-trimmed.png') }}" alt="وزارة التكوين والتعليم المهنيين" class="h-8 sm:h-10 w-auto object-contain">
            <div class="h-6 w-px bg-white/20"></div>
            <img src="{{ asset('africa-logo-trimmed.png') }}" alt="Africa Skills Forum Logo" class="h-8 sm:h-10 w-auto object-contain">
        </div>

        <!-- Vector SVG Language Switcher -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.outside="open = false" type="button" class="glass-panel px-4 py-2.5 rounded-2xl text-xs font-bold text-white hover:border-white/30 transition flex items-center gap-2.5 shadow-lg group">
                <!-- SVG Globe Icon -->
                <svg class="w-4 h-4 text-[#35A536] group-hover:scale-110 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m6 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                <span class="uppercase font-mono font-black text-xs text-[#F5A800] tracking-wider">{{ app()->getLocale() }}</span>
                <!-- SVG Chevron Down Icon -->
                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-white transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <!-- Language Options Menu -->
            <div x-show="open" x-cloak x-transition class="absolute top-full end-0 mt-2 w-44 rounded-2xl bg-[#06163A] text-white shadow-2xl border border-white/15 py-2 z-50 overflow-hidden divide-y divide-white/5">
                <a href="{{ route('lang.switch', 'ar') }}" @click.prevent="window.location.href = '{{ route('lang.switch', 'ar') }}'" class="flex items-center justify-between px-4 py-3 text-xs font-bold transition {{ app()->getLocale() === 'ar' ? 'bg-[#0066FF] text-white font-black' : 'hover:bg-white/10 text-slate-200' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>العربية</span>
                    </div>
                    <span class="text-[10px] font-mono text-[#F5A800]">AR</span>
                </a>
                <a href="{{ route('lang.switch', 'fr') }}" @click.prevent="window.location.href = '{{ route('lang.switch', 'fr') }}'" class="flex items-center justify-between px-4 py-3 text-xs font-bold transition {{ app()->getLocale() === 'fr' ? 'bg-[#0066FF] text-white font-black' : 'hover:bg-white/10 text-slate-200' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Français</span>
                    </div>
                    <span class="text-[10px] font-mono text-[#F5A800]">FR</span>
                </a>
                <a href="{{ route('lang.switch', 'en') }}" @click.prevent="window.location.href = '{{ route('lang.switch', 'en') }}'" class="flex items-center justify-between px-4 py-3 text-xs font-bold transition {{ app()->getLocale() === 'en' ? 'bg-[#0066FF] text-white font-black' : 'hover:bg-white/10 text-slate-200' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>English</span>
                    </div>
                    <span class="text-[10px] font-mono text-[#F5A800]">EN</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Stage Content -->
    <main class="relative z-20 my-auto py-10 sm:py-16 px-4 sm:px-6 max-w-5xl mx-auto text-center space-y-10 sm:space-y-14">
        
        <!-- Status Pill Badge with Vector SVG Icon -->
        <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full glass-panel border border-[#35A536]/40 text-xs font-black text-[#35A536] shadow-2xl tracking-wider">
            <!-- SVG Sparkles Icon -->
            <svg class="w-4 h-4 text-[#F5A800] animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            <span>{{ $locale === 'fr' ? 'ÉVÉNEMENT OFFICIEL PANAFRICAIN EN PRÉPARATION' : ($locale === 'en' ? 'OFFICIAL PAN-AFRICAN EVENT PREPARATION IN PROGRESS' : 'الحدث القاري الأفريقي قريباً بوهران') }}</span>
        </div>

        <!-- Title & Subtitle -->
        <div class="space-y-5 sm:space-y-7 max-w-4xl mx-auto">
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight gold-glow-text drop-shadow-2xl">
                {{ $title }}
            </h1>
            <p class="text-sm sm:text-lg text-slate-300 font-medium leading-relaxed max-w-2xl mx-auto drop-shadow-md">
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
             class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 max-w-3xl mx-auto">
            
            <!-- Days Card -->
            <div class="glass-card-glow p-4 sm:p-6 rounded-3xl border-t-2 border-t-[#F5A800] flex flex-col items-center justify-center relative overflow-hidden group">
                <div class="absolute top-2 right-2 text-white/10 group-hover:text-[#F5A800]/20 transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <span class="text-3xl sm:text-6xl font-black text-[#F5A800] font-mono tracking-tight" x-text="days">00</span>
                <span class="text-xs font-bold text-slate-300 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Jours' : ($locale === 'en' ? 'Days' : 'أيام') }}</span>
            </div>

            <!-- Hours Card -->
            <div class="glass-card-glow p-4 sm:p-6 rounded-3xl border-t-2 border-t-[#35A536] flex flex-col items-center justify-center relative overflow-hidden group">
                <div class="absolute top-2 right-2 text-white/10 group-hover:text-[#35A536]/20 transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-3xl sm:text-6xl font-black text-[#35A536] font-mono tracking-tight" x-text="hours">00</span>
                <span class="text-xs font-bold text-slate-300 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Heures' : ($locale === 'en' ? 'Hours' : 'ساعات') }}</span>
            </div>

            <!-- Minutes Card -->
            <div class="glass-card-glow p-4 sm:p-6 rounded-3xl border-t-2 border-t-[#0066FF] flex flex-col items-center justify-center relative overflow-hidden group">
                <div class="absolute top-2 right-2 text-white/10 group-hover:text-[#0066FF]/20 transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <span class="text-3xl sm:text-6xl font-black text-[#0066FF] font-mono tracking-tight" x-text="minutes">00</span>
                <span class="text-xs font-bold text-slate-300 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Minutes' : ($locale === 'en' ? 'Minutes' : 'دقائق') }}</span>
            </div>

            <!-- Seconds Card -->
            <div class="glass-card-glow p-4 sm:p-6 rounded-3xl border-t-2 border-t-purple-500 flex flex-col items-center justify-center relative overflow-hidden group">
                <div class="absolute top-2 right-2 text-white/10 group-hover:text-purple-400/20 transition">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-3xl sm:text-6xl font-black text-purple-400 font-mono tracking-tight" x-text="seconds">00</span>
                <span class="text-xs font-bold text-slate-300 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Secondes' : ($locale === 'en' ? 'Seconds' : 'ثواني') }}</span>
            </div>
        </div>

        <!-- Venue Location Tag with Vector SVG Pin -->
        <div class="pt-4 flex items-center justify-center gap-2.5 text-xs sm:text-sm font-bold text-slate-300 max-w-xl mx-auto glass-panel p-3.5 px-6 rounded-2xl border border-white/10 shadow-lg">
            <svg class="w-5 h-5 text-[#35A536] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            <span class="leading-relaxed">{{ $locale === 'fr' ? '16 – 17 Novembre 2026 — Centre des Conventions Mohamed Ben Ahmed, Oran - Algérie' : ($locale === 'en' ? '16 – 17 November 2026 — Mohamed Ben Ahmed Convention Center, Oran - Algeria' : '16 – 17 نوفمبر 2026 — مركز المؤتمرات محمد بن أحمد، وهران - الجزائر') }}</span>
        </div>

    </main>

    <!-- Footer Area with Vector SVG Admin Icon -->
    <footer class="relative z-30 w-full max-w-7xl mx-auto p-4 sm:p-6 lg:p-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs font-medium text-slate-400">
        <div>
            © 2026 {{ platform()->name() }}. {{ $locale === 'fr' ? 'Tous droits réservés — République Algérienne & Union Africaine' : ($locale === 'en' ? 'All rights reserved — Republic of Algeria & African Union' : 'جميع الحقوق محفوظة — الجمهورية الجزائرية الديمقراطية الشعبية ومفوضية الاتحاد الأفريقي') }}
        </div>

        <!-- Admin Access Gateway -->
        <a href="{{ route('login') }}" class="px-5 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs transition flex items-center gap-2 border border-white/15 shadow-xl hover:border-white/30">
            <!-- SVG Lock Icon -->
            <svg class="w-4 h-4 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            <span>{{ $locale === 'fr' ? 'Espace Administrateurs' : ($locale === 'en' ? 'Admin Portal' : 'بوابة الإدارة والتنظيم') }}</span>
        </a>
    </footer>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
