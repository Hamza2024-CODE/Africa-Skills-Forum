@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };

/** Quick-action vector SVG paths */
$svgPaths = [
    'home'          => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>',
    'users'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/>',
    'globe'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418"/>',
    'trophy'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0"/>',
    'clipboard'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z"/>',
    'shield'        => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/>',
    'paint'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245c0-.399-.078-.78-.22-1.128zm0 0a15.998 15.998 0 003.388-1.62m-5.043-.025a15.994 15.994 0 011.622-3.395m3.42 3.42a15.995 15.995 0 004.764-4.648l3.876-5.814a1.151 1.151 0 00-1.597-1.597L14.146 6.32a15.996 15.996 0 00-4.649 4.763m3.42 3.42a6.776 6.776 0 00-3.42-3.42"/>',
    'newspaper'     => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/>',
    'calendar'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>',
    'arrow-right'   => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>',
    'building'      => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/>',
    'badge'         => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>',
];
@endphp

<div class="space-y-6 pb-12">

    {{-- ══════════════════════════════════════
         SECTION 1 — EXECUTIVE HERO BANNER
    ══════════════════════════════════════ --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#04122E] via-[#0B2A6F] to-[#06205C] p-6 sm:p-8 text-white shadow-2xl border border-blue-900/50">
        
        {{-- Ambient Gold Glow Overlay --}}
        <div class="absolute -top-24 -end-24 w-96 h-96 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -start-24 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">

            {{-- Brand Badge + Titles --}}
            <div class="space-y-4 max-w-3xl">
                
                {{-- Dual Brand Logo Pill Container --}}
                <div class="inline-flex items-center gap-3 bg-white/95 backdrop-blur-md p-1.5 px-4 rounded-2xl shadow-md border border-white/50 shrink-0">
                    <img src="{{ asset('ministry-logo-trimmed.png') }}" alt="وزارة التكوين والتعليم المهنيين" class="h-6 sm:h-7 w-auto object-contain shrink-0">
                    <div class="h-5 w-px bg-slate-300 shrink-0"></div>
                    <img src="{{ asset('africa-logo-trimmed.png') }}" alt="African Union - Africa Skills Forum" class="h-6 sm:h-7 w-auto object-contain shrink-0">
                </div>

                {{-- Status Pills --}}
                <div class="flex items-center gap-2 flex-wrap pt-1">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/40 text-emerald-300 text-[11px] font-black uppercase tracking-wider backdrop-blur-sm">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
                        <span>{{ $t('المنصة تعمل بنجاح', 'OPÉRATIONNEL', 'OPERATIONAL') }}</span>
                        <span>— {{ $systemHealth['score'] ?? '99.9%' }}</span>
                    </span>

                    <a href="{{ route('admin.cms.homepage') }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black border transition backdrop-blur-sm {{ $countdownEnabled ? 'bg-blue-500/20 text-blue-200 border-blue-400/40 hover:bg-blue-500/30' : 'bg-slate-700/50 text-slate-300 border-slate-600' }}">
                        <svg class="w-3.5 h-3.5 text-blue-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $t('العداد التنازلي:', 'Décompte:', 'Countdown:') }}</span>
                        <span class="font-mono">{{ $countdownEnabled ? $t('نشط بالموقع', 'ACTIF', 'ACTIVE') : $t('مخفي', 'MASQUÉ', 'HIDDEN') }}</span>
                    </a>

                    <a href="{{ route('admin.cms.homepage') }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-black border transition backdrop-blur-sm {{ $showPartnersSection ? 'bg-emerald-500/20 text-emerald-200 border-emerald-400/40 hover:bg-emerald-500/30' : 'bg-rose-500/20 text-rose-200 border-rose-400/40' }}">
                        <svg class="w-3.5 h-3.5 text-emerald-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        <span>{{ $t('قسم الشركاء:', 'Partenaires:', 'Partners:') }}</span>
                        <span>{{ $showPartnersSection ? $t('ظاهر بالمنصة', 'VISIBLE', 'VISIBLE') : $t('مخفي', 'MASQUÉ', 'HIDDEN') }}</span>
                    </a>
                </div>

                {{-- Main Title --}}
                <div class="space-y-1">
                    <h1 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white tracking-tight leading-tight">
                        {{ $t('مركز القيادة العليا والتحكم — منتدى المهارات الإفريقية', 'Centre de Commandement — Africa Skills Forum', 'Executive Command Center — Africa Skills Forum') }}
                        <span class="text-amber-400 block sm:inline text-xl sm:text-2xl font-black"> (CCO Oran 2026)</span>
                    </h1>

                    <p class="text-xs sm:text-sm font-medium text-blue-100/90 leading-relaxed pt-1">
                        {{ $t(
                            'الجمهورية الجزائرية الديمقراطية الشعبية — وزارة التكوين والتعليم المهنيين. الإدارة الشاملة للوفود الإفريقية، المحاضرين، الضيوف، والاعتماد الرقمي الرسمي.',
                            'République Algérienne Démocratique et Populaire — Ministère de la Formation et de l\'Enseignement Professionnels. Gestion globale des délégations et accréditations.',
                            'People\'s Democratic Republic of Algeria — Ministry of Vocational Education and Training. Full management of delegates, speakers, and digital accreditations.'
                        ) }}
                    </p>
                </div>

            </div>

            {{-- Current Edition Card --}}
            <div class="shrink-0 bg-white/10 backdrop-blur-md text-white rounded-3xl p-5 border border-white/20 min-w-[240px] space-y-3 shadow-xl">
                <div class="flex items-center justify-between">
                    <span class="text-[10px] font-black text-amber-400 uppercase tracking-widest block">
                        {{ $t('الدورة الرسمية الحالية', 'ÉDITION OFFICIELLE', 'CURRENT SUMMIT EDITION') }}
                    </span>
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                </div>
                <div class="space-y-0.5">
                    <h3 class="text-base font-black text-white leading-snug">
                        {{ $activeEdition?->getLocalized('name') ?? 'Africa Skills Forum 2026' }}
                    </h3>
                    <p class="text-[11px] font-bold text-blue-200">
                        📍 {{ $t('مركز المؤتمرات محمد بن أحمد - وهران', 'CCO Ben Ahmed — Oran', 'Mohamed Ben Ahmed Center — Oran') }}
                    </p>
                </div>
                <div class="flex items-center justify-between text-[11px] font-bold text-slate-200 pt-2 border-t border-white/15">
                    <span>{{ $t('مؤسسات:', 'Établissements:', 'Orgs:') }} <strong class="text-amber-300 font-black">{{ number_format($totalOrganizations) }}</strong></span>
                    <span>{{ $t('تخصصات:', 'Métiers:', 'Skills:') }} <strong class="text-emerald-300 font-black">{{ number_format($totalSkills) }}</strong></span>
                </div>
            </div>

        </div>
    </div>


    {{-- ══════════════════════════════════════
         SECTION 2 — STRATEGIC KPI GRID (6 Cards)
    ══════════════════════════════════════ --}}
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span>{{ $t('المؤشرات الاستراتيجية الرئيسية للمنصة', 'Indicateurs Stratégiques Clés', 'Key Strategic Summit Metrics') }}</span>
            </h2>
            <span class="text-[11px] font-bold text-slate-400">{{ $t('محدّث لحظياً بقاعدة البيانات', 'Mise à jour en temps réel', 'Live DB Sync') }}</span>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">

            {{-- 1. African Countries --}}
            <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/90 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-lg transition-all group relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-sky-400 flex items-center justify-center font-black group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $svgPaths['globe'] !!}</svg>
                    </div>
                    <span class="text-[10px] font-black text-blue-700 bg-blue-50 dark:bg-blue-950 dark:text-blue-300 px-2.5 py-1 rounded-full">
                        {{ $t('إفريقيا', 'Afrique', 'Africa') }}
                    </span>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($totalCountries) }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 truncate">{{ $t('الدول والوفود المشاركة', 'Délégations', 'Participating Nations') }}</p>
                    <div class="mt-2.5 h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                        <div class="h-full bg-blue-600 rounded-full" style="width:{{ min(100, ($totalCountries / 54) * 100) }}%"></div>
                    </div>
                    <p class="text-[10px] font-bold text-slate-400 pt-0.5">{{ round(($totalCountries / 54) * 100) }}% {{ $t('تغطية الاتحاد الإفريقي', 'de l\'Union Africaine', 'African Union Coverage') }}</p>
                </div>
            </div>

            {{-- 2. Vocational Organizations --}}
            <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/90 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-lg transition-all group relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400 flex items-center justify-center font-black group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $svgPaths['building'] !!}</svg>
                    </div>
                    <span class="text-[10px] font-black text-emerald-700 bg-emerald-50 dark:bg-emerald-950 dark:text-emerald-300 px-2.5 py-1 rounded-full">
                        {{ $t('58 ولاية', '58 Wilayas', '58 Wilayas') }}
                    </span>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($totalOrganizations) }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 truncate">{{ $t('المؤسسات التكوينية', 'Établissements', 'Vocational Centers') }}</p>
                    <p class="text-[10px] font-bold text-emerald-600 dark:text-emerald-400 pt-2 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        <span>{{ $t('معتمدة رسمياً بالشبكة', 'Réseau National', 'National Network') }}</span>
                    </p>
                </div>
            </div>

            {{-- 3. Official Registrations --}}
            <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/90 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-lg transition-all group relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-purple-50 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400 flex items-center justify-center font-black group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $svgPaths['clipboard'] !!}</svg>
                    </div>
                    <span class="text-[10px] font-black text-purple-700 bg-purple-50 dark:bg-purple-950 dark:text-purple-300 px-2.5 py-1 rounded-full">
                        {{ $t('المسجلون', 'Inscriptions', 'Registrations') }}
                    </span>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($totalRegistrations) }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 truncate">{{ $t('طلبات الاعتماد المعتمدة', 'Inscriptions Soumises', 'Submitted Applications') }}</p>
                    <div class="flex items-center justify-between text-[10px] font-bold text-slate-500 pt-1">
                        <span class="text-emerald-600 font-black">✓ {{ $approvedRegistrations }} {{ $t('مقبول', 'Acceptés', 'Approved') }}</span>
                        <span class="text-amber-600 font-black">⏳ {{ $pendingRegistrations }} {{ $t('قيد الدراسة', 'En attente', 'Pending') }}</span>
                    </div>
                </div>
            </div>

            {{-- 4. Ministers & VIP Officials --}}
            <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/90 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-lg transition-all group relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-amber-50 dark:bg-amber-900/40 text-amber-600 dark:text-amber-400 flex items-center justify-center font-black group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $svgPaths['users'] !!}</svg>
                    </div>
                    <span class="text-[10px] font-black text-amber-700 bg-amber-50 dark:bg-amber-950 dark:text-amber-300 px-2.5 py-1 rounded-full">
                        {{ $t('دبلوماسي', 'Diplomates', 'Diplomatic') }}
                    </span>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($totalMinisters) }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 truncate">{{ $t('الوزراء والقيادات الرسمية', 'Ministres & VIP', 'Ministers & Officials') }}</p>
                    <p class="text-[10px] font-bold text-amber-600 dark:text-amber-400 pt-2 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                        <span>{{ $availableMinisters }} {{ $t('متاحون للقاءات الثنائية', 'Disponibles Salons', 'Available for Talks') }}</span>
                    </p>
                </div>
            </div>

            {{-- 5. Skill Disciplines --}}
            <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/90 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-lg transition-all group relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-rose-50 dark:bg-rose-900/40 text-rose-600 dark:text-rose-400 flex items-center justify-center font-black group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $svgPaths['trophy'] !!}</svg>
                    </div>
                    <span class="text-[10px] font-black text-rose-700 bg-rose-50 dark:bg-rose-950 dark:text-rose-300 px-2.5 py-1 rounded-full">
                        {{ $t('التخصصات', 'Métiers', 'Skills') }}
                    </span>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($totalSkills) }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 truncate">{{ $t('التخصصات والمجالات', 'Compétences Métiers', 'Skill Disciplines') }}</p>
                    <div class="flex gap-1 mt-2.5 flex-wrap">
                        @for($i = 0; $i < min(7, $totalSkills); $i++)
                            <div class="w-2 h-2 rounded-full bg-rose-500"></div>
                        @endfor
                        @if($totalSkills > 7)
                            <span class="text-[9px] font-black text-slate-400">+{{ $totalSkills - 7 }}</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- 6. Issued Accreditations & Badges --}}
            <div class="bg-white dark:bg-slate-800/90 rounded-3xl border border-slate-200/90 dark:border-slate-700/80 p-5 shadow-xs hover:shadow-lg transition-all group relative overflow-hidden">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 rounded-2xl bg-teal-50 dark:bg-teal-900/40 text-teal-600 dark:text-teal-400 flex items-center justify-center font-black group-hover:scale-105 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $svgPaths['shield'] !!}</svg>
                    </div>
                    <span class="text-[10px] font-black text-teal-700 bg-teal-50 dark:bg-teal-950 dark:text-teal-300 px-2.5 py-1 rounded-full">
                        {{ $t('موثق QR', 'Badges QR', 'QR Badges') }}
                    </span>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($issuedCertificates) }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400 truncate">{{ $t('البادجات والشهادات', 'Badges & Certificats', 'Badges & Certificates') }}</p>
                    <p class="text-[10px] font-bold text-teal-600 dark:text-teal-400 pt-2 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-500"></span>
                        <span>{{ $t('نظام التوثيق الأمني نشط', 'Témoin Sécurité', 'Security QR Active') }}</span>
                    </p>
                </div>
            </div>

        </div>
    </div>


    {{-- ══════════════════════════════════════
         SECTION 3 — EXECUTIVE COMMAND HUB TABS
    ══════════════════════════════════════ --}}
    <div class="space-y-4">
        
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                <span>{{ $t('مراكز التحكم والقيادة التنفيذية', 'Centres de Contrôle Exécutifs', 'Executive Control Centers') }}</span>
            </h2>
        </div>

        {{-- High-Contrast Executive Tab Bar --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-1 scrollbar-none bg-slate-100 dark:bg-slate-800/60 p-1.5 rounded-2xl border border-slate-200/80 dark:border-slate-700">
            @foreach([
                ['overview',                   'home',      $t('نظرة عامة والعمليات',  'Vue d\'ensemble', 'Overview & Operations')],
                ['accreditations_delegations', 'users',     $t('الاعتمادات والوفود',  'Accréditations',  'Accreditations & Delegations')],
                ['users_access',               'shield',    $t('المستخدمون والأدوار',   'Utilisateurs',    'Users & Roles')],
                ['cms_media',                  'newspaper', $t('المحتوى والإعلام',    'CMS & Médias',    'CMS & Media')],
                ['security_governance',        'shield',    $t('الأمان والرقابة',     'Sécurité',        'Security & Audit')],
            ] as [$tab, $icon, $label])
                <button wire:click="setTab('{{ $tab }}')"
                        class="flex items-center gap-2.5 px-4 py-2.5 rounded-xl text-xs font-black whitespace-nowrap transition-all shrink-0 cursor-pointer select-none"
                        style="{{ $activeTab === $tab
                            ? 'background:#0B2A6F;color:white;box-shadow:0 4px 12px rgba(11,42,111,0.25);'
                            : 'color:#64748B;' }}"
                        @mouseenter="if('{{ $activeTab }}' !== '{{ $tab }}') { $el.style.background='rgba(255,255,255,0.8)'; $el.style.color='#0F172A'; }"
                        @mouseleave="if('{{ $activeTab }}' !== '{{ $tab }}') { $el.style.background='transparent'; $el.style.color='#64748B'; }"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $svgPaths[$icon] !!}
                    </svg>
                    <span>{{ $label }}</span>
                </button>
            @endforeach
        </div>

        {{-- Tab Content Containers --}}
        <div class="pt-2">

            {{-- ── TAB 1: OVERVIEW & STRATEGIC OPERATIONS ── --}}
            @if($activeTab === 'overview')
                <div class="space-y-6">
                    
                    {{-- Quick Action Launch Grid --}}
                    <div>
                        <span class="text-[11px] font-black text-slate-400 uppercase tracking-wider block mb-2">{{ $t('روابط الإطلاق السريع:', 'Accès Rapides:', 'Quick Action Launchers:') }}</span>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                            @foreach([
                                ['admin.delegation.invitations', 'clipboard', $t('دعوات الوفود الرسمية', 'Invitations', 'Delegation Invites'), 'blue'],
                                ['admin.accreditations',       'badge',     $t('مركز الاعتمادات', 'Accréditations', 'Accreditations'), 'purple'],
                                ['admin.skills',               'trophy',    $t('التخصصات القارية', 'Métiers', 'Skill Specializations'), 'pink'],
                                ['admin.cms.news',             'newspaper', $t('المركز الإعلامي', 'Actualités', 'News Manager'), 'emerald'],
                            ] as [$route, $icon, $label, $color])
                                @php
                                    $colors = ['blue'=>'#3B82F6','purple'=>'#8B5CF6','pink'=>'#EC4899','emerald'=>'#10B981'];
                                    $bgColors = ['blue'=>'#EFF6FF','purple'=>'#F5F3FF','pink'=>'#FDF2F8','emerald'=>'#ECFDF5'];
                                @endphp
                                <a href="{{ route($route) }}"
                                   class="flex items-center gap-3.5 p-4 rounded-2xl border border-slate-200/80 dark:border-slate-700 bg-white dark:bg-slate-800 hover:shadow-lg transition-all group">
                                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 transition-transform group-hover:scale-110"
                                         style="background:{{ $bgColors[$color] }};">
                                        <svg class="w-5 h-5" fill="none" stroke="{{ $colors[$color] }}" viewBox="0 0 24 24">
                                            {!! $svgPaths[$icon] !!}
                                        </svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <span class="text-xs font-black text-slate-900 dark:text-slate-100 block truncate group-hover:text-blue-600 transition">{{ $label }}</span>
                                        <div class="flex items-center gap-1 text-[10px] font-bold text-slate-400 mt-0.5">
                                            <span>{{ $t('فتح الآن', 'Ouvrir', 'Launch') }}</span>
                                            <svg class="w-3 h-3 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $svgPaths['arrow-right'] !!}</svg>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Split View: Diplomatic Bilateral Talks + Recent Registrations --}}
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

                        {{-- Left Column: Diplomatic Bilateral Talks Widget (5 Cols) --}}
                        <div class="lg:col-span-5 bg-gradient-to-br from-[#041029] via-[#0B2A6F] to-[#06205C] text-white rounded-3xl border border-blue-900/60 p-6 shadow-xl space-y-4">
                            <div class="flex items-center justify-between pb-3 border-b border-white/15">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-2xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-black shrink-0 border border-amber-500/30 shadow-md">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/></svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-black text-white leading-tight">
                                            {{ $t('اللقاءات الدبلوماسية الوزارية الثنائية', 'Entretiens Ministériels Bilatéraux', 'Diplomatic Ministerial Bilateral Talks') }}
                                        </h3>
                                        <p class="text-[11px] text-blue-200 font-medium">
                                            {{ $t('جاهزية الوزراء والوفود وحجوزات القاعات', 'Disponibilité ministérielle et salons VIP', 'Ministerial availability & VIP lounges') }}
                                        </p>
                                    </div>
                                </div>

                                <a href="{{ route('admin.diplomatic') }}" class="px-3 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs transition shrink-0 flex items-center gap-1 shadow-md">
                                    <span>{{ $t('المركز', 'Centre', 'Center') }}</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </a>
                            </div>

                            <div class="grid grid-cols-3 gap-2.5 text-center">
                                <div class="bg-white/10 rounded-2xl p-3 border border-white/10">
                                    <span class="text-[10px] text-slate-300 font-bold block">{{ $t('الوزراء المسجلون', 'Ministres', 'Ministers') }}</span>
                                    <span class="text-xl font-black text-amber-400">{{ $totalMinisters }}</span>
                                </div>
                                <div class="bg-white/10 rounded-2xl p-3 border border-white/10">
                                    <span class="text-[10px] text-slate-300 font-bold block">{{ $t('متاحون للعمل', 'Disponibles', 'Available') }}</span>
                                    <span class="text-xl font-black text-emerald-400">{{ $availableMinisters }}</span>
                                </div>
                                <div class="bg-white/10 rounded-2xl p-3 border border-white/10">
                                    <span class="text-[10px] text-slate-300 font-bold block">{{ $t('حجوزات اليوم', 'Réservations', 'Today\'s Talks') }}</span>
                                    <span class="text-xl font-black text-blue-300">{{ $todayDiplomaticMeetings }}</span>
                                </div>
                            </div>

                            @if(!empty($recentDiplomaticMeetings) && $recentDiplomaticMeetings->count() > 0)
                                <div class="space-y-2 pt-2">
                                    <span class="text-[10px] text-amber-300 font-black uppercase block tracking-wider">{{ $t('أحدث اللقاءات الثنائية المجدولة:', 'Derniers Entretiens:', 'Latest Bilateral Sessions:') }}</span>
                                    <div class="space-y-2">
                                        @foreach($recentDiplomaticMeetings as $rMtg)
                                            <div class="bg-slate-900/90 p-3 rounded-2xl border border-white/10 text-xs space-y-1">
                                                <div class="flex items-center justify-between text-[10px] font-mono text-blue-300">
                                                    <span>{{ $rMtg->start_time->format('H:i') }} - {{ $rMtg->end_time->format('H:i') }}</span>
                                                    <span class="text-amber-400 font-bold">{{ $rMtg->room?->name_ar ?? 'القاعة الرئاسية' }}</span>
                                                </div>
                                                <p class="font-black text-white text-[11px] truncate">{{ $rMtg->title }}</p>
                                                <div class="flex items-center justify-between text-[10px] text-slate-300 font-bold pt-1 border-t border-white/10">
                                                    <span>{{ $rMtg->hostMinister?->full_name }}</span>
                                                    <span class="text-amber-400">⇄</span>
                                                    <span>{{ $rMtg->guestMinister?->full_name }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Right Column: Live Registrations Feed (7 Cols) --}}
                        <div class="lg:col-span-7 bg-white dark:bg-slate-800 rounded-3xl border border-slate-200/90 dark:border-slate-700 shadow-xs overflow-hidden flex flex-col">
                            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                                <div>
                                    <h3 class="text-sm font-black text-slate-900 dark:text-slate-100">
                                        {{ $t('أحدث طلبات التسجيل والاعتماد الرسمي', 'Dernières Inscriptions', 'Recent Official Registrations') }}
                                    </h3>
                                    <p class="text-[11px] text-slate-400 font-medium">{{ $t('متابعة الطلبات المقدمة لحظة بلحظة', 'Suivi en temps réel des demandes', 'Live application tracking') }}</p>
                                </div>
                                <a href="{{ route('admin.registrations') }}" class="text-xs font-black text-blue-600 hover:text-blue-700 dark:text-sky-400">
                                    {{ $t('عرض الكل', 'Voir Tout', 'View All') }} ({{ $totalRegistrations }}) →
                                </a>
                            </div>

                            <div class="overflow-x-auto flex-1">
                                <table class="w-full text-xs">
                                    <thead>
                                        <tr class="bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 font-black uppercase tracking-wider text-[10px]">
                                            <th class="px-6 py-3 text-start">{{ $t('رمز الطلب', 'Référence', 'Reference') }}</th>
                                            <th class="px-6 py-3 text-start">{{ $t('التخصص / الصفة', 'Compétence / Rôle', 'Skill / Capacity') }}</th>
                                            <th class="px-6 py-3 text-start">{{ $t('الحالة', 'Statut', 'Status') }}</th>
                                            <th class="px-6 py-3 text-start">{{ $t('التاريخ', 'Date', 'Date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                        @forelse($recentRegistrations as $reg)
                                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition">
                                                <td class="px-6 py-3.5 font-black text-blue-600 dark:text-blue-400 font-mono">
                                                    {{ $reg->registration_code ?? 'REG-'.$reg->id }}
                                                </td>
                                                <td class="px-6 py-3.5 font-bold text-slate-800 dark:text-slate-200">
                                                    {{ $reg->skill?->getLocalized('name') ?? $t('اعتماد رسمي عام', 'Accréditation Officielle', 'Official Accreditation') }}
                                                </td>
                                                <td class="px-6 py-3.5">
                                                    @php
                                                        $sv = is_object($reg->status) ? ($reg->status->value ?? $reg->status->name) : ($reg->status ?? 'SUBMITTED');
                                                        $sbg = match(strtolower($sv)) {
                                                            'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200 dark:bg-emerald-950 dark:text-emerald-300',
                                                            'rejected' => 'bg-rose-50 text-rose-700 border-rose-200 dark:bg-rose-950 dark:text-rose-300',
                                                            default    => 'bg-blue-50 text-blue-700 border-blue-200 dark:bg-blue-950 dark:text-sky-300',
                                                        };
                                                    @endphp
                                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black border {{ $sbg }}">
                                                        {{ strtoupper($sv) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-3.5 font-medium text-slate-500 dark:text-slate-400 whitespace-nowrap">
                                                    {{ $reg->created_at?->format('Y-m-d') ?? '—' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="px-6 py-12 text-center">
                                                    <div class="flex flex-col items-center gap-2">
                                                        <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            {!! $svgPaths['clipboard'] !!}
                                                        </svg>
                                                        <p class="text-xs font-bold text-slate-400">{{ $t('لا توجد طلبات تسجيل حتى الآن', 'Aucune inscription', 'No registrations yet') }}</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            @endif

            {{-- ── TAB 2: ACCREDITATIONS & DELEGATIONS ── --}}
            @if($activeTab === 'accreditations_delegations')
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.delegation.invitations') }}" class="p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-lg transition group">
                            <div class="flex items-center gap-3.5 mb-3">
                                <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-900/40 text-blue-600 flex items-center justify-center font-black">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <h4 class="text-base font-black text-slate-900 dark:text-slate-100 group-hover:text-blue-600 transition">{{ $t('دعوات الوفود الإفريقية الرسمية', 'Invitations des Délégations', 'Delegation Invitations') }}</h4>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium leading-relaxed">{{ $t('إرسال ومتابعة خطابات الدعوة والاعتماد الرسمي للدول الأعضاء بالاتحاد الإفريقي.', 'Gérer les lettres d\'invitation et accréditations.', 'Manage invitation letters & official accreditations.') }}</p>
                        </a>

                        <a href="{{ route('admin.accreditations') }}" class="p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-lg transition group">
                            <div class="flex items-center gap-3.5 mb-3">
                                <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 flex items-center justify-center font-black">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-6 0h6"/></svg>
                                </div>
                                <h4 class="text-base font-black text-slate-900 dark:text-slate-100 group-hover:text-emerald-600 transition">{{ $t('طباعة واعتماد البادجات الرسمية', 'Badges & Accréditations', 'Badges & Accreditations') }}</h4>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium leading-relaxed">{{ $t('توليد بطاقات الاعتماد الرقمية وتحديد صلاحيات المناطق بمركز المؤتمرات.', 'Génération de badges et contrôle des accès.', 'Badge generation & access control zones.') }}</p>
                        </a>

                        <a href="{{ route('admin.countries') }}" class="p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-xs hover:shadow-lg transition group">
                            <div class="flex items-center gap-3.5 mb-3">
                                <div class="w-12 h-12 rounded-2xl bg-purple-50 dark:bg-purple-900/40 text-purple-600 flex items-center justify-center font-black">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V7a2 2 0 00-2-2h-1.5a1 1 0 01-1-1V2.5"/></svg>
                                </div>
                                <h4 class="text-base font-black text-slate-900 dark:text-slate-100 group-hover:text-purple-600 transition">{{ $t('قائمة الدول والوفود المشاركة', 'Liste des Délégations', 'Delegations & Countries') }}</h4>
                            </div>
                            <p class="text-xs text-slate-500 dark:text-slate-400 font-medium leading-relaxed">{{ $t('متابعة كشوفات الوفود الوطنية ورؤساء البعثات الرسمية لكل دولة.', 'Suivi des membres de chaque délégation nationale.', 'Roster tracking for national delegation leads.') }}</p>
                        </a>
                    </div>
                </div>
            @endif

            {{-- ── TAB 3: USERS & ROLES ACCESS ── --}}
            @if($activeTab === 'users_access')
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach([
                            [$totalUsers,         $t('إجمالي المستخدمين والحسابات', 'Utilisateurs', 'Total Users'), $t('جميع الأدوار بالحسابات', 'Tous rôles', 'All roles'), 'blue'],
                            [$totalCountries,      $t('الوفود والدول الرسمية', 'Délégations', 'Delegations'), $t('مسؤولو دول', 'Pays', 'Country Admins'), 'emerald'],
                            [$totalRegistrations,  $t('الضيوف والمشاركون', 'Compétiteurs', 'Participants'), $t('مسجلون بالمنصة', 'Candidats', 'Registrants'), 'purple'],
                        ] as [$val, $label, $sublabel, $color])
                            @php
                                $ringC = ['blue'=>'ring-blue-100 dark:ring-blue-900','emerald'=>'ring-emerald-100 dark:ring-emerald-900','purple'=>'ring-purple-100 dark:ring-purple-900'];
                                $numC  = ['blue'=>'text-blue-600 dark:text-sky-400','emerald'=>'text-emerald-600 dark:text-emerald-400','purple'=>'text-purple-600 dark:text-purple-400'];
                            @endphp
                            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 shadow-xs flex items-center gap-4">
                                <div class="w-14 h-14 rounded-2xl ring-2 {{ $ringC[$color] }} flex items-center justify-center shrink-0 bg-white dark:bg-slate-700 shadow-sm">
                                    <span class="text-2xl font-black {{ $numC[$color] }}">{{ number_format($val) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900 dark:text-slate-100">{{ $label }}</p>
                                    <p class="text-xs font-bold text-slate-400 mt-0.5">{{ $sublabel }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-950/60 rounded-3xl border border-blue-200 dark:border-blue-800 p-6 flex items-center justify-between">
                        <p class="text-xs font-bold text-blue-800 dark:text-blue-200 leading-relaxed">
                            {{ $t(
                                'لإدارة الأدوار والحسابات بشكل كامل وتعيين صلاحيات الدخول، انتقل إلى صفحة المستخدمين من القائمة الجانبية.',
                                'Pour gérer les rôles, accédez à la section Utilisateurs depuis le menu.',
                                'To manage roles and access permissions, navigate to Users from the Sidebar.'
                            ) }}
                        </p>
                        <a href="{{ route('admin.users') }}" class="px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-md transition shrink-0 ms-4">
                            {{ $t('إدارة المستخدمين', 'Gérer Utilisateurs', 'Manage Users') }} →
                        </a>
                    </div>
                </div>
            @endif

            {{-- ── TAB 4: CMS & MEDIA BROADCAST ── --}}
            @if($activeTab === 'cms_media')
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach([
                        ['admin.cms.homepage', 'home',      $t('محرر الصفحة الرئيسية',    'Page d\'Accueil',    'Homepage Editor'),  $t('العناوين والفيديو المميز', 'Titre & Vidéo',  'Titles & Featured Video')],
                        ['admin.cms.news',     'newspaper', $t('مركز الأخبار والمقالات',   'Actualités',         'News Articles'),    $t('نشر التغطيات الأنبائية', 'Presse',          'Press Coverage')],
                        ['admin.media.dashboard','newspaper',$t('المركز الإعلامي',          'Centre Médias',     'Media Center'),     $t('الأخبار والصور والفيديوهات','Actualités',     'News, Photos & Videos')],
                        ['live-tv',            'trophy',    $t('بث الشاشات المباشرة (Live TV)', 'Direct TV (Écrans)', 'Live TV Screen Broadcast'), $t('عرض الترتيب والشريط الإخباري', 'Ticker & Live Status', 'Live Results & Ticker')],
                    ] as [$route, $icon, $label, $desc])
                        <a href="{{ route($route) }}"
                           class="flex flex-col gap-4 p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:shadow-lg hover:border-blue-300 dark:hover:border-blue-700 transition group">
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-700 flex items-center justify-center">
                                <svg class="w-6 h-6 text-slate-600 dark:text-slate-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $svgPaths[$icon] !!}
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-slate-900 dark:text-slate-100 group-hover:text-blue-600 transition">{{ $label }}</h4>
                                <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mt-1">{{ $desc }}</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 group-hover:text-blue-500 mt-auto transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $svgPaths['arrow-right'] !!}
                            </svg>
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- ── TAB 5: SECURITY & AUDIT ── --}}
            @if($activeTab === 'security_governance')
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $svgPaths['shield'] !!}
                            </svg>
                            <h3 class="text-sm font-black text-slate-900 dark:text-slate-100">
                                {{ $t('سجلات الأمان والرقابة الوطنية', 'Journaux de Sécurité', 'Security & Audit Logs') }}
                            </h3>
                        </div>
                        <a href="{{ route('admin.audit') }}" class="text-xs font-black text-blue-600 hover:text-blue-700">
                            {{ $t('مركز الأمان الكلي', 'Centre Sécurité', 'Full Security Center') }} →
                        </a>
                    </div>
                    <div class="p-6 space-y-3">
                        @forelse($recentAuditLogs as $log)
                            <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-700/50 border border-slate-100 dark:border-slate-700 text-xs">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <div class="min-w-0">
                                        <span class="font-black text-slate-900 dark:text-slate-100 block truncate">{{ $log->event }}</span>
                                        <span class="font-semibold text-slate-500 dark:text-slate-400 text-[10px] block mt-0.5">
                                            IP: {{ $log->ip_address }} · {{ $log->created_at?->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                <span class="font-mono font-black text-slate-600 dark:text-slate-300 bg-slate-200 dark:bg-slate-600 px-2.5 py-1 rounded-lg text-[10px] shrink-0 ms-2">
                                    #{{ $log->id }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-10 flex flex-col items-center gap-3">
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $svgPaths['shield'] !!}
                                </svg>
                                <p class="text-xs font-bold text-slate-400">{{ $t('لا توجد سجلات حالياً', 'Aucun journal', 'No audit logs yet') }}</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            @endif

        </div>

    </div>

</div>
