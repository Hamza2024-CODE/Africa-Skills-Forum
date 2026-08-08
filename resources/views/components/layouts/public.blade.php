<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="h-full bg-[#F4F7FC]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'WorldSkills Algeria') }} — {{ $title ?? __('messages.hero_subtitle') }}</title>

    {!! app(\App\Services\SettingsEngine::class)->getDesignTokensCss() !!}

    <!-- PWA Manifest & Mobile Meta Tags -->
    <link rel="manifest" href="/manifest.webmanifest">
    <meta name="theme-color" content="#020A24">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="/icon-192.png">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script>
        (function(){const w=console.warn;console.warn=function(...a){if(a[0]&&typeof a[0]==='string'&&a[0].includes('cdn.tailwindcss.com'))return;w.apply(console,a);};})();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = {
        theme: {
          extend: {
            fontFamily: {
              sans: ['Tajawal', 'Outfit', 'sans-serif'],
            },
            colors: {
              brand: {
                50: '#F4F7FC',
                100: '#E2ECFA',
                200: '#C2D9F7',
                300: '#8FBDF0',
                400: '#4D95E6',
                500: '#0066FF',
                600: '#0052CC',
                700: '#06205C',
                800: '#041235',
                900: '#020A24',
                sky: '#00B8FF',
                dark: '#06205C',
                bg: '#F4F7FC',
                muted: '#64748B'
              }
            }
          }
        }
      }
    </script>
    
    <!-- AOS Animation Library CDN -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

    <style>
        .wsap-glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .wsap-hover-card {
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }
        .wsap-hover-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 25px 35px -5px rgba(0, 102, 255, 0.2), 0 10px 15px -5px rgba(0, 102, 255, 0.08);
        }

        /* Floating Slow Animation */
        @keyframes floatSlow {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-8px) rotate(1deg); }
        }
        .wsap-float-slow {
            animation: floatSlow 6s ease-in-out infinite;
        }

        /* Shimmer Ambient Glow Pulse */
        @keyframes ambientPulse {
            0%, 100% { opacity: 0.4; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.15); }
        }
        .wsap-ambient-pulse {
            animation: ambientPulse 4s ease-in-out infinite;
        }

        @media (prefers-reduced-motion: reduce) {
            *, ::before, ::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
                scroll-behavior: auto !important;
            }
        }
        .touch-target {
            min-height: 44px;
            min-width: 44px;
        }
    </style>

    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    @livewireStyles
</head>
<body x-data="{ pwaUpdateAvailable: false, swWaiting: null }" x-init="
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js').then((reg) => {
            if (reg.waiting) {
                swWaiting = reg.waiting;
                pwaUpdateAvailable = true;
            }
            reg.addEventListener('updatefound', () => {
                const newWorker = reg.installing;
                newWorker.addEventListener('statechange', () => {
                    if (newWorker.state === 'installed' && navigator.serviceWorker.controller) {
                        swWaiting = newWorker;
                        pwaUpdateAvailable = true;
                    }
                });
            });
        });

        let refreshing = false;
        navigator.serviceWorker.addEventListener('controllerchange', () => {
            if (!refreshing) {
                refreshing = true;
                window.location.reload();
            }
        });
    }
