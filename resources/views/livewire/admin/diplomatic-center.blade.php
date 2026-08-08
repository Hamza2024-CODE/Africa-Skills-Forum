@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-6 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    <div class="printable-hide-on-print space-y-6">

    {{-- DIPLOMATIC EXECUTIVE HEADER BAND --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4 bg-gradient-to-l from-[#020A24] via-[#06205C] to-[#0A3580] p-6 rounded-3xl text-white shadow-xl border border-blue-900/50">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-black shrink-0 border border-amber-500/40 shadow-inner">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/>
                </svg>
            </div>
            <div>
                <div class="flex items-center gap-2">
                    <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 font-mono text-[10px] font-black uppercase border border-amber-500/30">
                        {{ $t('الجمهورية الجزائرية الديمقراطية الشعبية', 'République Algérienne Démocratique et Populaire', 'People\'s Democratic Republic of Algeria') }}
                    </span>
                    <span class="px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-300 font-mono text-[10px] font-black uppercase border border-emerald-500/30">
                        {{ $t('بروتوكول محمي', 'Protocole Sécurisé', 'Secured Protocol') }}
                    </span>
                </div>
                <h1 class="text-xl sm:text-2xl font-black text-white tracking-tight mt-1">
                    {{ $t('مركز القيادة الدبلوماسية والتبادل الوزاري وثقافي', 'Centre Commandement Diplomatique & Échanges Ministériels', 'Diplomatic Command Center & Ministerial Bilateral Exchange') }}
                </h1>
                <p class="text-xs font-bold text-blue-200 mt-1">
                    {{ $t('منظومة حجز القاعات الدبلوماسية، الجدولة الثنائية وتتبع جاهزية الوزراء والوفود بين وزارة التكوين المهني الجزائرية والوفود الإفريقية.', 'Système de réservation des salons diplomatiques et suivi des entretiens ministériels.', 'Diplomatic room reservations, bilateral schedules, and minister availability tracking.') }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2">
            <button wire:click="$set('showAddMinisterModal', true)" class="px-4 py-2.5 rounded-2xl bg-white/10 hover:bg-white/20 text-white font-bold text-xs border border-white/20 backdrop-blur-xs transition flex items-center gap-2">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                <span>{{ $t('إضافة مسؤول وزاري', 'Ajouter Ministre/Officiel', 'Add Ministerial Official') }}</span>
            </button>

            <button wire:click="openBookingModal" class="px-4 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs shadow-lg transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ $t('حجز لقاء ثنائي وقاعة', 'Nouveau Rendez-vous', 'New Bilateral Meeting') }}</span>
            </button>
        </div>
    </div>

    {{-- FLASH / ERROR NOTIFICATIONS --}}
    @if($flashMessage)
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-xs font-bold flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ $flashMessage }}</span>
            </div>
            <button wire:click="$set('flashMessage', '')" class="text-emerald-700 font-black text-xs">✕</button>
        </div>
    @endif

    {{-- EXECUTIVE KPI CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        
        <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-black shrink-0 border border-blue-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <span class="text-slate-400 text-[10px] font-black uppercase tracking-wider block">
                    {{ $t('الوزراء والمسؤولون', 'Ministres & Officiels', 'Ministers & Officials') }}
                </span>
                <p class="text-2xl font-black text-[#06205C] dark:text-white">{{ $totalMinistersCount }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-black shrink-0 border border-emerald-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <span class="text-emerald-700 dark:text-emerald-400 text-[10px] font-black uppercase tracking-wider block">
                    {{ $t('متاحون للعمل واللقاءات', 'Disponible pour entretiens', 'Available for Meetings') }}
                </span>
                <p class="text-2xl font-black text-emerald-900 dark:text-emerald-200">{{ $availableMinistersCount }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center font-black shrink-0 border border-amber-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <div>
                <span class="text-amber-700 dark:text-amber-400 text-[10px] font-black uppercase tracking-wider block">
                    {{ $t('لقاءات ثنائية مجدولة', 'Rencontres Mainties', 'Scheduled Meetings') }}
                </span>
                <p class="text-2xl font-black text-amber-900 dark:text-amber-200">{{ $scheduledMeetingsCount }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center font-black shrink-0 border border-purple-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/></svg>
            </div>
            <div>
                <span class="text-purple-700 dark:text-purple-400 text-[10px] font-black uppercase tracking-wider block">
                    {{ $t('قاعات اجتماعات VIP جاهزة', 'Salons VIP Prêts', 'Ready VIP Lounges') }}
                </span>
                <p class="text-2xl font-black text-purple-900 dark:text-purple-200">{{ $activeRoomsCount }}</p>
            </div>
        </div>

    </div>

    {{-- NAVIGATION TABS --}}
    <div class="flex items-center gap-2 border-b border-slate-200 dark:border-slate-700 pb-2">
        <button wire:click="$set('activeTab', 'MEETINGS')"
                class="px-5 py-2.5 rounded-2xl font-black text-xs transition flex items-center gap-2 {{ $activeTab === 'MEETINGS' ? 'bg-[#06205C] text-white shadow-md' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100' }}">
            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span>{{ $t('جدول اللقاءات الثنائية المحجوزة', 'Rencontres Bilatérales Programmées', 'Scheduled Bilateral Meetings') }}</span>
        </button>

        <button wire:click="$set('activeTab', 'MINISTERS')"
                class="px-5 py-2.5 rounded-2xl font-black text-xs transition flex items-center gap-2 {{ $activeTab === 'MINISTERS' ? 'bg-[#06205C] text-white shadow-md' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100' }}">
            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            <span>{{ $t('حالة توافر وجاهزية الوزراء والمدراء', 'Disponibilité des Ministres & Officiels', 'Ministers Availability Status') }}</span>
        </button>

        <button wire:click="$set('activeTab', 'ROOMS')"
                class="px-5 py-2.5 rounded-2xl font-black text-xs transition flex items-center gap-2 {{ $activeTab === 'ROOMS' ? 'bg-[#06205C] text-white shadow-md' : 'bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-100' }}">
            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/></svg>
            <span>{{ $t('دليل وتوقيتات قاعات الاجتماعات', 'Salons VIP & Planning', 'VIP Lounges & Schedule') }}</span>
        </button>
    </div>

    {{-- TAB 1: SCHEDULED MEETINGS & ROOM RESERVATIONS --}}
    @if($activeTab === 'MEETINGS')
        <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-md overflow-hidden space-y-0">
            <div class="p-5 bg-slate-50 dark:bg-slate-900/60 border-b border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-3">
                <h3 class="text-sm font-black text-[#06205C] dark:text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $t('جدول المحادثات والمواعيد الثنائية المحجوزة', 'Liste des Entretiens Bilatéraux', 'Scheduled Bilateral Sessions') }}</span>
                </h3>

                <select wire:model.live="selectedStatus" class="px-3 py-2 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-white dark:bg-slate-800 dark:text-white">
                    <option value="ALL">{{ $t('جميع الحالات', 'Tous les statuts', 'All Statuses') }}</option>
                    <option value="SCHEDULED">{{ $t('مجدول ومثبت', 'Programmé', 'Scheduled') }}</option>
                    <option value="IN_PROGRESS">{{ $t('جاري الآن (In Session)', 'En cours', 'In Progress') }}</option>
                    <option value="COMPLETED">{{ $t('مكتمل', 'Terminé', 'Completed') }}</option>
                    <option value="CANCELLED">{{ $t('ملغى', 'Annulé', 'Cancelled') }}</option>
                </select>
            </div>

            <div class="divide-y divide-slate-100 dark:divide-slate-700">
                @forelse($meetings as $mtg)
                    <div class="p-6 hover:bg-slate-50/70 dark:hover:bg-slate-700/40 transition flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                        
                        {{-- Meeting details & Ministers --}}
                        <div class="space-y-3 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="px-3 py-1 rounded-full text-[10px] font-mono font-black bg-blue-50 text-blue-800 border border-blue-200">
                                    {{ $mtg->start_time->format('Y-m-d') }} | {{ $mtg->start_time->format('H:i') }} — {{ $mtg->end_time->format('H:i') }}
                                </span>

                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase border
                                    {{ $mtg->status === 'SCHEDULED' ? 'bg-amber-50 text-amber-900 border-amber-300' : ($mtg->status === 'IN_PROGRESS' ? 'bg-emerald-50 text-emerald-900 border-emerald-300 animate-pulse' : ($mtg->status === 'COMPLETED' ? 'bg-slate-100 text-slate-700 border-slate-200' : 'bg-rose-50 text-rose-900 border-rose-300')) }}">
                                    {{ $mtg->status }}
                                </span>
                            </div>

                            <h4 class="text-base font-black text-[#06205C] dark:text-white leading-tight">
                                {{ $mtg->title }}
                            </h4>

                            {{-- Ministers Pair Grid --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-1">
                                {{-- Host Minister --}}
                                <div class="p-3 rounded-2xl bg-blue-50/60 dark:bg-blue-950/40 border border-blue-100 dark:border-blue-900 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-[#06205C] text-white flex items-center justify-center font-black text-xs shrink-0">
                                        {{ $mtg->hostMinister?->country?->code ?? 'DZA' }}
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-blue-600 dark:text-blue-300 font-black uppercase block">{{ $t('الطرف المستضيف', 'Partie Hôte', 'Host Official') }}</span>
                                        <span class="font-black text-xs text-slate-900 dark:text-slate-100 block">{{ $mtg->hostMinister?->full_name }}</span>
                                        <span class="text-[10px] text-slate-500 font-bold block">{{ $mtg->hostMinister?->title_ar }}</span>
                                    </div>
                                </div>

                                {{-- Guest Minister --}}
                                <div class="p-3 rounded-2xl bg-amber-50/60 dark:bg-amber-950/40 border border-amber-100 dark:border-amber-900 flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-amber-600 text-white flex items-center justify-center font-black text-xs shrink-0">
                                        {{ $mtg->guestMinister?->country?->code ?? 'VIP' }}
                                    </div>
                                    <div>
                                        <span class="text-[10px] text-amber-700 dark:text-amber-300 font-black uppercase block">{{ $t('الضيف الرسمي', 'Invité Officiel', 'Guest Official') }}</span>
                                        <span class="font-black text-xs text-slate-900 dark:text-slate-100 block">{{ $mtg->guestMinister?->full_name }}</span>
                                        <span class="text-[10px] text-slate-500 font-bold block">{{ $mtg->guestMinister?->title_ar }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Reserved Room details & Actions --}}
                        <div class="lg:w-72 shrink-0 bg-slate-50 dark:bg-slate-900/60 p-4 rounded-2xl border border-slate-200 dark:border-slate-700 space-y-3">
                            <div>
                                <span class="text-[10px] text-slate-400 font-black uppercase block">{{ $t('القاعة المحجوزة', 'Salon VIP Réservé', 'Reserved Lounge') }}</span>
                                <span class="font-black text-xs text-[#06205C] dark:text-white block mt-0.5">{{ $mtg->room?->getLocalized('name') }}</span>
                                <span class="text-[10px] text-slate-500 font-bold block">{{ $mtg->room?->location_zone }}</span>
                            </div>

                            @if($mtg->status === 'SCHEDULED')
                                <button wire:click="cancelMeeting({{ $mtg->id }})" class="w-full py-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-700 border border-rose-200 font-bold text-xs transition">
                                    {{ $t('إلغاء حجز الموعد', 'Annuler Rendez-vous', 'Cancel Reservation') }}
                                </button>
                            @endif
                        </div>

                    </div>
                @empty
                    <div class="p-16 text-center text-slate-400 font-bold text-xs space-y-2">
                        <svg class="w-12 h-12 mx-auto text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p>{{ $t('لا توجد لقاءات ثنائية مجدولة حالياً.', 'Aucune rencontre bilatérale programmée.', 'No bilateral meetings currently scheduled.') }}</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endif

    {{-- TAB 2: MINISTERS & EXECUTIVE AVAILABILITY COMMAND --}}
    @if($activeTab === 'MINISTERS')
        <div class="space-y-4">
            <div class="bg-white dark:bg-slate-800 p-4 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-3">
                <div class="relative w-full sm:w-80">
                    <input type="text" wire:model.live.debounce.300ms="searchQuery"
                           placeholder="{{ $t('بحث باسم الوزير أو الوزارة...', 'Rechercher par nom ou ministère...', 'Search minister name or ministry...') }}"
                           class="w-full ps-9 pe-4 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    <svg class="w-4 h-4 text-slate-400 absolute start-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($ministers as $min)
                    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-md p-6 space-y-4 flex flex-col justify-between">
                        
                        {{-- Top Header --}}
                        <div class="space-y-3">
                            <div class="flex items-center justify-between gap-2">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-1 rounded-xl bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 font-mono font-black text-xs">
                                        {{ $min->country?->code ?? 'DZA' }}
                                    </span>
                                    <span class="px-2 py-0.5 rounded-full bg-gradient-to-r from-amber-400 via-amber-500 to-yellow-500 text-slate-950 font-black text-[10px] tracking-wider uppercase border border-amber-300 shadow-xs">
                                        VIP DIPLOMATIC
                                    </span>
                                </div>

                                {{-- Availability Badge --}}
                                @php
                                    $st = $min->availability_status;
                                    $stBadge = match($st) {
                                        'AVAILABLE'  => ['bg-emerald-50 text-emerald-900 border-emerald-300', $t('متاح للعمل واللقاءات', 'Disponible', 'Available')],
                                        'BUSY'       => ['bg-rose-50 text-rose-900 border-rose-300', $t('في اجتماع / غير متاح', 'En Réunion', 'Busy')],
                                        'IN_SESSION' => ['bg-amber-50 text-amber-900 border-amber-300', $t('في الجلسة العامة', 'En Session', 'In Session')],
                                        default      => ['bg-slate-100 text-slate-700 border-slate-200', $t('خارج ساعات العمل', 'Hors Service', 'Off Duty')],
                                    };
                                @endphp
                                <span class="px-3 py-1 rounded-full text-[10px] font-black border uppercase {{ $stBadge[0] }}">
                                    {{ $stBadge[1] }}
                                </span>
                            </div>

                            <div>
                                <h3 class="text-base font-black text-[#06205C] dark:text-white leading-tight">
                                    {{ $min->full_name }}
                                </h3>
                                <p class="text-xs text-amber-700 dark:text-amber-400 font-bold mt-0.5">
                                    {{ $min->title_ar }}
                                </p>
                                <span class="text-[11px] text-slate-400 font-medium block mt-1">
                                    {{ $min->ministry_name }}
                                </span>
                            </div>
                        </div>

                        {{-- Status Toggle Buttons & Booking Action --}}
                        <div class="space-y-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                            <span class="text-[10px] text-slate-400 font-black uppercase block">{{ $t('تحديث حالة التوافر الحالية:', 'Changer statut disponible:', 'Update Availability:') }}</span>
                            
                            <div class="grid grid-cols-2 gap-1.5 text-[10px] font-black">
                                <button wire:click="updateMinisterStatus({{ $min->id }}, 'AVAILABLE')" class="py-1.5 px-2 rounded-xl bg-emerald-50 hover:bg-emerald-100 text-emerald-800 border border-emerald-200 text-center transition">
                                    {{ $t('متاح', 'Disponible', 'Available') }}
                                </button>

                                <button wire:click="updateMinisterStatus({{ $min->id }}, 'BUSY')" class="py-1.5 px-2 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-800 border border-rose-200 text-center transition">
                                    {{ $t('في اجتماع', 'En Réunion', 'Busy') }}
                                </button>

                                <button wire:click="updateMinisterStatus({{ $min->id }}, 'IN_SESSION')" class="py-1.5 px-2 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 border border-amber-200 text-center transition">
                                    {{ $t('في الجلسة', 'En Session', 'In Session') }}
                                </button>

                                <button wire:click="updateMinisterStatus({{ $min->id }}, 'OFF_DUTY')" class="py-1.5 px-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 border border-slate-200 text-center transition">
                                    {{ $t('غير متاح', 'Hors Service', 'Off Duty') }}
                                </button>
                            </div>

                            <div class="grid grid-cols-2 gap-2">
                                <button wire:click="openBookingModal({{ $min->id }})" class="py-2.5 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-xs shadow-md transition flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <span>{{ $t('حجز موعد', 'Réserver', 'Book Talk') }}</span>
                                </button>

                                <button wire:click="showMinisterCredentials({{ $min->id }})" class="py-2.5 rounded-2xl bg-amber-50 hover:bg-amber-100 text-amber-900 border border-amber-300 font-black text-xs transition flex items-center justify-center gap-1">
                                    <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 0121 9z"/></svg>
                                    <span>{{ $t('بطاقة الدخول', 'Identifiants', 'Credentials') }}</span>
                                </button>
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- TAB 3: DIPLOMATIC ROOMS & REAL-TIME SCHEDULE --}}
    @if($activeTab === 'ROOMS')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            @foreach($rooms as $rm)
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-md p-6 space-y-4 flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase bg-purple-50 text-purple-700 border border-purple-200">
                                {{ $rm->location_zone }}
                            </span>
                            <span class="text-xs font-bold text-slate-500 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                {{ $rm->capacity }} {{ $t('مقعد ثنائي', 'Sièges VIP', 'VIP Seats') }}
                            </span>
                        </div>

                        <h3 class="text-base font-black text-[#06205C] dark:text-white leading-snug">
                            {{ $rm->getLocalized('name') }}
                        </h3>

                        {{-- Today's Schedule for this room --}}
                        <div class="space-y-2 pt-2">
                            <span class="text-[10px] text-slate-400 font-black uppercase block">{{ $t('مواعيد الحجز لهذا اليوم:', 'Réservations du jour:', 'Today\'s Slot Schedule:') }}</span>
                            @forelse($rm->meetings as $rMtg)
                                <div class="p-2.5 rounded-xl bg-amber-50/80 dark:bg-amber-950/40 border border-amber-200/80 text-xs font-bold text-amber-900 dark:text-amber-200 flex items-center justify-between">
                                    <span class="font-mono text-[11px]">{{ $rMtg->start_time->format('H:i') }} - {{ $rMtg->end_time->format('H:i') }}</span>
                                    <span class="truncate max-w-[140px]">{{ $rMtg->title }}</span>
                                </div>
                            @empty
                                <span class="text-emerald-600 dark:text-emerald-400 text-xs font-bold block bg-emerald-50/50 p-2 rounded-xl border border-emerald-100">
                                    {{ $t('القاعة متاحة بالكامل للحجز اليوم', 'Salon disponible toute la journée', 'Lounge available all day') }}
                                </span>
                            @endforelse
                        </div>
                    </div>

                    <button wire:click="openBookingModal(null, {{ $rm->id }})" class="w-full py-2.5 rounded-2xl bg-purple-700 hover:bg-purple-800 text-white font-black text-xs shadow-md transition flex items-center justify-center gap-1.5">
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>{{ $t('حجز هذه القاعة الآن', 'Réserver ce Salon VIP', 'Book This VIP Lounge') }}</span>
                    </button>
                </div>
            @endforeach
        </div>
    @endif

    </div> {{-- END .printable-hide-on-print --}}

    {{-- BOOKING DIPLOMATIC MEETING MODAL --}}
    @if($showBookingModal)
        <div class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-xl w-full p-6 space-y-5 shadow-2xl border border-slate-200 dark:border-slate-700 max-h-[85vh] overflow-y-auto my-auto">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-[#06205C] text-white flex items-center justify-center font-black shrink-0">
                            <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-white">
                                {{ $t('حجز لقاء ثنائي وقاعة اجتماعات دبلوماسية', 'Réservation d\'un Entretien Bilatéral', 'Book Bilateral Meeting & Diplomatic Lounge') }}
                            </h3>
                            <p class="text-xs text-slate-500 font-bold">{{ $t('تحديد الأطراف، القاعة، والتوقيت الزمني الدقيق.', 'Spécifiez les officiels, le salon VIP et le créneau horaire.', 'Specify officials, lounge room, and exact time slot.') }}</p>
                        </div>
                    </div>
                    <button wire:click="$set('showBookingModal', false)" class="text-slate-400 hover:text-slate-600 font-black text-lg">✕</button>
                </div>

                @if($errorMessage)
                    <div class="p-3.5 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-xs font-bold flex items-center gap-2">
                        <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        <span>{{ $errorMessage }}</span>
                    </div>
                @endif

                <div class="space-y-4">
                    
                    {{-- Meeting Title --}}
                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('عنوان المباحثات الثنائية *', 'Titre de la Rencontre *', 'Bilateral Session Title *') }}
                        </label>
                        <input type="text" wire:model="meetingTitle" placeholder="{{ $t('مثال: جلسة مباحثات الجزائر-مصر حول التكوين والمهن', 'Ex: Entretien Algérie-Égypte sur la formation', 'Ex: Algeria-Egypt Bilateral Session') }}"
                               class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                        @error('meetingTitle') <span class="text-[10px] text-rose-500 font-bold">{{ $message }}</span> @enderror
                    </div>

                    {{-- Host & Guest Ministers --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">
                                {{ $t('الوزير المستضيف (الجزائر) *', 'Ministre Hôte *', 'Host Official *') }}
                            </label>
                            <select wire:model="hostMinisterId" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                                <option value="">{{ $t('-- اختر الوزير المستضيف --', '-- Sélectionner --', '-- Select --') }}</option>
                                @foreach($ministers as $mOption)
                                    <option value="{{ $mOption->id }}">{{ $mOption->country?->code }} — {{ $mOption->full_name }} ({{ $mOption->title_ar }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">
                                {{ $t('الوزير الضيف (الوفد الإفريقي) *', 'Ministre Invité *', 'Guest Official *') }}
                            </label>
                            <select wire:model="guestMinisterId" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                                <option value="">{{ $t('-- اختر الوزير الضيف --', '-- Sélectionner --', '-- Select --') }}</option>
                                @foreach($ministers as $mOption)
                                    <option value="{{ $mOption->id }}">{{ $mOption->country?->code }} — {{ $mOption->full_name }} ({{ $mOption->title_ar }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Diplomatic Room --}}
                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('قاعة الاجتماعات الدبلوماسية *', 'Salon VIP d\'Accueil *', 'Diplomatic Lounge Room *') }}
                        </label>
                        <select wire:model="roomId" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                            <option value="">{{ $t('-- اختر قاعة الاجتماعات --', '-- Sélectionner --', '-- Select --') }}</option>
                            @foreach($rooms as $rOption)
                                <option value="{{ $rOption->id }}">{{ $rOption->getLocalized('name') }} ({{ $rOption->capacity }} seat)</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Date & Time Slots --}}
                    <div class="grid grid-cols-3 gap-3">
                        <div>
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('التاريخ *', 'Date *', 'Date *') }}</label>
                            <input type="date" wire:model="meetingDate" class="w-full px-3 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('من الساعة *', 'Heure début *', 'From Time *') }}</label>
                            <input type="time" wire:model="startTime" class="w-full px-3 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('إلى الساعة *', 'Heure fin *', 'To Time *') }}</label>
                            <input type="time" wire:model="endTime" class="w-full px-3 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                        </div>
                    </div>

                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('showBookingModal', false)" type="button" class="px-4 py-2.5 rounded-2xl bg-slate-100 font-bold text-xs">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="createBilateralMeeting" type="button" class="px-5 py-2.5 rounded-2xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs shadow-md transition">
                        {{ $t('تأكيد وحجز القاعة', 'Confirmer la réservation', 'Confirm Booking') }}
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- ADD NEW MINISTER MODAL --}}
    @if($showAddMinisterModal)
        <div class="fixed inset-0 z-50 bg-slate-900/80 backdrop-blur-xs flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-xl w-full p-6 space-y-5 shadow-2xl border border-slate-200 dark:border-slate-700 max-h-[85vh] overflow-y-auto my-auto">
                
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white">
                        {{ $t('إضافة وزير أو مسؤول حكومي رفيع المستوى', 'Ajouter un Ministre ou Officiel', 'Add Minister or High Government Official') }}
                    </h3>
                    <button wire:click="$set('showAddMinisterModal', false)" class="text-slate-400 font-black text-lg">✕</button>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الدولة الأفريقية *', 'Pays Africain *', 'African Country *') }}</label>
                        <select wire:model="newMinisterCountryId" class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                            <option value="">{{ $t('-- اختر الدولة --', '-- Sélectionner --', '-- Select --') }}</option>
                            @foreach($countries as $cOpt)
                                <option value="{{ $cOpt->id }}">{{ $cOpt->code }} — {{ $cOpt->getLocalized('name') }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('اسم الوزير الكامل *', 'Nom complet *', 'Full Name *') }}</label>
                        <input type="text" wire:model="newMinisterName" placeholder="{{ $t('مثال: د. محمد بن علي', 'Ex: Dr. Mohamed', 'Ex: Dr. Mohamed') }}"
                               class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الصفة والمنصب الوزاري بالعربية *', 'Titre en Arabe *', 'Title Arabic *') }}</label>
                            <input type="text" wire:model="newMinisterTitleAr" placeholder="{{ $t('وزير التكوين والتعليم المهنيين', 'Ministre...', 'Minister...') }}"
                                   class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('الصفة بالفرنسية', 'Titre en Français', 'Title French') }}</label>
                            <input type="text" wire:model="newMinisterTitleFr" placeholder="Ministre..."
                                   class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-slate-700 dark:text-slate-300 mb-1">{{ $t('اسم الوزارة أو الهيئة *', 'Nom du Ministère *', 'Ministry Name *') }}</label>
                        <input type="text" wire:model="newMinisterMinistry" placeholder="{{ $t('وزارة التكوين المهني - السنغال', 'Ministère...', 'Ministry...') }}"
                               class="w-full px-3.5 py-2.5 rounded-2xl border border-slate-200 dark:border-slate-700 text-xs font-bold bg-slate-50 dark:bg-slate-900 dark:text-white">
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('showAddMinisterModal', false)" type="button" class="px-4 py-2.5 rounded-2xl bg-slate-100 font-bold text-xs">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="saveNewMinister" type="button" class="px-5 py-2.5 rounded-2xl bg-[#06205C] text-white font-black text-xs shadow-md transition">
                        {{ $t('حفظ بيانات الوزير', 'Enregistrer', 'Save Official') }}
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- 100% OFFICIAL TRI-LINGUAL STATE INVITATION & DIPLOMATIC ACCREDITATION A4 CERTIFICATE MODAL --}}
    @if($showCredentialModal && !empty($credentialData))
        <div id="printable-credential-modal-backdrop" class="fixed inset-0 z-50 bg-slate-950/90 backdrop-blur-md flex items-center justify-center p-3 sm:p-6 overflow-y-auto">
            
            {{-- Modal Wrapper --}}
            <div class="relative w-full max-w-4xl mx-auto space-y-4 my-auto">
                
                {{-- Action Controls Bar (No Print) --}}
                <div class="no-print bg-slate-900/90 border border-slate-700/80 rounded-2xl p-4 flex flex-wrap items-center justify-between gap-3 shadow-2xl backdrop-blur-md">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 border border-amber-500/40 flex items-center justify-center font-black">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-500/20 text-amber-300 font-mono text-[10px] font-black uppercase tracking-wider border border-amber-500/30">
                                معاينة الاعتماد والطباعة — وثيقة A4 رسمية 100%
                            </span>
                            <h3 class="text-sm font-black text-white mt-0.5">
                                {{ $credentialData['name'] }} — {{ $credentialData['ministry'] }}
                            </h3>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <button onclick="downloadOfficialPDF()" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-black text-xs shadow-lg transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                            <span>تنزيل ملف PDF المباشر (Download PDF)</span>
                        </button>

                        <button onclick="printOfficialDocument()" class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-slate-950 font-black text-xs shadow-md transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            <span>طباعة الوثيقة (Print)</span>
                        </button>

                        <button wire:click="closeModal" class="px-4 py-2.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold text-xs border border-slate-700 transition">
                            إغلاق (Close)
                        </button>
                    </div>
                </div>

                {{-- PERFECT A4 CERTIFICATE SHEET PREVIEW CARD --}}
                <div id="printable-credential-card" class="bg-gradient-to-b from-[#FFFDF9] via-[#FAF6EE] to-[#F5EFE0] rounded-3xl w-full p-6 sm:p-8 space-y-4 shadow-2xl border-8 border-double border-[#06205C] ring-4 ring-amber-500/80 overflow-hidden text-slate-900 relative aspect-[210/297] flex flex-col justify-between mx-auto">
                    
                    {{-- Official State Header & Tri-Lingual Seal --}}
                    <div class="text-center space-y-2 border-b-2 border-amber-600/60 pb-3 relative z-10">
                        <div class="flex items-center justify-between gap-4">
                            <img src="/LOGO01.png" alt="Logo State" class="h-24 sm:h-28 print-compact-img w-auto object-contain drop-shadow-md">
                            <div class="text-center flex-1 space-y-1">
                                <h4 class="text-base sm:text-lg font-black text-[#06205C] uppercase tracking-widest">الجمهورية الجزائرية الديمقراطية الشعبية</h4>
                                <h5 class="text-[11px] font-black text-slate-700 uppercase tracking-wide">République Algérienne Démocratique et Populaire</h5>
                                <h5 class="text-[11px] font-black text-slate-700 uppercase tracking-wide">People's Democratic Republic of Algeria</h5>
                                <p class="text-xs font-black text-amber-800 pt-0.5">وزارة التكوين والتعليم المهنيين — Ministry of Vocational Training and Education</p>
                            </div>
                            <img src="/logo.svg" alt="WorldSkills Logo" class="h-16 print-compact-img w-auto object-contain">
                        </div>

                        <div class="mt-2 py-2 px-4 rounded-2xl bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0A3580] text-white space-y-0.5 shadow-md border-2 border-amber-400/50">
                            <h2 class="text-base font-black uppercase text-amber-300 tracking-wider">
                                وثيقة اعتماد ودعوة رسمية VIP — WORLDSKILLS AFRICA 2027
                            </h2>
                            <p class="text-[10px] font-bold text-amber-100 uppercase tracking-wide">
                                INVITATION OFFICIELLE ET ACCRÉDITATION DIPLOMATIQUE / OFFICIAL VIP DIPLOMATIC INVITATION PASS
                            </p>
                        </div>
                    </div>

                    {{-- Tri-Lingual Honor Invitation Text --}}
                    <div class="bg-amber-100/60 p-3.5 rounded-2xl border-2 border-amber-400/80 text-center space-y-1 text-slate-900 text-xs leading-relaxed font-bold shadow-xs relative z-10">
                        <p class="text-slate-950 font-black text-xs">
                            تتشرف اللجنة العليا المنظمة لأولمبياد المهن الإفريقية بالجمهورية الجزائرية بدعوة معاليكم واعتماد حسابكم الرسمي لدخول المنظومة الدبلوماسية.
                        </p>
                        <p class="text-[11px] text-slate-800 italic border-t border-amber-300/80 pt-1">
                            Le Comité d'Organisation de la République Algérienne a l'honneur d'inviter Votre Excellence et d'accréditer votre compte officiel.
                        </p>
                        <p class="text-[11px] text-slate-800 italic">
                            The Organizing Committee of Algeria has the honor to invite Your Excellency and accredit your official VIP diplomatic account.
                        </p>
                    </div>

                    {{-- Official Delegate & Ministry Information Box --}}
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-white/90 p-4 rounded-2xl border-2 border-slate-300 items-center shadow-xs relative z-10">
                        <div class="md:col-span-2 space-y-2 text-right">
                            <div>
                                <span class="text-[10px] font-black text-slate-500 uppercase block">اسم الوزير / المسؤول (Minister / Official Name):</span>
                                <h3 class="text-base font-black text-[#06205C] block mt-0.5">{{ $credentialData['name'] }}</h3>
                            </div>

                            <div>
                                <span class="text-[10px] font-black text-slate-500 uppercase block">الصفة والوزارة (Title & Ministry):</span>
                                <p class="text-xs font-black text-amber-900 block">{{ $credentialData['title'] }}</p>
                                <span class="text-[11px] font-bold text-slate-700 block mt-0.5">{{ $credentialData['ministry'] }} — {{ $credentialData['country'] }} ({{ $credentialData['country_code'] }})</span>
                            </div>
                        </div>

                        {{-- Security QR Code Box --}}
                        <div class="text-center bg-slate-50 p-3 rounded-2xl border-2 border-amber-400/60 shadow-md flex flex-col items-center justify-center">
                            @php
                                $qrData = \App\Services\QrCodeService::generateDataUri('VIP-GOV-' . $credentialData['email'], 200);
                            @endphp
                            <img src="{{ $qrData }}" alt="VIP QR" class="w-22 h-22 print-compact-qr object-contain">
                            <span class="text-[8px] font-mono font-black text-slate-600 mt-1 uppercase tracking-wider">SECURED VIP ZERO-TRUST</span>
                        </div>
                    </div>

                    {{-- Platform Access Credentials Box (اسم المستخدم + كلمة السر + كود الوصول) --}}
                    <div class="bg-gradient-to-r from-blue-950 via-[#06205C] to-slate-950 text-white p-4 rounded-2xl space-y-2 border-2 border-amber-400/60 shadow-lg relative z-10">
                        <div class="flex items-center justify-between border-b border-white/20 pb-1.5">
                            <span class="text-xs font-black text-amber-300 uppercase tracking-wide">بيانات الدخول الموحد للمنصة (Platform VIP Access Credentials):</span>
                            <span class="px-3 py-0.5 rounded-full bg-amber-400 text-slate-950 font-mono font-black text-[11px] shadow-md">VIP PIN CODE: WSAP-2027-VIP</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-xs">
                            <div class="bg-white/10 p-2.5 rounded-xl border border-white/20">
                                <span class="text-[10px] text-slate-300 block font-bold">اسم المستخدم / البريد الإلكتروني (Username / Email):</span>
                                <span class="font-mono font-black text-amber-300 text-xs select-all block mt-1">{{ $credentialData['email'] }}</span>
                            </div>

                            <div class="bg-white/10 p-2.5 rounded-xl border border-white/20">
                                <span class="text-[10px] text-slate-300 block font-bold">كلمة السر الرسمية (Official Password):</span>
                                <span class="font-mono font-black text-emerald-300 text-xs select-all block mt-1">{{ $credentialData['password'] }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Verification Seal --}}
                    <div class="flex items-center justify-between pt-2 border-t-2 border-amber-600/40 text-[11px] text-slate-700 font-bold relative z-10">
                        <span>الجمهورية الجزائرية — البرتوكول والدبلوماسية الرسمية 2027</span>
                        <span class="text-[#06205C] font-black font-mono">Official State Token: VIP-WSAP-GOV-2027</span>
                    </div>

                </div>
            </div>
        </div>
    @endif

    {{-- HTML2PDF JS LIBRARY & DIRECT CLIENT-SIDE PDF EXPORT & PRINT WINDOW --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        function downloadOfficialPDF() {
            const element = document.getElementById('printable-credential-card');
            if (!element) return;

            const opt = {
                margin:       [4, 4, 4, 4],
                filename:     'Official_Invitation_WSAP_2027.pdf',
                image:        { type: 'jpeg', quality: 0.99 },
                html2canvas:  { scale: 2, useCORS: true, logging: false },
                jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save();
        }

        function printOfficialDocument() {
            const cardEl = document.getElementById('printable-credential-card');
            if (!cardEl) return;

            const win = window.open('', '_blank', 'width=900,height=1000');
            win.document.write(`
                <!DOCTYPE html>
                <html dir="rtl" lang="ar">
                <head>
                    <title>وثيقة اعتماد ودعوة رسمية - WorldSkills Africa 2027</title>
                    <script src="https://cdn.tailwindcss.com"><\/script>
                    <style>
                        @page { size: A4 portrait; margin: 4mm; }
                        body { background: #ffffff !important; margin: 0; padding: 10px; font-family: system-ui, -apple-system, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
                        #printable-credential-card {
                            box-shadow: none !important;
                            border: 6px double #06205C !important;
                            outline: 3px solid #D4AF37 !important;
                            background: #FFFDF9 !important;
                            color: #0f172a !important;
                            width: 100% !important;
                            max-width: 800px !important;
                            padding: 24px !important;
                            border-radius: 16px !important;
                            box-sizing: border-box !important;
                            margin: 0 auto !important;
                            overflow: hidden !important;
                        }
                        .no-print { display: none !important; }
                    </style>
                </head>
                <body onload="setTimeout(function(){ window.print(); window.close(); }, 500);">
                    ${cardEl.outerHTML}
                </body>
                </html>
            `);
            win.document.close();
        }
    </script>

    {{-- Strict 1-Page Full-Width A4 Print & PDF Styles --}}
    <style>
        @media print {
            @page {
                size: A4 portrait;
                margin: 0 !important;
            }
            html, body {
                width: 100% !important;
                height: 100% !important;
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
                overflow: hidden !important;
            }
            .printable-hide-on-print, nav, header, aside, footer, .sidebar, .no-print, [role="navigation"] {
                display: none !important;
            }
            #printable-credential-modal-backdrop {
                position: fixed !important;
                inset: 0 !important;
                width: 100% !important;
                height: 100% !important;
                background: #ffffff !important;
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                padding: 12px !important;
                margin: 0 !important;
                box-sizing: border-box !important;
                z-index: 9999999 !important;
                overflow: hidden !important;
            }
            #printable-credential-card {
                position: relative !important;
                box-shadow: none !important;
                border: 6px double #06205C !important;
                outline: 3px solid #D4AF37 !important;
                background: #FFFDF9 !important;
                color: #0f172a !important;
                width: 96% !important;
                max-width: 96% !important;
                height: 96% !important;
                max-height: 96% !important;
                padding: 18px !important;
                border-radius: 16px !important;
                overflow: hidden !important;
                box-sizing: border-box !important;
                margin: auto !important;
                display: flex !important;
                flex-direction: column !important;
                justify-content: space-between !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>

</div>
