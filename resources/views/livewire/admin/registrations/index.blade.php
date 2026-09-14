@php
$locale = app()->getLocale();
 $t = fn($ar, $fr, $en, $pt = null) => polyTrans($ar, $fr, $en, $pt);
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
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V8.5M12 2a10 10 0 100 20 10 10 0 000-20z"/></svg>
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
                                        $avatarUrl = $reg->photo_url ?: $u?->avatar_url;
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
                                        @php
                                            $jobOrPos = ($reg->job_title ?? '') . ' ' . ($u?->position ?? '');
                                        @endphp
                                        <div class="flex items-center gap-1.5 mt-0.5">
                                            @if(str_contains($jobOrPos, 'VVIP') || str_contains($jobOrPos, 'سامية'))
                                                <span class="px-2.5 py-0.5 rounded-full bg-gradient-to-r from-amber-400 via-amber-500 to-amber-600 text-slate-950 font-black text-[10px] shadow-sm border border-amber-300 flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-slate-950" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                                                    <span>{{ $t('شخصية سامية جداً (VVIP)', 'Très Haute Personnalité (VVIP)', 'VVIP Guest') }}</span>
                                                </span>
                                            @elseif(str_contains($jobOrPos, 'VIP') || str_contains($jobOrPos, 'شرف'))
                                                <span class="px-2.5 py-0.5 rounded-full bg-pink-100 dark:bg-pink-950/80 text-pink-800 dark:text-pink-300 text-[10px] font-black border border-pink-300 flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                                    <span>{{ $t('ضيف شرف (VIP)', 'Invité d\'Honneur (VIP)', 'VIP Guest') }}</span>
                                                </span>
                                            @elseif(str_contains($jobOrPos, 'دبلوماسي') || str_contains($jobOrPos, 'Diplomate') || str_contains($jobOrPos, 'سفار'))
                                                <span class="px-2.5 py-0.5 rounded-full bg-purple-100 dark:bg-purple-950/80 text-purple-800 dark:text-purple-300 text-[10px] font-black border border-purple-300 flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h4m-4 0v-4a2 2 0 012-2h2a2 2 0 012 2v4"/></svg>
                                                    <span>{{ $t('دبلوماسي / مبعوث سفارة', 'Diplomate / Envoyé', 'Diplomat') }}</span>
                                                </span>
                                            @elseif(str_contains($jobOrPos, 'رئيس الوفد') || str_contains($jobOrPos, 'مسؤول الوفد') || str_contains($jobOrPos, 'Chef de Délégation'))
                                                <span class="px-2.5 py-0.5 rounded-full bg-blue-100 dark:bg-blue-950/80 text-blue-800 dark:text-blue-300 text-[10px] font-black border border-blue-300 flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
                                                    <span>{{ $t('رئيس الوفد الوطني', 'Chef de Délégation', 'Delegation Head') }}</span>
                                                </span>
                                            @elseif(str_contains($jobOrPos, 'مؤطر') || str_contains($jobOrPos, 'Coordinateur'))
                                                <span class="px-2.5 py-0.5 rounded-full bg-teal-100 dark:bg-teal-950/80 text-teal-800 dark:text-teal-300 text-[10px] font-black border border-teal-300 flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                                    <span>{{ $t('مؤطر ومرافق تنفيذي', 'Coordinateur de Délégation', 'Delegation Coordinator') }}</span>
                                                </span>
                                            @elseif(str_contains($jobOrPos, 'عضو') || str_contains($jobOrPos, 'Membre'))
                                                <span class="px-2.5 py-0.5 rounded-full bg-sky-100 dark:bg-sky-950/80 text-sky-800 dark:text-sky-300 text-[10px] font-black border border-sky-300 flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                                    <span>{{ $t('عضو رسمي في الوفد', 'Membre Officiel de Délégation', 'Official Delegation Member') }}</span>
                                                </span>
                                            @elseif($u?->hasRole('SPEAKER') || str_contains($jobOrPos, 'SPEAKER') || str_contains($jobOrPos, 'محاضر'))
                                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 text-[10px] font-black border border-emerald-300 flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                                                    <span>{{ $t('محاضر رئيسي', 'Conférencier Principal', 'Keynote Speaker') }}</span>
                                                </span>
                                            @elseif($u?->hasRole('EXPERT') || str_contains($jobOrPos, 'EXPERT') || str_contains($jobOrPos, 'خبير'))
                                                <span class="px-2.5 py-0.5 rounded-full bg-indigo-100 dark:bg-indigo-950/80 text-indigo-800 dark:text-indigo-300 text-[10px] font-black border border-indigo-300 flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                                    <span>{{ $t('خبير محكّم', 'Expert Juge', 'Expert Judge') }}</span>
                                                </span>
                                            @elseif($u?->hasRole('MEDIA_MANAGER') || str_contains($jobOrPos, 'MEDIA') || str_contains($jobOrPos, 'صحف') || str_contains($jobOrPos, 'إعلام'))
                                                <span class="px-2.5 py-0.5 rounded-full bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 text-[10px] font-black border border-amber-300 flex items-center gap-1">
                                                    <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H14"/></svg>
                                                    <span>{{ $t('صحافة وإعلام', 'Presse & Médias', 'Media & Press') }}</span>
                                                </span>
                                            @else
                                                <span class="px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 text-[10px] font-black border border-slate-300 flex items-center gap-1">
                                                    <span>{{ $t('مشارك عام / زائر', 'Participant Général / Visiteur', 'General Participant / Visitor') }}</span>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            {{-- Domain / Skill --}}
                            <td class="p-4 font-bold text-slate-700 dark:text-slate-300">
                                @php
                                    $domainTitle = null;
                                    if (($u?->hasRole('EXPERT') || !empty($reg->skill_id)) && $reg->skill) {
                                        $domainTitle = $reg->skill->getLocalized('name');
                                    }
                                    if (empty($domainTitle)) {
                                        $domainTitle = $reg->organization_name ?: $reg->job_title ?: $u?->position;
                                    }
                                    if (empty($domainTitle)) {
                                        $domainTitle = $t('الوفد والمنصة الوطنية', 'Délégation & Plateforme', 'Delegation & Platform');
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

                                    {{-- Edit Button --}}
                                    <button wire:click="openEditModal({{ $reg->id }})"
                                            class="px-3 py-1.5 rounded-xl bg-amber-50 hover:bg-amber-100 text-amber-800 dark:bg-amber-950/50 dark:hover:bg-amber-900/80 dark:text-amber-300 font-black text-[11px] border border-amber-300 dark:border-amber-800 transition flex items-center gap-1 shadow-xs"
                                            title="{{ $t('تعديل البيانات والصور والملفات', 'Modifier les données & fichiers', 'Edit details, photos & files') }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        <span>{{ $t('تعديل', 'Modifier', 'Edit') }}</span>
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
                            $drawerAvatarUrl = $selectedRegistration->photo_url ?: $u?->avatar_url;
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
                    <button wire:click="openEditModal({{ $selectedRegistration->id }})"
                            class="px-4 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-black text-xs text-center shadow-md transition flex items-center justify-center gap-2 col-span-2">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>{{ $t('تعديل البيانات والصور والملفات ✏️', 'Modifier Données & Fichiers ✏️', 'Edit Details, Photos & Files ✏️') }}</span>
                    </button>
                </div>

                {{-- Details Section --}}
                <div class="bg-slate-50 dark:bg-slate-700/50 p-4 rounded-2xl space-y-3 text-xs border border-slate-200 dark:border-slate-700">
                    <div class="flex justify-between border-b border-slate-200 dark:border-slate-600 pb-2">
                        <span class="text-slate-500 font-bold">{{ $t('الاسم بالعربية:', 'Nom en Arabe:', 'Name in Arabic:') }}</span>
                        <span class="font-black text-slate-800 dark:text-slate-200">{{ ($p?->first_name_ar || $p?->last_name_ar) ? ($p->first_name_ar . ' ' . $p->last_name_ar) : ($u?->name ?? '—') }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-200 dark:border-slate-600 pb-2">
                        <span class="text-slate-500 font-bold">{{ $t('الاسم باللاتينية:', 'Nom en Latin:', 'Name in Latin:') }}</span>
                        <span class="font-black text-slate-800 dark:text-slate-200" dir="ltr">{{ ($p?->first_name_fr || $p?->last_name_fr) ? ($p->first_name_fr . ' ' . $p->last_name_fr) : ($u?->name ?? '—') }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-200 dark:border-slate-600 pb-2">
                        <span class="text-slate-500 font-bold">{{ $t('البريد الإلكتروني:', 'Adresse Email:', 'Email Address:') }}</span>
                        <span class="font-mono font-bold text-blue-600" dir="ltr">{{ $u?->email }}</span>
                    </div>
                    <div class="flex justify-between border-b border-slate-200 dark:border-slate-600 pb-2">
                        <span class="text-slate-500 font-bold">{{ $t('الهاتف:', 'Téléphone:', 'Phone Number:') }}</span>
                        <span class="font-mono font-bold text-slate-800 dark:text-slate-200" dir="ltr">{{ $p?->phone }}</span>
                    </div>
                    @php
                        $dJobPos = ($selectedRegistration->job_title ?? '') . ' ' . ($u?->position ?? '');
                        $dCapTitle = $selectedRegistration->job_title ?: $u?->position;
                        if (str_contains($dJobPos, 'VVIP') || str_contains($dJobPos, 'سامية')) {
                            $dCapTitle = $t('شخصية سامية جداً (VVIP)', 'Très Haute Personnalité (VVIP)', 'VVIP Guest');
                        } elseif (str_contains($dJobPos, 'VIP') || str_contains($dJobPos, 'شرف')) {
                            $dCapTitle = $t('ضيف شرف (VIP)', 'Invité d\'Honneur (VIP)', 'VIP Guest');
                        } elseif (str_contains($dJobPos, 'دبلوماسي') || str_contains($dJobPos, 'Diplomate')) {
                            $dCapTitle = $t('دبلوماسي / مبعوث سفارة', 'Diplomate / Envoyé', 'Diplomat');
                        } elseif (str_contains($dJobPos, 'رئيس') || str_contains($dJobPos, 'مسؤول الوفد') || str_contains($dJobPos, 'Chef')) {
                            $dCapTitle = $t('رئيس الوفد الوطني', 'Chef de Délégation', 'Delegation Head');
                        } elseif (str_contains($dJobPos, 'مؤطر') || str_contains($dJobPos, 'Coordinateur')) {
                            $dCapTitle = $t('مؤطر ومرافق تنفيذي', 'Coordinateur de Délégation', 'Delegation Coordinator');
                        } elseif (str_contains($dJobPos, 'عضو') || str_contains($dJobPos, 'Membre')) {
                            $dCapTitle = $t('عضو رسمي في الوفد', 'Membre Officiel de Délégation', 'Official Delegation Member');
                        } elseif ($u?->hasRole('SPEAKER') || str_contains($dJobPos, 'محاضر')) {
                            $dCapTitle = $t('محاضر رئيسي (Speaker)', 'Conférencier Principal', 'Keynote Speaker');
                        } elseif ($u?->hasRole('EXPERT') || str_contains($dJobPos, 'خبير')) {
                            $dCapTitle = $t('خبير محكّم تقني (Expert)', 'Expert Juge Technique', 'Technical Expert Judge');
                        } elseif ($u?->hasRole('MEDIA_MANAGER') || str_contains($dJobPos, 'صحافة') || str_contains($dJobPos, 'إعلام')) {
                            $dCapTitle = $t('صحافة وإعلام معتمد (Media Press)', 'Presse & Médias Accrédités', 'Accredited Media & Press');
                        } else {
                            $dCapTitle = $dCapTitle ?: $t('زائر معتمد / مشارك عام', 'Visiteur Accrédité / Participant Général', 'Accredited Visitor / General Participant');
                        }

                        $dDomain = null;
                        if ($u?->hasRole('EXPERT') && $selectedRegistration->skill) {
                            $dDomain = $selectedRegistration->skill->getLocalized('name');
                        }
                        if (empty($dDomain)) {
                            $dDomain = $selectedRegistration->organization_name ?: $selectedRegistration->job_title ?: $u?->position;
                        }
                        if (empty($dDomain)) {
                            $dDomain = $t('الوفد والمنصة الوطنية', 'Délégation & Plateforme', 'Delegation & Platform');
                        }
                    @endphp
                    <div class="flex justify-between border-b border-slate-200 dark:border-slate-600 pb-2">
                        <span class="text-slate-500 font-bold">{{ $t('صفة المشاركة:', 'Qualité / Rôle:', 'Participation Role:') }}</span>
                        <span class="font-black text-amber-600 dark:text-amber-400">
                            {{ $dCapTitle }}
                        </span>
                    </div>
                    <div class="flex justify-between border-b border-slate-200 dark:border-slate-600 pb-2">
                        <span class="text-slate-500 font-bold">{{ $t('التخصص والمجال:', 'Spécialité / Domaine:', 'Specialization / Skill:') }}</span>
                        <span class="font-black text-slate-800 dark:text-slate-200">{{ $dDomain }}</span>
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

                {{-- Official Photos & Identity Documents Preview --}}
                <div class="space-y-3 pt-2 border-t border-slate-200 dark:border-slate-700">
                    <h4 class="text-xs font-black text-slate-900 dark:text-slate-100 uppercase tracking-wider flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>{{ $t('الصور والوثائق الثبوتية المعاينة:', 'Photos & Documents Joints:', 'Photos & Verification Documents:') }}</span>
                    </h4>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        {{-- 1. Official Personal Photo Preview --}}
                        @php
                            $personalPhoto = $selectedRegistration->photo_url ?: $u?->avatar_url;
                        @endphp
                        <div class="p-3 bg-slate-50 dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 flex flex-col items-center text-center space-y-2">
                            <span class="text-[11px] font-black text-slate-700 dark:text-slate-300">
                                📷 {{ $t('الصورة الشخصية للاعتماد', 'Photo d\'Accréditation', 'Official Passport Photo') }}
                            </span>
                            @if($personalPhoto)
                                <a href="{{ $personalPhoto }}" target="_blank" class="relative group block overflow-hidden rounded-xl border border-slate-300 shadow-sm">
                                    <img src="{{ $personalPhoto }}" alt="Personal Photo" class="w-28 h-32 object-cover transition duration-300 group-hover:scale-105">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-[10px] font-bold transition">
                                        🔍 {{ $t('تكبير', 'Agrandir', 'Zoom') }}
                                    </div>
                                </a>
                            @else
                                <div class="w-28 h-32 rounded-xl bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-400 text-xs">
                                    {{ $t('غير متوفرة', 'Non disponible', 'Not available') }}
                                </div>
                            @endif
                        </div>

                        {{-- 2. National ID or Passport Document Preview --}}
                        @php
                            $docPath = $selectedRegistration->national_id_pdf_path 
                                    ?? $selectedRegistration->passport_pdf_path 
                                    ?? $selectedRegistration->documents?->first()?->file_path 
                                    ?? null;
                            $docUrl = $docPath ? \App\Models\Registration::resolveFileUrl($docPath) : null;
                            $isPdf = $docPath && (str_ends_with(strtolower($docPath), '.pdf') || str_contains(strtolower($docPath), 'pdf'));
                        @endphp
                        <div class="p-3 bg-slate-50 dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 flex flex-col items-center text-center space-y-2">
                            <span class="text-[11px] font-black text-slate-700 dark:text-slate-300">
                                🪪 {{ $t('صورة الهوية / جواز السفر', 'Pièce d\'Identité / Passeport', 'ID Card / Passport') }}
                            </span>
                            @if($docUrl)
                                @if($isPdf)
                                    <a href="{{ $docUrl }}" target="_blank" class="w-28 h-32 rounded-xl bg-red-50 dark:bg-red-950/40 border border-red-200 flex flex-col items-center justify-center text-red-600 space-y-1 hover:bg-red-100 transition p-2">
                                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        <span class="text-[10px] font-black">PDF Document</span>
                                        <span class="text-[9px] underline">فتح الملف ↗</span>
                                    </a>
                                @else
                                    <a href="{{ $docUrl }}" target="_blank" class="relative group block overflow-hidden rounded-xl border border-slate-300 shadow-sm">
                                        <img src="{{ $docUrl }}" alt="ID Card / Passport" class="w-28 h-32 object-cover transition duration-300 group-hover:scale-105">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white text-[10px] font-bold transition">
                                            🔍 {{ $t('تكبير', 'Agrandir', 'Zoom') }}
                                        </div>
                                    </a>
                                @endif
                            @else
                                <div class="w-28 h-32 rounded-xl bg-slate-200 dark:bg-slate-700 flex items-center justify-center text-slate-400 text-xs font-bold">
                                    {{ $t('غير متوفرة', 'Non disponible', 'Not available') }}
                                </div>
                            @endif
                        </div>
                    </div>
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

    {{-- EDIT REGISTRATION & FILES MODAL --}}
    @if($editModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs overflow-y-auto">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-xl w-full space-y-5 border border-slate-200 dark:border-slate-700 shadow-2xl my-8">
                
                {{-- Modal Header --}}
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 pb-3">
                    <div class="flex items-center gap-2 text-slate-900 dark:text-slate-100 font-black text-base">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        <span>{{ $t('تعديل بيانات المسجل والصور والملفات', 'Modifier Inscription & Fichiers', 'Edit Registrant Details & Files') }}</span>
                    </div>
                    <button wire:click="$set('editModalOpen', false)" class="p-2 text-slate-400 hover:text-slate-600 rounded-xl bg-slate-100 dark:bg-slate-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Modal Form Fields --}}
                <div class="space-y-4 text-xs font-bold max-h-[70vh] overflow-y-auto px-1">
                    
                    {{-- 1. Official Capacity Title --}}
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1 font-black">
                            {{ $t('الصفة الرسمية للمشارك / المسجل *', 'Qualité / Rôle Officiel *', 'Official Capacity / Role *') }}
                        </label>
                        <select wire:model.live="editCapacityTitle" class="w-full p-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold">
                            <option value="شخصية سامية جداً (VVIP)">شخصية سامية جداً (VVIP) / Très Haute Personnalité</option>
                            <option value="ضيف شرف (VIP)">ضيف شرف (VIP) / Invité d'Honneur</option>
                            <option value="دبلوماسي / مبعوث سفارة">دبلوماسي / مبعوث سفارة (Diplomat)</option>
                            <option value="رئيس الوفد الوطني">رئيس الوفد الوطني (Chef de Délégation)</option>
                            <option value="عضو رسمي في الوفد">عضو رسمي في الوفد (Membre Officiel)</option>
                            <option value="مؤطر ومرافق تنفيذي">مؤطر ومرافق تنفيذي (Coordinateur)</option>
                            <option value="محاضر رئيسي بالمنتدى">محاضر رئيسي بالمنتدى (Keynote Speaker)</option>
                            <option value="خبير محكّم تقني">خبير محكّم تقني (Expert Judge)</option>
                            <option value="صحافة وإعلام معتمد">صحافة وإعلام معتمد (Media Press)</option>
                            <option value="زائر معتمد / مشارك عام">زائر معتمد / مشارك عام (Visitor / Participant)</option>
                        </select>
                    </div>

                    {{-- 2. Organization Name --}}
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 mb-1 font-black">
                            {{ $t('المؤسسة / الهيئة / الوزارة / السفارة', 'Organisme / Ministère / Ambassade', 'Organization / Ministry / Embassy') }}
                        </label>
                        <input type="text" wire:model.live="editOrganizationName" placeholder="مثال: رئاسة الجمهورية / وزارة التكوين المهني"
                               class="w-full p-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold">
                    </div>

                    {{-- 3. Name Fields (Arabic & Latin) --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1 font-black">{{ $t('الاسم بالعربية', 'Prénom (Arabe)', 'First Name (Arabic)') }}</label>
                            <input type="text" wire:model.live="editFirstNameAr" class="w-full p-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold">
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1 font-black">{{ $t('اللقب بالعربية', 'Nom (Arabe)', 'Last Name (Arabic)') }}</label>
                            <input type="text" wire:model.live="editLastNameAr" class="w-full p-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1 font-black">{{ $t('الاسم باللاتينية', 'Prénom (Latin)', 'First Name (Latin)') }}</label>
                            <input type="text" wire:model.live="editFirstNameFr" dir="ltr" class="w-full p-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold">
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1 font-black">{{ $t('اللقب باللاتينية', 'Nom (Latin)', 'Last Name (Latin)') }}</label>
                            <input type="text" wire:model.live="editLastNameFr" dir="ltr" class="w-full p-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold">
                        </div>
                    </div>

                    {{-- 4. Email & Phone --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1 font-black">{{ $t('البريد الإلكتروني', 'Email', 'Email') }}</label>
                            <input type="email" wire:model.live="editEmail" dir="ltr" class="w-full p-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold">
                        </div>
                        <div>
                            <label class="block text-slate-700 dark:text-slate-300 mb-1 font-black">{{ $t('رقم الهاتف', 'Téléphone', 'Phone') }}</label>
                            <input type="text" wire:model.live="editPhone" dir="ltr" class="w-full p-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-slate-100 font-bold">
                        </div>
                    </div>

                    {{-- 5. Upload New Personal Photo --}}
                    <div class="p-4 bg-emerald-50/70 dark:bg-emerald-950/40 rounded-2xl border border-emerald-200 dark:border-emerald-800 space-y-2">
                        <label class="block text-emerald-900 dark:text-emerald-200 font-black">
                            📷 {{ $t('رفع صورة شخصية جديدة للاعتماد (تغيير الصورة الحاليّة):', 'Télécharger nouvelle photo :', 'Upload New Photo (Replace Current):') }}
                        </label>
                        <input type="file" wire:model="newPhotoFile" accept="image/*"
                               class="w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-emerald-600 file:text-white hover:file:bg-emerald-700">
                        @if($newPhotoFile)
                            <p class="text-[11px] text-emerald-700 font-bold">✓ تم اختيار صورة جديدة جاهزة للحفظ</p>
                        @endif
                    </div>

                    {{-- 6. Upload New ID Card / Passport File --}}
                    <div class="p-4 bg-amber-50/70 dark:bg-amber-950/40 rounded-2xl border border-amber-200 dark:border-amber-800 space-y-2">
                        <label class="block text-amber-900 dark:text-amber-200 font-black">
                            🪪 {{ $t('رفع ملف الهوية / جواز السفر الجديد (تغيير الملف الحالي):', 'Télécharger nouvelle pièce d\'identité :', 'Upload New ID/Passport File (Replace Current):') }}
                        </label>
                        <input type="file" wire:model="newDocumentFile" accept="image/*,.pdf"
                               class="w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-amber-600 file:text-white hover:file:bg-amber-700">
                        @if($newDocumentFile)
                            <p class="text-[11px] text-amber-700 font-bold">✓ تم اختيار ملف هويّة جديد جاهز للحفظ</p>
                        @endif
                    </div>

                </div>

                {{-- Modal Footer --}}
                <div class="flex items-center justify-end gap-3 border-t border-slate-200 dark:border-slate-700 pt-3">
                    <button wire:click="$set('editModalOpen', false)" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-50">
                        {{ $t('إلغاء', 'Annuler', 'Cancel') }}
                    </button>
                    <button wire:click="saveRegistrationEdit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md transition flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ $t('حفظ التعديلات والتحديث', 'Enregistrer les Modifications', 'Save & Apply Changes') }}</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
