<div class="space-y-12 pb-16" x-data="{ showScheduleModal: false, scheduleTab: 16, showVideoModal: false, showPdfModal: false }" @open-schedule.window="showScheduleModal = true">

    <!-- 1. Pan-African Summit Hero Stage (Ultra-Modern African Leadership Aesthetic & Auto-Slider) -->
    <section class="relative bg-gradient-to-br from-[#052D48] via-[#031826] to-[#010a12] text-white pt-16 pb-28 px-4 sm:px-6 lg:px-8 overflow-hidden shadow-2xl"
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
        
        <!-- Background Layer: Multi-Image Dynamic Auto-Slider (Controlled by Admin via GlobalSettings) -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <template x-for="(slide, index) in slides" :key="index">
                <div class="absolute inset-0 transition-all duration-1000 ease-in-out"
                     :class="activeSlide === index ? 'opacity-90 scale-105 z-10' : 'opacity-0 scale-100 z-0'"
                     style="transition: opacity 1.2s ease-in-out, transform 6s ease-out;">
                    <img :src="slide" alt="Africa Skills Policy Forum 2026" class="w-full h-full object-cover object-center filter brightness-90">
                </div>
            </template>
            <!-- Fallback Static First Slide -->
            <div class="absolute inset-0 z-0 opacity-90 scale-105" x-show="!slides || slides.length === 0">
                <img src="{{ asset('/images/hero_slide_1.png') }}" alt="Africa Skills Policy Forum 2026" class="w-full h-full object-cover object-center filter brightness-90">
            </div>
            <!-- Elegant Cinematic Gradient Overlay for Maximum Text Readability -->
            <div class="absolute inset-0 z-20 bg-gradient-to-t from-[#010a12] via-[#052D48]/75 to-black/40"></div>
        </div>

        <!-- Slide Navigation Indicators (Bottom Left, matching official artwork) -->
        <div class="absolute bottom-12 sm:bottom-14 left-6 sm:left-10 z-20 flex items-center gap-2" x-show="slides.length > 1">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="activeSlide = index" 
                        class="h-2 rounded-full transition-all duration-500 cursor-pointer"
                        :class="activeSlide === index ? 'w-8 bg-[#24BDC3] shadow-md shadow-[#24BDC3]/50' : 'w-2.5 bg-white/40 hover:bg-white/70'"></button>
            </template>
        </div>

        <!-- Dynamic Ambient Beams in Bright Teal (#24BDC3) & Deep Petrol Blue (#052D48) -->
        <div class="hidden sm:block absolute -top-24 -left-24 w-[32rem] h-[32rem] bg-[#24BDC3]/20 rounded-full blur-2xl pointer-events-none"></div>
        <div class="hidden sm:block absolute -bottom-24 -right-24 w-[32rem] h-[32rem] bg-[#052D48]/40 rounded-full blur-2xl pointer-events-none"></div>
        <div class="max-w-7xl mx-auto relative z-10 space-y-8 text-right">

            <!-- Title & Subtitle Card with Glass Text Effect -->
            <div class="space-y-4 max-w-4xl">

                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.15] text-white drop-shadow-[0_4px_25px_rgba(0,0,0,0.9)]">
                    {{ app()->getLocale() === 'fr' ? 'Forum des Politiques Africaines des Compétences 2026' : (app()->getLocale() === 'en' ? 'Africa Skills Policy Forum 2026' : 'منتدى السياسات الأفريقية للمهارات 2026') }}
                    <span class="text-[#24BDC3] block mt-2 text-xl sm:text-3xl lg:text-4xl font-black">
                        "{{ $forumData['slogan'] ?? 'صياغة مستقبل المهارات، تمكين الشباب الأفريقي' }}"
                    </span>
                </h1>

                <p class="text-sm sm:text-base text-slate-100 font-medium leading-relaxed max-w-3xl drop-shadow-[0_2px_12px_rgba(0,0,0,0.9)]">
                    @if(app()->getLocale() === 'fr')
                        Le principal sommet politique de haut niveau réunissant les ministres africains, experts et partenaires internationaux autour du principe fondateur: L'avenir des compétences en Afrique doit être façonné par les Africains eux-mêmes.
                    @elseif(app()->getLocale() === 'en')
                        The principal high-level political summit bringing together African Ministers, technical experts, and international partners around the core principle: Africa's skills future must be shaped by Africans themselves.
                    @else
                        الحدث السياسي الرفيع المستوى الرئيسي الذي يجمع الوزراء الأفارقة والخبراء التقنيين والشركاء المؤسساتيين والدوليين، تجسيدًا لمبدأ أساسي: مستقبل المهارات في إفريقيا يجب أن يُصاغ من قِبل الأفارقة أنفسهم.
                    @endif
                </p>

            </div>

            <!-- Action Buttons with Smooth Hover Animations -->
            <div class="flex flex-wrap items-center gap-4 pt-2">
                <a href="{{ route('official.registration') }}" class="px-8 py-4 rounded-2xl btn-teal-gradient font-black text-sm flex items-center gap-2.5 group">
                    <svg class="w-5 h-5 text-white group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>{{ __('messages.register_now') }}</span>
                </a>
                <a href="{{ route('guide') }}" class="px-8 py-4 rounded-2xl bg-white/10 hover:bg-white/20 backdrop-blur-md text-white font-extrabold text-sm border border-white/30 shadow-xl transition-all duration-300 transform hover:-translate-y-1 hover:scale-105 flex items-center gap-2.5 group">
                    <svg class="w-5 h-5 text-[#24BDC3] group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Découvrir la Vision & Guide' : (app()->getLocale() === 'en' ? 'Explore Forum Vision & Guide' : 'رؤية ودليل المنتدى') }}</span>
                </a>
                <button @click="$dispatch('open-schedule'); showScheduleModal = true" class="px-8 py-4 rounded-2xl btn-petrol-gradient font-black text-sm shadow-xl flex items-center gap-2.5 group cursor-pointer">
                    <svg class="w-5 h-5 text-[#24BDC3] group-hover:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Programme Officiel' : (app()->getLocale() === 'en' ? 'Official Event Schedule' : 'جدول أعمال المنتدى') }}</span>
                </button>
            </div>

            <!-- Embedded Hero Stat Badges with Pure Vector SVG Icons -->
            <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-4 pt-8 max-w-6xl">
                <!-- Stat 1: +30 Nations -->
                <div class="p-4 sm:p-5 rounded-2xl bg-white/10 dark:bg-[#031826]/80 backdrop-blur-md border border-white/20 dark:border-[#24BDC3]/30 flex items-center justify-between gap-3 shadow-xl hover:-translate-y-1 hover:border-[#24BDC3] hover:shadow-[0_0_25px_rgba(36,189,195,0.3)] transition-all duration-300 group">
                    <div class="space-y-1">
                        <div class="text-2xl sm:text-3xl font-black text-white font-mono tracking-tight drop-shadow-sm">+30</div>
                        <div class="text-xs text-teal-100 font-bold leading-snug">{{ app()->getLocale() === 'fr' ? 'Pays africains' : (app()->getLocale() === 'en' ? 'African countries' : 'دولة مشاركة') }}</div>
                    </div>
                    <div class="w-11 h-11 rounded-2xl bg-[#24BDC3]/20 border border-[#24BDC3]/50 text-[#24BDC3] flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-[#24BDC3] group-hover:text-[#02101b] transition-all duration-300 shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 012 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V14m-3 7c9 0 9-9 9-9s-9 0-9 9z"/></svg>
                    </div>
                </div>

                <!-- Stat 2: +20 Ministers Expected -->
                <div class="p-4 sm:p-5 rounded-2xl bg-white/10 dark:bg-[#031826]/80 backdrop-blur-md border border-white/20 dark:border-[#24BDC3]/30 flex items-center justify-between gap-3 shadow-xl hover:-translate-y-1 hover:border-[#24BDC3] hover:shadow-[0_0_25px_rgba(36,189,195,0.3)] transition-all duration-300 group">
                    <div class="space-y-1">
                        <div class="text-2xl sm:text-3xl font-black text-white font-mono tracking-tight drop-shadow-sm">+20</div>
                        <div class="text-xs text-teal-100 font-bold leading-snug">{{ app()->getLocale() === 'fr' ? 'Ministres attendus' : (app()->getLocale() === 'en' ? 'Ministers expected' : 'وزيراً متوقعاً') }}</div>
                    </div>
                    <div class="w-11 h-11 rounded-2xl bg-[#24BDC3]/20 border border-[#24BDC3]/50 text-[#24BDC3] flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-[#24BDC3] group-hover:text-[#02101b] transition-all duration-300 shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                </div>

                <!-- Stat 3: 2 Ministerial Roundtables -->
                <div class="p-4 sm:p-5 rounded-2xl bg-white/10 dark:bg-[#031826]/80 backdrop-blur-md border border-white/20 dark:border-[#24BDC3]/30 flex items-center justify-between gap-3 shadow-xl hover:-translate-y-1 hover:border-[#24BDC3] hover:shadow-[0_0_25px_rgba(36,189,195,0.3)] transition-all duration-300 group">
                    <div class="space-y-1">
                        <div class="text-2xl sm:text-3xl font-black text-white font-mono tracking-tight drop-shadow-sm">2</div>
                        <div class="text-xs text-teal-100 font-bold leading-snug">{{ app()->getLocale() === 'fr' ? 'Tables rondes ministérielles' : (app()->getLocale() === 'en' ? 'Ministerial Roundtables' : 'موائد مستديرة وزارية') }}</div>
                    </div>
                    <div class="w-11 h-11 rounded-2xl bg-[#24BDC3]/20 border border-[#24BDC3]/50 text-[#24BDC3] flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-[#24BDC3] group-hover:text-[#02101b] transition-all duration-300 shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                </div>

                <!-- Stat 4: 7 Thematic Workshops -->
                <div class="p-4 sm:p-5 rounded-2xl bg-white/10 dark:bg-[#031826]/80 backdrop-blur-md border border-white/20 dark:border-[#24BDC3]/30 flex items-center justify-between gap-3 shadow-xl hover:-translate-y-1 hover:border-[#24BDC3] hover:shadow-[0_0_25px_rgba(36,189,195,0.3)] transition-all duration-300 group">
                    <div class="space-y-1">
                        <div class="text-2xl sm:text-3xl font-black text-white font-mono tracking-tight drop-shadow-sm">7</div>
                        <div class="text-xs text-teal-100 font-bold leading-snug">{{ app()->getLocale() === 'fr' ? 'Axes thématiques' : (app()->getLocale() === 'en' ? 'Thematic workshops' : 'ورشات تخصصية') }}</div>
                    </div>
                    <div class="w-11 h-11 rounded-2xl bg-[#24BDC3]/20 border border-[#24BDC3]/50 text-[#24BDC3] flex items-center justify-center shrink-0 group-hover:scale-110 group-hover:bg-[#24BDC3] group-hover:text-[#02101b] transition-all duration-300 shadow-md">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v7M5 11.5v5.5a2.5 2.5 0 005 0v-5.5"/></svg>
                    </div>
                </div>
            </div>

        </div>
            <!-- Pan-African Cultural Animated Wavy Transition Divider (Hero to Content Stage) -->
        <div class="absolute bottom-0 inset-x-0 w-full overflow-hidden leading-none pointer-events-none z-20" style="bottom: -1px;">
            <svg class="relative block w-full text-[#F4F7FC] dark:text-[#02101b]" viewBox="0 0 1440 140" preserveAspectRatio="none" style="width: 100% !important; height: 110px !important; min-height: 80px !important; display: block !important;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                <defs>
                    <!-- Authentic African Green Motif Ribbon Strip (from Official Cultural Artwork 6991441) -->
                    <pattern id="hero-african-green-motif" width="320" height="32" patternUnits="userSpaceOnUse" x="0" y="0">
                        <animate attributeName="x" from="0" to="-320" dur="18s" repeatCount="indefinite"/>
                        <rect width="320" height="32" fill="#1f9c98"/>
                        <image href="data:image/png;base64,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" xlink:href="data:image/png;base64,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" width="320" height="32" preserveAspectRatio="none"/>
                    </pattern>
                </defs>





                <!-- Layer 1: Ambient Cyan Glow Wave -->
                <path fill="#24BDC3" fill-opacity="0.30" d="M0,50 C320,15 640,85 960,35 C1160,10 1340,55 1440,50 L1440,140 L0,140 Z">
                    <animate attributeName="d" dur="8s" repeatCount="indefinite"
                        values="M0,50 C320,15 640,85 960,35 C1160,10 1340,55 1440,50 L1440,140 L0,140 Z;
                                M0,40 C300,75 640,25 980,65 C1180,40 1320,15 1440,40 L1440,140 L0,140 Z;
                                M0,50 C320,15 640,85 960,35 C1160,10 1340,55 1440,50 L1440,140 L0,140 Z" />
                </path>

                <!-- Layer 2: Main Base Fill Wave (Completely covers dark blue beneath ribbon with page background) -->
                <path fill="#F4F7FC" class="dark:fill-[#02101b]" d="M0,80 C320,45 640,115 960,65 C1160,40 1340,85 1440,80 L1440,140 L0,140 Z">
                    <animate attributeName="d" dur="9s" repeatCount="indefinite"
                        values="M0,80 C320,45 640,115 960,65 C1160,40 1340,85 1440,80 L1440,140 L0,140 Z;
                                M0,72 C280,100 580,55 900,100 C1120,70 1300,45 1440,72 L1440,140 L0,140 Z;
                                M0,80 C320,45 640,115 960,65 C1160,40 1340,85 1440,80 L1440,140 L0,140 Z" />
                </path>

                <!-- Layer 3: Vibrant Authentic Green African Geometric Ribbon Band (Prominent & Vivid) -->
                <path fill="url(#hero-african-green-motif)" stroke="#1f9c98" stroke-width="1" d="M0,50 C320,15 640,85 960,35 C1160,10 1340,55 1440,50 L1440,80 C1340,85 1160,40 960,65 C640,115 320,45 0,80 Z">
                    <animate attributeName="d" dur="9s" repeatCount="indefinite"
                        values="M0,50 C320,15 640,85 960,35 C1160,10 1340,55 1440,50 L1440,80 C1340,85 1160,40 960,65 C640,115 320,45 0,80 Z;
                                M0,42 C280,70 580,25 900,70 C1120,40 1300,15 1440,42 L1440,72 C1300,45 1120,70 900,100 C580,55 280,100 0,72 Z;
                                M0,50 C320,15 640,85 960,35 C1160,10 1340,55 1440,50 L1440,80 C1340,85 1160,40 960,65 C640,115 320,45 0,80 Z" />
                </path>

                <!-- Layer 4: Cyan Upper Crest Glowing Stroke -->
                <path fill="none" stroke="#24BDC3" stroke-width="2.5" stroke-linecap="round" d="M0,50 C320,15 640,85 960,35 C1160,10 1340,55 1440,50">
                    <animate attributeName="d" dur="9s" repeatCount="indefinite"
                        values="M0,50 C320,15 640,85 960,35 C1160,10 1340,55 1440,50;
                                M0,42 C280,70 580,25 900,70 C1120,40 1300,15 1440,42;
                                M0,50 C320,15 640,85 960,35 C1160,10 1340,55 1440,50" />
                </path>

                <!-- Layer 5: Warm Sahara Gold Flowing Dashed Accent Line on Ribbon Base -->
                <path fill="none" stroke="#F5A800" stroke-width="2" stroke-dasharray="10 6" stroke-linecap="round" d="M0,80 C320,45 640,115 960,65 C1160,40 1340,85 1440,80">
                    <animate attributeName="stroke-dashoffset" from="0" to="-96" dur="3s" repeatCount="indefinite"/>
                    <animate attributeName="d" dur="9s" repeatCount="indefinite"
                        values="M0,80 C320,45 640,115 960,65 C1160,40 1340,85 1440,80;
                                M0,72 C280,100 580,55 900,100 C1120,70 1300,45 1440,72;
                                M0,80 C320,45 640,115 960,65 C1160,40 1340,85 1440,80" />
                </path>
            </svg>
        </div>
    </section>

    <!-- 2. Africa Skills Forum Official Event Dashboard & Countdown Stage (Animated & Interactive) -->
    @if(platform()->get('countdown_enabled', true) && $countdownStatus !== 'DISABLED')

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-6 sm:-mt-10 lg:-mt-14 mb-8 relative z-30" 
             wire:ignore 
             id="wsap-countdown-widget" 
             data-target-timestamp="{{ strtotime($countdownTargetDate ?? '2026-09-15 09:00:00') * 1000 }}"
             data-flip-anim="{{ $countdownFlipAnimation ? '1' : '0' }}">
        
        <!-- Outer Dashboard Light Container Card with Subtle Dynamic Mesh -->
        <div class="rounded-3xl bg-white dark:bg-[#031826] p-6 sm:p-10 shadow-2xl border border-slate-200 dark:border-[#24BDC3]/30 text-slate-900 dark:text-slate-100 space-y-8 relative overflow-hidden group/dashboard transition-colors duration-300">
            
            <!-- Dynamic Background Ambient Lighting Orbs -->
            <div class="absolute -top-32 -left-32 w-80 h-80 bg-[#24BDC3]/15 rounded-full blur-3xl pointer-events-none group-hover/dashboard:scale-125 transition-transform duration-1000"></div>
            <div class="absolute -bottom-32 -right-32 w-80 h-80 bg-[#052D48]/30 rounded-full blur-3xl pointer-events-none group-hover/dashboard:scale-125 transition-transform duration-1000"></div>

            <!-- Top Row: Left Text/Info + Right Tech Map Illustration -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                
                <!-- Left Side (RTL Info) -->
                <div class="lg:col-span-7 space-y-4 text-right">
                    
                    <!-- Subtitle -->
                    <div class="inline-flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#24BDC3] animate-ping"></span>
                        <h4 class="text-base sm:text-lg font-black text-slate-600 dark:text-teal-200 uppercase tracking-wide">
                            {{ app()->getLocale() === 'fr' ? 'ÉVÉNEMENT À VENIR // UPCOMING' : (app()->getLocale() === 'en' ? 'UPCOMING EVENT // NEXT STAGE' : 'الحدث القادم // UPCOMING STAGE') }}
                        </h4>
                    </div>

                    <!-- Main Heading -->
                    <h2 class="text-2xl sm:text-4xl font-black text-[#052D48] dark:text-white leading-tight tracking-tight drop-shadow-xs">
                        @if(app()->getLocale() === 'fr')
                            {{ $countdownTitleFr }}
                        @elseif(app()->getLocale() === 'en')
                            {{ $countdownTitleEn }}
                        @else
                            {{ $countdownTitleAr }}
                        @endif
                    </h2>

                    <!-- Venue Pill Badge with Hover Glow -->
                    <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-[#052D48]/90 backdrop-blur-md border border-slate-200 dark:border-[#24BDC3]/30 shadow-sm text-slate-700 dark:text-slate-200 text-xs font-bold hover:shadow-md hover:border-[#24BDC3] transition-all duration-300">
                        <svg class="w-4 h-4 text-[#24BDC3] shrink-0 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? platform()->get('venue_name_fr', 'Centre des Conventions Mohamed Ben Ahmed (CCO) — Oran, Algérie') : (app()->getLocale() === 'en' ? platform()->get('venue_name_en', 'Mohamed Ben Ahmed Convention Center (CCO) — Oran, Algeria') : platform()->get('venue_name', 'مركز المؤتمرات محمد بن أحمد (CCO) — وهران، الجزائر')) }}</span>
                    </div>

                </div>

                <!-- Right Side: Tech Orbital Africa Map Badge with Spin & Float -->
                <div class="lg:col-span-5 flex justify-center">
                    <div class="relative w-64 h-64 sm:w-80 sm:h-80 flex items-center justify-center group/map">
                        <!-- Dual Orbital Radar Rings with Spin Animation -->
                        <div class="absolute inset-0 rounded-full border-2 border-[#24BDC3]/30 animate-spin pointer-events-none" style="animation-duration: 25s;"></div>
                        <div class="absolute inset-3 rounded-full border border-dashed border-[#24BDC3]/50 animate-spin pointer-events-none" style="animation-duration: 15s; animation-direction: reverse;"></div>
                        <div class="absolute inset-8 rounded-full bg-gradient-to-tr from-teal-50/60 via-white to-blue-50/60 dark:from-[#052D48] dark:via-[#031826] dark:to-[#083b5e] shadow-xl flex items-center justify-center p-6 border border-white dark:border-[#24BDC3]/30 group-hover/map:scale-105 group-hover/map:rotate-3 transition-all duration-700">
                            <img src="/AFRICA.png" alt="{{ platform()->name() }}" class="w-full h-full object-contain filter drop-shadow-2xl">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Middle Row: 4 Symmetric Counter Cards + Date Card -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch relative z-10">

                <!-- Left: 4 Perfectly Symmetric Counter Cards -->
                <div class="lg:col-span-8 bg-slate-50/90 dark:bg-[#052D48]/80 backdrop-blur-md rounded-3xl p-5 sm:p-6 shadow-xl border border-slate-200 dark:border-[#24BDC3]/30">
                    <div class="grid grid-cols-4 gap-3 h-full">

                        <!-- DAYS — Bright Teal -->
                        <div class="flex flex-col items-center justify-between gap-3 p-4 rounded-2xl bg-white dark:bg-[#031826] border border-teal-200 dark:border-[#24BDC3]/40 hover:border-[#24BDC3] hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 group/cd cursor-default">
                            <div class="w-9 h-9 rounded-xl bg-[#24BDC3]/15 flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#24BDC3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <div class="text-4xl sm:text-5xl font-black font-mono text-[#24BDC3] leading-none group-hover/cd:scale-105 transition-transform tabular-nums" id="cd-days">
                                {{ str_pad($eventCountdown['days'] ?? 104, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="text-[11px] font-black text-slate-600 dark:text-slate-300 uppercase tracking-widest">
                                {{ app()->getLocale() === 'fr' ? 'JOUR' : (app()->getLocale() === 'en' ? 'DAY' : 'يوم') }}
                            </div>
                            <div class="w-full h-1.5 bg-teal-100 dark:bg-[#052D48] rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-[#24BDC3] to-[#42CBD0] h-full rounded-full" style="width:80%"></div>
                            </div>
                        </div>

                        <!-- HOURS — Bright Teal -->
                        <div class="flex flex-col items-center justify-between gap-3 p-4 rounded-2xl bg-white dark:bg-[#031826] border border-teal-200 dark:border-[#24BDC3]/40 hover:border-[#24BDC3] hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 group/cd cursor-default">
                            <div class="w-9 h-9 rounded-xl bg-[#24BDC3]/15 flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#24BDC3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="text-4xl sm:text-5xl font-black font-mono text-[#24BDC3] leading-none group-hover/cd:scale-105 transition-transform tabular-nums" id="cd-hours">
                                {{ str_pad($eventCountdown['hours'] ?? 7, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="text-[11px] font-black text-slate-600 uppercase tracking-widest">
                                {{ app()->getLocale() === 'fr' ? 'HEURE' : (app()->getLocale() === 'en' ? 'HOUR' : 'ساعة') }}
                            </div>
                            <div class="w-full h-1.5 bg-emerald-100 rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-[#35A536] to-emerald-400 h-full rounded-full" style="width:60%"></div>
                            </div>
                        </div>

                        <!-- MINUTES — Teal -->
                        <div class="flex flex-col items-center justify-between gap-3 p-4 rounded-2xl bg-white dark:bg-[#031826] border border-teal-200 dark:border-[#24BDC3]/40 hover:border-[#24BDC3] hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 group/cd cursor-default">
                            <div class="w-9 h-9 rounded-xl bg-[#24BDC3]/15 flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#24BDC3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="text-4xl sm:text-5xl font-black font-mono text-[#24BDC3] leading-none group-hover/cd:scale-105 transition-transform tabular-nums" id="cd-minutes">
                                {{ str_pad($eventCountdown['minutes'] ?? 14, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="text-[11px] font-black text-slate-600 dark:text-slate-300 uppercase tracking-widest">
                                {{ app()->getLocale() === 'fr' ? 'MIN' : (app()->getLocale() === 'en' ? 'MIN' : 'دقيقة') }}
                            </div>
                            <div class="w-full h-1.5 bg-teal-100 dark:bg-[#052D48] rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-[#24BDC3] to-[#42CBD0] h-full rounded-full" style="width:75%"></div>
                            </div>
                        </div>

                        <!-- SECONDS — Pulsing Teal -->
                        <div class="flex flex-col items-center justify-between gap-3 p-4 rounded-2xl bg-white dark:bg-[#031826] border border-teal-300 dark:border-[#24BDC3]/50 hover:border-[#24BDC3] hover:-translate-y-1.5 hover:shadow-lg transition-all duration-300 group/cd cursor-default">
                            <div class="w-9 h-9 rounded-xl bg-[#24BDC3]/15 flex items-center justify-center">
                                <svg class="w-5 h-5 text-[#24BDC3] animate-spin" style="animation-duration:3s" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div class="text-4xl sm:text-5xl font-black font-mono text-[#24BDC3] leading-none animate-pulse tabular-nums" id="cd-seconds">
                                {{ str_pad($eventCountdown['seconds'] ?? 36, 2, '0', STR_PAD_LEFT) }}
                            </div>
                            <div class="text-[11px] font-black text-[#24BDC3] uppercase tracking-widest">
                                {{ app()->getLocale() === 'fr' ? 'SEC' : (app()->getLocale() === 'en' ? 'SEC' : 'ثانية') }}
                            </div>
                            <div class="w-full h-1.5 bg-teal-100 dark:bg-[#052D48] rounded-full overflow-hidden">
                                <div class="bg-gradient-to-r from-[#24BDC3] to-[#42CBD0] h-full w-full rounded-full animate-pulse"></div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Dark Event Date Card with Hover Glow -->
                <div class="lg:col-span-4 bg-gradient-to-br from-[#052D48] via-[#031826] to-[#010a12] text-white rounded-3xl p-6 shadow-2xl flex flex-col justify-between text-center space-y-4 border border-[#24BDC3]/40 hover:-translate-y-1.5 hover:shadow-[0_0_30px_rgba(36,189,195,0.3)] transition-all duration-300 group/date">
                    <div class="space-y-2">
                        <div class="w-12 h-12 rounded-2xl bg-white/10 mx-auto flex items-center justify-center border border-white/20 shadow-md group-hover/date:rotate-12 transition-transform duration-500">
                            <svg class="w-6 h-6 text-[#24BDC3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <h3 class="text-3xl sm:text-4xl font-black tracking-tight text-white drop-shadow-md">
                            <span dir="ltr" class="inline-block font-mono">16 - 18</span>
                        </h3>
                        <p class="text-base font-black text-[#24BDC3]">{{ app()->getLocale() === 'fr' ? 'Novembre 2026' : (app()->getLocale() === 'en' ? 'November 2026' : 'نوفمبر 2026') }}</p>
                    </div>

                    <div class="pt-3 border-t border-white/15 text-xs font-black text-teal-200/90 tracking-wide">
                        {{ app()->getLocale() === 'fr' ? 'Forum des Politiques Africaines des Compétences' : (app()->getLocale() === 'en' ? 'Africa Skills Policy Forum 2026' : 'منتدى السياسات الأفريقية للمهارات 2026') }}
                    </div>
                </div>

            </div>

            <!-- Bottom Row: Event Timeline Stepper + About Forum Card -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pt-2 relative z-10">
                
                <!-- Left Event Timeline Stepper with Interactive Connecting Line (8 cols) -->
                <div class="lg:col-span-8 bg-slate-50/90 dark:bg-[#052D48]/80 backdrop-blur-md rounded-3xl p-6 shadow-xl border border-slate-200 dark:border-[#24BDC3]/30 space-y-5">
                    <div class="flex items-center justify-between">
                        <h4 class="text-base font-black text-[#052D48] dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#24BDC3]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Étapes Clés du Forum' : (app()->getLocale() === 'en' ? 'Key Forum Stages' : 'مراحل المنتدى الرئيسية') }}</span>
                        </h4>
                        <span class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ app()->getLocale() === 'fr' ? '6 étapes officielles' : (app()->getLocale() === 'en' ? '6 official stages' : '6 محطات رسمية') }}</span>
                    </div>
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 relative pt-2">
                        <!-- Horizontal Laser Connecting Line -->
                        <div class="hidden lg:block absolute top-7.5 left-8 right-8 h-1 bg-slate-200 dark:bg-[#031826] z-0 rounded-full overflow-hidden">
                            <div class="bg-gradient-to-r from-[#24BDC3] via-[#052D48] to-[#42CBD0] h-full w-full rounded-full animate-pulse"></div>
                        </div>

                        <!-- Step 1: Opening Ceremony -->
                        <div @click="$dispatch('open-schedule'); scheduleTab = 16" class="text-center space-y-2 relative z-10 group/step cursor-pointer">
                            <div class="w-11 h-11 rounded-2xl bg-white dark:bg-[#031826] text-[#24BDC3] border-2 border-teal-300 dark:border-[#24BDC3]/50 flex items-center justify-center mx-auto shadow-md group-hover/step:-translate-y-1.5 group-hover/step:scale-110 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div class="text-[11px] font-black text-slate-800 dark:text-slate-200 group-hover/step:text-[#24BDC3] transition-colors leading-tight">{{ app()->getLocale() === 'fr' ? 'Cérémonie d\'Ouverture' : (app()->getLocale() === 'en' ? 'Opening Ceremony' : 'حفل الافتتاح') }}</div>
                            <div class="inline-block px-2.5 py-1 rounded-full text-[11px] font-black shadow-sm" style="background-color: #0f766e; color: #ffffff !important; border: 1px solid #14b8a6;">16 {{ app()->getLocale() === 'fr' ? 'Nov. — 18:00' : (app()->getLocale() === 'en' ? 'Nov. — 18:00' : 'نوفمبر — 18:00') }}</div>
                        </div>

                        <!-- Step 2: Ministerial Roundtable -->
                        <div @click="$dispatch('open-schedule'); scheduleTab = 17" class="text-center space-y-2 relative z-10 group/step cursor-pointer">
                            <div class="w-11 h-11 rounded-2xl bg-white dark:bg-[#031826] text-[#24BDC3] border-2 border-teal-300 dark:border-[#24BDC3]/50 flex items-center justify-center mx-auto shadow-md group-hover/step:-translate-y-1.5 group-hover/step:scale-110 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            </div>
                            <div class="text-[11px] font-black text-slate-800 dark:text-slate-200 group-hover/step:text-[#24BDC3] transition-colors leading-tight">{{ app()->getLocale() === 'fr' ? 'Table Ronde Ministérielle' : (app()->getLocale() === 'en' ? 'Ministerial Roundtable' : 'المائدة المستديرة الوزارية') }}</div>
                            <div class="inline-block px-2.5 py-1 rounded-full text-[11px] font-black shadow-sm" style="background-color: #d97706; color: #ffffff !important; border: 1px solid #f59e0b;">17 {{ app()->getLocale() === 'fr' ? 'Nov. — 09:30' : (app()->getLocale() === 'en' ? 'Nov. — 09:30' : 'نوفمبر — 09:30') }}</div>
                        </div>

                        <!-- Step 3: Joint Declaration -->
                        <div @click="$dispatch('open-schedule'); scheduleTab = 17" class="text-center space-y-2 relative z-10 group/step cursor-pointer">
                            <div class="w-11 h-11 rounded-2xl bg-white dark:bg-[#031826] text-[#35A536] border-2 border-emerald-300 dark:border-emerald-500/50 flex items-center justify-center mx-auto shadow-md group-hover/step:-translate-y-1.5 group-hover/step:scale-110 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div class="text-[11px] font-black text-slate-800 dark:text-slate-200 group-hover/step:text-[#35A536] transition-colors leading-tight">{{ app()->getLocale() === 'fr' ? 'Déclaration Conjointe' : (app()->getLocale() === 'en' ? 'Joint Declaration' : 'الإعلان المشترك') }}</div>
                            <div class="inline-block px-2.5 py-1 rounded-full text-[11px] font-black shadow-sm" style="background-color: #059669; color: #ffffff !important; border: 1px solid #10b981;">17 {{ app()->getLocale() === 'fr' ? 'Nov. — 12:15' : (app()->getLocale() === 'en' ? 'Nov. — 12:15' : 'نوفمبر — 12:15') }}</div>
                        </div>

                        <!-- Step 4: Expert Panels -->
                        <div @click="$dispatch('open-schedule'); scheduleTab = 17" class="text-center space-y-2 relative z-10 group/step cursor-pointer">
                            <div class="w-11 h-11 rounded-2xl bg-white dark:bg-[#031826] text-purple-600 dark:text-purple-300 border-2 border-purple-300 dark:border-purple-500/50 flex items-center justify-center mx-auto shadow-md group-hover/step:-translate-y-1.5 group-hover/step:scale-110 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            </div>
                            <div class="text-[11px] font-black text-slate-800 dark:text-slate-200 group-hover/step:text-purple-600 transition-colors leading-tight">{{ app()->getLocale() === 'fr' ? 'Panneaux d\'Experts' : (app()->getLocale() === 'en' ? 'Expert Panels' : 'الجلسات التخصصية') }}</div>
                            <div class="inline-block px-2.5 py-1 rounded-full text-[11px] font-black shadow-sm" style="background-color: #7c3aed; color: #ffffff !important; border: 1px solid #8b5cf6;">17 {{ app()->getLocale() === 'fr' ? 'Nov. — 14:00' : (app()->getLocale() === 'en' ? 'Nov. — 14:00' : 'نوفمبر — 14:00') }}</div>
                        </div>

                        <!-- Step 5: Where Policy Meets Talent -->
                        <div @click="$dispatch('open-schedule'); scheduleTab = 18" class="text-center space-y-2 relative z-10 group/step cursor-pointer">
                            <div class="w-11 h-11 rounded-2xl bg-white dark:bg-[#031826] text-sky-600 dark:text-sky-300 border-2 border-sky-300 dark:border-sky-500/50 flex items-center justify-center mx-auto shadow-md group-hover/step:-translate-y-1.5 group-hover/step:scale-110 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            </div>
                            <div class="text-[11px] font-black text-slate-800 dark:text-slate-200 group-hover/step:text-sky-600 transition-colors leading-tight">{{ app()->getLocale() === 'fr' ? 'Politiques & Talents' : (app()->getLocale() === 'en' ? 'Where Policy Meets Talent' : 'التلاقي بين السياسات والمواهب') }}</div>
                            <div class="text-[10px] font-extrabold text-sky-700 dark:text-sky-200 bg-sky-50 dark:bg-[#052D48] px-2 py-0.5 rounded-full inline-block border border-sky-200 dark:border-[#24BDC3]/30">18 {{ app()->getLocale() === 'fr' ? 'Nov. — 09:30' : (app()->getLocale() === 'en' ? 'Nov. — 09:30' : 'نوفمبر — 09:30') }}</div>
                        </div>

                        <!-- Step 6: Closing Ceremony -->
                        <div @click="$dispatch('open-schedule'); scheduleTab = 18" class="text-center space-y-2 relative z-10 group/step cursor-pointer">
                            <div class="w-11 h-11 rounded-2xl bg-white dark:bg-[#031826] text-rose-600 dark:text-rose-300 border-2 border-rose-300 dark:border-rose-500/50 flex items-center justify-center mx-auto shadow-md group-hover/step:-translate-y-1.5 group-hover/step:scale-110 transition-all duration-300">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            </div>
                            <div class="text-[11px] font-black text-slate-800 dark:text-slate-200 group-hover/step:text-rose-600 transition-colors leading-tight">{{ app()->getLocale() === 'fr' ? 'Cérémonie de Clôture' : (app()->getLocale() === 'en' ? 'Closing Ceremony' : 'حفل الاختتام') }}</div>
                            <div class="text-[10px] font-extrabold text-rose-700 dark:text-rose-200 bg-rose-50 dark:bg-[#052D48] px-2 py-0.5 rounded-full inline-block border border-rose-200 dark:border-[#24BDC3]/30">18 {{ app()->getLocale() === 'fr' ? 'Nov. — 14:00' : (app()->getLocale() === 'en' ? 'Nov. — 14:00' : 'نوفمبر — 14:00') }}</div>
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

    <!-- 2.5 Africa Skills Policy Forum 2026 — Official High-Level Showcase -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 my-12 space-y-12">
        
        <!-- Main Forum Card Header & About Grid (Classy Pristine White Theme) -->
        <div class="relative bg-white text-slate-900 rounded-3xl p-6 sm:p-10 shadow-xl border border-slate-200/90 overflow-hidden">
            
            <!-- Dynamic Background Subtle Ambient Lighting -->
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#35A536]/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#F5A800]/10 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 space-y-8">
                
                <!-- Section Badge & Dates -->
                <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-amber-50 border border-amber-200 text-[#F5A800] flex items-center justify-center font-black shadow-xs">
                            <svg class="w-5 h-5 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <div>
                            <span class="text-xs font-black text-[#35A536] uppercase tracking-widest block">
                                {{ app()->getLocale() === 'fr' ? 'Événement Politique de Haut Niveau' : (app()->getLocale() === 'en' ? 'Principal High-Level Political Summit' : 'الحدث السياسي الرفيع المستوى الرئيسي') }}
                            </span>
                            <h2 class="text-2xl sm:text-3xl font-black text-[#0B2A6F]">
                                {{ !empty($forumData['name']) ? $forumData['name'] : (app()->getLocale() === 'fr' ? 'Forum des Politiques Africaines des Compétences 2026' : (app()->getLocale() === 'en' ? 'Africa Skills Policy Forum 2026' : 'منتدى السياسات الأفريقية للمهارات 2026')) }}
                            </h2>
                        </div>
                    </div>

                    <div class="px-5 py-2.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-black text-[#0B2A6F] flex items-center gap-2 shadow-xs">
                        <svg class="w-4 h-4 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>{{ !empty($forumData['dates']) ? $forumData['dates'] : (app()->getLocale() === 'fr' ? '16 – 18 Novembre 2026' : (app()->getLocale() === 'en' ? '16 – 18 November 2026' : '16 - 18 نوفمبر 2026')) }}</span>
                    </div>
                </div>

                <!-- What is Africa's Skills Policy Forum Body -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <div class="lg:col-span-7 space-y-4">
                        <h3 class="text-xl sm:text-2xl font-black text-[#0B2A6F]">
                            {{ app()->getLocale() === 'fr' ? 'Qu\'est-ce que le Forum des Politiques Africaines des Compétences ?' : (app()->getLocale() === 'en' ? 'What is Africa’s Skills Policy Forum?' : 'ما هو منتدى السياسات الأفريقية للمهارات؟') }}
                        </h3>

                        <p class="text-sm sm:text-base text-slate-600 font-medium leading-relaxed">
                            {{ !empty($forumData['description']) ? $forumData['description'] : (app()->getLocale() === 'fr' ? 'Le Forum des Politiques Africaines des Compétences est co-organisé par le Ministère de la Formation et de l\'Enseignement Professionnels d\'Algérie et la Commission de l\'Union Africaine, constituant le principal événement politique de haut niveau. Le Forum réunit les ministres africains chargés de l\'EFTP, des experts techniques et des partenaires institutionnels internationaux pour un programme d\'action fondé sur le dialogue ministériel, la coopération continentale et l\'engagement politique conjoint.' : (app()->getLocale() === 'en' ? 'The African Skills Policy Forum is co-organized by Algeria\'s Ministry of Vocational Training and Education and the African Union Commission, serving as the principal high-level political summit. The Forum brings together African Ministers responsible for technical and vocational education and training, together with technical experts and institutional and international partners, for a working programme of ministerial dialogue, continental cooperation, and shared political commitment.' : 'يُنظَّم منتدى السياسات الأفريقية للمهارات بشراكة بين وزارة التكوين والتعليم المهنيين بالجزائر ومفوضية الاتحاد الأفريقي، ليكون الحدث السياسي الرفيع المستوى الرئيسي. يجمع المنتدى الوزراء الأفارقة المكلفين بالتكوين والتعليم المهنيين، إلى جانب الخبراء التقنيين والشركاء المؤسساتيين والدوليين، في برنامج عمل يقوم على الحوار الوزاري والتعاون القاري والالتزام السياسي المشترك.')) }}
                        </p>

                        <div class="p-5 rounded-2xl bg-emerald-50/60 border-s-4 border-[#35A536] border-y border-e border-slate-200/80 space-y-1 shadow-xs">
                            <div class="flex items-center gap-1.5 text-xs font-black uppercase text-[#35A536] tracking-wider">
                                <svg class="w-4 h-4 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                <span>{{ app()->getLocale() === 'fr' ? 'Principe Fondateur' : (app()->getLocale() === 'en' ? 'Founding Principle' : 'المبدأ الأساسي للمنتدى') }}</span>
                            </div>
                            <blockquote class="text-base sm:text-lg font-black text-[#0B2A6F]">
                                "{{ !empty($forumData['principle']) ? $forumData['principle'] : (app()->getLocale() === 'fr' ? 'Façonner l\'avenir des compétences, autonomiser la jeunesse africaine' : (app()->getLocale() === 'en' ? 'Shaping the Future of Skills, Empowering Africa\'s Youth' : 'صياغة مستقبل المهارات، تمكين الشباب الأفريقي')) }}"
                            </blockquote>
                        </div>
                    </div>

                    <!-- Right Key Stat Highlights Card Grid (Classy White Metric Cards) -->
                    <div class="lg:col-span-5 grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-2 gap-3.5">
                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-1 hover:bg-white hover:shadow-md transition">
                            <div class="text-2xl font-black text-[#F5A800]">{{ $forumData['stat_countries'] ?? '+30' }}</div>
                            <div class="text-xs font-bold text-slate-600">{{ app()->getLocale() === 'fr' ? 'Pays participants' : (app()->getLocale() === 'en' ? 'Participating countries' : '+30 دولة مشاركة') }}</div>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-1 hover:bg-white hover:shadow-md transition">
                            <div class="text-2xl font-black text-[#35A536]">{{ $forumData['stat_ministers'] ?? '+20' }}</div>
                            <div class="text-xs font-bold text-slate-600">{{ app()->getLocale() === 'fr' ? 'Ministres attendus' : (app()->getLocale() === 'en' ? 'Ministers expected' : '+20 وزيراً متوقعاً') }}</div>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-1 hover:bg-white hover:shadow-md transition">
                            <div class="text-2xl font-black text-[#0B2A6F]">{{ $forumData['stat_roundtables'] ?? '2' }}</div>
                            <div class="text-xs font-bold text-slate-600">{{ app()->getLocale() === 'fr' ? 'Tables rondes ministérielles' : (app()->getLocale() === 'en' ? 'Ministerial Roundtables' : '2 موائد مستديرة وزارية') }}</div>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-1 hover:bg-white hover:shadow-md transition">
                            <div class="text-2xl font-black text-purple-600">2+</div>
                            <div class="text-xs font-bold text-slate-600">{{ app()->getLocale() === 'fr' ? 'Panneaux de haut niveau' : (app()->getLocale() === 'en' ? 'High-level panels' : '+2 جلسات رفيعة المستوى') }}</div>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-1 hover:bg-white hover:shadow-md transition col-span-2 sm:col-span-1 xl:col-span-2">
                            <div class="text-2xl font-black text-emerald-600">7</div>
                            <div class="text-xs font-bold text-slate-600">{{ app()->getLocale() === 'fr' ? '7 Axes thématiques' : (app()->getLocale() === 'en' ? '7 Thematic panels' : '7 ورشات ومحاور تخصصية') }}</div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- 7 Thematic Tracks Section -->
        <div class="space-y-6">
            <div class="text-center max-w-3xl mx-auto space-y-2">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-50 text-[#35A536] border border-emerald-200 text-xs font-black">
                    <svg class="w-4 h-4 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? '7 Axes Thématiques' : (app()->getLocale() === 'en' ? '7 Thematic Panels & Tracks' : 'المحاور التخصصية السبعة') }}</span>
                </div>
                <h3 class="text-2xl sm:text-4xl font-black text-[#0B2A6F]">
                    {{ app()->getLocale() === 'fr' ? 'Les 7 Axes Thématiques du Forum' : (app()->getLocale() === 'en' ? 'The 7 Core Thematic Panels' : 'المحاور والأجندة التخصصية السبعة للمنتدى') }}
                </h3>
                <p class="text-xs sm:text-sm text-slate-500 font-medium max-w-xl mx-auto">
                    {{ app()->getLocale() === 'fr' ? 'Orientations stratégiques pour relever les défis des compétences et façonner l\'avenir du travail en Afrique.' : (app()->getLocale() === 'en' ? 'Strategic directions addressing key skills challenges and shaping the future of work in Africa.' : 'محاور استراتيجية تناقش التحولات الكبرى وإصلاح المناهج وصناعة مهارات الغد.') }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                
                <!-- Track 1 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md hover:shadow-xl hover:border-[#0B2A6F] transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-[#0B2A6F] flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h4 class="text-base font-black text-[#0B2A6F] group-hover:text-[#35A536] transition">
                        1. {{ app()->getLocale() === 'fr' ? 'Réforme des Politiques d\'EFTP' : (app()->getLocale() === 'en' ? 'TVET Policy Reform' : 'إصلاح سياسات التكوين والتعليم المهني') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' ? 'Modernisation des cadres nationaux, harmonisation des certifications et politiques inclusives pour la jeunesse.' : (app()->getLocale() === 'en' ? 'Modernizing national frameworks, aligning qualifications, and implementing inclusive skills policies.' : 'تحديث الأطر الوطنية، توحيد مؤهلات التكوين، وتطوير المناهج لتتوافق مع معايير الجودة القارية.') }}
                    </p>
                </div>

                <!-- Track 2 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md hover:shadow-xl hover:border-[#35A536] transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#35A536] flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6m-6 0V10m6 11V10m-6 0a2 2 0 012-2h2a2 2 0 012 2m-6 0V6a2 2 0 012-2h2a2 2 0 012 2v4"/></svg>
                    </div>
                    <h4 class="text-base font-black text-[#0B2A6F] group-hover:text-[#35A536] transition">
                        2. {{ app()->getLocale() === 'fr' ? 'Compétences pour l\'Industrialisation' : (app()->getLocale() === 'en' ? 'Skills for Industrialization' : 'المهارات للتصنيع') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' ? 'Aligner la formation professionnelle sur les priorités industrielles continentales et le secteur manufacturier.' : (app()->getLocale() === 'en' ? 'Aligning vocational training with continental manufacturing goals and industrial infrastructure development.' : 'ربط برامج التكوين بااحتياجات القطاع الصناعي والتصنيعي والتكنولوجي لبناء اقتصاد قوي.') }}
                    </p>
                </div>

                <!-- Track 3 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md hover:shadow-xl hover:border-[#F5A800] transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-[#F5A800] flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="text-base font-black text-[#0B2A6F] group-hover:text-[#F5A800] transition">
                        3. {{ app()->getLocale() === 'fr' ? 'Financement du Développement des Compétences' : (app()->getLocale() === 'en' ? 'Financing Skills Development' : 'تمويل تطوير المهارات') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' ? 'Explorer des modèles de financement durables, partenariats public-privé et fonds d\'investissement.' : (app()->getLocale() === 'en' ? 'Exploring sustainable financing models, public-private partnerships, and innovative skills funds.' : 'ابتكار نماذج تمويل مستدامة، الشراكة بين القطاعين العام والخاص، واستثمار الموارد لبناء الكفاءات.') }}
                    </p>
                </div>

                <!-- Track 4 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md hover:shadow-xl hover:border-purple-500 transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h4 class="text-base font-black text-[#0B2A6F] group-hover:text-purple-600 transition">
                        4. {{ app()->getLocale() === 'fr' ? 'IA & l\'Avenir de l\'EFTP' : (app()->getLocale() === 'en' ? 'Artificial Intelligence & Future of TVET' : 'الذكاء الاصطناعي ومستقبل التكوين المهني') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' ? 'Intégrer les technologies émergentes, la numérisation et l\'intelligence artificielle dans la formation.' : (app()->getLocale() === 'en' ? 'Integrating artificial intelligence, digital learning tools, and future-proof tech in vocational curricula.' : 'دمج الذكاء الاصطناعي، التحول الرقمي، والمؤهلات التكنولوجية الحديثة في التكوين والتعليم المهني.') }}
                    </p>
                </div>

                <!-- Track 5 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md hover:shadow-xl hover:border-emerald-600 transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 012 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V14m-3 7c9 0 9-9 9-9s-9 0-9 9z"/></svg>
                    </div>
                    <h4 class="text-base font-black text-[#0B2A6F] group-hover:text-teal-700 transition">
                        5. {{ app()->getLocale() === 'fr' ? 'Compétences Vertes & Transition Juste' : (app()->getLocale() === 'en' ? 'Green Skills & Just Transition' : 'المهارات الخضراء والانتقال العادل') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' ? 'Préparer la main-d\'œuvre aux énergies renouvelables, l\'économie circulaire et la durabilité.' : (app()->getLocale() === 'en' ? 'Preparing the workforce for renewable energy, circular economies, and sustainable green transition.' : 'تأهيل اليد العاملة والشباب في مجالات الطاقة المتجددة، الاقتصاد الأخضر، والاستدامة البيئية.') }}
                    </p>
                </div>

                <!-- Track 6 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md hover:shadow-xl hover:border-sky-600 transition-all duration-300 space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-700 flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h4 class="text-base font-black text-[#0B2A6F] group-hover:text-sky-700 transition">
                        6. {{ app()->getLocale() === 'fr' ? 'Coopération Continentale & Gouvernance' : (app()->getLocale() === 'en' ? 'Continental Cooperation & Governance' : 'التعاون القاري والحوكمة') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' ? 'Renforcer les alliances bilatérales et multilatérales et la gouvernance conjointe inter-états.' : (app()->getLocale() === 'en' ? 'Strengthening bilateral and multilateral TVET partnerships across African Member States.' : 'تعزيز الشراكات الدبلوماسية والقارية بين الدول الأعضاء والتأطير المؤسساتي المشترك.') }}
                    </p>
                </div>

                <!-- Track 7: Digital Skills & Inclusion -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-md hover:shadow-xl hover:border-indigo-600 transition-all duration-300 space-y-4 group sm:col-span-2 lg:col-span-3 xl:col-span-1">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                    </div>
                    <h4 class="text-base font-black text-[#0B2A6F] group-hover:text-indigo-700 transition">
                        7. {{ app()->getLocale() === 'fr' ? 'Compétences Numériques & Inclusion' : (app()->getLocale() === 'en' ? 'Digital Skills & Inclusion' : 'المهارات الرقمية والشمول الاجتماعي') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' ? 'Démocratiser l\'accès aux compétences numériques, réduire la fracture numérique et autonomiser la jeunesse et les femmes.' : (app()->getLocale() === 'en' ? 'Democratizing digital skills access, bridging the digital divide, and empowering youth and women.' : 'تيسير الوصول للتربية الرقمية والتكنولوجية، ردم الفجوة الرقمية، وتمكين الشباب والمرأة في إفريقيا.') }}
                    </p>
                </div>

            </div>
        </div>

        <!-- Forum Agenda Program Flow (17 November 2026) Stepper -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-xl space-y-8">
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-100 pb-6">
                <div>
                    <div class="flex items-center gap-1.5 text-xs font-black text-[#35A536] uppercase tracking-widest">
                        <svg class="w-3.5 h-3.5 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Déroulement Officiel du Programme' : (app()->getLocale() === 'en' ? 'Official Forum Programme Flow' : 'التسلسل الإجرائي لبرنامج المنتدى') }}</span>
                    </div>
                    <h3 class="text-2xl font-black text-[#0B2A6F]">
                        {{ app()->getLocale() === 'fr' ? 'Parcours du Forum — 17 Novembre 2026' : (app()->getLocale() === 'en' ? 'Forum Working Programme — 17 November 2026' : 'مسار المنتدى — 17 نوفمبر 2026') }}
                    </h3>
                </div>
                <span class="px-4 py-2 rounded-2xl bg-amber-50 text-[#F5A800] border border-amber-200 text-xs font-black">
                    {{ app()->getLocale() === 'fr' ? '6 Étapes Majeures' : (app()->getLocale() === 'en' ? '6 Key Stages' : '6 محطات رسمية') }}
                </span>
            </div>

            <!-- Horizontal Flow Timeline Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-4 relative">
                
                <!-- Stage 1 -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-[#0B2A6F] transition text-center space-y-2 group">
                    <div class="w-10 h-10 rounded-xl bg-blue-100 text-[#0B2A6F] flex items-center justify-center font-black mx-auto group-hover:scale-110 transition">1</div>
                    <h5 class="text-xs font-black text-[#0B2A6F]">
                        {{ app()->getLocale() === 'fr' ? 'Cérémonie d\'Ouverture' : (app()->getLocale() === 'en' ? 'Opening Ceremony' : 'حفل الافتتاح') }}
                    </h5>
                    <p class="text-[11px] text-slate-500 font-medium">
                        {{ app()->getLocale() === 'fr' ? 'Allocutions officielles & accueil' : (app()->getLocale() === 'en' ? 'Official keynotes & welcome' : 'الكلمات الرسمية واستقبال الوفود') }}
                    </p>
                </div>

                <!-- Stage 2 -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-[#35A536] transition text-center space-y-2 group">
                    <div class="w-10 h-10 rounded-xl bg-emerald-100 text-[#35A536] flex items-center justify-center font-black mx-auto group-hover:scale-110 transition">2</div>
                    <h5 class="text-xs font-black text-[#0B2A6F]">
                        {{ app()->getLocale() === 'fr' ? 'Table Ronde Ministérielle' : (app()->getLocale() === 'en' ? 'Ministerial Roundtable' : 'الطاولة المستديرة الوزارية') }}
                    </h5>
                    <p class="text-[11px] text-slate-500 font-medium">
                        {{ app()->getLocale() === 'fr' ? 'Dialogue ministériel & débats' : (app()->getLocale() === 'en' ? '2 High-level ministerial sessions' : 'جلستان وزارياتان للحوار القاري') }}
                    </p>
                </div>

                <!-- Stage 3 -->
                <div class="p-4 rounded-2xl bg-amber-50/80 border border-amber-200 hover:border-[#F5A800] transition text-center space-y-2 group">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 text-[#F5A800] flex items-center justify-center font-black mx-auto group-hover:scale-110 transition">3</div>
                    <h5 class="text-xs font-black text-amber-900">
                        {{ app()->getLocale() === 'fr' ? 'Déclaration Conjointe' : (app()->getLocale() === 'en' ? 'Joint Declaration' : 'الإعلان المشترك') }}
                    </h5>
                    <p class="text-[11px] text-amber-700 font-medium">
                        {{ app()->getLocale() === 'fr' ? 'Adoption de la Déclaration 2026' : (app()->getLocale() === 'en' ? 'Adopting Skills for Tomorrow' : 'اعتماد إعلان مهارات المستقبل') }}
                    </p>
                </div>

                <!-- Stage 4 -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-purple-500 transition text-center space-y-2 group">
                    <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center font-black mx-auto group-hover:scale-110 transition">4</div>
                    <h5 class="text-xs font-black text-[#0B2A6F]">
                        {{ app()->getLocale() === 'fr' ? 'Panneaux d\'Experts' : (app()->getLocale() === 'en' ? 'Expert Panels' : 'الجلسات التخصصية') }}
                    </h5>
                    <p class="text-[11px] text-slate-500 font-medium">
                        {{ app()->getLocale() === 'fr' ? '5+ débats thématiques' : (app()->getLocale() === 'en' ? '5+ high-level expert panels' : 'جلسات نقاش مع الخبراء الدوليين') }}
                    </p>
                </div>

                <!-- Stage 5 -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-sky-500 transition text-center space-y-2 group">
                    <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center font-black mx-auto group-hover:scale-110 transition">5</div>
                    <h5 class="text-xs font-black text-[#0B2A6F]">
                        {{ app()->getLocale() === 'fr' ? 'Politiques & Talents' : (app()->getLocale() === 'en' ? 'Where Policy Meets Talent' : 'التلاقي بين السياسات والمواهب') }}
                    </h5>
                    <p class="text-[11px] text-slate-500 font-medium">
                        {{ app()->getLocale() === 'fr' ? 'Rencontre jeunes & décideurs' : (app()->getLocale() === 'en' ? 'Bridging leadership and youth' : 'ربط صناع القرار بالشباب الإفريقي') }}
                    </p>
                </div>

                <!-- Stage 6 -->
                <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 hover:border-rose-500 transition text-center space-y-2 group">
                    <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center font-black mx-auto group-hover:scale-110 transition">6</div>
                    <h5 class="text-xs font-black text-[#0B2A6F]">
                        {{ app()->getLocale() === 'fr' ? 'Cérémonie de Clôture' : (app()->getLocale() === 'en' ? 'Closing Ceremony' : 'حفل الاختتام') }}
                    </h5>
                    <p class="text-[11px] text-slate-500 font-medium">
                        {{ app()->getLocale() === 'fr' ? 'Conclusions & recommandations' : (app()->getLocale() === 'en' ? 'Final remarks & commitments' : 'توصيات وختام فعاليات المنتدى') }}
                    </p>
                </div>

            </div>
        </div>

        <!-- 5 Core Forum Objectives Grid -->
        <div class="space-y-6">
            <div class="text-center max-w-3xl mx-auto space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-50 text-[#0B2A6F] border border-blue-200 text-xs font-black">
                    <svg class="w-4 h-4 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Objectifs Stratégiques' : (app()->getLocale() === 'en' ? 'Core Forum Objectives' : 'الأهداف الاستراتيجية الـ 5 للمنتدى') }}</span>
                </div>
                <h3 class="text-2xl sm:text-4xl font-black text-[#0B2A6F]">
                    {{ app()->getLocale() === 'fr' ? 'Les 5 Objectifs Majeurs du Forum' : (app()->getLocale() === 'en' ? 'The 5 Core Strategic Objectives' : 'الأهداف الـ 5 الرئيسية لمنتدى المهارات') }}
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Objective 1 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-lg hover:shadow-xl transition space-y-3 relative overflow-hidden group">
                    <div class="w-10 h-10 rounded-2xl bg-[#0B2A6F] text-white flex items-center justify-center font-black text-sm shadow-md group-hover:scale-110 transition">
                        01
                    </div>
                    <h4 class="text-base font-black text-[#0B2A6F] leading-snug">
                        {{ app()->getLocale() === 'fr' ? 'Mettre en œuvre la Stratégie Continentale d\'EFTP (2025–34)' : (app()->getLocale() === 'en' ? 'Advance Continental TVET Strategy (2025–34)' : 'تنفيذ الاستراتيجية القارية للتكوين المهني (2025–2034)') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' 
                            ? 'Faire progresser la mise en œuvre de la stratégie continentale d\'EFTP (2025–34) dans les États membres africains et traduire les engagements en actions concrètes.' 
                            : (app()->getLocale() === 'en' 
                                ? 'Advance the implementation of the Continental TVET Strategy (2025–34) across African Member States, translating continental commitments into concrete action.' 
                                : 'النهوض بتنفيذ الاستراتيجية القارية للتكوين المهني والتقني (2025–2034) عبر الدول الأعضاء الأفريقية، وترجمة الالتزامات القارية إلى إجراءات ملموسة.') }}
                    </p>
                </div>

                <!-- Objective 2 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-lg hover:shadow-xl transition space-y-3 relative overflow-hidden group">
                    <div class="w-10 h-10 rounded-2xl bg-[#35A536] text-white flex items-center justify-center font-black text-sm shadow-md group-hover:scale-110 transition">
                        02
                    </div>
                    <h4 class="text-base font-black text-[#0B2A6F] leading-snug">
                        {{ app()->getLocale() === 'fr' ? 'Plateforme Structurée d\'Échange d\'Expériences' : (app()->getLocale() === 'en' ? 'Structured TVET Exchange Platform' : 'منصة منظمة لتبادل التجارب الناجحة') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' 
                            ? 'Créer une plateforme structurée permettant aux ministères africains d\'échanger des expériences éprouvées — réforme des programmes, modèles de financement et partenariats.' 
                            : (app()->getLocale() === 'en' 
                                ? 'Create a structured platform for African Ministries to exchange proven experience in TVET — curricula reform, financing models, industry partnerships, and apprenticeship systems.' 
                                : 'إنشاء منصة منظمة تتيح للوزارات الأفريقية تبادل التجارب الناجحة في مجال التكوين المهني — إصلاح المناهج، نماذج التمويل، الشراكات مع القطاع الصناعي، وأنظمة التمهين.') }}
                    </p>
                </div>

                <!-- Objective 3 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-lg hover:shadow-xl transition space-y-3 relative overflow-hidden group">
                    <div class="w-10 h-10 rounded-2xl bg-[#F5A800] text-[#0B2A6F] flex items-center justify-center font-black text-sm shadow-md group-hover:scale-110 transition">
                        03
                    </div>
                    <h4 class="text-base font-black text-[#0B2A6F] leading-snug">
                        {{ app()->getLocale() === 'fr' ? 'Adopter la Déclaration sur les Compétences de Demain' : (app()->getLocale() === 'en' ? 'Adopt Declaration on Skills for Tomorrow' : 'اعتماد إعلان مهارات المستقبل') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' 
                            ? 'Adopter une Déclaration sur les compétences de demain, anticipant les besoins futurs des économies africaines au-delà des programmes actuels.' 
                            : (app()->getLocale() === 'en' 
                                ? 'Adopt a Declaration on Skills for Tomorrow, anticipating the technical and vocational skills Africa\'s economies will need in the years ahead.' 
                                : 'اعتماد إعلان حول مهارات المستقبل، يستشرف المهارات التقنية والمهنية التي ستحتاجها اقتصادات إفريقيا في السنوات القادمة، وليس فقط تلك المدرجة حاليًا.') }}
                    </p>
                </div>

                <!-- Objective 4 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-lg hover:shadow-xl transition space-y-3 relative overflow-hidden group">
                    <div class="w-10 h-10 rounded-2xl bg-sky-600 text-white flex items-center justify-center font-black text-sm shadow-md group-hover:scale-110 transition">
                        04
                    </div>
                    <h4 class="text-base font-black text-[#0B2A6F] leading-snug">
                        {{ app()->getLocale() === 'fr' ? 'Renforcer les Partenariats Bilatéraux & Multilatéraux' : (app()->getLocale() === 'en' ? 'Strengthen Bilateral & Multilateral Alliances' : 'تعزيز الشراكات الثنائية والمتعددة الأطراف') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' 
                            ? 'Renforcer les partenariats bilatéraux et multilatéraux en matière d\'EFTP entre les États membres africains et les partenaires institutionnels internationaux.' 
                            : (app()->getLocale() === 'en' 
                                ? 'Strengthen bilateral and multilateral partnerships in TVET between African Member States and international institutional partners.' 
                                : 'تعزيز الشراكات الثنائية والمتعددة الأطراف في مجال التكوين المهني بين الدول الأفريقية الأعضاء والشركاء المؤسساتيين الدوليين.') }}
                    </p>
                </div>

                <!-- Objective 5 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200 shadow-lg hover:shadow-xl transition space-y-3 relative overflow-hidden group md:col-span-2 lg:col-span-1">
                    <div class="w-10 h-10 rounded-2xl bg-purple-600 text-white flex items-center justify-center font-black text-sm shadow-md group-hover:scale-110 transition">
                        05
                    </div>
                    <h4 class="text-base font-black text-[#0B2A6F] leading-snug">
                        {{ app()->getLocale() === 'fr' ? 'Programme de Renforcement des Capacités des Jeunes' : (app()->getLocale() === 'en' ? 'Youth Capacity-Building Programme' : 'برنامج لبناء قدرات الشباب الأفريقي') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ app()->getLocale() === 'fr' 
                            ? 'Déployer un programme dédié au renforcement des capacités de la jeunesse africaine dans 5 compétences prioritaires, au-delà de la compétition.' 
                            : (app()->getLocale() === 'en' 
                                ? 'Deliver a dedicated capacity-building programme for African youth across five priority skills, reinforcing technical capacities beyond the competition floor.' 
                                : 'تنفيذ برنامج مخصص لبناء القدرات لفائدة الشباب الأفريقي في خمسة اختصاصات ذات أولوية، بما يعزز القدرات التقنية للمشاركين خارج فضاء المنافسة.') }}
                    </p>
                </div>

            </div>
        </div>

    </section>

    <!-- 3. Dynamic Real DB Statistics Grid tailored for Africa Skills Policy Forum 2026 -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6">
            <x-animated-counter :target="30" :label="app()->getLocale() === 'fr' ? 'Pays Africains' : (app()->getLocale() === 'en' ? 'African Nations' : 'الدول الإفريقية')" :description="app()->getLocale() === 'fr' ? 'Délégations officielles' : (app()->getLocale() === 'en' ? 'Official Delegations' : 'الوفود الوطنية الرسمية')" color="text-[#F5A800]">
                <x-slot:icon><svg class="w-6 h-6 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 012 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V14m-3 7c9 0 9-9 9-9s-9 0-9 9z"/></svg></x-slot:icon>
            </x-animated-counter>
            <x-animated-counter :target="$stats['ministers'] ?? 20" :label="app()->getLocale() === 'fr' ? 'Ministres Attendus' : (app()->getLocale() === 'en' ? 'Ministers Expected' : 'الوزراء والوفود')" :description="app()->getLocale() === 'fr' ? 'Ministres de la Formation' : (app()->getLocale() === 'en' ? 'Vocational Ministers' : 'وزراء التكوين والتعليم المهني')" color="text-[#35A536]">
                <x-slot:icon><svg class="w-6 h-6 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg></x-slot:icon>
            </x-animated-counter>
            <x-animated-counter :target="$stats['experts'] ?? 0" :label="app()->getLocale() === 'fr' ? 'Experts & Conférenciers' : (app()->getLocale() === 'en' ? 'Experts & Speakers' : 'الخبراء والمحاضرون')" :description="app()->getLocale() === 'fr' ? 'Panélistes internationaux' : (app()->getLocale() === 'en' ? 'International Panelists' : 'المحاضرون والخبراء التقنيون')" color="text-[#F5A800]">
                <x-slot:icon><svg class="w-6 h-6 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg></x-slot:icon>
            </x-animated-counter>
            <x-animated-counter :target="$stats['participants'] ?? 0" :label="app()->getLocale() === 'fr' ? 'Délégués Inscrits' : (app()->getLocale() === 'en' ? 'Registered Delegates' : 'المشاركين المسجلين')" :description="app()->getLocale() === 'fr' ? 'Délégués & Jeunes' : (app()->getLocale() === 'en' ? 'African Delegates & Youth' : 'الوفود والمشاركون الشباب')" color="text-[#0B2A6F]">
                <x-slot:icon><svg class="w-6 h-6 text-[#0B2A6F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg></x-slot:icon>
            </x-animated-counter>
            <x-animated-counter :target="$stats['panels'] ?? 7" :label="app()->getLocale() === 'fr' ? 'Axes & Sessions' : (app()->getLocale() === 'en' ? 'Panels & Sessions' : 'الورشات والجلسات')" :description="app()->getLocale() === 'fr' ? 'Thématiques du Forum' : (app()->getLocale() === 'en' ? 'Forum Key Panels' : 'الورشات والجلسات التخصصية')" color="text-[#35A536]">
                <x-slot:icon><svg class="w-6 h-6 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg></x-slot:icon>
            </x-animated-counter>
            <x-animated-counter :target="$stats['partners'] ?? 10" :label="app()->getLocale() === 'fr' ? 'Partenaires Officiels' : (app()->getLocale() === 'en' ? 'Official Partners' : 'الشركاء والرعاة')" :description="app()->getLocale() === 'fr' ? 'Soutien institutionnel' : (app()->getLocale() === 'en' ? 'Institutional Support' : 'الدعم المؤسساتي والدولي')" color="text-[#0B2A6F]">
                <x-slot:icon><svg class="w-6 h-6 text-[#0B2A6F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg></x-slot:icon>
            </x-animated-counter>
        </div>
    </section>

    <!-- 4. Featured Skills Showcase -->
    @if(filter_var(platform()->get('show_skills_section', 'true'), FILTER_VALIDATE_BOOLEAN))
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
                        {{ app()->getLocale() === 'fr' ? 'Métiers de la Compétition & Guide Technique' : (app()->getLocale() === 'en' ? 'Competition Skills & Trade Guide' : 'تخصصات المنافسة ودليل المهن') }}
                    </span>
                </h2>

                <p class="text-xs sm:text-sm text-slate-500 font-bold max-w-2xl group-hover/head:text-slate-700 transition-colors">
                    @if(app()->getLocale() === 'fr')
                        Explorez les métiers de la compétition: Nous vous invitons à consulter le guide des métiers pour découvrir tous les détails et normes techniques de chaque compétence.
                    @elseif(app()->getLocale() === 'en')
                        Explore competition skills: We invite you to visit the skills directory to review full details and technical standards for each trade.
                    @else
                        استكشف تخصصات المنافسة: ندعوك لزيارة دليل المهن للاطلاع على كافة التفاصيل والمعايير التقنية الخاصة بكل مهارة.
                    @endif
                </p>
            </div>

            <a href="{{ route('skills') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-gradient-to-r from-[#0B2A6F] to-[#35A536] hover:from-[#35A536] hover:to-[#0B2A6F] text-white text-xs font-black shadow-lg hover:scale-105 transition-all duration-300 group/btn self-start md:self-auto border border-white/20">
                <span>{{ app()->getLocale() === 'fr' ? 'Guide des Métiers' : (app()->getLocale() === 'en' ? 'Skills & Trades Directory' : 'دليل المهن والتخصصات') }}</span>
                <svg class="w-4 h-4 text-white group-hover/btn:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @if(count($skills) > 0)
                @foreach($skills as $skill)
                    <a wire:key="skill-card-{{ $skill->id }}" href="{{ route('skills', ['skill' => $skill->id]) }}" class="bg-white rounded-3xl overflow-hidden shadow-xl border border-slate-200/90 hover:shadow-2xl transition-all duration-400 transform hover:-translate-y-2 group cursor-pointer flex flex-col justify-between hover:border-[#35A536] wsap-hover-card">
                        
                        {{-- Photo Banner Header --}}
                        <div class="h-48 bg-slate-950 relative overflow-hidden">
                            <img src="{{ asset($skill->image_path ?: 'images/skills/trade_16.png') }}"
                                 onerror="this.onerror=null; this.src='/images/skills/ict.png';"
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
                                    {{ app()->getLocale() === 'fr' 
                                        ? "Normes techniques et cahier des charges officiel pour l'épreuve " . $skill->getLocalized('name') . " selon les standards officiels."
                                        : (app()->getLocale() === 'en' 
                                            ? "Official technical description standard for " . $skill->getLocalized('name') . " skill according to official standards."
                                            : "المعايير والوصف التقني الرسمي للتخصص " . $skill->getLocalized('name') . " وفق المعايير والضوابط المعتمدة.") }}
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
                @endforeach
            @else
                <div class="col-span-3 bg-white rounded-3xl p-8 text-center text-slate-400 font-medium text-sm">
                    {{ app()->getLocale() === 'fr' ? 'Aucune discipline disponible actuellement.' : (app()->getLocale() === 'en' ? 'No trade categories added yet.' : 'لا توجد تخصصات مضافة حالياً.') }}
                </div>
            @endif
        </div>
    </section>
    @endif

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
                        @if(count($albums) > 0)
                            @foreach($albums as $album)
                                <a wire:key="album-card-{{ $album->id }}" href="{{ route('gallery') }}" class="flex items-center gap-3 group">
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
                            @endforeach
                        @else
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-10 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center flex-shrink-0 border border-slate-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-[#0B2A6F] leading-snug line-clamp-1">African Skills Policy Forum 2026</h4>
                                    <span class="text-[10px] text-slate-400">2026-08-04</span>
                                </div>
                            </div>
                        @endif
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
                        @php
                            $dynamicEvents = \App\Models\Event::where('status', 'PUBLISHED')->orderBy('start_at')->take(2)->get();
                        @endphp

                        @if($dynamicEvents->count() > 0)
                            @foreach($dynamicEvents as $ev)
                                <a href="{{ route('events') }}" class="flex items-start gap-3 group/ev hover:opacity-90 transition">
                                    <div class="w-10 h-10 rounded-xl bg-teal-50 text-[#24BDC3] flex flex-col items-center justify-center flex-shrink-0 font-bold border border-teal-200 group-hover/ev:scale-105 transition-transform">
                                        <span class="text-xs leading-none">{{ $ev->start_at ? $ev->start_at->format('d') : '16' }}</span>
                                        <span class="text-[9px] uppercase">{{ $ev->start_at ? $ev->start_at->format('M') : 'NOV' }}</span>
                                    </div>
                                    <div>
                                        <h4 class="text-xs font-bold text-[#06205C] group-hover/ev:text-[#24BDC3] transition-colors line-clamp-1">
                                            {{ $ev->getLocalized('title') }}
                                        </h4>
                                        <span class="text-[10px] text-slate-400 block line-clamp-1">{{ $ev->venue ?: 'مركز المؤتمرات — وهران' }}</span>
                                    </div>
                                </a>
                            @endforeach
                        @else
                            <a href="{{ route('events') }}" class="flex items-start gap-3 group/ev">
                                <div class="w-10 h-10 rounded-xl bg-teal-50 text-[#24BDC3] flex flex-col items-center justify-center flex-shrink-0 font-bold border border-teal-200">
                                    <span class="text-xs leading-none">16</span>
                                    <span class="text-[9px] uppercase">{{ app()->getLocale() === 'fr' ? 'NOV' : (app()->getLocale() === 'en' ? 'NOV' : 'نوفمبر') }}</span>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-[#06205C] group-hover/ev:text-[#24BDC3] transition-colors">
                                        {{ app()->getLocale() === 'fr' ? 'Cérémonie d\'Ouverture Officielle du Forum' : (app()->getLocale() === 'en' ? 'Official Forum Opening Ceremony' : 'حفل الافتتاح الرسمي لمنتدى السياسات الأفريقية للمهارات 2026') }}
                                    </h4>
                                    <span class="text-[10px] text-slate-400">Mohamed Ben Ahmed Convention Center — Oran</span>
                                </div>
                            </a>
                        @endif
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
                        @if(count($news) > 0)
                            @foreach($news as $article)
                                <a wire:key="news-card-{{ $article->id }}" href="{{ route('news') }}" class="flex items-center gap-3 group">
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
                            @endforeach
                        @else
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-10 rounded-lg bg-slate-100 text-slate-400 flex items-center justify-center flex-shrink-0 border border-slate-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold text-[#06205C] leading-snug line-clamp-1">African Skills Policy Forum 2026</h4>
                                    <span class="text-[10px] text-slate-400">2026-08-04</span>
                                </div>
                            </div>
                        @endif
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
                        @if($featuredVideoThumbUrl)
                            <img src="{{ $featuredVideoThumbUrl }}" alt="Featured Video"
                                 class="w-full h-32 object-cover opacity-80 group-hover:scale-105 transition-transform duration-300"
                                 onerror="this.style.display='none'">
                        @else
                            <div class="w-full h-32 bg-gradient-to-br from-[#020A24] via-[#06205C] to-blue-900 flex items-center justify-center p-4">
                                <img src="/logo.png" alt="Africa Skills Forum" class="h-12 w-auto opacity-30 filter drop-shadow">
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
            @if(count($partners) > 0)
                @foreach($partners as $p)
                    <div wire:key="partner-card-{{ $p->id }}" class="flex flex-col items-center justify-center gap-2 group transition transform hover:scale-105 py-2 px-3">
                        <div class="h-10 sm:h-12 w-auto flex items-center justify-center">
                            @if($p->logo_path)
                                <img src="{{ asset($p->logo_path) }}" alt="{{ $p->getLocalized('name') }}" class="h-10 sm:h-12 w-auto object-contain filter grayscale group-hover:grayscale-0 transition duration-300">
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
                @endforeach
            @else
                <div class="text-xs text-slate-400 font-bold">
                    {{ app()->getLocale() === 'fr' ? 'Aucun partenaire disponible' : (app()->getLocale() === 'en' ? 'No featured partners yet' : 'لا يوجد شركاء مميزون حالياً.') }}
                </div>
            @endif
        </div>
    </section>
    @endif


    <!-- 7. Call to Action Banner -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl text-white p-8 lg:p-12 shadow-2xl relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-8 group bg-cover bg-center" style="background-image: linear-gradient(135deg, rgba(0, 45, 140, 0.88), rgba(0, 102, 255, 0.82)), url('/images/blue_bg.jpg');">
            
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
            
            <a href="{{ route('official.registration') }}" class="px-8 py-3.5 rounded-2xl bg-white text-[#0052CC] font-bold text-xs shadow-xl hover:bg-blue-50 transition flex items-center gap-2 flex-shrink-0 hover:scale-105">
                <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                <span>{{ __('messages.register_now') }}</span>
            </a>
        </div>
    </section>

    <!-- 8. Inline Video Pop-Up Modal (Plays video directly inside site without redirecting) -->
    <div x-show="showVideoModal" x-cloak x-transition.opacity class="fixed inset-0 z-50 bg-black/85 flex items-center justify-center p-4">
        <div @click.outside="showVideoModal = false" class="bg-slate-900 rounded-3xl overflow-hidden max-w-4xl w-full shadow-2xl border border-slate-700 relative">
            <button @click="showVideoModal = false" class="absolute top-4 right-4 z-10 w-10 h-10 rounded-full bg-black/60 text-white flex items-center justify-center hover:bg-black transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <div class="aspect-video w-full">
                <iframe class="w-full h-full" src="https://www.youtube.com/embed/ee7fzNFUKIM?autoplay=1" title="WorldSkills Video" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
    </div>

    <!-- Schedule & Events Official Programme Modal -->
    <div x-show="showScheduleModal" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 bg-slate-950/85 backdrop-blur-xs flex items-end sm:items-center justify-center p-0 sm:p-6 pb-16 sm:pb-6 overflow-y-auto">
        
        <div @click.outside="showScheduleModal = false" 
             class="bg-white dark:bg-[#031420] text-slate-900 dark:text-white rounded-t-3xl sm:rounded-3xl max-w-4xl w-full shadow-[0_25px_80px_rgba(0,0,0,0.35)] dark:shadow-[0_25px_80px_rgba(0,0,0,0.7)] border-t sm:border border-slate-200 dark:border-[#24BDC3]/40 relative overflow-hidden my-0 sm:my-auto max-h-[82vh] sm:max-h-[92vh] flex flex-col transition-colors">
            
            <!-- Background Ambient Glow Accents -->
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-blue-500/10 dark:bg-[#24BDC3]/15 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-emerald-500/10 dark:bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

            <!-- Modal Header Bar with Ministry Logo & AU Emblem -->
            <div class="p-3 sm:p-5 border-b border-slate-200 dark:border-[#24BDC3]/20 relative z-10 bg-slate-50/95 dark:bg-[#020b12]/95 backdrop-blur-md flex flex-col sm:flex-row items-start sm:items-center justify-between gap-2.5 sm:gap-4">
                
                <!-- Header Top Row (Decoupled Logos Box + Close Button on Mobile) -->
                <div class="flex items-center justify-between w-full sm:w-auto gap-3">
                    <!-- Official Dual Brand Logos -->
                    <div class="flex items-center gap-2 sm:gap-3 bg-white dark:bg-[#052033] p-1.5 sm:p-2 px-2.5 sm:px-4 rounded-xl sm:rounded-2xl border border-slate-200/90 dark:border-[#24BDC3]/30 shadow-xs shrink-0">
                        <img src="{{ asset('ministry-logo-trimmed.png') }}" 
                             alt="الجمهورية الجزائرية الديمقراطية الشعبية" 
                             class="h-5 sm:h-7 w-auto object-contain shrink-0 dark:hidden">
                        <img src="{{ asset('ministry-logo-white-trimmed.png') }}" 
                             alt="الجمهورية الجزائرية الديمقراطية الشعبية" 
                             class="h-5 sm:h-7 w-auto object-contain shrink-0 hidden dark:block">
                        
                        <div class="h-5 sm:h-6 w-px bg-slate-300 dark:bg-white/20 shrink-0"></div>
                        
                        <img src="{{ asset('africa-logo-trimmed.png') }}" 
                             alt="African Union - Africa Skills Forum" 
                             class="h-5 sm:h-7 w-auto object-contain shrink-0">
                    </div>

                    <!-- Mobile Close Button -->
                    <button @click="showScheduleModal = false" class="sm:hidden w-8 h-8 rounded-xl bg-slate-200/80 dark:bg-white/10 hover:bg-rose-600 text-slate-700 dark:text-slate-300 hover:text-white flex items-center justify-center shrink-0 border border-slate-300 dark:border-white/15 cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-1 flex-1 sm:text-right w-full">
                    <div class="inline-flex items-center gap-2 px-2.5 py-0.5 rounded-full bg-blue-50 dark:bg-[#24BDC3]/15 border border-blue-200/80 dark:border-[#24BDC3]/30 text-[10px] sm:text-[11px] font-black text-[#0B2A6F] dark:text-[#24BDC3]">
                        <span>{{ app()->getLocale() === 'fr' ? 'Programme Officiel 2026' : (app()->getLocale() === 'en' ? 'Official Forum Programme' : 'برنامج الفعاليات الرسمي 2026') }}</span>
                    </div>
                    <h3 class="text-sm sm:text-2xl font-black text-[#0B2A6F] dark:text-white tracking-tight leading-snug">
                        {{ app()->getLocale() === 'fr' ? 'Forum des Politiques Africaines des Compétences' : (app()->getLocale() === 'en' ? 'African Skills Policy Forum' : 'منتدى السياسات الأفريقية للمهارات 2026') }}
                    </h3>
                    <p class="text-[10px] sm:text-xs text-slate-500 dark:text-teal-200/80 font-bold flex items-center gap-1 sm:justify-end">
                        <svg class="w-3.5 h-3.5 text-brand-500 dark:text-[#24BDC3] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? '16 – 18 Novembre 2026 • Centre des Conventions d\'Oran' : (app()->getLocale() === 'en' ? '16 – 18 November 2026 • Mohamed Ben Ahmed Convention Center - Oran' : '16 – 18 نوفمبر 2026 • مركز المؤتمرات محمد بن أحمد - وهران') }}</span>
                    </p>
                </div>

                <!-- Desktop Close Button -->
                <button @click="showScheduleModal = false" class="hidden sm:flex w-9 h-9 rounded-xl bg-slate-100 dark:bg-white/10 hover:bg-rose-600 text-slate-600 dark:text-slate-300 hover:text-white border border-slate-200 dark:border-white/15 items-center justify-center transition cursor-pointer shrink-0 shadow-xs">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Modal Segmented Date Switcher Tabs (Dual Theme & Perfect 3-Grid Fit) -->
            <div class="px-3 sm:px-6 pt-2.5 pb-2 relative z-10">
                <div class="p-1 sm:p-1.5 bg-slate-100 dark:bg-[#052033] rounded-xl sm:rounded-2xl border border-slate-200 dark:border-[#24BDC3]/20 grid grid-cols-3 sm:flex items-center gap-1 sm:gap-2">
                    <button @click="scheduleTab = 16" 
                            class="px-2 sm:px-4 py-2 sm:py-2.5 rounded-lg sm:rounded-xl font-black text-[11px] sm:text-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                            :class="scheduleTab === 16 ? 'bg-[#0B2A6F] dark:bg-gradient-to-r dark:from-[#24BDC3] dark:to-[#00969B] text-white dark:text-[#02101b] shadow-md' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-white dark:hover:bg-white/5'">
                        <svg class="w-3.5 h-3.5 text-amber-400 dark:text-[#02101b] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>16 {{ app()->getLocale() === 'fr' ? 'Nov.' : (app()->getLocale() === 'en' ? 'Nov.' : 'نوفمبر') }} <span class="hidden sm:inline">— {{ app()->getLocale() === 'fr' ? 'Jour 1' : (app()->getLocale() === 'en' ? 'Day 1' : 'اليوم الأول') }}</span></span>
                    </button>

                    <button @click="scheduleTab = 17" 
                            class="px-2 sm:px-4 py-2 sm:py-2.5 rounded-lg sm:rounded-xl font-black text-[11px] sm:text-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                            :class="scheduleTab === 17 ? 'bg-[#35A536] dark:bg-gradient-to-r dark:from-[#35A536] dark:to-emerald-600 text-white shadow-md' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-white dark:hover:bg-white/5'">
                        <svg class="w-3.5 h-3.5 text-emerald-200 dark:text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <span>17 {{ app()->getLocale() === 'fr' ? 'Nov.' : (app()->getLocale() === 'en' ? 'Nov.' : 'نوفمبر') }} <span class="hidden sm:inline">— {{ app()->getLocale() === 'fr' ? 'Jour 2' : (app()->getLocale() === 'en' ? 'Day 2' : 'اليوم الثاني') }}</span></span>
                    </button>

                    <button @click="scheduleTab = 18" 
                            class="px-2 sm:px-4 py-2 sm:py-2.5 rounded-lg sm:rounded-xl font-black text-[11px] sm:text-xs transition-all flex items-center justify-center gap-1.5 cursor-pointer"
                            :class="scheduleTab === 18 ? 'bg-[#24BDC3] dark:bg-gradient-to-r dark:from-purple-500 dark:to-indigo-600 text-white shadow-md' : 'text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-white dark:hover:bg-white/5'">
                        <svg class="w-3.5 h-3.5 text-white shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <span>18 {{ app()->getLocale() === 'fr' ? 'Nov.' : (app()->getLocale() === 'en' ? 'Nov.' : 'نوفمبر') }} <span class="hidden sm:inline">— {{ app()->getLocale() === 'fr' ? 'Jour 3' : (app()->getLocale() === 'en' ? 'Day 3' : 'اليوم الثالث') }}</span></span>
                    </button>
                </div>
            </div>

            <!-- Modal Content Body (Clean no-scrollbar Touch Scroll) -->
            <div class="p-3 sm:p-6 space-y-3 overflow-y-auto no-scrollbar relative z-10 flex-1">
                
                <!-- Day 1: Nov 16 -->
                <div x-show="scheduleTab === 16" class="space-y-3">
                    <!-- Nov 16 Item 1: 18:00 -->
                    <div class="p-3.5 sm:p-5 rounded-2xl bg-slate-50 dark:bg-[#041a29]/90 border-s-4 border-amber-400 border-y border-e border-slate-200/90 dark:border-[#24BDC3]/20 hover:border-amber-400 dark:hover:border-[#24BDC3]/60 hover:shadow-md transition-all flex flex-col sm:flex-row items-start gap-3 sm:gap-4 group">
                        <div class="px-3 py-1 rounded-xl bg-amber-100 dark:bg-amber-400/20 text-amber-900 dark:text-amber-300 border border-amber-300 dark:border-amber-400/40 font-mono font-black text-xs sm:text-sm shrink-0">
                            18:00
                        </div>
                        <div class="space-y-1 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-full bg-amber-50 dark:bg-amber-400/15 text-amber-800 dark:text-amber-300 text-[10px] font-black border border-amber-200 dark:border-amber-400/30">
                                    {{ app()->getLocale() === 'fr' ? 'Cérémonie d\'Ouverture' : (app()->getLocale() === 'en' ? 'Official Opening' : 'حفل الافتتاح الرسمي') }}
                                </span>
                            </div>
                            <h4 class="text-sm sm:text-lg font-black text-[#0B2A6F] dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-300 transition leading-snug">
                                {{ app()->getLocale() === 'fr' ? 'Cérémonie d\'Ouverture Officielle du Forum et de la Compétition' : (app()->getLocale() === 'en' ? 'Opening Ceremony marking the official launch of African Skills Policy forum' : 'حفل الافتتاح الرسمي المنظم لإطلاق منتدى السياسات الأفريقية للمهارات والمسابقات الرسمية') }}
                            </h4>
                            <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                                {{ app()->getLocale() === 'fr' ? 'Lancement officiel du Forum des Politiques Africaines des Compétences avec la présence des hautes autorités et des délégations continentales.' : (app()->getLocale() === 'en' ? 'Official opening ceremony launching the African Skills Policy Forum alongside technical competition events with continental delegations.' : 'الافتتاح الرسمي للمنتدى بحضور رفيع المستوى للوزراء والوفود الأفريقية والشركاء الدوليين.') }}
                            </p>
                        </div>
                    </div>

                    <!-- Nov 16 Item 2: 22:30 -->
                    <div class="p-3.5 sm:p-5 rounded-2xl bg-slate-50 dark:bg-[#041a29]/90 border-s-4 border-[#35A536] border-y border-e border-slate-200/90 dark:border-[#24BDC3]/20 hover:border-[#35A536] dark:hover:border-[#24BDC3]/60 hover:shadow-md transition-all flex flex-col sm:flex-row items-start gap-3 sm:gap-4 group">
                        <div class="px-3 py-1 rounded-xl bg-emerald-100 dark:bg-[#35A536]/20 text-emerald-900 dark:text-emerald-400 border border-emerald-300 dark:border-[#35A536]/40 font-mono font-black text-xs sm:text-sm shrink-0">
                            22:30
                        </div>
                        <div class="space-y-1 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-[#35A536]/15 text-emerald-800 dark:text-emerald-300 text-[10px] font-black border border-emerald-200 dark:border-[#35A536]/30">
                                    {{ app()->getLocale() === 'fr' ? 'Dîner de Gala Protocolaire' : (app()->getLocale() === 'en' ? 'Protocol Gala Dinner' : 'عشاء عمل بروتوكولي') }}
                                </span>
                            </div>
                            <h4 class="text-sm sm:text-lg font-black text-[#0B2A6F] dark:text-white group-hover:text-[#35A536] dark:group-hover:text-emerald-300 transition leading-snug">
                                {{ app()->getLocale() === 'fr' ? 'Dîner de Gala pour les Ministres, Officiels de l\'UA et Autorités Algériennes' : (app()->getLocale() === 'en' ? 'Gala Dinner for Ministers, African Union officials, and Algerian officials' : 'عشاء عمل بروتوكولي رسمي للوزراء، ومسؤولي الاتحاد الأفريقي، والمسؤولين الجزائريين') }}
                            </h4>
                            <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                                {{ app()->getLocale() === 'fr' ? 'Organisé selon l\'ordre protocolaire à la suite de la cérémonie d\'ouverture.' : (app()->getLocale() === 'en' ? 'Held in protocol order following the Opening Ceremony.' : 'يُقام وفقًا للترتيب البروتوكولي الرسمي عقب حفل الافتتاح مباشرة.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Day 2: Nov 17 -->
                <div x-show="scheduleTab === 17" class="space-y-3" style="display: none;">
                    <!-- Nov 17 Item 1: 09:30 - 11:00 -->
                    <div class="p-3.5 sm:p-5 rounded-2xl bg-slate-50 dark:bg-[#041a29]/90 border-s-4 border-[#24BDC3] border-y border-e border-slate-200/90 dark:border-[#24BDC3]/20 hover:border-[#24BDC3] dark:hover:border-[#24BDC3]/60 hover:shadow-md transition-all flex flex-col sm:flex-row items-start gap-3 sm:gap-4 group">
                        <div class="px-3 py-1 rounded-xl bg-teal-100 dark:bg-[#24BDC3]/20 text-teal-900 dark:text-[#24BDC3] border border-teal-300 dark:border-[#24BDC3]/40 font-mono font-black text-xs shrink-0 whitespace-nowrap">
                            09:30 – 11:00
                        </div>
                        <div class="space-y-1 flex-1">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <span class="px-2 py-0.5 rounded-full bg-teal-50 dark:bg-[#24BDC3]/15 text-teal-800 dark:text-[#24BDC3] text-[10px] font-black border border-teal-200 dark:border-[#24BDC3]/30">
                                    {{ app()->getLocale() === 'fr' ? 'Session Ministérielle I' : (app()->getLocale() === 'en' ? 'Ministerial Session I' : 'الجلسة الوزارية الأولى') }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full bg-amber-50 dark:bg-amber-400/15 text-amber-800 dark:text-amber-300 text-[10px] font-black border border-amber-200 dark:border-amber-400/30">
                                    {{ app()->getLocale() === 'fr' ? 'Présidente: S.E. Mme Nacima Arhab' : (app()->getLocale() === 'en' ? 'Chair: H.E. Ms. Nacima Arhab' : 'رئاسة الجلسة: معالي السيدة نسيمة أرحاب') }}
                                </span>
                            </div>
                            <h4 class="text-sm sm:text-lg font-black text-[#0B2A6F] dark:text-white group-hover:text-[#24BDC3] transition leading-snug">
                                {{ app()->getLocale() === 'fr' ? 'Faire progresser les systèmes d\'EFTP pour l\'Agenda 2063 et la transformation industrielle' : (app()->getLocale() === 'en' ? 'Advancing TVET Systems for Agenda 2063 and Africa\'s Industrial Transformation' : 'تطوير أنظمة التكوين المهني والتقني لتحقيق أجندة 2063 والتحول الصناعي في إفريقيا') }}
                            </h4>
                        </div>
                    </div>

                    <!-- Nov 17 Item 2: 11:00 - 12:15 -->
                    <div class="p-3.5 sm:p-5 rounded-2xl bg-slate-50 dark:bg-[#041a29]/90 border-s-4 border-amber-400 border-y border-e border-slate-200/90 dark:border-[#24BDC3]/20 hover:border-amber-400 dark:hover:border-[#24BDC3]/60 hover:shadow-md transition-all flex flex-col sm:flex-row items-start gap-3 sm:gap-4 group">
                        <div class="px-3 py-1 rounded-xl bg-amber-100 dark:bg-amber-400/20 text-amber-900 dark:text-amber-300 border border-amber-300 dark:border-amber-400/40 font-mono font-black text-xs shrink-0 whitespace-nowrap">
                            11:00 – 12:15
                        </div>
                        <div class="space-y-1 flex-1">
                            <div class="flex flex-wrap items-center gap-1.5">
                                <span class="px-2 py-0.5 rounded-full bg-amber-50 dark:bg-amber-400/15 text-amber-800 dark:text-amber-300 text-[10px] font-black border border-amber-200 dark:border-amber-400/30">
                                    {{ app()->getLocale() === 'fr' ? 'Session Ministérielle II — « Compétences de Demain »' : (app()->getLocale() === 'en' ? 'Session II — “Skills of Tomorrow”' : 'الجلسة الوزارية الثانية — « مهارات الغد »') }}
                                </span>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-50 dark:bg-emerald-400/15 text-emerald-800 dark:text-emerald-300 text-[10px] font-black border border-emerald-200 dark:border-emerald-400/30">
                                    {{ app()->getLocale() === 'fr' ? 'Président: Prof. Gaspard Banyankimbona' : (app()->getLocale() === 'en' ? 'Chair: Prof. Gaspard Banyankimbona' : 'رئاسة الجلسة: الأستاذ غاسبار بنيانكيمبونا') }}
                                </span>
                            </div>
                            <h4 class="text-sm sm:text-lg font-black text-[#0B2A6F] dark:text-white group-hover:text-amber-600 dark:group-hover:text-amber-300 transition leading-snug">
                                {{ app()->getLocale() === 'fr' ? 'Préparer la main-d\'œuvre africaine aux industries émergentes' : (app()->getLocale() === 'en' ? 'Preparing Africa\'s Workforce for Emerging Industries' : 'إعداد القوى العاملة الإفريقية للصناعات والقطاعات الناشئة') }}
                            </h4>
                        </div>
                    </div>

                    <!-- Nov 17 Item 3: 12:15 - 12:30 -->
                    <div class="p-3.5 sm:p-5 rounded-2xl bg-gradient-to-r from-emerald-50 via-teal-50 to-emerald-100/70 dark:from-emerald-950/80 dark:to-[#041a29] border-s-4 border-[#35A536] border-y border-e border-emerald-200/90 dark:border-[#35A536]/40 transition-all flex flex-col sm:flex-row items-start gap-3 sm:gap-4 shadow-xs">
                        <div class="px-3 py-1 rounded-xl bg-[#35A536] text-white font-mono font-black text-xs shrink-0 shadow-xs whitespace-nowrap">
                            12:15 – 12:30
                        </div>
                        <div class="space-y-1 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-full bg-[#35A536] text-white text-[10px] font-black shadow-xs">
                                    {{ app()->getLocale() === 'fr' ? 'Déclaration Conjointe' : (app()->getLocale() === 'en' ? 'Joint Declaration' : 'اعتماد الإعلان المشترك') }}
                                </span>
                            </div>
                            <h4 class="text-sm sm:text-lg font-black text-[#0B2A6F] dark:text-emerald-300 leading-snug">
                                {{ app()->getLocale() === 'fr' ? 'Adoption de la Déclaration Conjointe sur l\'Agenda des Compétences en Afrique' : (app()->getLocale() === 'en' ? 'Joint Declaration on Africa\'s Skills Agenda' : 'إصدار واعتماد الإعلان المشترك حول أجندة المهارات في إفريقيا') }}
                            </h4>
                            <p class="text-[11px] sm:text-xs text-slate-700 dark:text-slate-300 font-medium leading-relaxed">
                                {{ app()->getLocale() === 'fr' ? 'Les sessions I et II se concluent par l\'adoption de la Déclaration conjointe ministérielle.' : (app()->getLocale() === 'en' ? 'Sessions I and II culminate in a joint Declaration on Africa\'s skills agenda.' : 'تتوج الجلستان الوزاريتان الأولى والثانية باعتمد وثيقة الإعلان المشترك حول المستقبل القاري للمهارات.') }}
                            </p>
                        </div>
                    </div>

                    <!-- Nov 17 Item 4: 12:30 - 14:00 -->
                    <div class="p-3 sm:p-4 rounded-2xl bg-slate-100 dark:bg-[#020b12]/80 border border-slate-200 dark:border-white/10 flex items-center justify-between gap-3">
                        <div class="flex items-center gap-2.5">
                            <div class="px-2.5 py-0.5 rounded-xl bg-white dark:bg-white/10 text-slate-700 dark:text-slate-200 font-mono font-black text-xs border border-slate-200 dark:border-white/10 shrink-0">
                                12:30 – 14:00
                            </div>
                            <span class="text-xs font-bold text-slate-700 dark:text-slate-300">
                                {{ app()->getLocale() === 'fr' ? 'Pause Déjeuner & Réseautage Protocolaire' : (app()->getLocale() === 'en' ? 'Lunch Break & Networking' : 'استراحة غداء وتواصل شبكي بين الوفود') }}
                            </span>
                        </div>
                    </div>

                    <!-- Nov 17 Item 5: 14:00 - 15:30 -->
                    <div class="p-3.5 sm:p-5 rounded-2xl bg-slate-50 dark:bg-[#041a29]/90 border-s-4 border-purple-500 border-y border-e border-slate-200/90 dark:border-[#24BDC3]/20 hover:border-purple-500 dark:hover:border-[#24BDC3]/60 hover:shadow-md transition-all flex flex-col sm:flex-row items-start gap-3 sm:gap-4 group">
                        <div class="px-3 py-1 rounded-xl bg-purple-100 dark:bg-purple-500/20 text-purple-900 dark:text-purple-300 border border-purple-300 dark:border-purple-500/40 font-mono font-black text-xs shrink-0 whitespace-nowrap">
                            14:00 – 15:30
                        </div>
                        <div class="space-y-1 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-full bg-purple-50 dark:bg-purple-500/15 text-purple-800 dark:text-purple-300 text-[10px] font-black border border-purple-200 dark:border-purple-500/30">
                                    {{ app()->getLocale() === 'fr' ? 'Panel I — Technologie & IA' : (app()->getLocale() === 'en' ? 'Panel I — AI & Digital' : 'الورشة التخصصية الأولى — الذكاء الاصطناعي') }}
                                </span>
                            </div>
                            <h4 class="text-sm sm:text-lg font-black text-[#0B2A6F] dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-300 transition leading-snug">
                                {{ app()->getLocale() === 'fr' ? 'Intelligence Artificielle, Transformation Numérique et L\'Avenir de l\'EFTP' : (app()->getLocale() === 'en' ? 'Artificial Intelligence, Digital Transformation and the Future of TVET' : 'الذكاء الاصطناعي، التحول الرقمي ومستقبل التكوين والتعليم المهني') }}
                            </h4>
                        </div>
                    </div>

                    <!-- Nov 17 Item 6: 15:30 - 17:00 -->
                    <div class="p-3.5 sm:p-5 rounded-2xl bg-slate-50 dark:bg-[#041a29]/90 border-s-4 border-sky-400 border-y border-e border-slate-200/90 dark:border-[#24BDC3]/20 hover:border-sky-400 dark:hover:border-[#24BDC3]/60 hover:shadow-md transition-all flex flex-col sm:flex-row items-start gap-3 sm:gap-4 group">
                        <div class="px-3 py-1 rounded-xl bg-sky-100 dark:bg-sky-400/20 text-sky-900 dark:text-sky-300 border border-sky-300 dark:border-sky-400/40 font-mono font-black text-xs shrink-0 whitespace-nowrap">
                            15:30 – 17:00
                        </div>
                        <div class="space-y-1 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-full bg-sky-50 dark:bg-sky-400/15 text-sky-800 dark:text-sky-300 text-[10px] font-black border border-sky-200 dark:border-sky-400/30">
                                    {{ app()->getLocale() === 'fr' ? 'Panel II — Écosystème & Partenariats' : (app()->getLocale() === 'en' ? 'Panel II — Skills Ecosystem' : 'الورشة التخصصية الثانية — منظومة الشراكات') }}
                                </span>
                            </div>
                            <h4 class="text-sm sm:text-lg font-black text-[#0B2A6F] dark:text-white group-hover:text-sky-600 dark:group-hover:text-sky-300 transition leading-snug">
                                {{ app()->getLocale() === 'fr' ? 'Construire l\'Écosystème des Compétences en Afrique' : (app()->getLocale() === 'en' ? 'Building Africa\'s Skills Ecosystem' : 'بناء منظومة المهارات الإفريقية: التعاون بين الحكومة والقطاع الصناعي والمؤسسات لتحقيق التميز') }}
                            </h4>
                        </div>
                    </div>
                </div>

                <!-- Day 3: Nov 18 -->
                <div x-show="scheduleTab === 18" class="space-y-3" style="display: none;">
                    <!-- Nov 18 Item 1: 09:30 - 11:00 -->
                    <div class="p-3.5 sm:p-5 rounded-2xl bg-slate-50 dark:bg-[#041a29]/90 border-s-4 border-sky-400 border-y border-e border-slate-200/90 dark:border-[#24BDC3]/20 hover:border-sky-400 dark:hover:border-[#24BDC3]/60 hover:shadow-md transition-all flex flex-col sm:flex-row items-start gap-3 sm:gap-4 group">
                        <div class="px-3 py-1 rounded-xl bg-sky-100 dark:bg-sky-400/20 text-sky-900 dark:text-sky-300 border border-sky-300 dark:border-sky-400/40 font-mono font-black text-xs shrink-0 whitespace-nowrap">
                            09:30 – 11:00
                        </div>
                        <div class="space-y-1 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-0.5 rounded-full bg-sky-50 dark:bg-sky-400/15 text-sky-800 dark:text-sky-300 text-[10px] font-black border border-sky-200 dark:border-sky-400/30">
                                    {{ app()->getLocale() === 'fr' ? 'Session Interactive & Débat' : (app()->getLocale() === 'en' ? 'Open Q&A Session' : 'جلسة حوار مفتوحة — أسئلة وأجوبة') }}
                                </span>
                            </div>
                            <h4 class="text-sm sm:text-lg font-black text-[#0B2A6F] dark:text-white group-hover:text-sky-600 dark:group-hover:text-sky-300 transition leading-snug">
                                {{ app()->getLocale() === 'fr' ? 'Là où la politique rencontre le talent (Where Policy Meets Talent)' : (app()->getLocale() === 'en' ? 'Where Policy Meets Talent' : 'التلاقي بين السياسات والمواهب (Where Policy Meets Talent)') }}
                            </h4>
                            <p class="text-[11px] sm:text-xs text-slate-600 dark:text-slate-300 font-medium leading-relaxed">
                                {{ app()->getLocale() === 'fr' ? 'Session ouverte de questions-réponses réunissant les ministres africains et les jeunes compétiteurs et stagiaires. Les stagiaires posent leurs questions directement aux ministres sur l\'avenir de l\'EFTP et les politiques de compétences.' : (app()->getLocale() === 'en' ? 'An open Q&A session bringing together African Ministers and the young competitors and trainees of the Competition. Trainees put their questions directly to Ministers on the future of TVET, skills policy, and opportunity across the continent.' : 'جلسة حوار مفتوحة تجمع بين الوزراء الأفارقة والمتسابقين والمتدربين الشباب، يطرح فيها المتدربون أسئلتهم مباشرة على الوزراء حول مستقبل التكوين المهني وسياسات المهارات في القارة.') }}
                            </p>
                        </div>
                    </div>

                    <!-- Nov 18 Item 2: 11:00 - 11:15 -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-emerald-50 via-teal-50 to-emerald-100/70 dark:from-emerald-950/80 dark:to-[#041a29] border-s-4 border-[#35A536] border-y border-e border-emerald-200/90 dark:border-[#35A536]/40 hover:shadow-md transition-all flex flex-col sm:flex-row items-start gap-4 group">
                        <div class="px-3.5 py-1.5 rounded-xl bg-[#35A536] text-white font-mono font-black text-xs shrink-0 shadow-xs whitespace-nowrap">
                            11:00 – 11:15
                        </div>
                        <div class="space-y-1.5 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-full bg-[#35A536] text-white text-[10px] font-black shadow-xs">
                                    {{ app()->getLocale() === 'fr' ? 'Déclaration Conjointe' : (app()->getLocale() === 'en' ? 'Joint Declaration' : 'الإعلان المشترك حول أجندة المهارات') }}
                                </span>
                            </div>
                            <h4 class="text-base sm:text-lg font-black text-[#0B2A6F] dark:text-emerald-300">
                                {{ app()->getLocale() === 'fr' ? 'Déclaration Conjointe sur l\'Agenda des Compétences en Afrique' : (app()->getLocale() === 'en' ? 'Joint Declaration on Africa\'s Skills Agenda' : 'إصدار واعتماد الإعلان المشترك حول أجندة المهارات في إفريقيا') }}
                            </h4>
                            <p class="text-[11px] sm:text-xs text-slate-700 dark:text-slate-300 font-medium leading-relaxed">
                                {{ app()->getLocale() === 'fr' ? 'Les sessions I et II se concluent par l\'adoption d\'une Déclaration conjointe sur l\'agenda des compétences en Afrique.' : (app()->getLocale() === 'en' ? 'Sessions I and II culminate in a joint Declaration on Africa\'s skills agenda.' : 'تتوج الجلستان الأولى والثانية بإصدار واعتماد إعلان مشترك حول أجندة المهارات في إفريقيا.') }}
                            </p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Modal Footer Controls (Dual Theme) -->
            <div class="p-4 sm:p-5 border-t border-slate-200 dark:border-[#24BDC3]/20 bg-slate-50/90 dark:bg-[#020b12]/95 relative z-10 flex flex-wrap items-center justify-between gap-3 sm:gap-4">
                <div class="text-xs text-slate-600 dark:text-teal-300/90 font-bold flex items-center gap-2">
                    <span>{{ app()->getLocale() === 'fr' ? 'Centre des Conventions Mohamed Ben Ahmed — Oran' : (app()->getLocale() === 'en' ? 'Mohamed Ben Ahmed Convention Center — Oran' : 'مركز المؤتمرات محمد بن أحمد — وهران') }}</span>
                </div>

                <div class="flex flex-wrap items-center gap-2 sm:gap-3 w-full sm:w-auto justify-end">
                    <!-- PDF Preview Button -->
                    <button @click="showPdfModal = true" class="px-4 py-2.5 rounded-xl bg-amber-400 hover:bg-amber-500 text-slate-950 font-black text-xs shadow-md transition duration-300 flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Consulter PDF' : (app()->getLocale() === 'en' ? 'Preview PDF' : 'معاينة الملف PDF') }}</span>
                    </button>

                    <!-- PDF Download Button -->
                    <a href="{{ asset('African-Skills-Policy-Forum-Programme.pdf') }}" download 
                       class="px-4 py-2.5 rounded-xl bg-[#24BDC3] hover:bg-teal-400 text-slate-950 font-black text-xs shadow-md transition duration-300 flex items-center gap-2 cursor-pointer">
                        <svg class="w-4 h-4 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Télécharger PDF' : (app()->getLocale() === 'en' ? 'Download PDF' : 'تحميل البرنامج PDF') }}</span>
                    </a>

                    <!-- Proceed to Platform Button -->
                    <button @click="showScheduleModal = false" class="px-5 py-2.5 rounded-xl bg-[#0B2A6F] dark:bg-white/10 hover:bg-blue-900 dark:hover:bg-white/20 text-white font-black text-xs border border-transparent dark:border-white/20 transition duration-300 flex items-center gap-2 cursor-pointer">
                        <span>{{ app()->getLocale() === 'fr' ? 'Continuer' : (app()->getLocale() === 'en' ? 'Proceed' : 'المتابعة للمنصة') }}</span>
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </button>
                </div>
            </div>

        </div>
    </div>

    <!-- 10. Dedicated PDF Programme Viewer & Preview Modal -->
    <div x-show="showPdfModal" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 bg-slate-950/85 flex items-center justify-center p-3 sm:p-6 overflow-hidden">
        
        <div @click.outside="showPdfModal = false" 
             class="bg-white rounded-3xl max-w-5xl w-full h-[90vh] shadow-2xl border border-slate-200 relative overflow-hidden flex flex-col">
            
            <!-- PDF Viewer Modal Header -->
            <div class="p-4 sm:p-5 border-b border-slate-200 bg-slate-50 flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center font-black">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-[#0B2A6F]">
                            {{ app()->getLocale() === 'fr' ? 'Programme Officiel PDF — Forum des Politiques' : (app()->getLocale() === 'en' ? 'Official PDF Programme — African Skills Forum' : 'البرنامج الرسمي لمنتدى السياسات (ملف PDF)') }}
                        </h3>
                        <p class="text-xs text-slate-500 font-medium">African-Skills-Policy-Forum-Programme.pdf</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ asset('African-Skills-Policy-Forum-Programme.pdf') }}" download 
                       class="px-4 py-2 rounded-xl bg-[#35A536] hover:bg-emerald-700 text-white font-black text-xs transition flex items-center gap-2 shadow-xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Télécharger' : (app()->getLocale() === 'en' ? 'Download' : 'تحميل PDF') }}</span>
                    </a>

                    <a href="{{ asset('African-Skills-Policy-Forum-Programme.pdf') }}" target="_blank" 
                       class="px-4 py-2 rounded-xl bg-[#0B2A6F] hover:bg-blue-900 text-white font-black text-xs transition flex items-center gap-2 shadow-xs">
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Ouvrir plein écran' : (app()->getLocale() === 'en' ? 'Open Fullscreen' : 'فتح في نافذة كاملة') }}</span>
                    </a>
                    
                    <button @click="showPdfModal = false" class="w-9 h-9 rounded-xl bg-slate-200 hover:bg-rose-600 hover:text-white text-slate-600 flex items-center justify-center transition cursor-pointer shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Friendly Notification Bar + PDF Viewer Embed -->
            <div class="flex-1 bg-slate-100 p-2 sm:p-4 overflow-hidden flex flex-col">
                <!-- Mobile Optimization Alert Banner -->
                <div class="p-3 mb-3 rounded-2xl bg-blue-50 border border-blue-200 text-[#0B2A6F] text-xs font-bold flex flex-wrap items-center justify-between gap-3 shrink-0">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M12 6v6m8 6a9 9 0 11-18 0 9 9 0 0118 0"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Mobile : Pour une meilleure expérience sur smartphone, cliquez sur "فتح الملف" لفتحه مباشرة.' : (app()->getLocale() === 'en' ? 'Mobile users: Tap "Open Fullscreen" for instant viewing in your native PDF reader.' : 'مستخدمي الهواتف الذكية: انقر فوق "فتح الملف" أو "تحميل PDF" لمشاهدة المستند بسلاسة على هاتفك.') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('pdf.view', ['file' => 'African-Skills-Policy-Forum-Programme.pdf']) }}" target="_blank" rel="noopener noreferrer" class="px-3.5 py-1.5 rounded-xl bg-[#0B2A6F] text-white font-black text-xs shrink-0 shadow-xs flex items-center gap-1">
                            <span>{{ app()->getLocale() === 'fr' ? 'Ouvrir ↗' : (app()->getLocale() === 'en' ? 'Open ↗' : 'فتح الملف ↗') }}</span>
                        </a>
                    </div>
                </div>

                <div class="flex-1 rounded-2xl border border-slate-300 overflow-hidden bg-slate-200 relative">
                    <object data="{{ route('pdf.view', ['file' => 'African-Skills-Policy-Forum-Programme.pdf']) }}" type="application/pdf" class="w-full h-full">
                        <iframe src="{{ route('pdf.view', ['file' => 'African-Skills-Policy-Forum-Programme.pdf']) }}#toolbar=1" class="w-full h-full border-0">
                            <div class="p-8 text-center text-xs font-bold text-slate-700 space-y-4">
                                <p>{{ app()->getLocale() === 'fr' ? 'Votre navigateur mobile ne prend pas en charge la prévisualisation directe.' : 'متصفح هاتفك لا يدعم المعاينة المدمجة مباشرة.' }}</p>
                                <a href="{{ route('pdf.view', ['file' => 'African-Skills-Policy-Forum-Programme.pdf']) }}" target="_blank" class="inline-block px-6 py-3 rounded-xl bg-[#0B2A6F] text-white font-black text-xs">
                                    انقر هنا لفتح الملف على هاتفك
                                </a>
                            </div>
                        </iframe>
                    </object>
                </div>
            </div>

        </div>
    </div>

</div>