" class="font-sans antialiased h-full flex flex-col text-[#06205C] bg-[#F4F7FC] relative">

    <!-- Controlled PWA Update Notification Banner -->
    <div x-show="pwaUpdateAvailable" x-cloak class="fixed bottom-6 left-6 right-6 md:left-auto md:right-6 md:max-w-md z-50 bg-[#020A24] text-white rounded-2xl p-4 shadow-2xl border border-brand-sky/40 flex items-center justify-between gap-4 animate-bounce">
        <div class="flex items-center gap-3">
            <span class="w-3 h-3 rounded-full bg-brand-sky animate-ping"></span>
            <div class="text-xs font-bold">
                <span class="block text-slate-200">
                    {{ app()->getLocale() === 'fr' ? 'Mise à jour disponible' : (app()->getLocale() === 'en' ? 'New update available' : 'تحديث جديد لمنصة WSAP متوفر') }}
                </span>
                <span class="text-[10px] text-slate-400 font-medium">
                    {{ app()->getLocale() === 'fr' ? 'Cliquez pour mettre à jour la plateforme' : (app()->getLocale() === 'en' ? 'Click to update platform' : 'اضغط لتحديث المنصة بآخر المميزات') }}
                </span>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button @click="if (swWaiting) { swWaiting.postMessage({ type: 'SKIP_WAITING' }); }" class="px-4 py-2 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white text-xs font-bold transition shadow-md">
                {{ app()->getLocale() === 'fr' ? 'Mettre à jour' : (app()->getLocale() === 'en' ? 'Update Now' : 'تحديث الآن') }}
            </button>
            <button @click="pwaUpdateAvailable = false" class="text-slate-400 hover:text-white p-1 text-xs font-bold">
                ✕
            </button>
        </div>
    </div>

    <!-- Modular Top Header Navigation Component -->
    <x-navbar />

    <!-- Page Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Modular Dark Deep Blue Footer Component -->
    <x-footer />

    <!-- Dynamic Scroll Mascot Popup Widget (WorldSkills Algeria Mascot 2026) -->
    <div x-data="{ 
            showMascot: false, 
            dismissed: false,
            mobileNavOpen: false,
            init() {
                window.addEventListener('scroll', () => {
                    if (this.dismissed) return;
                    const scrollPos = window.innerHeight + window.scrollY;
                    const totalHeight = document.documentElement.scrollHeight;
                    if (scrollPos >= totalHeight - 950) {
                        this.showMascot = true;
                    }
                });
                window.addEventListener('mobile-menu-toggled', (e) => {
                    this.mobileNavOpen = !!e.detail;
                });
            }
         }"
         x-show="showMascot && !dismissed && !mobileNavOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-700 transform"
         x-transition:enter-start="translate-y-32 opacity-0 scale-75 rotate-12"
         x-transition:enter-end="translate-y-0 opacity-100 scale-100 rotate-0"
         x-transition:leave="transition ease-in duration-500 transform"
         x-transition:leave-start="translate-y-0 opacity-100 scale-100"
         x-transition:leave-end="translate-y-32 opacity-0 scale-75"
         class="fixed bottom-3 start-3 sm:bottom-6 sm:start-6 z-40 flex items-end gap-2 sm:gap-3 pointer-events-auto max-w-[88vw] sm:max-w-sm">

        <!-- Speech Bubble Card -->
        <div class="bg-white/95 backdrop-blur-xl p-3 sm:p-4 rounded-2xl sm:rounded-3xl shadow-2xl border-2 border-blue-500/30 text-slate-900 space-y-1.5 sm:space-y-2 relative transform -rotate-1 group hover:rotate-0 transition-transform">
            
            <!-- Close Button -->
            <button @click="dismissed = true" class="absolute -top-2 -end-2 w-6 h-6 sm:w-7 sm:h-7 rounded-full bg-slate-900 text-white flex items-center justify-center text-[10px] sm:text-xs font-black shadow-md hover:bg-red-600 transition" title="إغلاق">
                ✕
            </button>

            <!-- Mascot Badge Header -->
            <div class="flex items-center gap-1.5 sm:gap-2">
                <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 rounded-full bg-[#0066FF] animate-ping"></span>
                <span class="text-[9px] sm:text-[10px] font-black text-[#0066FF] uppercase tracking-wider">
                    ✦ {{ app()->getLocale() === 'fr' ? 'Mascotte Officielle 2026' : (app()->getLocale() === 'en' ? 'Official Mascot 2026' : 'تعويذة أولمبياد المهن 2026') }}
                </span>
            </div>

            <!-- Welcome Text Message -->
            <p class="text-[11px] sm:text-xs font-bold text-[#06205C] leading-snug sm:leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Bienvenue aux Olympiades Africaines des Métiers 2026 ! L\'Algérie vous accueille.' : (app()->getLocale() === 'en' ? 'Welcome to the African WorldSkills Competition 2026!' : 'أهلاً بكم في أولمبياد المهن إفريقيا 2026! الجزائر ترحب بجميع المتنافسين والوفود المشاركة.') }}
            </p>

            <!-- Interactive Quick Link Button -->
            <a href="{{ route('skills') }}" class="inline-flex items-center gap-1.5 px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-xl bg-gradient-to-r from-[#0066FF] to-[#00A3FF] text-white text-[10px] sm:text-[11px] font-black shadow-md hover:shadow-lg transition hover:scale-105">
                <span>{{ __('messages.skills') }}</span>
                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>

            <!-- Tail Pointer -->
            <div class="absolute -bottom-2 start-6 sm:start-8 w-3.5 h-3.5 sm:w-4 sm:h-4 bg-white border-r border-b border-blue-500/30 transform rotate-45"></div>
        </div>

        <!-- High-Res Floating Mascot Image Portrait -->
        <div class="w-16 sm:w-32 md:w-36 h-auto flex-shrink-0 relative group filter drop-shadow-2xl wsap-float-slow cursor-pointer" @click="showMascot = true">
            <img src="/images/mascot.png" alt="WorldSkills Algeria Mascot 2026" class="w-full h-auto object-contain transform group-hover:scale-110 transition-transform duration-300">
        </div>
    </div>

    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 900,
                    easing: 'ease-out-cubic',
                    once: false,
                    mirror: true,
                    offset: 80
                });
            }
        });
        document.addEventListener('livewire:navigated', function() {
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        });
    </script>
</body>
</html>
