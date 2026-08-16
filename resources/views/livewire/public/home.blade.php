<div class="space-y-12 pb-16" x-data="{ showVideoModal: false }">
    @php
        $activeEvent = $activeEvent ?? null;
        $stats = $stats ?? [];
        $countdownEnabled = $countdownEnabled ?? true;
        $countdownStatus = $countdownStatus ?? 'COUNTDOWN';
        $countdownTargetDate = $countdownTargetDate ?? '2026-09-15 09:00:00';

        // — Dynamic Hero Slides from Admin GlobalSettings —
        // Admin can upload/change via: global_settings -> hero_slide_1 to hero_slide_5
        $heroSlides = collect([
            platform()->get('hero_slide_1', '/images/hero_slide_1.png'),
            platform()->get('hero_slide_2', '/images/hero_slide_2.png'),
            platform()->get('hero_slide_3', '/images/hero_slide_3.png'),
            platform()->get('hero_slide_4', ''),
            platform()->get('hero_slide_5', ''),
        ])->filter(fn($s) => !empty($s))->values()->all();
    @endphp
    
    @php
        // Pre-compute for clean JS output — avoids quote conflicts inside x-data=""
        $heroSlidesJson = json_encode(
            array_map(fn($s) => url($s), $heroSlides)
        );
        $heroMode = platform()->get('hero_bg_mode', 'slider');
    @endphp

    <!-- 1. Pan-African Summit Hero Stage (Ultra-Modern African Leadership Aesthetic & Auto-Slider) -->
    <section class="relative bg-gradient-to-br from-[#0B2A6F] via-[#081F54] to-[#040E26] text-white pt-16 pb-24 px-4 sm:px-6 lg:px-8 overflow-hidden rounded-b-[3.5rem] border-b-2 border-[#35A536]/40 shadow-2xl"
             x-data="{
                 activeSlide: 0,
                 slides: {{ $heroSlidesJson }},
                 heroMode: '{{ $heroMode }}',
                 init() {
                     if (this.slides.length > 1) {
                         setInterval(() => {
                             this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                         }, 5000);
                     }
                 }
             }">
        
        <!-- Background Layer: Auto-Sliding Image Carousel & Video Switcher -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            
            <template x-if="heroMode === 'video'">
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[180vw] h-[180vh] min-w-[177.77vh] min-h-[56.25vw] opacity-75">
                    <iframe class="w-full h-full pointer-events-none object-cover" 
                            src="{{ $featuredVideoUrl ?? 'https://www.youtube.com/embed/ee7fzNFUKIM' }}?autoplay=1&mute=1&controls=0&loop=1&playlist=ee7fzNFUKIM&playsinline=1" 
                            title="Background Video" 
                            frameborder="0" 
                            allow="autoplay; encrypted-media"></iframe>
                </div>
            </template>

            <!-- Auto Sliding High-Definition Image Layers with Ken Burns Smooth Transition -->
            <template x-for="(slide, index) in slides" :key="index">
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                     :class="activeSlide === index ? 'opacity-90 scale-105' : 'opacity-0 scale-100'"
                     style="transition: opacity 1.2s ease-in-out, transform 6s ease-out;">
                    <img :src="slide" alt="Africa Skills Forum Stage" class="w-full h-full object-cover object-center filter brightness-90">
                </div>
            </template>

            <!-- Elegant Cinematic Gradient Overlay for Maximum Text Readability -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#0B2A6F] via-[#0B2A6F]/60 to-black/40"></div>
        </div>

        <!-- Slide Navigation Indicators (Bottom Left) -->
        <div class="absolute bottom-6 left-8 z-20 flex items-center gap-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        class="h-2 rounded-full transition-all duration-500 cursor-pointer"
                        :class="activeSlide === index ? 'w-8 bg-[#F5A800] shadow-md' : 'w-2 bg-white/40 hover:bg-white/70'"></button>
            </template>
        </div>

        <!-- Dynamic Ambient Beams in Logo Green & Gold -->
        <div class="absolute -top-24 -left-24 w-[32rem] h-[32rem] bg-[#35A536]/30 rounded-full blur-3xl pointer-events-none animate-pulse"></div>
        <div class="absolute -bottom-24 -right-24 w-[32rem] h-[32rem] bg-[#F5A800]/25 rounded-full blur-3xl pointer-events-none animate-pulse"></div>

        <div class="max-w-7xl mx-auto relative z-10 space-y-8 text-right">

            <!-- Title & Subtitle Card with Glass Text Effect -->
            <div class="space-y-4 max-w-4xl">
                
                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.15] text-white drop-shadow-[0_4px_25px_rgba(0,0,0,0.9)]">
                    {{ $activeEvent ? $activeEvent->getLocalized('title') : platform()->get('hero_title', 'افتتاح منتدى المهارات الإفريقية 2026') }}
                    <span class="text-[#F5A800] block mt-1">Africa Skills Forum 2026</span>
                </h1>

                <p class="text-sm sm:text-lg text-slate-100 font-bold leading-relaxed max-w-2xl drop-shadow-[0_2px_12px_rgba(0,0,0,0.9)]">
                    @if($activeEvent)
                        {{ $activeEvent->getLocalized('summary') }}
                    @elseif(app()->getLocale() === 'fr')
                        {{ platform()->get('home_hero_subtitle_fr', 'Rassemblement des délégations nationales et internationales au Centre des Conventions Mohamed Ben Ahmed à Oran.') }}
                    @elseif(app()->getLocale() === 'en')
                        {{ platform()->get('home_hero_subtitle_en', 'Gathering of national and international delegations at Mohamed Ben Ahmed Convention Center, Oran.') }}
                    @else
                        {{ platform()->get('home_hero_subtitle_ar', 'تجمع الوفود الوطنية والدولية والخبراء بمركز المؤتمرات محمد بن أحمد بولاية وهران.') }}
                    @endif
                </p>

            </div>


            <!-- Action Buttons with Smooth Hover Animations -->
            <div class="flex flex-wrap items-center gap-4 pt-2">
                <a href="{{ route('registration') }}" class="px-8 py-4 rounded-2xl bg-[#F5A800] hover:bg-amber-400 text-[#0B2A6F] font-black text-sm shadow-[0_0_30px_rgba(245,168,0,0.5)] transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 flex items-center gap-2.5 group">
                    <svg class="w-5 h-5 text-[#0B2A6F] group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>{{ __('messages.register_now') }}</span>
                </a>
                <a href="{{ route('guide') }}" class="px-8 py-4 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-extrabold text-sm border border-white/30 shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 flex items-center gap-2.5 group">
                    <svg class="w-5 h-5 text-[#35A536] group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ __('messages.explore_more') }}</span>
                </a>
            </div>

            <!-- Embedded Hero Stat Badges with Pure Vector SVG Icons (No Emojis) -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-6 max-w-3xl">
                <!-- Stat 1: Nations -->
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center gap-3.5 shadow-lg hover:-translate-y-1 hover:bg-white/15 transition-all duration-300 group">
                    <div class="w-10 h-10 rounded-xl bg-[#F5A800]/20 border border-[#F5A800]/50 text-[#F5A800] flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 012 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V14m-3 7c9 0 9-9 9-9s-9 0-9 9z"/></svg>
                    </div>
                    <div>
                        <div class="text-lg font-black text-white">54+ {{ app()->getLocale() === 'fr' ? 'pays' : (app()->getLocale() === 'en' ? 'nations' : 'دولة') }}</div>
                        <div class="text-[11px] text-blue-100 font-medium">{{ app()->getLocale() === 'fr' ? 'Délégations africaines & internationales' : (app()->getLocale() === 'en' ? 'African & international delegations' : 'وفود إفريقية ودولية') }}</div>
                    </div>
                </div>

                <!-- Stat 2: Delegates & Experts -->
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center gap-3.5 shadow-lg hover:-translate-y-1 hover:bg-white/15 transition-all duration-300 group">
                    <div class="w-10 h-10 rounded-xl bg-[#35A536]/20 border border-[#35A536]/50 text-[#35A536] flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <div class="text-lg font-black text-white">500+ {{ app()->getLocale() === 'fr' ? 'participants' : (app()->getLocale() === 'en' ? 'participants' : 'مشارك') }}</div>
                        <div class="text-[11px] text-blue-100 font-medium">{{ app()->getLocale() === 'fr' ? 'Experts & juges continentaux' : (app()->getLocale() === 'en' ? 'Continental experts & judges' : 'خبراء ومحكّمون قاريون') }}</div>
                    </div>
                </div>

                <!-- Stat 3: Venue CCO Oran -->
                <div class="p-4 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 flex items-center gap-3.5 shadow-lg hover:-translate-y-1 hover:bg-white/15 transition-all duration-300 group">
                    <div class="w-10 h-10 rounded-xl bg-white/20 border border-white/40 text-white flex items-center justify-center shrink-0 group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6m-6 0V10m6 11V10m-6 0a2 2 0 012-2h2a2 2 0 012 2m-6 0V6a2 2 0 012-2h2a2 2 0 012 2v4"/></svg>
                    </div>
                    <div>
                        <div class="text-lg font-black text-white">CCO {{ app()->getLocale() === 'fr' ? 'Oran' : (app()->getLocale() === 'en' ? 'Oran' : 'وهران') }}</div>
                        <div class="text-[11px] text-blue-100 font-medium">{{ app()->getLocale() === 'fr' ? 'Centre International des Conférences' : (app()->getLocale() === 'en' ? 'International Convention Center' : 'مركز المؤتمرات الدولي') }}</div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- 2. Africa Skills Forum Official Event Dashboard & Countdown Stage (Animated & Interactive) -->
    @if(platform()->get('countdown_enabled', true) && $countdownStatus !== 'DISABLED')

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-8 relative" 
             wire:ignore 
             id="wsap-countdown-widget" 
             data-target-timestamp="{{ strtotime($countdownTargetDate ?? '2026-09-15 09:00:00') * 1000 }}"
             data-flip-anim="{{ $countdownFlipAnimation ? '1' : '0' }}">
        
        <!-- Outer Dashboard Light Container Card with Subtle Dynamic Mesh -->
        <div class="rounded-3xl bg-gradient-to-br from-[#F8FAFC] via-[#F1F5F9] to-[#E2E8F0] p-6 sm:p-10 shadow-2xl border border-slate-200 text-slate-900 space-y-8 relative overflow-hidden group/dashboard">
            
            <!-- Dynamic Background Ambient Lighting Orbs -->
            <div class="absolute -top-32 -left-32 w-80 h-80 bg-[#35A536]/15 rounded-full blur-3xl pointer-events-none group-hover/dashboard:scale-125 transition-transform duration-1000"></div>
            <div class="absolute -bottom-32 -right-32 w-80 h-80 bg-[#F5A800]/15 rounded-full blur-3xl pointer-events-none group-hover/dashboard:scale-125 transition-transform duration-1000"></div>

            <!-- Top Row: Left Text/Info + Right Tech Map Illustration -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                
                <!-- Left Side (RTL Info) -->
                <div class="lg:col-span-7 space-y-4 text-right">
                    
                    <!-- Subtitle -->
                    <div class="inline-flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#35A536] animate-ping"></span>
                        <h4 class="text-base sm:text-lg font-black text-slate-700 uppercase tracking-wide">
                            {{ app()->getLocale() === 'fr' ? 'ÉVÉNEMENT À VENIR // UPCOMING' : (app()->getLocale() === 'en' ? 'UPCOMING EVENT // NEXT STAGE' : 'الحدث القادم // UPCOMING STAGE') }}
                        </h4>
                    </div>

                    <!-- Main Heading -->
                    <h2 class="text-2xl sm:text-4xl font-black text-[#0B2A6F] leading-tight tracking-tight drop-shadow-xs">
                        @if(app()->getLocale() === 'fr')
                            {{ $countdownTitleFr }}
                        @elseif(app()->getLocale() === 'en')
                            {{ $countdownTitleEn }}
                        @else
                            {{ $countdownTitleAr }}
                        @endif
                    </h2>

                    <!-- Venue Pill Badge with Hover Glow -->
                    <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-2xl bg-white/90 backdrop-blur-md border border-slate-200 shadow-sm text-slate-700 text-xs font-bold hover:shadow-md hover:border-[#0B2A6F]/30 hover:-translate-y-0.5 transition-all duration-300">
                        <svg class="w-4 h-4 text-[#0B2A6F] shrink-0 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? platform()->get('venue_name_fr', 'Centre des Conventions Mohamed Ben Ahmed (CCO) — Oran, Algérie') : (app()->getLocale() === 'en' ? platform()->get('venue_name_en', 'Mohamed Ben Ahmed Convention Center (CCO) — Oran, Algeria') : platform()->get('venue_name', 'مركز المؤتمرات محمد بن أحمد (CCO) — وهران، الجزائر')) }}</span>
                    </div>

                </div>

                <!-- Right Side: Tech Orbital Africa Map Badge with Spin & Float -->
                <div class="lg:col-span-5 flex justify-center">
                    <div class="relative w-64 h-64 sm:w-80 sm:h-80 flex items-center justify-center group/map">
                        <!-- Dual Orbital Radar Rings with Spin Animation -->
                        <div class="absolute inset-0 rounded-full border-2 border-[#35A536]/30 animate-spin pointer-events-none" style="animation-duration: 25s;"></div>
                        <div class="absolute inset-3 rounded-full border border-dashed border-[#F5A800]/50 animate-spin pointer-events-none" style="animation-duration: 15s; animation-direction: reverse;"></div>
                        <div class="absolute inset-8 rounded-full bg-gradient-to-tr from-emerald-100/60 via-white to-blue-50/60 shadow-xl flex items-center justify-center p-6 border border-white group-hover/map:scale-105 group-hover/map:rotate-3 transition-all duration-700">
                            <img src="/AFRICA.png" alt="{{ platform()->name() }}" class="w-full h-full object-contain filter drop-shadow-2xl">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Middle Row: 4 Symmetric Counter Cards + Date Card -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch relative z-10">

                <!-- Left: 4 Perfectly Symmetric Counter Cards -->
                <div class="lg:col-span-8 bg-white/90 backdrop-blur-md rounded-3xl p-5 sm:p-6 shadow-xl border border-slate-200">
                    <div class="grid grid-cols-4 gap-3 h-full">

                        <!-- DAYS — Gold -->
                        <div class="flex flex-col items-center justify-between gap-3 p-4 rounded-2xl bg-amber-50 border border-amber-200 hover:border-amber-400 hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 group/cd cursor-default">
                            <div class="w-9 h-9 rounded-xl bg-[#F5A800]/15 flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="text-4xl sm:text-5xl font-black font-mono text-[#F5A800] leading-none group-hover/cd:scale-105 transition-transform tabular-nums" id="cd-days">
                                {{ str_pad($eventCountdown['days'] ?? 104, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="text-[11px] font-black text-slate-600 uppercase tracking-widest">
                                {{ app()->getLocale() === 'fr' ? 'JOUR' : (app()->getLocale() === 'en' ? 'DAY' : 'يوم') }}
                            </div>
                            <div class="w-full h-1.5 bg-amber-100 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-[#F5A800] to-amber-400 h-full rounded-full" style="width:80%"></div>
                            </div>
                        </div>

                        <!-- HOURS — Green -->
                        <div class="flex flex-col items-center justify-between gap-3 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 hover:border-emerald-400 hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 group/cd cursor-default">
                            <div class="w-9 h-9 rounded-xl bg-[#35A536]/15 flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="text-4xl sm:text-5xl font-black font-mono text-[#35A536] leading-none group-hover/cd:scale-105 transition-transform tabular-nums" id="cd-hours">
                                {{ str_pad($eventCountdown['hours'] ?? 7, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="text-[11px] font-black text-slate-600 uppercase tracking-widest">
                                {{ app()->getLocale() === 'fr' ? 'HEURE' : (app()->getLocale() === 'en' ? 'HOUR' : 'ساعة') }}
                            </div>
                            <div class="w-full h-1.5 bg-emerald-100 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-[#35A536] to-emerald-400 h-full rounded-full" style="width:60%"></div>
                            </div>
                        </div>

                        <!-- MINUTES — Navy -->
                        <div class="flex flex-col items-center justify-between gap-3 p-4 rounded-2xl bg-blue-50 border border-blue-200 hover:border-blue-400 hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 group/cd cursor-default">
                            <div class="w-9 h-9 rounded-xl bg-[#0B2A6F]/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#0B2A6F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="text-4xl sm:text-5xl font-black font-mono text-[#0B2A6F] leading-none group-hover/cd:scale-105 transition-transform tabular-nums" id="cd-minutes">
                                {{ str_pad($eventCountdown['minutes'] ?? 14, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="text-[11px] font-black text-slate-600 uppercase tracking-widest">
                                {{ app()->getLocale() === 'fr' ? 'MIN' : (app()->getLocale() === 'en' ? 'MIN' : 'دقيقة') }}
                            </div>
                            <div class="w-full h-1.5 bg-blue-100 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-[#0B2A6F] to-blue-500 h-full rounded-full" style="width:75%"></div>
                            </div>
                        </div>

                        <!-- SECONDS — Pulsing Green -->
                        <div class="flex flex-col items-center justify-between gap-3 p-4 rounded-2xl bg-emerald-50 border border-emerald-300 hover:border-[#35A536] hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 group/cd cursor-default">
                            <div class="w-9 h-9 rounded-xl bg-[#35A536]/15 flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#35A536] animate-spin" style="animation-duration:3s" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div class="text-4xl sm:text-5xl font-black font-mono text-[#35A536] leading-none animate-pulse tabular-nums" id="cd-seconds">
                                {{ str_pad($eventCountdown['seconds'] ?? 36, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="text-[11px] font-black text-[#35A536] uppercase tracking-widest">
                                {{ app()->getLocale() === 'fr' ? 'SEC' : (app()->getLocale() === 'en' ? 'SEC' : 'ثانية') }}
                            </div>
                            <div class="w-full h-1.5 bg-emerald-200 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-[#35A536] to-emerald-400 h-full w-full rounded-full animate-pulse"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Dark Event Date Card with Hover Glow -->
                <div class="lg:col-span-4 bg-gradient-to-br from-[#0B2A6F] via-[#081F54] to-[#040E26] text-white rounded-3xl p-6 shadow-2xl flex flex-col justify-between text-center space-y-4 border border-[#35A536]/40 hover:-translate-y-1.5 hover:shadow-[0_0_30px_rgba(11,42,111,0.5)] transition-all duration-300 group/date">
                    <div class="space-y-2">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 mx-auto flex items-center justify-center border border-white/20 shadow-md group-hover/date:rotate-12 transition-transform duration-500">
                            <svg class="w-6 h-6 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-3xl sm:text-4xl font-black tracking-tight text-white drop-shadow-md">
                            <span dir="ltr" class="inline-block font-mono">16 - 21</span>
                        </h3>
                        <p class="text-base font-black text-[#35A536]">{{ app()->getLocale() === 'fr' ? 'Novembre 2026' : (app()->getLocale() === 'en' ? 'November 2026' : 'نوفمبر 2026') }}</p>
                    </div>

                    <div class="pt-3 border-t border-white/15 text-xs font-black text-amber-300/90 tracking-wide">
                        {{ app()->getLocale() === 'fr' ? '6 jours d\'excellence et créativité africaine' : (app()->getLocale() === 'en' ? '6 days of African excellence & creativity' : '6 أيام من التميز والإبداع الإفريقي') }}
                    </div>
                </div>

            </div>

            <!-- Bottom Row: Event Timeline Stepper + About Forum Card -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pt-2 relative z-10">
                
                <!-- Left Event Timeline Stepper with Interactive Connecting Line (8 cols) -->
                <div class="lg:col-span-8 bg-white/90 backdrop-blur-md rounded-3xl p-6 shadow-xl border border-slate-200 space-y-5">
                    <div class="flex items-center justify-between">
                        <h4 class="text-base font-black text-[#0B2A6F] flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Étapes Clés de l\'Événement' : (app()->getLocale() === 'en' ? 'Key Event Stages' : 'مراحل الحدث الرئيسية') }}</span>
                        </h4>
                        <span class="text-xs font-bold text-slate-400">{{ app()->getLocale() === 'fr' ? '4 étapes officielles' : (app()->getLocale() === 'en' ? '4 official stages' : '4 محطات رسمية') }}</span>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 relative pt-2">
                        <!-- Horizontal Laser Connecting Line -->
                        <div class="hidden sm:block absolute top-8 left-8 right-8 h-1 bg-slate-100 -z-0 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-[#35A536] via-[#0B2A6F] to-[#F5A800] h-full w-full rounded-full animate-pulse"></div>
                        </div>

                        <!-- Step 1 -->
                        <div class="text-center space-y-2 relative z-10 group/step cursor-pointer">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#35A536] border-2 border-emerald-300 flex items-center justify-center mx-auto shadow-md group-hover/step:-translate-y-1.5 group-hover/step:scale-110 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div class="text-xs font-black text-slate-800 group-hover/step:text-[#35A536] transition-colors">{{ app()->getLocale() === 'fr' ? 'Ouverture' : (app()->getLocale() === 'en' ? 'Opening' : 'الافتتاح') }}</div>
                            <div class="text-[11px] font-extrabold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full inline-block">16 {{ app()->getLocale() === 'fr' ? 'Nov.' : (app()->getLocale() === 'en' ? 'Nov.' : 'نوفمبر') }}</div>
                        </div>

                        <!-- Step 2 -->
                        <div class="text-center space-y-2 relative z-10 group/step cursor-pointer">
                            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-[#0B2A6F] border-2 border-blue-300 flex items-center justify-center mx-auto shadow-md group-hover/step:-translate-y-1.5 group-hover/step:scale-110 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                            </div>
                            <div class="text-xs font-black text-slate-800 group-hover/step:text-[#0B2A6F] transition-colors">{{ app()->getLocale() === 'fr' ? 'Compétitions' : (app()->getLocale() === 'en' ? 'Competitions' : 'المنافسات') }}</div>
                            <div class="text-[11px] font-extrabold text-blue-800 bg-blue-50 px-2 py-0.5 rounded-full inline-block">17 - 19 {{ app()->getLocale() === 'fr' ? 'Nov.' : (app()->getLocale() === 'en' ? 'Nov.' : 'نوفمبر') }}</div>
                        </div>

                        <!-- Step 3 -->
                        <div class="text-center space-y-2 relative z-10 group/step cursor-pointer">
                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#35A536] border-2 border-emerald-300 flex items-center justify-center mx-auto shadow-md group-hover/step:-translate-y-1.5 group-hover/step:scale-110 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            </div>
                            <div class="text-xs font-black text-slate-800 group-hover/step:text-[#35A536] transition-colors">{{ app()->getLocale() === 'fr' ? 'Finales' : (app()->getLocale() === 'en' ? 'Finals' : 'التصفيات النهائية') }}</div>
                            <div class="text-[11px] font-extrabold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full inline-block">20 {{ app()->getLocale() === 'fr' ? 'Nov.' : (app()->getLocale() === 'en' ? 'Nov.' : 'نوفمبر') }}</div>
                        </div>

                        <!-- Step 4 -->
                        <div class="text-center space-y-2 relative z-10 group/step cursor-pointer">
                            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-[#F5A800] border-2 border-amber-300 flex items-center justify-center mx-auto shadow-md group-hover/step:-translate-y-1.5 group-hover/step:scale-110 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V3m0 0l3 3m-3-3L9 6"/></svg>
                            </div>
                            <div class="text-xs font-black text-slate-800 group-hover/step:text-[#F5A800] transition-colors">{{ app()->getLocale() === 'fr' ? 'Cérémonie de Clôture' : (app()->getLocale() === 'en' ? 'Closing Ceremony' : 'حفل الختام') }}</div>
                            <div class="text-[11px] font-extrabold text-amber-800 bg-amber-50 px-2 py-0.5 rounded-full inline-block">21 {{ app()->getLocale() === 'fr' ? 'Nov.' : (app()->getLocale() === 'en' ? 'Nov.' : 'نوفمبر') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Right About Forum Card (4 cols) with Interactive Link -->
                <div class="lg:col-span-4 bg-white/90 backdrop-blur-md rounded-3xl p-6 shadow-xl border border-slate-200 space-y-4 flex flex-col justify-between hover:border-[#35A536]/40 transition-colors group/about">
                    <div class="space-y-3">
                        <div class="flex items-center gap-2.5 text-base font-black text-slate-800">
                            <div class="w-8 h-8 rounded-xl bg-emerald-100 text-[#35A536] flex items-center justify-center shadow-xs group-hover/about:scale-110 transition-transform">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                            </div>
                            <span>{{ app()->getLocale() === 'fr' ? 'À Propos du Forum // ABOUT' : (app()->getLocale() === 'en' ? 'About the Forum // ABOUT' : 'عن المنتدى // ABOUT FORUM') }}</span>
                        </div>
                        <p class="text-xs text-slate-600 font-bold leading-relaxed">
                            {{ app()->getLocale() === 'fr' ? 'Une plateforme africaine de premier plan réunissant talents, experts et décideurs pour autonomiser la jeunesse et développer les compétences.' : (app()->getLocale() === 'en' ? 'A leading African platform bringing together talents, experts and decision-makers to empower youth and drive skills development across Africa.' : 'منصة إفريقية رائدة تجمع المواهب والخبراء وصناع القرار لتمكين الشباب، تطوير المهارات، وقيادة مستقبل العمل في إفريقيا.') }}
                        </p>
                    </div>

                    <a href="{{ route('guide') }}" class="inline-flex items-center gap-2 text-xs font-black text-[#35A536] hover:text-emerald-700 transition-colors pt-2 group-hover/about:translate-x-1">
                        <span>{{ app()->getLocale() === 'fr' ? 'En savoir plus sur le Forum' : (app()->getLocale() === 'en' ? 'Learn more about the Forum' : 'المزيد عن المنتدى') }}</span>
                        <svg class="w-4 h-4 text-[#35A536] group-hover/about:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>

            </div>

        </div>

        <script>
            (function initWsapChronometer() {
                var widgetEl = document.getElementById('wsap-countdown-widget');
                var targetAttr = widgetEl ? widgetEl.getAttribute('data-target-timestamp') : null;
                var targetTime = targetAttr ? parseInt(targetAttr, 10) : (Date.now() + 2500000000);
                
                function tickWsapClock() {
                    var now = Date.now();
                    var diff = Math.max(0, targetTime - now);

                    var d = String(Math.floor(diff / 86400000)).padStart(2, '0');
                    var h = String(Math.floor((diff % 86400000) / 3600000)).padStart(2, '0');
                    var m = String(Math.floor((diff % 3600000) / 60000)).padStart(2, '0');
                    var s = String(Math.floor((diff % 60000) / 1000)).padStart(2, '0');

                    var elD = document.getElementById('cd-days');
                    var elH = document.getElementById('cd-hours');
                    var elM = document.getElementById('cd-minutes');
                    var elS = document.getElementById('cd-seconds');

                    if (elD) elD.textContent = d;
                    if (elH) elH.textContent = h;
                    if (elM) elM.textContent = m;
                    if (elS) elS.textContent = s;
                }

                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', tickWsapClock);
                } else {
                    tickWsapClock();
                }
                setInterval(tickWsapClock, 1000);
            })();
        </script>
    </section>
    @endif

    <!-- 3. Dynamic Real DB Statistics Grid with Image Logos, Text & Animated Counters -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            <x-animated-counter :target="!empty($stats['partners']) ? $stats['partners'] : 10" :label="app()->getLocale() === 'fr' ? 'Partenaires Officiels' : (app()->getLocale() === 'en' ? 'Official Partners' : 'الشركاء والرعاة')" :description="app()->getLocale() === 'fr' ? 'Soutien industriel & institutionnel' : (app()->getLocale() === 'en' ? 'Industrial & Institutional Support' : 'الدعم الصناعي والمؤسساتي')" icon='<svg class="w-6 h-6 text-[#0B2A6F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>' color="text-[#0B2A6F]" />
            <x-animated-counter :target="!empty($stats['organizations']) ? $stats['organizations'] : 150" :label="app()->getLocale() === 'fr' ? 'Centres de Formation' : (app()->getLocale() === 'en' ? 'Training Institutes' : 'المؤسسات التدريبية')" :description="app()->getLocale() === 'fr' ? 'Instituts & Établissements' : (app()->getLocale() === 'en' ? 'Institutes & Establishments' : 'المعاهد والمؤسسات التكوينية')" icon='<svg class="w-6 h-6 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6m-6 0V10m6 11V10m-6 0a2 2 0 012-2h2a2 2 0 012 2m-6 0V6a2 2 0 012-2h2a2 2 0 012 2v4"/></svg>' color="text-[#35A536]" />
            <x-animated-counter :target="!empty($stats['experts']) ? $stats['experts'] : 250" :label="app()->getLocale() === 'fr' ? 'Experts & Conférenciers' : (app()->getLocale() === 'en' ? 'Experts & Speakers' : 'الخبراء والمحاضرون')" :description="app()->getLocale() === 'fr' ? 'Intervenants internationaux' : (app()->getLocale() === 'en' ? 'International Speakers' : 'اللجان الفنية والمحاضرون')" icon='<svg class="w-6 h-6 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>' color="text-[#F5A800]" />
            <x-animated-counter :target="!empty($stats['participants']) ? $stats['participants'] : 1250" :label="app()->getLocale() === 'fr' ? 'Délégués Inscrits' : (app()->getLocale() === 'en' ? 'Registered Delegates' : 'المشاركين المسجلين')" :description="app()->getLocale() === 'fr' ? 'Délégués & Talents africains' : (app()->getLocale() === 'en' ? 'African Delegates & Youth' : 'الوفود والمشاركون الشباب')" icon='<svg class="w-6 h-6 text-[#0B2A6F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>' color="text-[#0B2A6F]" />
            <x-animated-counter :target="!empty($stats['skills']) ? $stats['skills'] : 64" :label="app()->getLocale() === 'fr' ? 'Axes & Conférences' : (app()->getLocale() === 'en' ? 'Tracks & Panels' : 'المحاور والمؤتمرات')" :description="app()->getLocale() === 'fr' ? 'Thématiques du Forum' : (app()->getLocale() === 'en' ? 'Forum Key Themes' : 'القضايا الاستراتيجية')" icon='<svg class="w-6 h-6 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>' color="text-[#35A536]" />
            <x-animated-counter :target="!empty($stats['countries']) ? $stats['countries'] : 54" :label="app()->getLocale() === 'fr' ? 'Pays Africains' : (app()->getLocale() === 'en' ? 'African Nations' : 'الدول الإفريقية')" :description="app()->getLocale() === 'fr' ? 'Délégations souveraines' : (app()->getLocale() === 'en' ? 'Sovereign Delegations' : 'الوفود الوطنية الرسمية')" icon='<svg class="w-6 h-6 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 012 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V14m-3 7c9 0 9-9 9-9s-9 0-9 9z"/></svg>' color="text-[#F5A800]" />
        </div>
    </section>

    <!-- 4. Featured Skills Showcase -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-4 border-b-2 border-slate-100/80 relative group/head cursor-default">
            {{-- Dynamic Ambient Light Glow with Hover Shimmer --}}
            <div class="absolute -top-12 start-0 w-64 h-24 bg-gradient-to-r from-blue-600/10 via-cyan-500/15 to-indigo-600/10 rounded-full blur-3xl pointer-events-none group-hover/head:scale-125 group-hover/head:from-blue-600/25 group-hover/head:to-cyan-400/25 transition-all duration-700"></div>

            <div class="space-y-2 relative z-10">


                {{-- Luxury Dynamic Title with Interactive Color Shift --}}
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight flex items-center gap-3">
                    <span class="p-3 rounded-2xl bg-gradient-to-tr from-[#06205C] via-[#0066FF] to-[#00A3FF] text-white shadow-lg shadow-blue-500/20 transform group-hover/head:rotate-6 group-hover/head:scale-110 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 01-1.187-2.19l.732-4.393A2 2 0 017.11 6.814l3.176.635a6 6 0 003.86-.517l.318-.158a6 6 0 013.86-.517l2.387.477a2 2 0 011.642 1.964v6.22a2 2 0 01-.927 1.69z"/></svg>
                    </span>
                    <span class="bg-gradient-to-r from-[#06205C] via-[#0038A8] to-[#0066FF] group-hover/head:from-[#0066FF] group-hover/head:via-[#00A3FF] group-hover/head:to-[#06205C] bg-clip-text text-transparent transition-all duration-500">
                        {{ app()->getLocale() === 'fr' ? 'Grands Axes & Thématiques du Forum' : (app()->getLocale() === 'en' ? 'Core Themes & Forum Tracks' : 'المحاور الكبرى والقضايا الاستراتيجية للمنتدى') }}
                    </span>
                </h2>

                <p class="text-xs sm:text-sm text-slate-500 font-bold max-w-xl group-hover/head:text-slate-700 transition-colors">
                    {{ app()->getLocale() === 'fr' ? 'Découvrez les conférences, ateliers stratégiques et opportunités de partenariat continental.' : (app()->getLocale() === 'en' ? 'Explore continental policy panels, workshops, and skills investment opportunities.' : 'استكشف الجلسات الوزارية والمؤتمرات الاستراتيجية وورشات التمكين المهني في أفريقيا') }}
                </p>
            </div>

            <a href="{{ route('skills') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-[#0B2A6F] to-[#35A536] hover:from-[#35A536] hover:to-[#0B2A6F] text-white text-xs font-black shadow-lg hover:scale-105 transition-all duration-300 group/btn self-start md:self-auto border border-white/20">
                <span>{{ app()->getLocale() === 'fr' ? 'Tous les Métiers & Axes' : (app()->getLocale() === 'en' ? 'All Skills & Tracks' : 'دليل جميع التخصصات والمحاور') }}</span>
                <svg class="w-4 h-4 text-white group-hover/btn:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($skills as $skill)
                @php
                    $imgUrl = asset($skill->image_path ?: 'images/skills/trade_16.png');
                @endphp
                <a href="{{ route('skills', ['skill' => $skill->id]) }}" class="bg-white rounded-3xl overflow-hidden shadow-xl border border-slate-200/90 hover:shadow-2xl transition-all duration-400 transform hover:-translate-y-2 group cursor-pointer flex flex-col justify-between hover:border-[#35A536] wsap-hover-card">
                    
                    {{-- Photo Banner Header --}}
                    <div class="h-48 bg-slate-950 relative overflow-hidden">
                        <img src="{{ $imgUrl }}"
                             onerror="this.onerror=null; this.src='{{ asset('images/skills/ict.png') }}';"
                             alt="{{ $skill->getLocalized('name') }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 opacity-95">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-black/20 to-black/10"></div>

                        {{-- Code Badge (Top-Start) --}}
                        <div class="absolute top-4 start-4 px-3.5 py-1.5 rounded-full bg-[#0B2A6F] text-white font-mono font-black text-xs shadow-md border border-white/30">
                            {{ $skill->code }}
                        </div>

                        {{-- Sector Badge (Top-End) --}}
                        <div class="absolute top-4 end-4 px-3.5 py-1.5 rounded-full bg-black/75 backdrop-blur-md text-white text-[10px] font-black uppercase tracking-wider border border-white/20">
                            {{ $skill->category ? $skill->category->getLocalized('name') : 'تكنولوجيا المعلومات والاتصالات' }}
                        </div>
                    </div>

                    {{-- Card Body Details --}}
                    <div class="p-6 space-y-4 flex-1 flex flex-col justify-between">
                        <div class="space-y-2">
                            <h3 class="text-lg font-black text-[#0B2A6F] group-hover:text-[#35A536] transition-colors leading-snug">
                                {{ $skill->getLocalized('name') }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed font-medium">
                                {{ $skill->getLocalized('description') }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                            <span class="inline-flex items-center gap-1.5 text-xs font-black text-[#0B2A6F] group-hover:text-[#35A536] transition">
                                <span>{{ __('messages.skills') }} — {{ app()->getLocale() === 'fr' ? 'Détails & Cahier des charges' : (app()->getLocale() === 'en' ? 'Details & Specs' : 'عرض التفاصيل والمعايير التقنية') }}</span>
                                <svg class="w-4 h-4 text-[#35A536] group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </div>

                </a>
            @empty
                <div class="col-span-3 bg-white rounded-3xl p-8 text-center text-slate-400 font-medium text-sm">
                    {{ app()->getLocale() === 'fr' ? 'Aucune discipline disponible actuellement.' : (app()->getLocale() === 'en' ? 'No trade categories added yet.' : 'لا توجد تخصصات مضافة حالياً.') }}
                </div>
            @endforelse
        </div>
    </section>

    <!-- 5. Media & Event Highlights Grid -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 pb-4 border-b-2 border-slate-100/80 relative group/head cursor-default">
            {{-- Dynamic Ambient Light Glow with Hover Shimmer --}}
            <div class="absolute -top-12 start-0 w-64 h-24 bg-gradient-to-r from-amber-500/10 via-orange-500/15 to-rose-500/10 rounded-full blur-3xl pointer-events-none group-hover/head:scale-125 group-hover/head:from-amber-500/25 group-hover/head:to-orange-400/25 transition-all duration-700"></div>

            <div class="space-y-2 relative z-10">


                {{-- Luxury Dynamic Title with Interactive Color Shift --}}
                <h2 class="text-3xl sm:text-4xl font-black tracking-tight flex items-center gap-3">
                    <span class="p-3 rounded-2xl bg-gradient-to-tr from-amber-600 via-orange-500 to-amber-400 text-white shadow-lg shadow-amber-500/20 transform group-hover/head:-rotate-6 group-hover/head:scale-110 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                    </span>
                    <span class="bg-gradient-to-r from-[#06205C] via-amber-900 to-orange-600 group-hover/head:from-orange-600 group-hover/head:via-amber-500 group-hover/head:to-[#06205C] bg-clip-text text-transparent transition-all duration-500">
                        {{ app()->getLocale() === 'fr' ? 'Centre Média & Presse' : (app()->getLocale() === 'en' ? 'Media & Press Center' : 'المركز الإعلامي والتغطيات') }}
                    </span>
                </h2>

                <p class="text-xs sm:text-sm text-slate-500 font-bold max-w-xl group-hover/head:text-slate-700 transition-colors">
                    {{ app()->getLocale() === 'fr' ? 'Actualités, événements, galeries photos et médias' : (app()->getLocale() === 'en' ? 'Latest news, events, photos and video coverage' : 'متابعة حية لجميع المستجدات، الفعاليات، المعارض والتغطيات المصورة للأولمبياد') }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Card 1: معرض الصور المميز -->
            <div class="bg-white rounded-3xl p-6 shadow-md border border-slate-200/80 flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-[#06205C] mb-4">
                        {{ app()->getLocale() === 'fr' ? 'Galerie Photos' : (app()->getLocale() === 'en' ? 'Photo Gallery' : 'معرض الصور') }}
                    </h3>
                    <div class="space-y-3">
                        @forelse($albums as $album)
                            <a href="{{ route('gallery') }}" class="flex items-center gap-3 group">
                                @if($album->coverMedia?->storage_path || $album->mediaItems->first()?->storage_path)
                                    <img src="{{ $album->cover_url }}" alt="{{ $album->getLocalized('title') }}" class="w-12 h-10 rounded-lg object-cover flex-shrink-0 bg-slate-200 border border-slate-200">
                                @else
                                    <div class="w-12 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center flex-shrink-0 border border-amber-200/60 shadow-xs">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-[#06205C] group-hover:text-brand-500 transition-colors leading-snug line-clamp-1">{{ $album->getLocalized('title') }}</h4>
                                    <span class="text-[10px] text-slate-400">{{ optional($album->published_at)->format('Y-m-d') ?? now()->format('Y-m-d') }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-10 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center flex-shrink-0 border border-slate-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-[#0B2A6F] leading-snug line-clamp-1">Africa Skills Forum 2026</h4>
                                    <span class="text-[10px] text-slate-400">2026-08-04</span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <a href="{{ route('gallery') }}" class="text-xs font-bold text-brand-500 hover:text-brand-600 mt-6 inline-flex items-center gap-1">
                    <span>{{ __('messages.view_all_gallery') }}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Card 2: الأجندة والفعاليات القادمة -->
            <div class="bg-white rounded-3xl p-6 shadow-md border border-slate-200/80 flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-[#06205C] mb-4">
                        {{ app()->getLocale() === 'fr' ? 'Agenda & Événements' : (app()->getLocale() === 'en' ? 'Events & Calendar' : 'الأجندة والفعاليات') }}
                    </h3>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-500 flex flex-col items-center justify-center flex-shrink-0 font-bold border border-brand-100">
                                <span class="text-xs leading-none">25</span>
                                <span class="text-[9px] uppercase">{{ app()->getLocale() === 'fr' ? 'NOV' : (app()->getLocale() === 'en' ? 'NOV' : 'نوفمبر') }}</span>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-[#06205C]">
                                    {{ app()->getLocale() === 'fr' ? 'Cérémonie d\'Ouverture des Olympiades' : (app()->getLocale() === 'en' ? 'Official Opening Ceremony' : 'حفل الافتتاح الرسمي للأولمبياد الإفريقي') }}
                                </h4>
                                <span class="text-[10px] text-slate-400">CIC — Oran / Alger</span>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('events') }}" class="text-xs font-bold text-brand-500 hover:text-brand-600 mt-6 inline-flex items-center gap-1">
                    <span>{{ __('messages.view_all_events') }}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Card 3: الأخبار والمستجدات -->
            <div class="bg-white rounded-3xl p-6 shadow-md border border-slate-200/80 flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-[#06205C] mb-4">
                        {{ app()->getLocale() === 'fr' ? 'Actualités & Articles' : (app()->getLocale() === 'en' ? 'News & Updates' : 'الأخبار والمشاركات') }}
                    </h3>
                    <div class="space-y-3">
                        @forelse($news as $article)
                            <a href="{{ route('news') }}" class="flex items-center gap-3 group">
                                @if($article->featured_image)
                                    <img src="{{ $article->cover_url }}" alt="{{ $article->getLocalized('title') }}" class="w-12 h-10 rounded-lg object-cover flex-shrink-0 bg-slate-200 border border-slate-200">
                                @else
                                    <div class="w-12 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0 border border-blue-200/60 shadow-xs">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <h4 class="text-xs font-bold text-[#06205C] group-hover:text-brand-500 transition-colors leading-snug line-clamp-1">{{ $article->getLocalized('title') }}</h4>
                                    <span class="text-[10px] text-slate-400">{{ optional($article->published_at)->format('Y-m-d') ?? now()->format('Y-m-d') }}</span>
                                </div>
                            </a>
                        @empty
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-10 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center flex-shrink-0 border border-slate-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-[#06205C] leading-snug line-clamp-1">Africa Skills Forum 2026</h4>
                                    <span class="text-[10px] text-slate-400">2026-08-04</span>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
                <a href="{{ route('news') }}" class="text-xs font-bold text-brand-500 hover:text-brand-600 mt-6 inline-flex items-center gap-1">
                    <span>{{ __('messages.view_all_news') }}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <!-- Card 4: فيديو مميز -->
            <div class="bg-white rounded-3xl p-6 shadow-md border border-slate-200/80 flex flex-col justify-between">
                <div>
                    <h3 class="text-sm font-bold text-[#06205C] mb-4">
                        {{ app()->getLocale() === 'fr' ? 'Centre Vidéos' : (app()->getLocale() === 'en' ? 'Video Center' : 'مركز الفيديوهات والتغطيات') }}
                    </h3>
                    <button @click="showVideoModal = true" class="relative rounded-2xl overflow-hidden bg-[#020A24] group block w-full text-right focus:outline-none h-32 border border-slate-800 shadow-md">
                        @php
                            $featuredVideo = $videos->first();
                            $thumbUrl = null;
                            if ($featuredVideo) {
                                if ($featuredVideo->thumbnail_path) {
                                    $thumbUrl = $featuredVideo->thumbnail_path;
                                } elseif ($featuredVideo->youtube_id) {
                                    // Auto-generate from YouTube — use mqdefault for guaranteed availability
                                    $thumbUrl = 'https://img.youtube.com/vi/' . $featuredVideo->youtube_id . '/mqdefault.jpg';
                                }
                            }
                        @endphp
                        @if($thumbUrl)
                            <img src="{{ $thumbUrl }}" alt="Featured Video"
                                 class="w-full h-32 object-cover opacity-80 group-hover:scale-105 transition-transform duration-300"
                                 onerror="this.style.display='none'">
                        @else
                            <div class="w-full h-32 bg-gradient-to-br from-[#020A24] via-[#06205C] to-blue-900 flex items-center justify-center p-4">
                                <img src="/logo.svg" alt="Africa Skills Forum" class="h-12 w-auto opacity-30 filter drop-shadow">
                            </div>
                        @endif
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-12 h-12 rounded-full bg-[#0066FF] text-white flex items-center justify-center shadow-xl shadow-blue-500/50 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 fill-current translate-x-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>
                        <span class="absolute bottom-2 right-2 px-2 py-0.5 rounded bg-black/70 text-white text-[10px] font-mono">{{ $videos->first()?->duration ?: '02:45' }}</span>
                    </button>
                    <h4 class="text-xs font-bold text-[#06205C] mt-3 leading-snug line-clamp-1">{{ $videos->first()?->getLocalized('title') ?? 'Africa Skills Forum' }}</h4>
                </div>
                <a href="{{ route('videos') }}" class="text-xs font-bold text-brand-500 hover:text-brand-600 mt-6 inline-flex items-center gap-1">
                    <span>{{ __('messages.view_all_videos') }}</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

        </div>
    </section>

    <!-- 6. Featured Partners & Sponsors Banner Grid -->
    @if(platform()->get('show_partners_section', true))
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <div class="flex flex-col items-center text-center space-y-2 relative pb-4 group/head cursor-default">
            {{-- Dynamic Ambient Light Glow with Hover Shimmer --}}
            <div class="absolute -top-12 inset-x-0 mx-auto w-72 h-24 bg-gradient-to-r from-blue-600/10 via-indigo-500/15 to-purple-600/10 rounded-full blur-3xl pointer-events-none group-hover/head:scale-125 group-hover/head:from-blue-600/25 group-hover/head:to-purple-500/25 transition-all duration-700"></div>

            {{-- Luxury Dynamic Title with Interactive Color Shift --}}

            <h3 class="text-2xl sm:text-3xl font-black tracking-tight flex items-center justify-center gap-3">
                <span class="p-2.5 rounded-2xl bg-gradient-to-tr from-[#06205C] via-[#0066FF] to-indigo-600 text-white shadow-md transform group-hover/head:rotate-6 group-hover/head:scale-110 transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </span>
                <span class="bg-gradient-to-r from-[#06205C] via-[#0038A8] to-[#0066FF] group-hover/head:from-[#0066FF] group-hover/head:via-purple-600 group-hover/head:to-[#06205C] bg-clip-text text-transparent transition-all duration-500">
                    {{ app()->getLocale() === 'fr' ? 'Partenaires & Sponsors Officiels' : (app()->getLocale() === 'en' ? 'Official Partners & Sponsors' : 'الشركاء والرعاة المميزون') }}
                </span>
            </h3>

            <p class="text-xs sm:text-sm text-slate-500 font-bold max-w-lg group-hover/head:text-slate-700 transition-colors">
                {{ app()->getLocale() === 'fr' ? 'Soutien industriel et institutionnel' : (app()->getLocale() === 'en' ? 'Supporting Industrial & Institutional Partners' : 'المؤسسات الرائدة والهيئات الصناعية الداعمة لأولمبياد المهن 2026') }}
            </p>
        </div>

        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-md border border-slate-200/80 flex items-center justify-center flex-wrap gap-8 sm:gap-12">
            @forelse($partners as $p)
                @php $logoUrl = $p->logo_path ? asset($p->logo_path) : null; @endphp
                <div class="flex flex-col items-center justify-center gap-2 group transition transform hover:scale-105 py-2 px-3">
                    <div class="h-10 sm:h-12 w-auto flex items-center justify-center">
                        @if($logoUrl)
                            <img src="{{ $logoUrl }}" alt="{{ $p->getLocalized('name') }}" class="h-10 sm:h-12 w-auto object-contain filter grayscale group-hover:grayscale-0 transition duration-300">
                        @else
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 font-black text-sm flex items-center justify-center border border-blue-100">
                                {{ mb_substr($p->getLocalized('name'), 0, 1) }}
                            </div>
                        @endif
                    </div>
                    <span class="text-xs font-black text-[#06205C] group-hover:text-blue-600 transition tracking-tight text-center block">
                        {{ $p->getLocalized('name') }}
                    </span>
                </div>
            @empty
                <div class="text-xs text-slate-400 font-bold">
                    {{ app()->getLocale() === 'fr' ? 'Aucun partenaire disponible' : (app()->getLocale() === 'en' ? 'No featured partners yet' : 'لا يوجد شركاء مميزون حالياً.') }}
                </div>
            @endforelse
        </div>
    </section>
    @endif


    <!-- 7. Call to Action Banner -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-gradient-to-r from-[#0038A8] via-[#0066FF] to-[#00A3FF] text-white p-8 lg:p-12 shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8 group">
            
            <div class="flex items-center flex-shrink-0 bg-white/95 backdrop-blur-md p-3 rounded-2xl border border-white/30 shadow-lg">
                <img src="/AFRICA.png" alt="{{ platform()->name() }}" class="h-14 sm:h-16 w-auto object-contain drop-shadow-md">
            </div>

            <div class="space-y-3 max-w-xl text-center {{ app()->getLocale() === 'ar' ? 'md:text-right' : 'md:text-left' }}">
                <h2 class="text-2xl sm:text-3xl font-black leading-tight">
                    {{ app()->getLocale() === 'fr' ? 'Rejoignez le plus grand événement des compétences en Afrique !' : (app()->getLocale() === 'en' ? 'Join the Largest Skills Event in Africa!' : 'كن جزءاً من أكبر حدث للمهارات في إفريقيا!') }}
                </h2>
                <p class="text-xs text-blue-100 font-bold">
                    {{ app()->getLocale() === 'fr' ? 'Inscrivez-vous maintenant pour participer au développement des compétences au Centre des Conventions d\'Oran.' : (app()->getLocale() === 'en' ? 'Register now to shape the future of skills at Mohamed Ben Ahmed Convention Center in Oran.' : 'سجل الآن وشارك في صناعة المستقبل وتطوير المهارات بمركز المؤتمرات محمد بن أحمد بولاية وهران.') }}
                </p>
            </div>
            
            <a href="{{ route('registration') }}" class="px-8 py-3.5 rounded-2xl bg-white text-[#0052CC] font-bold text-xs shadow-xl hover:bg-blue-50 transition flex items-center gap-2 flex-shrink-0 hover:scale-105">
                <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>{{ __('messages.register_now') }}</span>
            </a>
        </div>
    </section>

    <!-- 8. Inline Video Pop-Up Modal (Plays video directly inside site without redirecting) -->
    <div x-show="showVideoModal" x-transition.opacity class="fixed inset-0 z-50 bg-black/80 backdrop-blur-md flex items-center justify-center p-4" style="display: none;">
        <div @click.outside="showVideoModal = false" class="bg-slate-900 rounded-3xl overflow-hidden max-w-4xl w-full shadow-2xl border border-slate-700 relative">
            <button @click="showVideoModal = false" class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-black/60 text-white flex items-center justify-center hover:bg-black transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="aspect-video w-full">
                <iframe class="w-full h-full" src="https://www.youtube.com/embed/ee7fzNFUKIM?autoplay=1" title="WorldSkills Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>

</div>
