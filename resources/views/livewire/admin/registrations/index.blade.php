@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-6 pb-12 font-sans" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- TOP EXECUTIVE TITLE & QUICK ACTIONS BAR --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 bg-white dark:bg-slate-800 p-6 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-md">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-[#35A536] to-emerald-700 flex items-center justify-center text-white font-black shadow-lg shadow-emerald-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                    {{ $t('إدارة طلبات التسجيل والترشيحات الرسمية', 'Gestion des Inscriptions & Candidatures', 'Registrations & Applications Management') }}
                </h1>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 mt-0.5">
                    {{ $t('لوحة تحكم معالجة الاعتمادات، التدقيق في الوثائق، وطباعة الشارات بالجملة', 'Panneau de contrôle et d\'impression des badges', 'Control panel for verification and batch badge printing') }}
                </p>
            </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <button wire:click="resetFilters" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold text-xs transition border border-slate-200 dark:border-slate-600 flex items-center gap-2">
                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                <span>{{ $t('إعادة ضبط الفلاتر', 'Réinitialiser', 'Reset Filters') }}</span>
            </button>

            <a href="{{ route('admin.accreditations.batch-print') }}" target="_blank"
               class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#35A536] via-emerald-700 to-[#092C1D] text-white font-black text-xs shadow-lg transition flex items-center gap-2 hover:scale-105 border border-emerald-400">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>{{ $t('طباعة دفعة شارات الاعتماد (Batch A4 Print)', 'Impression de masse A4', 'Batch Badge A4 Print') }}</span>
            </a>
        </div>
    </div>

    {{-- DYNAMIC COUNTER CARDS BAR (PURE SVG VECTOR ICONS) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Total --}}
        <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-sm flex items-center justify-between">
            <div>
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $t('إجمالي الطلبات', 'Total Inscriptions', 'Total Applications') }}</p>
                <h3 class="text-2xl font-black text-slate-900 dark:text-slate-100 mt-1 font-mono">{{ number_format($totalRegistrations) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 flex items-center justify-center font-bold shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
            </div>
        </div>

        {{-- Pending --}}
        <div wire:click="$set('filterStatus', 'PENDING')" class="cursor-pointer bg-amber-50/50 dark:bg-amber-950/20 p-5 rounded-2xl border border-amber-200 dark:border-amber-800/50 shadow-sm flex items-center justify-between hover:scale-[1.02] transition">
            <div>
                <p class="text-xs font-black text-amber-700 dark:text-amber-300">{{ $t('قيد الدراسة والمراجعة', 'En Cours de Validation', 'Pending Review') }}</p>
                <h3 class="text-2xl font-black text-amber-900 dark:text-amber-200 mt-1 font-mono">{{ number_format($pendingCount) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300 flex items-center justify-center font-bold shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        {{-- Approved --}}
        <div wire:click="$set('filterStatus', 'APPROVED')" class="cursor-pointer bg-emerald-50/50 dark:bg-emerald-950/20 p-5 rounded-2xl border border-emerald-200 dark:border-emerald-800/50 shadow-sm flex items-center justify-between hover:scale-[1.02] transition">
            <div>
                <p class="text-xs font-black text-emerald-700 dark:text-emerald-300">{{ $t('طلبات معتمدة ومقبولة', 'Candidatures Approuvées', 'Approved Accredited') }}</p>
                <h3 class="text-2xl font-black text-emerald-900 dark:text-emerald-200 mt-1 font-mono">{{ number_format($approvedCount) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 flex items-center justify-center font-bold shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        {{-- Rejected --}}
        <div wire:click="$set('filterStatus', 'REJECTED')" class="cursor-pointer bg-red-50/50 dark:bg-red-950/20 p-5 rounded-2xl border border-red-200 dark:border-red-800/50 shadow-sm flex items-center justify-between hover:scale-[1.02] transition">
            <div>
                <p class="text-xs font-black text-red-700 dark:text-red-300">{{ $t('طلبات مرفوضة', 'Candidatures Refusées', 'Rejected') }}</p>
                <h3 class="text-2xl font-black text-red-900 dark:text-red-200 mt-1 font-mono">{{ number_format($rejectedCount) }}</h3>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-red-100 dark:bg-red-900/50 text-red-700 dark:text-red-300 flex items-center justify-center font-bold shadow-inner">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
    </div>

    {{-- FILTER TOOLBAR & ADVANCED SEARCH --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-5 shadow-sm space-y-4">
        
        {{-- QUICK ROLE FILTER TABS --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none">
            <button wire:click="$set('filterRole', '')" 
                    class="px-4 py-2 rounded-xl text-xs font-black transition whitespace-nowrap flex items-center gap-1.5 {{ empty($filterRole) ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span>{{ $t('جميع المسجلين والطلبات (الكل)', 'Tous les inscrits (Tous)', 'All Registrations (All)') }}</span>
            </button>

            <button wire:click="$set('filterRole', 'COUNTRY_ADMIN')" 
                    class="px-4 py-2 rounded-xl text-xs font-black transition whitespace-nowrap flex items-center gap-1.5 {{ $filterRole === 'COUNTRY_ADMIN' ? 'bg-blue-600 text-white shadow-md' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V8.5dM12 2a10 10 0 100 20 10 10 0 000-20z"/></svg>
                <span>{{ $t('الوفود والدبلوماسيون (Delegations)', 'Délégations & Diplomates', 'Delegations & Diplomats') }}</span>
            </button>

            <button wire:click="$set('filterRole', 'MEDIA_MANAGER')" 
                    class="px-4 py-2 rounded-xl text-xs font-black transition whitespace-nowrap flex items-center gap-1.5 {{ $filterRole === 'MEDIA_MANAGER' ? 'bg-amber-600 text-white shadow-md' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H14"/></svg>
                <span>{{ $t('الصحافة والإعلام (Media Press)', 'Presse & Médias', 'Media & Press') }}</span>
            </button>

            <button wire:click="$set('filterRole', 'EXPERT')" 
                    class="px-4 py-2 rounded-xl text-xs font-black transition whitespace-nowrap flex items-center gap-1.5 {{ $filterRole === 'EXPERT' ? 'bg-indigo-600 text-white shadow-md' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                <span>{{ $t('الخُبراء والمُحكّمون (Experts)', 'Experts & Juges', 'Experts & Judges') }}</span>
            </button>

            <button wire:click="$set('filterRole', 'SPEAKER')" 
                    class="px-4 py-2 rounded-xl text-xs font-black transition whitespace-nowrap flex items-center gap-1.5 {{ $filterRole === 'SPEAKER' ? 'bg-emerald-700 text-white shadow-md' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                <span>{{ $t('المحاضرون والمتحدثون (Speakers)', 'Conférenciers & Intervenants', 'Speakers & Lecturers') }}</span>
            </button>

            <button wire:click="$set('filterRole', 'VISITOR')" 
                    class="px-4 py-2 rounded-xl text-xs font-black transition whitespace-nowrap flex items-center gap-1.5 {{ ($filterRole === 'VISITOR' || $filterRole === 'PARTICIPANT') ? 'bg-sky-600 text-white shadow-md' : 'bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-200' }}">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                <span>{{ $t('الزوار والمشاركون العامّون (Visitors)', 'Visiteurs & Participants Généraux', 'Visitors & General Participants') }}</span>
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3">
            {{-- Search Input --}}
            <div class="lg:col-span-2 relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text"
                       placeholder="{{ $t('ابحث بالاسم، البريد، الرمز، رقم الهوية أو جواز السفر...', 'Rechercher par nom, email, NIN, passeport...', 'Search by name, email, code, NIN, passport...') }}"
                       class="w-full ps-10 pe-4 py-2.5 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 shadow-inner">
            </div>

            {{-- Filter Status --}}
            <div>
                <select wire:model.live="filterStatus"
                        class="w-full px-3 py-2.5 text-xs rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">{{ $t('جميع الحالات', 'Tous les statuts', 'All Statuses') }}</option>
                    <option value="PENDING">{{ $t('قيد الدراسة (PENDING)', 'En attente', 'Pending Review') }}</option>
                    <option value="APPROVED">{{ $t('مقبول ومعتمد (APPROVED)', 'Approuvé', 'Approved') }}</option>
                    <option value="REJECTED">{{ $t('مرفوض (REJECTED)', 'Refusé', 'Rejected') }}</option>
                </select>
            </div>

            {{-- Filter Country --}}
            <div>
                <select wire:model.live="filterCountry"
                        class="w-full px-3 py-2.5 text-xs rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">{{ $t('جميع الدول والأوفاد', 'Toutes les nations', 'All Countries') }}</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->id }}">{{ $c->name_ar }} ({{ $c->code }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Skill --}}
            <div>
                <select wire:model.live="filterSkill"
                        class="w-full px-3 py-2.5 text-xs rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-emerald-500">
                    <option value="">{{ $t('جميع التخصصات والخبرات', 'Tous les domaines', 'All Skills') }}</option>
                    @foreach($skills as $sk)
                        <option value="{{ $sk->id }}">{{ $sk->getLocalized('name') }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    {{-- FLOATING BULK SELECTION ACTION BAR --}}
    @if(count($selectedIds) > 0)
        <div class="sticky top-4 z-30 bg-slate-900 text-white p-4 rounded-2xl shadow-2xl flex flex-wrap items-center justify-between gap-4 border border-slate-700 animate-in fade-in slide-in-from-top-4">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-full bg-emerald-500 text-slate-950 font-black text-xs flex items-center justify-center">
                    {{ count($selectedIds) }}
                </span>
                <span class="text-xs font-black">{{ $t('عناصر محددة جاهزة للتنفيذ بالجملة', 'Éléments sélectionnés', 'Selected items for batch action') }}</span>
            </div>

            <div class="flex items-center gap-3">
                <button wire:click="approveSelected"
                        class="px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-black text-xs shadow-md transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ $t('اعتماد المحددين', 'Approuver la sélection', 'Approve Selected') }}</span>
                </button>

                <button wire:click="printSelected"
                        class="px-4 py-2 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-400 hover:to-amber-500 text-slate-950 font-black text-xs shadow-md transition flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>{{ $t('طباعة شارات المحددين (A4)', 'Imprimer badges sélectionnés', 'Print Selected Badges') }}</span>
                </button>
            </div>
        </div>
    @endif

    {{-- MAIN REGISTRATIONS CONTROL TABLE --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-xs text-start border-collapse">
                <thead>
                    <tr class="bg-slate-100/80 dark:bg-slate-700/80 text-[11px] font-black uppercase tracking-wider text-slate-600 dark:text-slate-300 border-b border-slate-200 dark:border-slate-700">
                        <th class="p-4 text-center w-10">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4 cursor-pointer">
                        </th>
                        <th class="p-4 text-start">{{ $t('رمز التسجيل', 'Code d\'Inscription', 'Registration Code') }}</th>
                        <th class="p-4 text-start">{{ $t('المشارك / الاسم والبريد', 'Participant / Nom & Email', 'Participant / Name & Email') }}</th>
                        <th class="p-4 text-start">{{ $t('التخصص / المجال', 'Domaine / Spécialité', 'Specialization / Field') }}</th>
                        <th class="p-4 text-start">{{ $t('الدولة / الوفد', 'Pays / Délégation', 'Country / Delegation') }}</th>
                        <th class="p-4 text-center">{{ $t('حالة الطلب', 'Statut de la Demande', 'Application Status') }}</th>
                        <th class="p-4 text-center min-w-[240px]">{{ $t('الإجراءات والعمليات', 'Actions & Opérations', 'Actions & Operations') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse($registrations as $reg)
                        @php
                            $sv = is_object($reg->status) ? ($reg->status->value ?? $reg->status->name) : ($reg->status ?? 'PENDING');
                            $svUpper = strtoupper($sv);
                            
                            $p = $reg->participant;
                            $u = $p?->user ?? $reg->user;
                            $nameAr = $p?->first_name_ar ? ($p->first_name_ar . ' ' . $p->last_name_ar) : ($u?->name ?? '—');
                            $nameLatin = $p?->first_name_fr ? ($p->first_name_fr . ' ' . $p->last_name_fr) : ($u?->email ?? '—');
                            $token = $reg->verification_token ?? $reg->uuid;
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/50 transition">
                            {{-- Checkbox --}}
                            <td class="p-4 text-center">
                                <input type="checkbox" wire:model.live="selectedIds" value="{{ $reg->id }}" class="rounded border-slate-300 text-emerald-600 focus:ring-emerald-500 w-4 h-4 cursor-pointer">
                            </td>

                            {{-- Registration Code --}}
                            <td class="p-4 font-mono font-black text-blue-600 dark:text-blue-400 whitespace-nowrap">
                                <div class="px-2.5 py-1 rounded-lg bg-blue-50 dark:bg-blue-900/30 border border-blue-200 dark:border-blue-800 inline-block text-center">
                                    {{ $reg->registration_number ?: ('WSAP-REG-'.$reg->id) }}
                                </div>
                            </td>

                            {{-- Participant Name & Info --}}
                            <td class="p-4">
                                <div class="flex items-center gap-3">
                                    @php
                                        $avatarUrl = $u?->avatar_url;
                                        if (!$avatarUrl && !empty($reg->photo_url)) {
                                            $cleanPath = preg_replace('/^.*?storage\//', '', $reg->photo_url);
                                            $avatarUrl = '/storage/' . ltrim($cleanPath, '/');
                                        }
                                    @endphp
                                    @if($avatarUrl)
                                        <img src="{{ $avatarUrl }}" alt="Avatar" class="w-9 h-9 rounded-full object-cover border border-slate-200 shadow-xs">
                                    @else
                                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-emerald-600 to-emerald-800 text-white font-black flex items-center justify-center text-xs shadow-xs">
                                            {{ mb_substr($nameAr, 0, 1) }}
                                        </div>
                                    @endif
                                    <div>
                                        <h4 class="font-black text-slate-900 dark:text-slate-100 text-xs leading-tight hover:text-emerald-600 cursor-pointer" wire:click="openDrawer({{ $reg->id }})">
                                            {{ $nameAr }}
                                        </h4>
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            @if($u?->hasRole('SPEAKER'))
                                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 text-[10px] font-black border border-emerald-300">
                                                    {{ $t('محاضر رئيسي', 'Conférencier Principal', 'Keynote Speaker') }}
                                                </span>
                                            @elseif($u?->hasRole('EXPERT'))
                                                <span class="px-2 py-0.5 rounded-full bg-indigo-100 dark:bg-indigo-950/80 text-indigo-800 dark:text-indigo-300 text-[10px] font-black border border-indigo-300">
                                                    {{ $t('خبير محكّم', 'Expert Juge', 'Expert Judge') }}
                                                </span>
                                            @elseif($u?->hasRole('MEDIA_MANAGER'))
                                                <span class="px-2 py-0.5 rounded-full bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 text-[10px] font-black border border-amber-300">
                                                    {{ $t('صحافة وإعلام', 'Presse & Médias', 'Media & Press') }}
                                                </span>
                                            @elseif(str_contains($reg->job_title ?? '', 'وزير') || str_contains($u?->position ?? '', 'وزير') || str_contains($reg->job_title ?? '', 'كاتب') || str_contains($reg->job_title ?? '', 'الأمين'))
                                                <span class="px-2 py-0.5 rounded-full bg-purple-100 dark:bg-purple-950/80 text-purple-800 dark:text-purple-300 text-[10px] font-black border border-purple-300">
                                                    {{ $t('عضو حكومي / وزير', 'Membre du Gouvernement / Ministre', 'Government Official / Minister') }}
                                                </span>
                                            @elseif(str_contains($reg->job_title ?? '', 'وفد') || str_contains($u?->position ?? '', 'وفد') || $u?->hasRole('COUNTRY_ADMIN'))
                                                <span class="px-2 py-0.5 rounded-full bg-blue-100 dark:bg-blue-950/80 text-blue-800 dark:text-blue-300 text-[10px] font-black border border-blue-300">
                                                    {{ $t('مسؤول وفد', 'Chef de Délégation', 'Delegation Head') }}
                                                </span>
                                            @else
                                                <span class="px-2 py-0.5 rounded-full bg-sky-100 dark:bg-sky-950/80 text-sky-800 dark:text-sky-300 text-[10px] font-black border border-sky-300">
                                                    {{ $t('مشارك عام / زائر', 'Participant Général / Visiteur', 'General Participant / Visitor') }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Domain / Skill --}}
                            <td class="p-4 font-bold text-slate-700 dark:text-slate-300">
                                @php
                                    $domainTitle = $reg->skill?->getLocalized('name');
                                    if (empty($domainTitle)) {
                                        $domainTitle = $reg->job_title;
                                    }
                                    if (empty($domainTitle) && !empty($u?->position)) {
                                        $domainTitle = $u->position;
                                    }
                                    if (empty($domainTitle) && !empty($reg->organization_name)) {
                                        $domainTitle = $reg->organization_name;
                                    }
                                    if (empty($domainTitle)) {
                                        if ($u?->hasRole('COUNTRY_ADMIN')) {
                                            $domainTitle = $t('مسؤول وفد وطني / دبلوماسي', 'Chef de Délégation / Diplomate', 'Delegation Head / Diplomat');
                                        } elseif ($u?->hasRole('MEDIA_MANAGER')) {
                                            $domainTitle = $t('صحافة وإعلام معتمد', 'Presse & Médias Accrédités', 'Accredited Media & Press');
                                        } elseif ($u?->hasRole('SPEAKER')) {
                                            $domainTitle = $t('محاضر رئيسي بالمنتدى', 'Conférencier Principal', 'Keynote Forum Speaker');
                                        } elseif ($u?->hasRole('EXPERT')) {
                                            $domainTitle = $t('خبير محكّم تقني', 'Expert Juge Technique', 'Technical Expert Judge');
                                        } else {
                                            $domainTitle = $t('زائر معتمد / مشارك عام', 'Visiteur Accrédité / Participant Général', 'Accredited Visitor / General Participant');
                                        }
                                    }
                                @endphp
                                <span class="font-black text-slate-900 dark:text-slate-100">{{ $domainTitle }}</span>
                            </td>

                            {{-- Country / Flag --}}
                            <td class="p-4 font-bold text-slate-800 dark:text-slate-200 whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <span>{{ $reg->country?->name_ar ?? '—' }}</span>
                                </div>
                            </td>

                            {{-- Status Badge (SVG ICON) --}}
                            <td class="p-4 text-center whitespace-nowrap">
                                @if($svUpper === 'APPROVED')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black border shadow-xs bg-emerald-100 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300 border-emerald-300">
                                        <svg class="w-3.5 h-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ $t('مقبول ومعتمد', 'Approuvé', 'Approved') }}</span>
                                    </span>
                                @elseif($svUpper === 'REJECTED')
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black border shadow-xs bg-red-100 text-red-800 dark:bg-red-950/80 dark:text-red-300 border-red-300">
                                        <svg class="w-3.5 h-3.5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ $t('مرفوض', 'Refusé', 'Rejected') }}</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black border shadow-xs bg-amber-100 text-amber-800 dark:bg-amber-950/80 dark:text-amber-300 border-amber-300">
                                        <svg class="w-3.5 h-3.5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        <span>{{ $t('قيد الدراسة', 'En attente', 'Pending Review') }}</span>
                                    </span>
                                @endif
                            </td>

                            {{-- PROMINENT ACTION BUTTONS (SVG ICONS ONLY) --}}
                            <td class="p-4 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Eye Detail Modal --}}
                                    <button wire:click="openDrawer({{ $reg->id }})"
                                            class="px-3 py-1.5 rounded-xl bg-indigo-50 hover:bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:hover:bg-indigo-900/70 dark:text-indigo-300 font-black text-[11px] border border-indigo-200 dark:border-indigo-800 transition flex items-center gap-1 shadow-xs"
                                            title="{{ $t('معاينة الملف والوثائق والشارة 3D', 'Aperçu du dossier & badge 3D', 'View details & 3D badge') }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>{{ $t('معاينة', 'Aperçu', 'View') }}</span>
                                    </button>

                                    {{-- Approve Button --}}
                                    @if($svUpper !== 'APPROVED')
                                        <button wire:click="approveRegistration({{ $reg->id }})"
                                                class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-[11px] transition shadow-xs flex items-center gap-1"
                                                title="{{ $t('قبول واعتماد الطلب', 'Approuver la demande', 'Approve Application') }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            <span>{{ $t('اعتماد', 'Approuver', 'Approve') }}</span>
                                        </button>
                                    @endif

                                    {{-- Reject Button --}}
                                    @if($svUpper !== 'REJECTED')
                                        <button wire:click="openRejectModal({{ $reg->id }})"
                                                class="px-3 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-black text-[11px] transition shadow-xs flex items-center gap-1"
                                                title="{{ $t('رفض الطلب مع إدخال السبب', 'Refuser avec motif', 'Reject with reason') }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                            <span>{{ $t('رفض', 'Refuser', 'Reject') }}</span>
                                        </button>
                                    @endif

                                    {{-- Delete Button --}}
                                    <button wire:click="confirmDelete({{ $reg->id }})"
                                            class="p-1.5 rounded-xl bg-rose-50 hover:bg-rose-100 text-rose-600 dark:bg-rose-900/30 dark:hover:bg-rose-900/60 dark:text-rose-400 font-bold transition border border-rose-200 dark:border-rose-800"
                                            title="{{ $t('حذف نهائي', 'Suppression définitive', 'Permanent Delete') }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-12 text-center text-slate-400 font-medium bg-slate-50/50 dark:bg-slate-800/50">
                                <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-400 flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </div>
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">
                                    {{ $t('لا توجد طلبات تسجيل مطابقة لفلاتر البحث الحالية', 'Aucune inscription ne correspond aux filtres actuels', 'No registration records match current search filters') }}
                                </p>
                                <button wire:click="resetFilters" class="mt-3 px-4 py-2 rounded-xl bg-emerald-600 text-white font-black text-xs hover:bg-emerald-700 transition inline-flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    <span>{{ $t('إعادة ضبط البحث والفلاتر', 'Réinitialiser la recherche', 'Reset Search & Filters') }}</span>
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="p-4 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800">
                {{ $registrations->links() }}
            </div>
        @endif
    </div>

    {{-- RICH PARTICIPANT DETAIL DRAWER --}}
    @if($drawerOpen && $selectedRegistration)
        @php
            $p = $selectedRegistration->participant;
            $u = $p?->user ?? $selectedRegistration->user;
            $token = $selectedRegistration->verification_token ?? $selectedRegistration->uuid;
        @endphp
        <div class="fixed inset-0 z-50 flex justify-end bg-slate-900/60 backdrop-blur-xs animate-in fade-in">
            <div class="w-full sm:max-w-lg bg-white dark:bg-slate-800 border-s border-slate-200 dark:border-slate-700 h-full p-5 sm:p-6 overflow-y-auto space-y-6 shadow-2xl">
                
                {{-- Drawer Header --}}
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 pb-4">
                    <div class="flex items-center gap-3">
                        @php
                            $drawerAvatarUrl = $u?->avatar_url;
                            if (!$drawerAvatarUrl && !empty($selectedRegistration->photo_url)) {
                                $cleanPath = preg_replace('/^.*?storage\//', '', $selectedRegistration->photo_url);
                                $drawerAvatarUrl = '/storage/' . ltrim($cleanPath, '/');
                            }
                        @endphp
                        @if($drawerAvatarUrl)
                            <img src="{{ $drawerAvatarUrl }}" alt="Avatar" class="w-12 h-12 rounded-2xl object-cover border-2 border-emerald-500 shadow-md">
                        @else
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-600 to-emerald-800 text-white font-black text-lg flex items-center justify-center shadow-md">
                                {{ mb_substr($selectedRegistration->user?->name ?? 'M', 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h2 class="text-lg font-black text-slate-900 dark:text-slate-100 leading-tight">
                                {{ $selectedRegistration->user?->name }}
                            </h2>
                            <p class="text-xs font-bold text-emerald-600 font-mono mt-0.5">
                                {{ $selectedRegistration->registration_number ?: ('WSAP-REG-'.$selectedRegistration->id) }}
                            </p>
                        </div>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 rounded-xl bg-slate-100 dark:bg-slate-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Action Links --}}
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('accreditation.badge', ['identifier' => $token]) }}" target="_blank"
                       class="px-4 py-2.5 rounded-xl bg-gradient-to-r from-[#35A536] to-emerald-800 text-white font-black text-xs text-center shadow-md hover:scale-[1.02] transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        <span>{{ $t('معاينة شارة 3D', 'Aperçu Badge 3D', 'Preview 3D Badge') }}</span>
                    </a>

                    @if($selectedRegistration->status !== 'APPROVED')
                        <button wire:click="approveRegistration({{ $selectedRegistration->id }})"
                                class="px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs text-center shadow-md transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>{{ $t('اعتماد وقبول', 'Approuver & Valider', 'Approve & Validate') }}</span>
                        </button>
                    @endif
                </div>

                {{-- Details Section --}}
                <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-2xl space-y-3 text-xs border border-slate-200 dark:border-slate-700">
                    <div class="flex justify-between border-b border-slate-200 dark:border-slate-600 pb-2">
                        <span class="text-slate-500 font-bold">{{ $t('الاسم بالعربية:', 'Nom en Arabe:', 'Name in Arabic:') }}</span>
                        <span class="font-black text-slate-800 dark:text-slate-200">{{ $p?->first_name_ar }} {{ $p?->last_name_ar }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-200 dark:border-slate-600 pb-2">
                        <span class="text-slate-500 font-bold">{{ $t('الاسم باللاتينية:', 'Nom en Latin:', 'Name in Latin:') }}</span>
                        <span class="font-black text-slate-800 dark:text-slate-200" dir="ltr">{{ $p?->first_name_fr }} {{ $p?->last_name_fr }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-200 dark:border-slate-600 pb-2">
                        <span class="text-slate-500 font-bold">{{ $t('البريد الإلكتروني:', 'Adresse Email:', 'Email Address:') }}</span>
                        <span class="font-mono font-bold text-blue-600" dir="ltr">{{ $u?->email }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-200 dark:border-slate-600 pb-2">
                        <span class="text-slate-500 font-bold">{{ $t('الهاتف:', 'Téléphone:', 'Phone Number:') }}</span>
                        <span class="font-mono font-bold text-slate-800 dark:text-slate-200" dir="ltr">{{ $p?->phone }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-200 dark:border-slate-600 pb-2">
                        <span class="text-slate-500 font-bold">{{ $t('صفة المشاركة:', 'Qualité / Rôle:', 'Participation Role:') }}</span>
                        <span class="font-black text-blue-600">
                            @if($u?->hasRole('SPEAKER'))
                                {{ $t('محاضر رئيسي (Speaker)', 'Conférencier Principal', 'Keynote Speaker') }}
                            @elseif($u?->hasRole('EXPERT'))
                                {{ $t('خبير محكّم (Expert)', 'Expert Juge', 'Expert Judge') }}
                            @else
                                {{ $t('مشارك عام / زائر (General Visitor)', 'Participant Général / Visiteur', 'General Participant / Visitor') }}
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between border-b border-slate-200 dark:border-slate-600 pb-2">
                        <span class="text-slate-500 font-bold">{{ $t('التخصص والمجال:', 'Spécialité / Domaine:', 'Specialization / Skill:') }}</span>
                        <span class="font-black text-slate-800 dark:text-slate-200">{{ $selectedRegistration->skill?->getLocalized('name') ?? $t('مشارك عام', 'Participant Général', 'General Participant') }}</span>
                    </div>
                    @if($p?->national_id)
                        <div class="flex justify-between border-b border-slate-200 dark:border-slate-600 pb-2">
                            <span class="text-slate-500 font-bold">{{ $t('بطاقة التعريف (NIN):', 'Carte d\'Identité (NIN):', 'National ID (NIN):') }}</span>
                            <span class="font-mono font-black text-slate-900 dark:text-slate-100">{{ $p->national_id }}</span>
                        </div>
                    @endif
                    @if($p?->passport_number)
                        <div class="flex justify-between border-b border-slate-200 dark:border-slate-600 pb-2">
                            <span class="text-slate-500 font-bold">{{ $t('رقم جواز السفر:', 'Numéro de Passeport:', 'Passport Number:') }}</span>
                            <span class="font-mono font-black text-amber-600">{{ $p->passport_number }}</span>
                        </div>
                    @endif
                </div>

                {{-- Attached Documents --}}
                @if($selectedRegistration->documents && $selectedRegistration->documents->count() > 0)
                    <div class="space-y-2">
                        <h4 class="text-xs font-black text-slate-900 dark:text-slate-100 uppercase tracking-wider">
                            {{ $t('الوثائق الثبوتية المرفقة', 'Documents Justificatifs Joints', 'Attached Verification Documents') }}
                        </h4>
                        @foreach($selectedRegistration->documents as $doc)
                            <a href="{{ Storage::url($doc->file_path) }}" target="_blank"
                               class="p-3 rounded-xl bg-slate-100 dark:bg-slate-700 hover:bg-slate-200 dark:hover:bg-slate-600 flex items-center justify-between transition border border-slate-200 dark:border-slate-600">
                                <div class="flex items-center gap-2">
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                    <div>
                                        <p class="text-xs font-bold text-slate-800 dark:text-slate-200">{{ $doc->original_name ?: $doc->document_type }}</p>
                                        <p class="text-[10px] text-slate-400 uppercase font-mono">{{ $doc->document_type }}</p>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-blue-600 inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    <span>{{ $t('تحميل', 'Télécharger', 'Download') }}</span>
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- REJECT REASON MODAL --}}
    @if($rejectModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-sm w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-2xl">
                <h3 class="text-base font-black text-slate-900 dark:text-slate-100">
                    {{ $t('إدخال سبب رفض طلب التسجيل', 'Motif du Refus de l\'Inscription', 'Enter Registration Rejection Reason') }}
                </h3>
                <textarea wire:model="rejectionReason" rows="3"
                    placeholder="{{ $t('اكتب سبب الرفض هنا ليتم إشعاره للمترشح...', 'Saisissez le motif du refus à notifier au candidat...', 'Type the rejection reason to notify the candidate...') }}"
                    class="w-full p-3 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 focus:ring-2 focus:ring-red-500"></textarea>
                <div class="flex justify-end gap-2">
                    <button wire:click="$set('rejectModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="rejectRegistration" class="px-5 py-2 text-xs font-black text-white bg-red-600 hover:bg-red-700 rounded-xl shadow-md">
                        {{ $t('تأكيد الرفض', 'Confirmer le Refus', 'Confirm Rejection') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- CONFIRM DELETE MODAL --}}
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 w-full max-w-md shadow-2xl border border-slate-200 dark:border-slate-700 text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-rose-100 dark:bg-rose-900/50 text-rose-600 dark:text-rose-400 flex items-center justify-center mx-auto text-xl font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h3 class="text-base font-black text-slate-900 dark:text-slate-100">
                    {{ $t('تأكيد حذف طلب التسجيل نهائياً', 'Confirmer la Suppression Définitive', 'Confirm Permanent Registration Deletion') }}
                </h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                    {{ $t('هل أنت تأكد من رغبتك في حذف طلب التسجيل هذا نهائياً؟ هذا الإجراء سيمحو بيانات التسجيل والوثائق نهائياً.', 'Êtes-vous sûr de vouloir supprimer définitivement cette inscription ? Cette action est irréversible.', 'Are you sure you want to permanently delete this registration? This action cannot be undone.') }}
                </p>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-50 transition">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="deleteRegistration" class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs shadow-md transition">
                        {{ $t('تأكيد الحذف النهائي', 'Confirmer Suppression', 'Confirm Permanent Deletion') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
