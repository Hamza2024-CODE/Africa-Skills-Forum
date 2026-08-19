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

        @keyframes float-subtle {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-6px); }
        }
        .animate-float-subtle {
            animation: float-subtle 5s ease-in-out infinite;
        }

        @keyframes pulse-ring {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.05); opacity: 0.4; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }
        .animate-pulse-ring {
            animation: pulse-ring 3s ease-in-out infinite;
        }

        .countdown-card {
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .countdown-card:hover {
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 30px -10px rgba(11, 42, 111, 0.12);
        }
    </style>
</head>
<body class="min-h-full bg-[#F4F7FC] text-[#0B2A6F] flex flex-col justify-between overflow-x-hidden relative selection:bg-[#0066FF] selection:text-white antialiased">

    <!-- Glowing Background Lighting -->
    <div class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-7xl h-[34rem] bg-gradient-to-b from-[#0B2A6F]/10 via-[#0066FF]/5 to-transparent pointer-events-none rounded-b-[100px] blur-2xl"></div>
    <div class="fixed bottom-0 right-0 w-[28rem] h-[28rem] bg-[#35A536]/8 rounded-full blur-3xl pointer-events-none"></div>
    <div class="fixed top-1/3 left-0 w-[24rem] h-[24rem] bg-[#F5A800]/10 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Header Section -->
    <header class="relative z-30 w-full max-w-5xl mx-auto p-4 sm:p-6 flex items-center justify-between gap-3">
        <!-- Dual Official Seals Container -->
        <div class="bg-white/95 backdrop-blur-xl p-2 sm:p-3 px-4 sm:px-6 rounded-2xl sm:rounded-3xl flex items-center gap-3 sm:gap-5 shadow-xl shadow-slate-200/50 border border-white/80 ring-1 ring-slate-200/60 hover:shadow-2xl transition duration-300">
            <img src="{{ asset('africa-logo-trimmed.png') }}" alt="Africa Skills Forum Logo" class="h-8 sm:h-11 w-auto object-contain">
            <div class="h-6 sm:h-8 w-px bg-gradient-to-b from-transparent via-slate-300 to-transparent"></div>
            <img src="{{ asset('ministry-logo-trimmed.png') }}" alt="وزارة التكوين والتعليم المهنيين" class="h-8 sm:h-11 w-auto object-contain">
        </div>

        <!-- Language Switcher Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" @click.outside="open = false" type="button" class="bg-white/95 backdrop-blur-xl px-3.5 py-2.5 rounded-2xl text-xs font-black text-[#0B2A6F] hover:bg-white transition flex items-center gap-2 shadow-lg shadow-slate-200/50 border border-white/80 ring-1 ring-slate-200/60 group">
                <svg class="w-4 h-4 text-[#35A536] group-hover:rotate-12 transition transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m6 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                <span class="uppercase font-mono font-black text-xs text-[#0066FF] tracking-wider">{{ app()->getLocale() }}</span>
                <svg class="w-3.5 h-3.5 text-slate-400 group-hover:text-slate-700 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>

            <!-- Language Switcher Menu -->
            <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200 transform" x-transition:enter-start="opacity-0 scale-95 -translate-y-2" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-150 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 -translate-y-2" class="absolute top-full end-0 mt-2 w-44 rounded-2xl bg-white text-[#0B2A6F] shadow-2xl border border-slate-200/80 py-2 z-50 overflow-hidden divide-y divide-slate-100">
                <a href="{{ route('lang.switch', 'ar') }}" class="flex items-center justify-between px-4 py-3 text-xs font-bold transition {{ app()->getLocale() === 'ar' ? 'bg-[#0066FF] text-white font-black' : 'hover:bg-slate-50 text-slate-700' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ app()->getLocale() === 'ar' ? 'text-white' : 'text-[#35A536]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>العربية</span>
                    </div>
                    <span class="text-[10px] font-mono {{ app()->getLocale() === 'ar' ? 'text-white' : 'text-[#F5A800]' }}">AR</span>
                </a>
                <a href="{{ route('lang.switch', 'fr') }}" class="flex items-center justify-between px-4 py-3 text-xs font-bold transition {{ app()->getLocale() === 'fr' ? 'bg-[#0066FF] text-white font-black' : 'hover:bg-slate-50 text-slate-700' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ app()->getLocale() === 'fr' ? 'text-white' : 'text-[#35A536]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Français</span>
                    </div>
                    <span class="text-[10px] font-mono {{ app()->getLocale() === 'fr' ? 'text-white' : 'text-[#F5A800]' }}">FR</span>
                </a>
                <a href="{{ route('lang.switch', 'en') }}" class="flex items-center justify-between px-4 py-3 text-xs font-bold transition {{ app()->getLocale() === 'en' ? 'bg-[#0066FF] text-white font-black' : 'hover:bg-slate-50 text-slate-700' }}">
                    <div class="flex items-center gap-2">
                        <svg class="w-3.5 h-3.5 {{ app()->getLocale() === 'en' ? 'text-white' : 'text-[#35A536]' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>English</span>
                    </div>
                    <span class="text-[10px] font-mono {{ app()->getLocale() === 'en' ? 'text-white' : 'text-[#F5A800]' }}">EN</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Card Content -->
    <main class="relative z-20 my-auto py-6 sm:py-10 px-4 sm:px-6 max-w-4xl mx-auto text-center w-full">
        <div class="bg-white/95 backdrop-blur-2xl border border-white/80 ring-1 ring-slate-200/80 shadow-2xl shadow-blue-900/10 rounded-[28px] sm:rounded-[40px] p-6 sm:p-12 space-y-8 sm:space-y-10 relative overflow-hidden">
            
            <!-- Subtle Accent Light Spheres -->
            <div class="absolute -top-20 -right-20 w-56 h-56 bg-[#0066FF]/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-20 -left-20 w-56 h-56 bg-[#35A536]/10 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Header Badge Pill -->
            <div class="inline-flex items-center gap-2.5 px-4 sm:px-6 py-2.5 rounded-full bg-blue-50/90 border border-blue-200/80 text-xs sm:text-sm font-black text-[#0066FF] shadow-xs animate-float-subtle">
                <div class="relative flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#F5A800] animate-spin" style="animation-duration: 8s;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="tracking-wide">{{ $locale === 'fr' ? 'Événement Officiel Panafricain En Préparation' : ($locale === 'en' ? 'Official Pan-African Event Preparation' : 'الحدث القاري الأفريقي قريباً بوهران') }}</span>
            </div>

            <!-- Page Title (Elevated & Crisp) -->
            <div class="space-y-4 max-w-3xl mx-auto">
                <h1 class="text-2xl sm:text-4xl lg:text-5xl font-black text-[#0B2A6F] tracking-tight leading-snug sm:leading-tight">
                    {{ $title }}
                </h1>
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
                
                <!-- Days Card (Gold Top Border Accent) -->
                <div class="countdown-card bg-gradient-to-b from-white via-slate-50/80 to-slate-100/90 p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200/90 border-t-4 border-t-[#F5A800] shadow-md flex flex-col items-center justify-center relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-12 h-12 bg-[#F5A800]/10 rounded-bl-full pointer-events-none"></div>
                    <span class="text-3xl sm:text-5xl lg:text-6xl font-black text-[#0B2A6F] font-mono tracking-tight" x-text="days">{{ $days }}</span>
                    <span class="text-xs sm:text-sm font-bold text-slate-500 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Jours' : ($locale === 'en' ? 'Days' : 'أيام') }}</span>
                </div>

                <!-- Hours Card (Green Top Border Accent) -->
                <div class="countdown-card bg-gradient-to-b from-white via-slate-50/80 to-slate-100/90 p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200/90 border-t-4 border-t-[#35A536] shadow-md flex flex-col items-center justify-center relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-12 h-12 bg-[#35A536]/10 rounded-bl-full pointer-events-none"></div>
                    <span class="text-3xl sm:text-5xl lg:text-6xl font-black text-[#35A536] font-mono tracking-tight" x-text="hours">{{ $hours }}</span>
                    <span class="text-xs sm:text-sm font-bold text-slate-500 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Heures' : ($locale === 'en' ? 'Hours' : 'ساعات') }}</span>
                </div>

                <!-- Minutes Card (Royal Blue Top Border Accent) -->
                <div class="countdown-card bg-gradient-to-b from-white via-slate-50/80 to-slate-100/90 p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200/90 border-t-4 border-t-[#0066FF] shadow-md flex flex-col items-center justify-center relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-12 h-12 bg-[#0066FF]/10 rounded-bl-full pointer-events-none"></div>
                    <span class="text-3xl sm:text-5xl lg:text-6xl font-black text-[#0066FF] font-mono tracking-tight" x-text="minutes">{{ $minutes }}</span>
                    <span class="text-xs sm:text-sm font-bold text-slate-500 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Minutes' : ($locale === 'en' ? 'Minutes' : 'دقائق') }}</span>
                </div>

                <!-- Seconds Card (Purple Top Border Accent) -->
                <div class="countdown-card bg-gradient-to-b from-white via-slate-50/80 to-slate-100/90 p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200/90 border-t-4 border-t-purple-600 shadow-md flex flex-col items-center justify-center relative overflow-hidden group">
                    <div class="absolute top-0 right-0 w-12 h-12 bg-purple-600/10 rounded-bl-full pointer-events-none"></div>
                    <span class="text-3xl sm:text-5xl lg:text-6xl font-black text-purple-600 font-mono tracking-tight" x-text="seconds">{{ $seconds }}</span>
                    <span class="text-xs sm:text-sm font-bold text-slate-500 mt-2 uppercase tracking-wider">{{ $locale === 'fr' ? 'Secondes' : ($locale === 'en' ? 'Seconds' : 'ثواني') }}</span>
                </div>
            </div>

            <!-- Venue Location Badge -->
            <div class="pt-2 flex items-center justify-center gap-2.5 text-xs sm:text-sm font-bold text-slate-800 max-w-xl mx-auto bg-emerald-50/90 border border-emerald-200/90 p-3.5 px-5 rounded-2xl shadow-xs">
                <svg class="w-5 h-5 text-[#35A536] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span class="leading-relaxed">{{ $locale === 'fr' ? '16 – 17 Novembre 2026 — Centre des Conventions Mohamed Ben Ahmed, Oran - Algérie' : ($locale === 'en' ? '16 – 17 November 2026 — Mohamed Ben Ahmed Convention Center, Oran - Algeria' : '16 – 17 نوفمبر 2026 — مركز المؤتمرات محمد بن أحمد، وهران - الجزائر') }}</span>
            </div>

        </div>
    </main>

    <!-- Footer Area -->
    <footer class="relative z-30 w-full max-w-5xl mx-auto p-4 sm:p-6 text-center text-xs font-medium text-slate-500">
        © 2026 {{ platform()->name() }}. {{ $locale === 'fr' ? 'Tous droits réservés — République Algérienne & Union Africaine' : ($locale === 'en' ? 'All rights reserved — Republic of Algeria & African Union' : 'جميع الحقوق محفوظة — الجمهورية الجزائرية الديمقراطية الشعبية ومفوضية الاتحاد الأفريقي') }}
    </footer>

    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
