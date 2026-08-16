<!-- Native Mobile App Bottom Tab Bar (Context & Role Dynamic) -->
@php
    $u = auth()->user();
    $role = $u?->roles?->first()?->name ?? 'GUEST';

    $myBadgeUrl = '#';
    if ($u) {
        $identifier = $u->uuid ?? (string)$u->id;
        $myBadgeUrl = route('accreditation.badge', ['identifier' => $identifier]);
    }

    $tabs = [];

    if (!$u || $role === 'GUEST') {
        $tabs = [
            [
                'label' => __('messages.home'),
                'url' => route('home'),
                'active' => request()->routeIs('home'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
            ],
            [
                'label' => __('messages.skills'),
                'url' => route('skills'),
                'active' => request()->routeIs('skills*'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 01-1.187-2.19l.732-4.393A2 2 0 017.11 6.814l3.176.635a6 6 0 003.86-.517l.318-.158a6 6 0 013.86-.517l2.387.477a2 2 0 011.642 1.964v6.22a2 2 0 01-.927 1.69z"/>',
            ],
            [
                'label' => __('messages.register'),
                'url' => route('registration'),
                'active' => request()->routeIs('registration*'),
                'is_primary' => true,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>',
            ],
            [
                'label' => __('messages.news'),
                'url' => route('news'),
                'active' => request()->routeIs('news*'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>',
            ],
            [
                'label' => __('messages.login'),
                'url' => route('login'),
                'active' => request()->routeIs('login'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>',
            ],
        ];
    } elseif ($role === \App\Enums\RoleEnum::PARTICIPANT->value) {
        $tabs = [
            [
                'label' => __('messages.home'),
                'url' => route('home'),
                'active' => request()->routeIs('home'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
            ],
            [
                'label' => (app()->getLocale() === 'fr' ? 'Mon Espace' : (app()->getLocale() === 'en' ? 'Dashboard' : 'فضائي')),
                'url' => route('participant.dashboard'),
                'active' => request()->routeIs('participant.dashboard'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 00-2 2h2a2 2 0 00-2-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
            ],
            [
                'label' => (app()->getLocale() === 'fr' ? 'Mon Badge' : (app()->getLocale() === 'en' ? 'My Badge' : 'شارتي الرسمية')),
                'url' => $myBadgeUrl,
                'active' => request()->routeIs('accreditation.badge*'),
                'is_primary' => true,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
            ],
            [
                'label' => __('messages.skills'),
                'url' => route('skills'),
                'active' => request()->routeIs('skills*'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L5.6 15.12a2 2 0 01-1.187-2.19l.732-4.393A2 2 0 017.11 6.814l3.176.635a6 6 0 003.86-.517l.318-.158a6 6 0 013.86-.517l2.387.477a2 2 0 011.642 1.964v6.22a2 2 0 01-.927 1.69z"/>',
            ],
            [
                'label' => (app()->getLocale() === 'fr' ? 'Mon Profil' : (app()->getLocale() === 'en' ? 'My Profile' : 'حسابي')),
                'url' => route('profile'),
                'active' => request()->routeIs('profile'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
            ],
        ];
    } else {
        // Admins, Judges, Delegation Admins, Media Managers
        $dashUrl = match($role) {
            'SUPER_ADMIN', 'NATIONAL_ADMIN' => route('admin.dashboard'),
            'MEDIA_MANAGER'                 => route('admin.media.dashboard'),
            'EXECUTIVE_VIEWER'              => route('executive.dashboard'),
            'COUNTRY_ADMIN'                 => route('country.dashboard'),
            'ORGANIZATION_ADMIN'            => route('organization.dashboard'),
            'JUDGE', 'EXPERT'               => route('judge.dashboard'),
            default                         => route('admin.dashboard'),
        };

        $scannerUrl = \Illuminate\Support\Facades\Route::has('admin.scanner') 
            ? route('admin.scanner') 
            : (\Illuminate\Support\Facades\Route::has('scanner') ? route('scanner') : route('admin.accreditations'));

        $tabs = [
            [
                'label' => __('messages.home'),
                'url' => route('home'),
                'active' => request()->routeIs('home'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
            ],
            [
                'label' => (app()->getLocale() === 'fr' ? 'Dashboard Admin' : (app()->getLocale() === 'en' ? 'Admin Board' : 'فضائي الإداري')),
                'url' => $dashUrl,
                'active' => request()->routeIs('*dashboard*'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 00-2 2h2a2 2 0 00-2-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>',
            ],
            [
                'label' => (app()->getLocale() === 'fr' ? 'Scanner QR' : (app()->getLocale() === 'en' ? 'QR Scanner' : 'الماسح الضوئي')),
                'url' => $scannerUrl,
                'active' => request()->routeIs('*scanner*'),
                'is_primary' => true,
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>',
            ],
            [
                'label' => (app()->getLocale() === 'fr' ? 'Accréditations' : (app()->getLocale() === 'en' ? 'Accreditations' : 'الاعتمادات')),
                'url' => route('admin.accreditations'),
                'active' => request()->routeIs('admin.accreditations*'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
            ],
            [
                'label' => (app()->getLocale() === 'fr' ? 'Profil' : (app()->getLocale() === 'en' ? 'Profile' : 'حسابي')),
                'url' => route('profile'),
                'active' => request()->routeIs('profile'),
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
            ],
        ];
    }
@endphp

<div x-data="{ showRegModal: false }" class="md:hidden">

    <!-- Bottom Navigation Bar -->
    <div class="fixed bottom-0 left-0 right-0 z-50 bg-white/95 backdrop-blur-2xl border-t border-slate-200/90 shadow-[0_-8px_30px_rgba(0,0,0,0.12)] px-2 py-2 flex items-center justify-around print:hidden select-none">
        @foreach($tabs as $tab)
            @if(!empty($tab['is_primary']))
                @if(!$u || $role === 'GUEST')
                    <button type="button" @click="showRegModal = true" class="flex flex-col items-center justify-center -mt-6 relative group">
                        <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-full bg-gradient-to-tr from-[#0B2A6F] via-[#35A536] to-[#35A536] text-white flex items-center justify-center shadow-xl shadow-emerald-600/30 border-4 border-white transform active:scale-90 transition duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $tab['icon'] !!}
                            </svg>
                        </div>
                        <span class="text-[9px] font-black text-[#0B2A6F] mt-1">{{ $tab['label'] }}</span>
                    </button>
                @else
                    <a href="{{ $tab['url'] }}" class="flex flex-col items-center justify-center -mt-6 relative group">
                        <div class="w-13 h-13 sm:w-14 sm:h-14 rounded-full bg-gradient-to-tr from-[#0B2A6F] via-[#35A536] to-[#35A536] text-white flex items-center justify-center shadow-xl shadow-emerald-600/30 border-4 border-white transform active:scale-90 transition duration-200">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $tab['icon'] !!}
                            </svg>
                        </div>
                        <span class="text-[9px] font-black text-[#0B2A6F] mt-1">{{ $tab['label'] }}</span>
                    </a>
                @endif
            @else
                <a href="{{ $tab['url'] }}" class="flex flex-col items-center justify-center py-1 px-2 sm:px-3 rounded-2xl transition active:scale-95 {{ $tab['active'] ? 'text-[#0B2A6F] font-black' : 'text-slate-500 hover:text-[#0B2A6F]' }}">
                    <svg class="w-5 h-5 {{ $tab['active'] ? 'text-[#35A536]' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $tab['icon'] !!}
                    </svg>
                    <span class="text-[10px] font-bold mt-0.5 whitespace-nowrap">{{ $tab['label'] }}</span>
                </a>
            @endif
        @endforeach
    </div>

    <!-- Registration Options Chooser Modal (Bottom Sheet for Mobile) -->
    <template x-teleport="body">
        <div x-show="showRegModal" x-cloak class="fixed inset-0 z-50 flex items-end justify-center">
            <!-- Dark Overlay -->
            <div x-show="showRegModal" 
                 x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 @click="showRegModal = false" class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm"></div>

            <!-- Bottom Sheet Container -->
            <div x-show="showRegModal" 
                 x-transition:enter="ease-out duration-300 transform" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
                 x-transition:leave="ease-in duration-200 transform" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
                 class="relative w-full max-w-lg bg-white rounded-t-3xl p-6 shadow-2xl z-50 space-y-4 border-t-2 border-[#35A536]">
                
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <div>
                        <h3 class="text-sm font-black text-[#0B2A6F]">
                            {{ app()->getLocale() === 'fr' ? 'Choisissez le type d\'inscription' : (app()->getLocale() === 'en' ? 'Select Registration Type' : 'اختر نوع التسجيل والاعتماد') }}
                        </h3>
                        <p class="text-[11px] text-slate-500 font-bold">
                            {{ app()->getLocale() === 'fr' ? 'Portail officiel Africa Skills Forum 2026' : (app()->getLocale() === 'en' ? 'Official Africa Skills Forum 2026 Portal' : 'منتدى المهارات الإفريقية 2026') }}
                        </p>
                    </div>
                    <button @click="showRegModal = false" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center">✕</button>
                </div>

                <div class="grid grid-cols-1 gap-3 pt-1">
                    <!-- Option 1: Competitors & Youth -->
                    <a href="{{ route('registration') }}" class="p-4 rounded-2xl bg-emerald-50 hover:bg-emerald-100/80 border border-emerald-200 transition flex items-center gap-3.5 group">
                        <div class="w-11 h-11 rounded-xl bg-[#35A536] text-white flex items-center justify-center shrink-0 shadow-md group-hover:scale-105 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                        </div>
                        <div class="text-start">
                            <div class="text-xs font-black text-slate-900">
                                {{ app()->getLocale() === 'fr' ? 'Inscription Compétiteurs & Jeunes' : (app()->getLocale() === 'en' ? 'Competitors & Youth Registration' : 'تسجيل المتنافسين والشباب في التخصصات') }}
                            </div>
                            <div class="text-[10px] text-slate-500 font-bold mt-0.5">
                                {{ app()->getLocale() === 'fr' ? 'Pour les candidats aux métiers et compétitions' : (app()->getLocale() === 'en' ? 'For skill competitors and youth participants' : 'خاص بالمشاركين في التخصصات والمسابقات المهنية') }}
                            </div>
                        </div>
                    </a>

                    <!-- Option 2: Official Accreditation -->
                    <a href="{{ route('official.registration') }}" class="p-4 rounded-2xl bg-blue-50 hover:bg-blue-100/80 border border-blue-200 transition flex items-center gap-3.5 group">
                        <div class="w-11 h-11 rounded-xl bg-[#0B2A6F] text-white flex items-center justify-center shrink-0 shadow-md group-hover:scale-105 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5 5 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5 5 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                        </div>
                        <div class="text-start">
                            <div class="text-xs font-black text-[#0B2A6F]">
                                {{ app()->getLocale() === 'fr' ? 'Inscription Officielle & Accréditation' : (app()->getLocale() === 'en' ? 'Official Registration & Accreditation' : 'التسجيل الرسمي والاعتماد للوفود والصحافة') }}
                            </div>
                            <div class="text-[10px] text-slate-500 font-bold mt-0.5">
                                {{ app()->getLocale() === 'fr' ? 'Délégations nationales, invités VIP, médias et صحافة' : (app()->getLocale() === 'en' ? 'National delegations, VIP guests, media & press' : 'خاص بالوفود الوطنية، الدبلوماسيين، والصحافة والإعلام') }}
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </template>

</div>
