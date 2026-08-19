@php
    $isMaintenance = app(\App\Services\SettingsEngine::class)->get('maintenance_mode') === 'true';
    $isAdmin = auth()->check() && (auth()->user()->hasRole(\App\Enums\RoleEnum::SUPER_ADMIN->value) || auth()->user()->hasRole(\App\Enums\RoleEnum::COUNTRY_ADMIN->value) || auth()->user()->hasRole(\App\Enums\RoleEnum::MEDIA_MANAGER->value));
@endphp

@if($isMaintenance && !$isAdmin)
    @include('public.coming-soon')
    @php exit; @endphp
@endif

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}" class="h-full bg-[#F4F7FC]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ platform()->name() }} — {{ $title ?? __('messages.hero_subtitle') }}</title>

    {!! app(\App\Services\SettingsEngine::class)->getDesignTokensCss() !!}

    <!-- PWA Manifest & Mobile Meta Tags -->
    <link rel="manifest" href="/manifest.webmanifest">
    <link rel="icon" type="image/png" sizes="192x192" href="/icon-192.png">
    <link rel="icon" type="image/png" sizes="512x512" href="/icon-512.png">
    <link rel="apple-touch-icon" href="/icon-192.png">
    <meta name="theme-color" content="#020A24">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <script>
        window.deferredPwaPrompt = null;
        window.addEventListener('beforeinstallprompt', function(e) {
            e.preventDefault();
            window.deferredPwaPrompt = e;
        });
    </script>
    
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
              navy: '#0B2A6F',
              green: '#35A536',
              gold: '#F5A800',
              brand: {
                50: '#F4F7FC',
                100: '#E2ECFA',
                200: '#C2D9F7',
                300: '#8FBDF0',
                400: '#35A536',
                500: '#0B2A6F',
                600: '#071E52',
                700: '#05153B',
                800: '#030D26',
                900: '#020718',
                navy: '#0B2A6F',
                green: '#35A536',
                gold: '#F5A800',
                sky: '#35A536',
                dark: '#0B2A6F',
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
        [x-cloak] { display: none !important; }

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

        /* ── Global Mobile Responsiveness Engine ── */
        html, body {
            max-width: 100vw;
            overflow-x: hidden !important;
            -webkit-tap-highlight-color: transparent;
            touch-action: manipulation;
        }

        img, svg, video, iframe {
            max-width: 100%;
            height: auto;
        }

        .touch-target {
            min-height: 44px;
            min-width: 44px;
        }

        /* Mobile Specific Overrides */
        @media (max-width: 640px) {
            .container, .max-w-7xl, .max-w-6xl, .max-w-5xl, .max-w-4xl, .max-w-3xl, .max-w-2xl {
                padding-left: 0.85rem !important;
                padding-right: 0.85rem !important;
            }
            h1 { font-size: 1.65rem !important; line-height: 1.25 !important; }
            h2 { font-size: 1.35rem !important; line-height: 1.3 !important; }
            h3 { font-size: 1.15rem !important; line-height: 1.35 !important; }
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

    @if($isMaintenance && $isAdmin)
        <div class="bg-amber-500 text-slate-950 px-4 py-2 text-xs font-black text-center shadow-lg sticky top-0 z-50 flex items-center justify-center gap-3">
            <span>⚠️ {{ app()->getLocale() === 'fr' ? 'Le mode "Bientôt disponible" (Maintenance) est activé pour les visiteurs.' : (app()->getLocale() === 'en' ? 'Maintenance / Coming Soon Mode is currently ACTIVE for visitors.' : 'وضع "انتظرونا قريباً / الصيانة" مفعّل حالياً لزوار الواجهة العامة.') }}</span>
            <a href="{{ route('admin.appearance') }}" class="px-3 py-1 rounded-lg bg-slate-950 text-amber-400 font-bold hover:bg-slate-900 transition">
                {{ app()->getLocale() === 'fr' ? 'Désactiver' : (app()->getLocale() === 'en' ? 'Manage' : 'إدارة أو إيقاف التفعيل') }}
            </a>
        </div>
    @endif

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
    <main class="flex-grow pb-16 md:pb-0">
        {{ $slot }}
    </main>

    <!-- Modular Dark Deep Blue Footer Component -->
    <x-footer />

    <!-- Native Smartphone Mobile App Bottom Tab Bar Navigation -->
    <x-mobile-bottom-nav />

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
                <span class="text-[9px] sm:text-[10px] font-black text-[#0B2A6F] uppercase tracking-wider">
                    ✦ {{ app()->getLocale() === 'fr' ? 'Mascotte Officielle 2026' : (app()->getLocale() === 'en' ? 'Official Mascot 2026' : 'رمز التميز والمهارات 2026') }}
                </span>
            </div>

            <!-- Welcome Text Message -->
            <p class="text-[11px] sm:text-xs font-bold text-[#0B2A6F] leading-snug sm:leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Bienvenue au Forum Africa Skills Forum 2026 ! L\'Algérie vous accueille à Oran.' : (app()->getLocale() === 'en' ? 'Welcome to Africa Skills Forum 2026! Algeria welcomes all delegations.' : 'أهلاً بكم في منتدى المهارات الإفريقية 2026! الجزائر ترحب بجميع الوفود والمشاركين بوهران.') }}
            </p>

            <!-- Interactive Quick Link Button -->
            <a href="{{ route('guide') }}" class="inline-flex items-center gap-1.5 px-3 py-1 sm:px-3.5 sm:py-1.5 rounded-xl bg-gradient-to-r from-[#0B2A6F] to-[#35A536] text-white text-[10px] sm:text-[11px] font-black shadow-md hover:shadow-lg transition hover:scale-105">
                <span>{{ __('messages.guide') }}</span>
                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>

            <!-- Tail Pointer -->
            <div class="absolute -bottom-2 start-6 sm:start-8 w-3.5 h-3.5 sm:w-4 sm:h-4 bg-white border-r border-b border-blue-500/30 transform rotate-45"></div>
        </div>

        <!-- High-Res Floating Mascot Image Portrait -->
        <div class="w-16 sm:w-32 md:w-36 h-auto flex-shrink-0 relative group filter drop-shadow-2xl wsap-float-slow cursor-pointer" @click="showMascot = true">
            <img src="/images/mascot.png" alt="Africa Skills Forum Mascot 2026" class="w-full h-auto object-contain transform group-hover:scale-110 transition-transform duration-300">
        </div>
    </div>

    @livewireScripts
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof AOS !== 'undefined') {
                AOS.init({
                    duration: 600,
                    easing: 'ease-out-cubic',
                    once: true,
                    mirror: false,
                    offset: 40,
                    disable: function() {
                        return window.innerWidth < 768; // Disable AOS scroll animations on mobile to prevent Android Chrome address-bar flicker loops
                    }
                });
            }
        });
        document.addEventListener('livewire:navigated', function() {
            if (typeof AOS !== 'undefined') {
                AOS.refresh();
            }
        });
    </script>
    <x-pwa-installer />
    <x-cookie-consent />
    <x-push-notifications />

    <!-- Global Dynamic Interactive Mouse Ambient Light Aura (Desktop Only) -->
    <div id="asf-cursor-spotlight" class="pointer-events-none fixed top-0 left-0 w-64 h-64 -ml-32 -mt-32 rounded-full z-30 transition-transform duration-150 ease-out opacity-0 hidden md:block" style="will-change: transform;">
        <div class="w-full h-full rounded-full bg-gradient-to-r from-[#0B2A6F]/10 via-[#35A536]/12 to-[#F5A800]/8 blur-2xl"></div>
    </div>

    <script>
        (function initMouseSpotlight() {
            if (window.innerWidth < 768 || 'ontouchstart' in window) return;
            var el = document.getElementById('asf-cursor-spotlight');
            if (!el) return;
            var reqId = null;
            var mouseX = 0, mouseY = 0;
            var isMoving = false;

            function updatePos() {
                if (el) {
                    el.style.transform = 'translate3d(' + mouseX + 'px, ' + mouseY + 'px, 0)';
                }
                reqId = null;
            }

            window.addEventListener('mousemove', function(e) {
                mouseX = e.clientX;
                mouseY = e.clientY;
                if (!isMoving) {
                    isMoving = true;
                    el.style.opacity = '1';
                }
                if (!reqId) {
                    reqId = requestAnimationFrame(updatePos);
                }
            }, { passive: true });

            document.addEventListener('mouseleave', function() {
                if (el) el.style.opacity = '0';
                isMoving = false;
            });
        })();
    </script>
</body>
</html>
