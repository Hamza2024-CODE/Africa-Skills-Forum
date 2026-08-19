<header class="sticky top-0 z-50 wsap-glass bg-white/95 border-b border-slate-200/80 shadow-sm" x-data="{ mobileMenuOpen: false }">
    <div class="max-w-[90rem] mx-auto px-2.5 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-15 sm:h-20 gap-2 sm:gap-3">
            
            <!-- Official Dual Brand Logos (Ministry Seal + African Union / Africa Skills Forum) -->
            <a href="{{ route('home') }}" class="flex items-center gap-1.5 sm:gap-3 group shrink-0 py-1" title="{{ platform()->name() }}">
                <div class="flex items-center gap-1.5 sm:gap-3 bg-slate-50/90 hover:bg-slate-100/90 p-1 sm:p-1.5 px-2 sm:px-3 rounded-2xl border border-slate-200/80 shadow-xs overflow-hidden shrink-0 transition max-w-[62vw] sm:max-w-none">
                    <!-- 1. Ministry Seal Logo (Crisp Dark for Light Navbar) -->
                    <img src="{{ asset('ministry-logo-trimmed.png') }}" 
                         alt="الجمهورية الجزائرية الديمقراطية الشعبية - وزارة التكوين والتعليم المهنيين" 
                         class="h-5 sm:h-8 md:h-9 w-auto object-contain transition-transform duration-300 group-hover:scale-105 shrink-0">
                    
                    <!-- Vertical Divider Line -->
                    <div class="h-4 sm:h-6 w-px bg-slate-300 shrink-0"></div>
                    
                    <!-- 2. African Union / Africa Skills Forum Logo -->
                    <img src="{{ asset('africa-logo-trimmed.png') }}" 
                         alt="African Union - Africa Skills Forum" 
                         class="h-5 sm:h-8 md:h-9 w-auto object-contain transition-transform duration-300 group-hover:scale-105 shrink-0">
                </div>
            </a>

            <!-- Desktop Menu Navigation (100% Dedicated to Africa Skills Forum) -->
            <nav class="hidden xl:flex items-center gap-3.5 2xl:gap-5 shrink">
                <a href="{{ route('home') }}" class="px-3.5 py-1.5 rounded-full {{ request()->routeIs('home') ? 'bg-[#0B2A6F] text-white shadow-xs' : 'text-[#0B2A6F] hover:text-[#35A536]' }} font-bold text-xs transition whitespace-nowrap">{{ __('messages.home') }}</a>
                <a href="{{ route('guide') }}" class="text-xs font-bold text-[#0B2A6F] hover:text-[#35A536] transition whitespace-nowrap">{{ app()->getLocale() === 'fr' ? 'À propos' : (app()->getLocale() === 'en' ? 'About' : 'عن المنتدى') }}</a>

                <!-- Media & Broadcast Dropdown -->
                <div class="relative shrink-0" x-data="{ open: false }">
                    <button @click="open = !open" @click.outside="open = false" class="flex items-center gap-1 text-xs font-bold text-[#0B2A6F] hover:text-[#35A536] transition py-2 whitespace-nowrap">
                        <span>{{ __('messages.media') }}</span>
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="open" x-transition class="absolute top-full right-0 mt-2 w-52 rounded-2xl bg-white shadow-xl border border-slate-100 py-2 z-50">
                        <a href="{{ route('news') }}" class="block px-4 py-2 text-xs font-bold text-[#0B2A6F] hover:bg-slate-50 hover:text-[#35A536]">{{ __('messages.news') }}</a>
                        <a href="{{ route('events') }}" class="block px-4 py-2 text-xs font-bold text-[#0B2A6F] hover:bg-slate-50 hover:text-[#35A536]">{{ __('messages.events') }}</a>
                        <a href="{{ route('gallery') }}" class="block px-4 py-2 text-xs font-bold text-[#0B2A6F] hover:bg-slate-50 hover:text-[#35A536]">{{ __('messages.gallery') }}</a>
                        <a href="{{ route('videos') }}" class="block px-4 py-2 text-xs font-bold text-[#0B2A6F] hover:bg-slate-50 hover:text-[#35A536]">{{ __('messages.videos') }}</a>
                        <a href="{{ route('live-tv') }}" target="_blank" class="block px-4 py-2 text-xs font-black text-rose-600 hover:bg-rose-50 border-t border-slate-100 mt-1 pt-2 flex items-center justify-between">
                            <span>{{ app()->getLocale() === 'fr' ? 'Direct TV (Écrans)' : (app()->getLocale() === 'en' ? 'Live TV Broadcast' : 'شاشة البث المباشر (Live TV)') }}</span>
                            <span class="w-2 h-2 rounded-full bg-rose-600 animate-ping"></span>
                        </a>
                    </div>
                </div>

                @if(platform()->get('show_partners_section', true))
                    <a href="{{ route('partners') }}" class="text-xs font-bold text-[#0B2A6F] hover:text-[#35A536] transition whitespace-nowrap">{{ __('messages.partners') }}</a>
                @endif
                <a href="{{ route('faq') }}" class="text-xs font-bold text-[#0B2A6F] hover:text-[#35A536] transition whitespace-nowrap">{{ __('messages.faq') }}</a>
                <a href="{{ route('contact') }}" class="text-xs font-bold text-[#0B2A6F] hover:text-[#35A536] transition whitespace-nowrap">{{ __('messages.contact') }}</a>
            </nav>

            <!-- Actions Right Area (Responsive Mobile Friendly) -->
            <div class="flex items-center gap-1 sm:gap-2 shrink-0">
                
                <!-- Search Button -->
                <a href="{{ route('search') }}" class="w-7 h-7 sm:w-9 sm:h-9 rounded-full bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-600 transition shrink-0" title="Search">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </a>

                <!-- Language Switcher Component -->
                <div class="shrink-0">
                    <x-language-switcher />
                </div>

                @auth
                    @php
                        $user = auth()->user();
                        $dashboardRoute = match (true) {
                            $user->hasRole(\App\Enums\RoleEnum::SUPER_ADMIN->value) => route('admin.dashboard'),
                            $user->hasRole(\App\Enums\RoleEnum::MEDIA_MANAGER->value) => route('admin.media.dashboard'),
                            $user->hasRole(\App\Enums\RoleEnum::COUNTRY_ADMIN->value) => route('country.dashboard'),
                            default => route('home'),
                        };
                    @endphp
                    @if($dashboardRoute !== route('home'))
                        <a href="{{ $dashboardRoute }}" class="px-2 sm:px-4 py-1 sm:py-2 rounded-xl bg-emerald-50 text-emerald-800 border border-emerald-200 hover:bg-emerald-100 font-bold text-xs transition whitespace-nowrap">
                            {{ __('messages.dashboard') }}
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" data-navigate-ignore class="hidden md:inline-flex items-center gap-1.5 px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl border border-slate-300 hover:border-[#0B2A6F] text-[#0B2A6F] hover:bg-blue-50 font-bold text-xs transition whitespace-nowrap">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                        <span>{{ __('messages.login') }}</span>
                    </a>
                    
                    <!-- Registration Dropdown Button (Desktop & Tablet) -->
                    <div class="relative shrink-0 hidden md:block" x-data="{ regOpen: false }">
                        <button @click="regOpen = !regOpen" @click.outside="regOpen = false" type="button" class="px-3 sm:px-4 py-1.5 sm:py-2.5 rounded-xl bg-[#35A536] hover:bg-emerald-700 text-white font-bold text-xs shadow-md shadow-emerald-600/20 transition-all flex items-center gap-1.5 whitespace-nowrap">
                            <span>{{ app()->getLocale() === 'fr' ? 'Inscription & Accréditation' : (app()->getLocale() === 'en' ? 'Registration & Accreditation' : 'التسجيل والاعتماد الرسمي') }}</span>
                            <svg class="w-3.5 h-3.5 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="regOpen" x-transition class="absolute top-full right-0 mt-2 w-80 rounded-2xl bg-white shadow-xl border border-slate-100 py-2 z-50 text-start">
                            <a href="{{ route('registration') }}" data-navigate-ignore class="block px-4 py-3 text-xs font-bold text-[#0B2A6F] hover:bg-slate-50 hover:text-[#35A536] border-b border-slate-100">
                                <div class="font-extrabold text-slate-900 flex items-center gap-2 justify-start">
                                    <svg class="w-4 h-4 text-[#35A536] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <span>{{ app()->getLocale() === 'fr' ? '1. Inscription Participants, Experts & Intervenants' : (app()->getLocale() === 'en' ? '1. Participants, Experts & Speakers Registration' : '1. تسجيل المشاركين والخبراء والمحاضرين') }}</span>
                                </div>
                                <div class="text-[10px] text-slate-400 font-medium mt-1">
                                    {{ app()->getLocale() === 'fr' ? 'Demande d\'accréditation individuelle et participation' : (app()->getLocale() === 'en' ? 'Individual accreditation request and session participation' : 'طلب الاعتماد الفردي والمشاركة في جلسات وفعاليات المنتدى') }}
                                </div>
                            </a>
                            <a href="{{ route('official.registration') }}" data-navigate-ignore class="block px-4 py-3 text-xs font-bold text-[#0B2A6F] hover:bg-slate-50 hover:text-[#0B2A6F]">
                                <div class="font-extrabold text-[#0B2A6F] flex items-center gap-2 justify-start">
                                    <svg class="w-4 h-4 text-[#0B2A6F] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5 5 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5 5 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                                    <span>{{ app()->getLocale() === 'fr' ? '2. Inscription Officielle & Accréditation' : (app()->getLocale() === 'en' ? '2. Official Accreditation & Registration' : '2. التسجيل والاعتماد الرسمي للوفود والإعلام') }}</span>
                                </div>
                                <div class="text-[10px] text-[#0B2A6F]/70 font-medium mt-1">
                                    {{ app()->getLocale() === 'fr' ? 'Accréditation des délégations officielles, presse et médias' : (app()->getLocale() === 'en' ? 'Accreditation for official delegations, press and media' : 'اعتماد الوفود الرسمية والصحافة والإعلام والضيوف') }}
                                </div>
                            </a>
                        </div>
                    </div>
                @endauth

                <!-- Mobile Hamburger Menu Button (ALWAYS visible below XL breakpoint) -->
                <button @click="mobileMenuOpen = !mobileMenuOpen; window.dispatchEvent(new CustomEvent('mobile-menu-toggled', { detail: mobileMenuOpen }))" 
                        type="button" 
                        class="xl:hidden w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-[#0B2A6F] hover:bg-blue-900 text-white flex items-center justify-center transition shrink-0 shadow-sm"
                        aria-label="Open Navigation Menu">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Slide-Over Menu Drawer (xl:hidden) -->
    <template x-teleport="body">
        <div x-show="mobileMenuOpen" x-cloak class="fixed inset-0 z-50 xl:hidden flex justify-end">
            
            <!-- Dark Backdrop Overlay -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileMenuOpen = false; window.dispatchEvent(new CustomEvent('mobile-menu-toggled', { detail: false }))"
                 class="fixed inset-0 bg-slate-950/75 backdrop-blur-sm"></div>

            <!-- Slide-Over Drawer Body -->
            <div x-show="mobileMenuOpen"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="{{ app()->getLocale() === 'ar' ? '-translate-x-full' : 'translate-x-full' }}"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="{{ app()->getLocale() === 'ar' ? '-translate-x-full' : 'translate-x-full' }}"
                 class="relative w-84 sm:w-96 max-w-[88vw] bg-white h-full shadow-2xl z-50 flex flex-col justify-between overflow-y-auto p-5 text-start border-s border-slate-200">
                
                <!-- Drawer Top Header -->
                <div class="space-y-5">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-4">
                        <div class="flex items-center gap-2 bg-slate-50 p-1.5 px-3 rounded-2xl border border-slate-200/80">
                            <img src="{{ asset('ministry-logo-trimmed.png') }}" alt="وزارة التكوين والتعليم المهنيين" class="h-7 w-auto object-contain">
                            <div class="h-5 w-px bg-slate-300"></div>
                            <img src="{{ asset('africa-logo-trimmed.png') }}" alt="Africa Skills Forum Logo" class="h-7 w-auto object-contain">
                        </div>

                        <button @click="mobileMenuOpen = false; window.dispatchEvent(new CustomEvent('mobile-menu-toggled', { detail: false }))" type="button" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold flex items-center justify-center transition">
                            ✕
                        </button>
                    </div>

                    <!-- 1. Highlighted Registration Section -->
                    <div class="p-3.5 rounded-2xl bg-gradient-to-br from-emerald-50 to-blue-50/80 border border-emerald-200/80 space-y-2">
                        <div class="text-[11px] font-black text-[#0B2A6F] uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-[#35A536]"></span>
                            <span>{{ app()->getLocale() === 'fr' ? 'Accréditation & Inscription' : (app()->getLocale() === 'en' ? 'Accreditation & Registration' : 'بوابات التسجيل والاعتماد') }}</span>
                        </div>
                        
                        <a href="{{ route('registration') }}" @click="mobileMenuOpen = false" class="block p-2.5 rounded-xl bg-white hover:bg-emerald-50 border border-emerald-100 shadow-xs transition">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-black text-slate-900">{{ app()->getLocale() === 'fr' ? '1. Inscription Participants & Experts' : (app()->getLocale() === 'en' ? '1. Participants & Experts' : '1. تسجيل المشاركين والخبراء والمحاضرين') }}</span>
                            </div>
                        </a>

                        <a href="{{ route('official.registration') }}" @click="mobileMenuOpen = false" class="block p-2.5 rounded-xl bg-[#0B2A6F] text-white hover:bg-blue-900 shadow-xs transition">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-black text-white">{{ app()->getLocale() === 'fr' ? '2. Inscription Officielle & Médias' : (app()->getLocale() === 'en' ? '2. Official Accreditation' : '2. التسجيل والاعتماد للوفود والإعلام') }}</span>
                            </div>
                        </a>
                    </div>

                    <!-- 2. Main Navigation Links -->
                    <nav class="space-y-1 text-start">
                        <div class="px-2 py-1 text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ app()->getLocale() === 'fr' ? 'Navigation Principale' : (app()->getLocale() === 'en' ? 'Main Navigation' : 'قائمة القسّم الرئيسية') }}</div>

                        <a href="{{ route('home') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-black {{ request()->routeIs('home') ? 'bg-[#0B2A6F] text-white shadow-md' : 'text-[#0B2A6F] hover:bg-slate-50' }} transition">
                            <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            <span>{{ __('messages.home') }}</span>
                        </a>

                        <a href="{{ route('guide') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-black {{ request()->routeIs('guide') ? 'bg-[#0B2A6F] text-white shadow-md' : 'text-[#0B2A6F] hover:bg-slate-50' }} transition">
                            <svg class="w-4 h-4 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'À propos du Forum' : (app()->getLocale() === 'en' ? 'About Forum & Guide' : 'عن المنتدى ودليل المشاركة') }}</span>
                        </a>

                        <a href="{{ route('skills') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-black {{ request()->routeIs('skills') ? 'bg-[#0B2A6F] text-white shadow-md' : 'text-[#0B2A6F] hover:bg-slate-50' }} transition">
                            <svg class="w-4 h-4 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 01-1.187-2.19l.732-4.393A2 2 0 017.11 6.814l3.176.635a6 6 0 003.86-.517l.318-.158a6 6 0 013.86-.517l2.387.477a2 2 0 011.642 1.964v6.22a2 2 0 01-.927 1.69z"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Guide des Métiers' : (app()->getLocale() === 'en' ? 'Skills Guide' : 'دليل التخصصات والمهن') }}</span>
                        </a>

                        <a href="{{ route('events') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-black {{ request()->routeIs('events') ? 'bg-[#0B2A6F] text-white shadow-md' : 'text-[#0B2A6F] hover:bg-slate-50' }} transition">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Sessions & Conférences' : (app()->getLocale() === 'en' ? 'Sessions & Encounters' : 'اللقاءات والجلسات والندوات') }}</span>
                        </a>

                        <a href="{{ route('news') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-black {{ request()->routeIs('news') ? 'bg-[#0B2A6F] text-white shadow-md' : 'text-[#0B2A6F] hover:bg-slate-50' }} transition">
                            <svg class="w-4 h-4 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                            <span>{{ __('messages.news') }}</span>
                        </a>

                        <a href="{{ route('gallery') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-black {{ request()->routeIs('gallery') ? 'bg-[#0B2A6F] text-white shadow-md' : 'text-[#0B2A6F] hover:bg-slate-50' }} transition">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Galerie Photos' : (app()->getLocale() === 'en' ? 'Photo Gallery' : 'معرض الصور والتغطيات') }}</span>
                        </a>

                        <a href="{{ route('videos') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-black {{ request()->routeIs('videos') ? 'bg-[#0B2A6F] text-white shadow-md' : 'text-[#0B2A6F] hover:bg-slate-50' }} transition">
                            <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Vidéos & Replays' : (app()->getLocale() === 'en' ? 'Videos & Highlights' : 'مركز الفيديو والتسجيلات') }}</span>
                        </a>

                        @if(platform()->get('show_partners_section', true))
                            <a href="{{ route('partners') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-black {{ request()->routeIs('partners') ? 'bg-[#0B2A6F] text-white shadow-md' : 'text-[#0B2A6F] hover:bg-slate-50' }} transition">
                                <svg class="w-4 h-4 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <span>{{ __('messages.partners') }}</span>
                            </a>
                        @endif

                        <a href="{{ route('faq') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-black {{ request()->routeIs('faq') ? 'bg-[#0B2A6F] text-white shadow-md' : 'text-[#0B2A6F] hover:bg-slate-50' }} transition">
                            <svg class="w-4 h-4 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>{{ __('messages.faq') }}</span>
                        </a>

                        <a href="{{ route('contact') }}" @click="mobileMenuOpen = false" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-black {{ request()->routeIs('contact') ? 'bg-[#0B2A6F] text-white shadow-md' : 'text-[#0B2A6F] hover:bg-slate-50' }} transition">
                            <svg class="w-4 h-4 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>{{ __('messages.contact') }}</span>
                        </a>

                        <a href="{{ route('live-tv') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-black text-rose-600 bg-rose-50 border border-rose-200 transition mt-2">
                            <div class="flex items-center gap-3">
                                <svg class="w-4 h-4 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <span>{{ app()->getLocale() === 'fr' ? 'Direct TV (Écrans)' : (app()->getLocale() === 'en' ? 'Live TV Broadcast' : 'شاشة البث المباشر (Live TV)') }}</span>
                            </div>
                            <span class="w-2 h-2 rounded-full bg-rose-600 animate-ping"></span>
                        </a>
                    </nav>
                </div>

                <!-- Bottom Quick Action Buttons -->
                <div class="pt-5 border-t border-slate-100 space-y-2 mt-4">
                    @guest
                        <a href="{{ route('login') }}" @click="mobileMenuOpen = false" class="w-full py-2.5 rounded-xl border-2 border-[#0B2A6F] text-center font-black text-xs text-[#0B2A6F] hover:bg-slate-50 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            <span>{{ __('messages.login') }}</span>
                        </a>
                        <a href="{{ route('registration') }}" @click="mobileMenuOpen = false" class="w-full py-2.5 rounded-xl bg-[#35A536] hover:bg-emerald-700 text-white text-center font-black text-xs shadow-md transition flex items-center justify-center gap-2">
                            <span>{{ __('messages.register') }}</span>
                        </a>
                    @endguest
                </div>

            </div>
        </div>
    </template>
</header>
