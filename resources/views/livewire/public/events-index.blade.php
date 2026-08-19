@php
$locale = app()->getLocale();
$t = function($ar, $fr, $en) use ($locale) { return match($locale) { 'fr' => $fr, 'en' => $en, default => $ar }; };
@endphp

<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        
        <!-- Hero Header -->
        <div class="relative rounded-[32px] overflow-hidden bg-slate-950 text-white p-8 sm:p-12 shadow-2xl border border-white/20">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/gallery_header_bg.png') }}" alt="Events Header Background"
                     class="w-full h-full object-cover object-center opacity-30 filter blur-xs">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-transparent"></div>
            </div>

            <div class="relative z-10 text-center max-w-3xl mx-auto space-y-4">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-[#0066FF]/20 border border-[#0066FF]/40 text-[#0066FF] text-xs font-black">
                    <svg class="w-4 h-4 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span>{{ $t('الأجندة الرسمية للمنتدى والقيعان', 'Agenda Officiel du Forum', 'Official Forum Agenda') }}</span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight drop-shadow-2xl">
                    {{ $t('أحداث ولقاءات منتدى المهارات الإفريقية', 'Événements & Sessions du Forum', 'Africa Skills Forum Events & Sessions') }}
                </h1>
                <p class="text-xs sm:text-base text-slate-200 font-medium leading-relaxed max-w-2xl mx-auto">
                    {{ $t('جدول اللقاءات، المحاضرات، الاجتماعات الرسمية، الجلسات رفيعة المستوى، والندوات القارية المبرمجة بمركز المؤتمرات CCO بوهران.', 'Consultez le programme des rencontres, conférences, réunions officielles, sessions de haut niveau et séminaires continentaux.', 'Explore the schedule of encounters, lectures, official meetings, high-level sessions, and continental seminars.') }}
                </p>
            </div>
        </div>

        <!-- Filter Pills & Search Control -->
        <div class="bg-white/80 backdrop-blur-xl rounded-[24px] p-5 shadow-xl border border-slate-200/90 space-y-4">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4">
                
                {{-- Search Input --}}
                <div class="relative w-full md:w-80">
                    <input type="text" wire:model.live.debounce.300ms="search"
                           placeholder="{{ $t('بحث في العنوان أو التفاصيل...', 'Rechercher un événement...', 'Search event title...') }}"
                           class="w-full pr-10 pl-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-bold text-[#06205C] focus:outline-none focus:ring-2 focus:ring-[#0066FF]">
                    <svg class="w-4 h-4 text-slate-400 absolute end-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                {{-- Event Categories Pills --}}
                <div class="flex flex-wrap items-center gap-2 w-full md:w-auto">
                    <button type="button" wire:click="$set('selectedCategory', '')"
                            class="px-3.5 py-2 rounded-xl text-xs font-black transition flex items-center gap-1.5 {{ $selectedCategory === '' ? 'bg-[#0066FF] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                        <span>{{ $t('الكل', 'Tous', 'All') }}</span>
                    </button>

                    <button type="button" wire:click="$set('selectedCategory', 'meetings')"
                            class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $selectedCategory === 'meetings' ? 'bg-[#0066FF] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>{{ $t('لقاءات', 'Rencontres / B2B', 'Meetings') }}</span>
                    </button>

                    <button type="button" wire:click="$set('selectedCategory', 'lectures')"
                            class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $selectedCategory === 'lectures' ? 'bg-[#0066FF] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/></svg>
                        <span>{{ $t('محاضرات', 'Conférences', 'Lectures') }}</span>
                    </button>

                    <button type="button" wire:click="$set('selectedCategory', 'assemblies')"
                            class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $selectedCategory === 'assemblies' ? 'bg-[#0066FF] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5m-5 0V9m0 4h.01M15 9h.01M15 13h.01M11 13h.01M11 17h.01M15 17h.01"/></svg>
                        <span>{{ $t('اجتماعات', 'Assemblées', 'Assemblies') }}</span>
                    </button>

                    <button type="button" wire:click="$set('selectedCategory', 'high_level')"
                            class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $selectedCategory === 'high_level' ? 'bg-[#0066FF] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        <svg class="w-4 h-4 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        <span>{{ $t('جلسات رفيعة المستوى', 'Sessions Haut Niveau', 'High-Level Sessions') }}</span>
                    </button>

                    <button type="button" wire:click="$set('selectedCategory', 'seminars')"
                            class="px-3.5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-1.5 {{ $selectedCategory === 'seminars' ? 'bg-[#0066FF] text-white shadow-md' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                        <svg class="w-4 h-4 text-sky-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>{{ $t('ندوات', 'Séminaires', 'Seminars') }}</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Events List Grid -->
        <div class="space-y-6 max-w-5xl mx-auto">
            @forelse($events as $event)
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-md hover:shadow-xl transition-all duration-300 flex flex-col md:flex-row md:items-center justify-between gap-6 group hover:border-[#0066FF]">
                    <div class="space-y-3 flex-1">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="px-3 py-1 rounded-xl bg-blue-50 text-[#0066FF] font-mono font-black text-[11px] border border-blue-200 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>{{ $event->start_at ? $event->start_at->format('Y-m-d — H:i') : '2026 / 2027' }}</span>
                            </span>

                            @if($event->venue)
                                <span class="px-3 py-1 rounded-xl bg-slate-100 text-slate-700 font-bold text-[11px] border border-slate-200 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span>{{ $event->venue }}</span>
                                </span>
                            @endif
                        </div>

                        <h3 class="text-xl font-black text-[#06205C] group-hover:text-[#0066FF] transition-colors leading-snug">
                            {{ $event->getLocalized('title') }}
                        </h3>

                        <p class="text-xs text-slate-600 leading-relaxed font-medium">
                            {{ $event->getLocalized('summary') }}
                        </p>
                    </div>

                    <div class="shrink-0 flex items-center gap-3">
                        <a href="{{ route('registration') }}" class="px-5 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white text-xs font-bold shadow transition flex items-center gap-1.5">
                            <span>{{ $t('طلب الحضور / الاعتماد', 'Demander l\'Accréditation', 'Request Access') }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-3xl p-16 text-center text-slate-400 font-bold text-xs border border-slate-200 space-y-2">
                    <svg class="w-12 h-12 text-slate-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <p>{{ $t('لا تتوفر فعاليات مبرمجة ضمن هذا التصنيف حالياً.', 'Aucun événement disponible dans cette catégorie.', 'No events found in this category.') }}</p>
                </div>
            @endforelse
        </div>

    </div>
</div>
