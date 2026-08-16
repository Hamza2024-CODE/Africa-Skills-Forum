@props(['items' => []])

<div x-show="mobileNavOpen" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-50 lg:hidden flex" x-cloak>

    <!-- Overlay backdrop -->
    <div @click="mobileNavOpen = false" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs"></div>

    <!-- Drawer Content Container -->
    <div class="relative w-4/5 max-w-sm bg-white dark:bg-slate-900 h-full shadow-2xl p-6 flex flex-col space-y-6 z-10 overflow-y-auto border-e border-slate-200 dark:border-slate-800 text-slate-900 dark:text-white">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 dark:border-slate-800">
            <a href="{{ route('home') }}" class="flex items-center gap-2 bg-slate-50 dark:bg-slate-800 p-1.5 px-3 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden shrink-0">
                <img src="{{ asset('ministry-logo-trimmed.png') }}" alt="وزارة التكوين والتعليم المهنيين" class="h-6 sm:h-7 w-auto object-contain shrink-0">
                <div class="h-4 sm:h-5 w-px bg-slate-300 dark:bg-slate-600 shrink-0"></div>
                <img src="{{ asset('africa-logo-trimmed.png') }}" alt="African Union - Africa Skills Forum" class="h-6 sm:h-7 w-auto object-contain shrink-0">
            </a>
            <button @click="mobileNavOpen = false" type="button" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 touch-target shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        @php
            $loc = app()->getLocale();
            $sectionMeta = [
                1 => [
                    'label' => $loc === 'fr' ? 'CENTRES DE COMMANDEMENT & CONTRÔLE' : ($loc === 'en' ? 'EXECUTIVE COMMAND & CONTROL CENTERS' : 'مراكز التحكم والقيادة التنفيذية'),
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>',
                ],
                2 => [
                    'label' => $loc === 'fr' ? 'INTERVENANTS & DÉLÉGATIONS' : ($loc === 'en' ? 'SPEAKERS & DELEGATIONS' : 'المحاضرون والضيوف والوفود'),
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
                ],
                3 => [
                    'label' => $loc === 'fr' ? 'MÉDIAS & CMS' : ($loc === 'en' ? 'MEDIA & CMS' : 'الإعلام والمحتوى والـ CMS'),
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>',
                ],
                4 => [
                    'label' => $loc === 'fr' ? 'ACCRÉDITATIONS' : ($loc === 'en' ? 'ACCREDITATIONS' : 'الاعتمادات والأمان والحوكمة'),
                    'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
                ],
            ];

            $groupedItems = [];
            foreach ($items as $item) {
                $secIdx = $item['section'] ?? 1;
                $meta = $sectionMeta[$secIdx] ?? $sectionMeta[1];
                $key = $meta['label'];
                if (!isset($groupedItems[$key])) {
                    $groupedItems[$key] = [
                        'label' => $meta['label'],
                        'icon'  => $meta['icon'],
                        'items' => [],
                    ];
                }
                $groupedItems[$key]['items'][] = $item;
            }
        @endphp

        <div class="space-y-4 flex-1">
            @foreach($groupedItems as $secKey => $secGroup)
                @php
                    $mItems = $secGroup['items'] ?? [];
                    $hasActiveMItem = false;
                    foreach ($mItems as $mCheck) {
                        if (request()->routeIs($mCheck['route'] ?? '')) {
                            $hasActiveMItem = true;
                            break;
                        }
                    }
                @endphp
                <div x-data="{ sectionOpen: {{ $hasActiveMItem ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="sectionOpen = !sectionOpen" type="button" 
                            class="w-full flex items-center justify-between px-3 py-2 rounded-xl text-xs font-black text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/80 uppercase tracking-wider mb-1 cursor-pointer select-none border border-slate-200/60 dark:border-slate-800">
                        <span class="flex items-center min-w-0">
                            @if(!empty($secGroup['icon']))
                                <svg class="w-4 h-4 shrink-0 text-blue-600 dark:text-sky-400 me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $secGroup['icon'] !!}
                                </svg>
                            @endif
                            <span class="truncate text-[11px] font-black">{{ $secGroup['label'] }}</span>
                        </span>
                        <svg class="w-3.5 h-3.5 text-slate-400 transition-transform duration-200 shrink-0 ms-1"
                             :class="sectionOpen ? 'rotate-180 text-blue-600' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="sectionOpen" x-collapse x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 -translate-y-1" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-0.5 ps-2">
                        @foreach($secGroup['items'] as $item)
                            @php
                                $isActive = request()->routeIs($item['route']);
                            @endphp
                            <a href="{{ route($item['route']) }}" 
                               @click="mobileNavOpen = false"
                               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition touch-target {{ $isActive ? 'bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-sky-300 border border-blue-200 dark:border-blue-800 shadow-xs' : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' }}">
                                <span class="w-2 h-2 rounded-full {{ $isActive ? 'bg-blue-600 dark:bg-sky-400' : 'bg-slate-300 dark:bg-slate-600' }}"></span>
                                <span class="truncate">{{ $item['label'] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Sticky Bottom Action Bar with Logout & Padding for Fixed Mobile Bottom Bar --}}
        <div class="sticky bottom-0 bg-white dark:bg-slate-900 pt-3 pb-24 border-t border-slate-200 dark:border-slate-800 space-y-2 z-20">
            <a href="{{ route('profile') }}" 
               @click="mobileNavOpen = false"
               class="flex items-center gap-3 px-3 py-2 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition">
                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-sky-300 flex items-center justify-center font-black text-xs shrink-0">
                    {{ substr(auth()->user()?->name ?? 'A', 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <p class="truncate font-black text-slate-900 dark:text-slate-100 text-xs">{{ auth()->user()?->name ?? 'User' }}</p>
                    <p class="truncate text-[10px] text-slate-400 font-bold">{{ auth()->user()?->email }}</p>
                </div>
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full py-2.5 rounded-xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-300 border border-rose-200 dark:border-rose-800 font-black text-xs hover:bg-rose-100 dark:hover:bg-rose-900 transition touch-target flex items-center justify-center gap-2 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Déconnexion' : (app()->getLocale() === 'en' ? 'Sign Out' : 'تسجيل الخروج') }}</span>
                </button>
            </form>
        </div>
    </div>
</div>
