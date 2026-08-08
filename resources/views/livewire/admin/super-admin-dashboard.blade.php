@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };

/** Quick-action SVG paths */
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
];
@endphp

<div class="space-y-6 pb-8">

    {{-- ══════════════════════════════════════
         SECTION 1 — WORKSPACE HEADER
    ══════════════════════════════════════ --}}
    <div class="flex flex-col lg:flex-row lg:items-start gap-4 lg:gap-6">

        {{-- Platform Status + Title --}}
        <div class="flex-1 space-y-3">
            {{-- Status Badge --}}
            <div class="flex items-center gap-2 flex-wrap">
                <span class="flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-200 text-emerald-700 text-[11px] font-black uppercase tracking-wider">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    {{ $t('المنصة تعمل', 'OPÉRATIONNEL', 'OPERATIONAL') }}
                    — {{ $t('معدل الصحة', 'Score Santé', 'Health Score') }} {{ $systemHealth['score'] ?? '99.9%' }}
                </span>
            </div>

            <h1 class="text-2xl md:text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight leading-tight">
                {{ $t('مركز القيادة والتحكم الوطني', 'Centre de Commandement National', 'National Command Center') }}
                <span class="text-blue-600 dark:text-blue-400"> — {{ $t('الإدارة العليا', 'Super Admin', 'Super Admin') }}</span>
            </h1>

            <p class="text-sm font-medium text-slate-500 dark:text-slate-400 max-w-2xl leading-relaxed">
                {{ $t(
                    'متابعة حية للجاهزية الوطنية، سجلات الأمان، استوديو مظهر الهوية ومؤشرات المسابقة دورتي 2026/2027.',
                    'Gouvernance globale, suivi en temps réel, sécurité et studio de design system.',
                    'Global platform governance, real-time health monitoring, and design system studio.'
                ) }}
            </p>
        </div>

        {{-- Active Edition Card --}}
        <div class="shrink-0 bg-slate-900 dark:bg-slate-800 text-white rounded-2xl p-4 min-w-[220px] space-y-2 shadow-lg">
            <span class="text-[10px] font-black text-emerald-400 uppercase tracking-widest block">
                {{ $t('الدورة الحالية', 'ÉDITION ACTIVE', 'CURRENT EDITION') }}
            </span>
            <span class="text-sm font-black block leading-snug">
                {{ $activeEdition?->getLocalized('name') ?? 'WorldSkills Algeria 2027' }}
            </span>
            <div class="flex items-center justify-between text-[11px] font-bold text-slate-400 pt-2 border-t border-slate-700">
                <span>{{ $t('مؤسسات:', 'Établissements:', 'Orgs:') }} {{ $totalOrganizations }}</span>
                <span>{{ $t('تخصصات:', 'Métiers:', 'Skills:') }} {{ $totalSkills }}</span>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         SECTION 2 — SYSTEM HEALTH GRID
    ══════════════════════════════════════ --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-2">
        @foreach([
            ['Database',      'Healthy',   'emerald'],
            ['Cache Engine',  'Active',    'emerald'],
            ['Queue Worker',  'Running',   'emerald'],
            ['Storage',       'Healthy',   'emerald'],
            ['PWA Manifest',  'Active',    'emerald'],
            ['Security Audit','Protected', 'emerald'],
        ] as [$service, $status, $color])
            <div class="p-3 rounded-xl bg-white dark:bg-slate-800/70 border border-slate-200 dark:border-slate-700 flex items-center justify-between gap-2 shadow-xs">
                <span class="text-[11px] font-bold text-slate-600 dark:text-slate-300 truncate">{{ $service }}</span>
                <span class="flex items-center gap-1 shrink-0">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                    <span class="text-[10px] font-black text-emerald-600 dark:text-emerald-400">{{ $status }}</span>
                </span>
            </div>
        @endforeach
    </div>

    {{-- ══════════════════════════════════════
         SECTION 3 — KPI GRID (Premium)
    ══════════════════════════════════════ --}}
    <div>
        <h2 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] mb-3">
            {{ $t('المؤشرات الرئيسية', 'Indicateurs Clés', 'Key Performance Indicators') }}
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            {{-- KPI: Total Users --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-5 shadow-xs hover:shadow-md transition-shadow group">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $svgPaths['users'] !!}
                        </svg>
                    </div>
                    <span class="text-[10px] font-black text-emerald-600 bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-400 px-2 py-1 rounded-full">
                        ↑ {{ $t('نشط', 'Actif', 'Active') }}
                    </span>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($totalUsers) }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $t('إجمالي الحسابات', 'Utilisateurs', 'Total Accounts') }}</p>
                    <div class="flex gap-0.5 mt-2">
                        @foreach([2,4,3,6,5,8,7,9,8,10] as $h)
                            <div class="flex-1 rounded-sm bg-blue-500 dark:bg-blue-600 opacity-{{ $h * 10 }}" style="height:{{ $h * 2 }}px"></div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- KPI: Countries --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-5 shadow-xs hover:shadow-md transition-shadow group">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $svgPaths['globe'] !!}
                        </svg>
                    </div>
                    <span class="text-[10px] font-black text-blue-600 bg-blue-50 dark:bg-blue-900/30 dark:text-blue-400 px-2 py-1 rounded-full">
                        {{ $t('إفريقيا', 'Afrique', 'Africa') }}
                    </span>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($totalCountries) }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $t('الدول المشاركة', 'Délégations', 'Participating Countries') }}</p>
                    <div class="mt-2 h-1.5 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                        <div class="h-full bg-emerald-500 rounded-full" style="width:{{ min(100, ($totalCountries / 54) * 100) }}%"></div>
                    </div>
                    <p class="text-[10px] font-semibold text-slate-400 dark:text-slate-500">{{ round(($totalCountries / 54) * 100) }}% {{ $t('من إفريقيا', 'de l\'Afrique', 'of Africa') }}</p>
                </div>
            </div>

            {{-- KPI: Skills --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-5 shadow-xs hover:shadow-md transition-shadow group">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $svgPaths['trophy'] !!}
                        </svg>
                    </div>
                    <span class="text-[10px] font-black text-purple-600 bg-purple-50 dark:bg-purple-900/30 dark:text-purple-400 px-2 py-1 rounded-full">
                        {{ $t('معتمد WSA', 'Officiel', 'WSA Official') }}
                    </span>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($totalSkills) }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $t('التخصصات الأولمبية', 'Compétences', 'Olympic Skills') }}</p>
                    <div class="flex gap-1 mt-2 flex-wrap">
                        @for($i = 0; $i < min(8, $totalSkills); $i++)
                            <div class="w-2 h-2 rounded-sm bg-purple-400 dark:bg-purple-600"></div>
                        @endfor
                        @if($totalSkills > 8)
                            <span class="text-[10px] font-bold text-slate-400">+{{ $totalSkills - 8 }}</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- KPI: Registrations --}}
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-5 shadow-xs hover:shadow-md transition-shadow group">
                <div class="flex items-start justify-between mb-3">
                    <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center">
                        <svg class="w-5 h-5 text-amber-600 dark:text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $svgPaths['clipboard'] !!}
                        </svg>
                    </div>
                    <span class="text-[10px] font-black text-amber-600 bg-amber-50 dark:bg-amber-900/30 dark:text-amber-400 px-2 py-1 rounded-full">
                        {{ $t('مسجل', 'Soumis', 'Submitted') }}
                    </span>
                </div>
                <div class="space-y-1">
                    <p class="text-3xl font-black text-slate-900 dark:text-slate-100 tracking-tight">{{ number_format($totalRegistrations) }}</p>
                    <p class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $t('طلبات التسجيل', 'Inscriptions', 'Registrations') }}</p>
                    <div class="mt-2 flex items-center gap-1.5">
                        <div class="h-1.5 flex-1 bg-slate-100 dark:bg-slate-700 rounded-full overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full" style="width:{{ $totalRegistrations > 0 ? '60%' : '0%' }}"></div>
                        </div>
                        <span class="text-[10px] font-bold text-slate-400">{{ $totalRegistrations > 0 ? '60%' : '0%' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══════════════════════════════════════
         SECTION 4 — COMMAND TABS
    ══════════════════════════════════════ --}}
    <div>
        <h2 class="text-xs font-black text-slate-400 dark:text-slate-500 uppercase tracking-[0.15em] mb-3">
            {{ $t('مراكز التحكم', 'Centres de Contrôle', 'Control Centers') }}
        </h2>

        {{-- Tab Bar --}}
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 scrollbar-none">
            @foreach([
                ['operations',          'home',      $t('العمليات الوطنية', 'Opérations',    'Operations')],
                ['users_access',        'users',     $t('المستخدمون',       'Utilisateurs',  'Users')],
                ['appearance',          'paint',     $t('المظهر والهوية',  'Apparence',     'Appearance')],
                ['cms_media',           'newspaper', $t('المحتوى والإعلام','CMS & Médias',  'CMS & Media')],
                ['security_governance', 'shield',    $t('الأمان والرقابة', 'Sécurité',      'Security')],
            ] as [$tab, $icon, $label])
                <button wire:click="setTab('{{ $tab }}')"
                        class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-black whitespace-nowrap transition-all shrink-0 border"
                        style="{{ $activeTab === $tab
                            ? 'background:#0F172A;color:white;border-color:#0F172A;box-shadow:0 1px 3px rgba(0,0,0,0.2);'
                            : 'background:white;color:#64748B;border-color:#E2E8F0;' }}"
                        @mouseenter="if('{{ $activeTab }}' !== '{{ $tab }}') { $el.style.background='#F8FAFC'; $el.style.color='#1E293B'; }"
                        @mouseleave="if('{{ $activeTab }}' !== '{{ $tab }}') { $el.style.background='white'; $el.style.color='#64748B'; }"
                >
                    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $svgPaths[$icon] !!}
                    </svg>
                    <span>{{ $label }}</span>
                </button>
            @endforeach
        </div>

        {{-- Tab Content --}}
        <div class="mt-4">

            {{-- TAB 1: OPERATIONS --}}
            @if($activeTab === 'operations')
                <div class="space-y-4">
                    {{-- Quick Actions --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach([
                            ['admin.schedule.index', 'calendar',  $t('إدارة الأحداث',    'Événements',  'Events'),      'blue'],
                            ['admin.logistics',   'clipboard', $t('اللوجستيات',        'Logistique',  'Logistics'),   'purple'],
                            ['admin.appearance',  'paint',     $t('التصميم',           'Apparence',   'Appearance'),  'pink'],
                            ['admin.cms.homepage','newspaper', $t('المحتوى',          'CMS',         'CMS'),         'emerald'],
                        ] as [$route, $icon, $label, $color])
                            @php
                                $colors = ['blue'=>'#3B82F6','purple'=>'#8B5CF6','pink'=>'#EC4899','emerald'=>'#10B981'];
                                $bgColors = ['blue'=>'#EFF6FF','purple'=>'#F5F3FF','pink'=>'#FDF2F8','emerald'=>'#ECFDF5'];
                            @endphp
                            <a href="{{ route($route) }}"
                               class="flex items-center gap-3 p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:shadow-md transition-all group">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center shrink-0"
                                     style="background:{{ $bgColors[$color] }};">
                                    <svg class="w-5 h-5" fill="none" stroke="{{ $colors[$color] }}" viewBox="0 0 24 24">
                                        {!! $svgPaths[$icon] !!}
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <span class="text-xs font-black text-slate-800 dark:text-slate-100 block truncate">{{ $label }}</span>
                                    <svg class="w-3 h-3 text-slate-300 mt-0.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        {!! $svgPaths['arrow-right'] !!}
                                    </svg>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- Diplomatic & Ministerial Exchange Widget --}}
                    <div class="bg-gradient-to-l from-[#020A24] via-[#06205C] to-[#0A3580] text-white rounded-2xl border border-blue-900/60 p-6 shadow-md space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-amber-500/20 text-amber-400 flex items-center justify-center font-black shrink-0 border border-amber-500/30">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m3 0h1m-4 0a1 1 0 01-1-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 01-1 1m-6 0h6"/></svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-black text-white leading-tight">
                                        {{ $t('القيادة الدبلوماسية واللقاءات الثنائية الوزارية', 'Commandement Diplomatique & Entretiens Ministériels', 'Diplomatic Command & Ministerial Bilateral Talks') }}
                                    </h3>
                                    <p class="text-[11px] text-blue-200 font-medium">
                                        {{ $t('جاهزية الوزراء والوفود الإفريقية وحجوزات القاعات الدبلوماسية', 'Disponibilité ministérielle et salons VIP', 'Ministerial availability & diplomatic lounges') }}
                                    </p>
                                </div>
                            </div>

                            <a href="{{ route('admin.diplomatic') }}" class="px-3.5 py-1.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 font-black text-xs transition flex items-center gap-1.5 shadow-md">
                                <span>{{ $t('فتح اللوحة الدبلوماسية', 'Ouvrir Centre', 'Open Center') }}</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>

                        <div class="grid grid-cols-3 gap-3 pt-1 text-center">
                            <div class="bg-white/10 rounded-xl p-2.5 border border-white/10">
                                <span class="text-[10px] text-slate-300 font-bold block">{{ $t('الوزراء والمسؤولون', 'Ministres', 'Ministers') }}</span>
                                <span class="text-lg font-black text-amber-400">{{ $totalMinisters }}</span>
                            </div>
                            <div class="bg-white/10 rounded-xl p-2.5 border border-white/10">
                                <span class="text-[10px] text-slate-300 font-bold block">{{ $t('متاحون للعمل', 'Disponibles', 'Available') }}</span>
                                <span class="text-lg font-black text-emerald-400">{{ $availableMinisters }}</span>
                            </div>
                            <div class="bg-white/10 rounded-xl p-2.5 border border-white/10">
                                <span class="text-[10px] text-slate-300 font-bold block">{{ $t('حجوزات اليوم', 'Réservations Jour', 'Today\'s Talks') }}</span>
                                <span class="text-lg font-black text-blue-300">{{ $todayDiplomaticMeetings }}</span>
                            </div>
                        </div>

                        @if(!empty($recentDiplomaticMeetings) && $recentDiplomaticMeetings->count() > 0)
                            <div class="space-y-2 pt-2 border-t border-white/10">
                                <span class="text-[10px] text-amber-300 font-black uppercase block">{{ $t('أحدث اللقاءات الثنائية المجدولة:', 'Derniers Entretiens:', 'Latest Bilateral Sessions:') }}</span>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                    @foreach($recentDiplomaticMeetings as $rMtg)
                                        <div class="bg-slate-900/80 p-2.5 rounded-xl border border-white/10 text-xs space-y-1">
                                            <div class="flex items-center justify-between text-[10px] font-mono text-blue-300">
                                                <span>{{ $rMtg->start_time->format('H:i') }} - {{ $rMtg->end_time->format('H:i') }}</span>
                                                <span class="text-amber-400">{{ $rMtg->room?->name_ar }}</span>
                                            </div>
                                            <p class="font-black text-white text-[11px] truncate">{{ $rMtg->title }}</p>
                                            <div class="flex items-center justify-between text-[10px] text-slate-300 font-bold">
                                                <span>{{ $rMtg->hostMinister?->full_name }}</span>
                                                <span class="text-amber-300">⇄</span>
                                                <span>{{ $rMtg->guestMinister?->full_name }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- Recent Registrations Table --}}
                    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
                        <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
                            <h3 class="text-sm font-black text-slate-900 dark:text-slate-100">
                                {{ $t('أحدث طلبات التسجيل', 'Dernières Inscriptions', 'Recent Registrations') }}
                            </h3>
                            <span class="text-[10px] font-black text-slate-400 bg-slate-50 dark:bg-slate-700 px-2 py-1 rounded-full">
                                {{ $totalRegistrations }} {{ $t('إجمالاً', 'total', 'total') }}
                            </span>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-xs">
                                <thead>
                                    <tr class="bg-slate-50 dark:bg-slate-700/50 text-slate-500 dark:text-slate-400 font-black uppercase tracking-wider text-[10px]">
                                        <th class="px-6 py-3 text-start">{{ $t('رمز الطلب', 'Référence', 'Reference') }}</th>
                                        <th class="px-6 py-3 text-start">{{ $t('التخصص', 'Compétence', 'Skill') }}</th>
                                        <th class="px-6 py-3 text-start">{{ $t('الحالة', 'Statut', 'Status') }}</th>
                                        <th class="px-6 py-3 text-start">{{ $t('التاريخ', 'Date', 'Date') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                                    @forelse($recentRegistrations as $reg)
                                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-700/30 transition">
                                            <td class="px-6 py-3.5 font-black text-blue-600 dark:text-blue-400">
                                                {{ $reg->registration_code ?? 'REG-'.$reg->id }}
                                            </td>
                                            <td class="px-6 py-3.5 font-bold text-slate-700 dark:text-slate-300">
                                                {{ $reg->skill?->getLocalized('name') ?? $t('تخصص عام', 'Compétence', 'General Skill') }}
                                            </td>
                                            <td class="px-6 py-3.5">
                                                @php
                                                    $sv = is_object($reg->status) ? ($reg->status->value ?? $reg->status->name) : ($reg->status ?? 'SUBMITTED');
                                                    $sbg = match(strtolower($sv)) {
                                                        'approved' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                                        'rejected' => 'bg-rose-50 text-rose-700 border-rose-200',
                                                        default    => 'bg-blue-50 text-blue-700 border-blue-200',
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
                                            <td colspan="4" class="px-6 py-10 text-center">
                                                <div class="flex flex-col items-center gap-2">
                                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
            @endif

            {{-- TAB 2: USERS & ACCESS --}}
            @if($activeTab === 'users_access')
                <div class="space-y-4">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach([
                            [$totalUsers,         $t('إجمالي المستخدمين', 'Utilisateurs', 'Total Users'),        $t('جميع الأدوار', 'Tous rôles', 'All roles'),   'blue'],
                            [$totalCountries,      $t('الوفود الرسمية',    'Délégations',  'Delegations'),         $t('مسؤولو دول',   'Pays',        'Country Admins'), 'emerald'],
                            [$totalRegistrations,  $t('المترشحون',         'Compétiteurs', 'Competitors'),         $t('متنافسون',      'Candidats',   'Participants'),   'purple'],
                        ] as [$val, $label, $sublabel, $color])
                            @php
                                $ringC = ['blue'=>'ring-blue-100','emerald'=>'ring-emerald-100','purple'=>'ring-purple-100'];
                                $numC  = ['blue'=>'text-blue-600','emerald'=>'text-emerald-600','purple'=>'text-purple-600'];
                            @endphp
                            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-5 shadow-xs flex items-center gap-4">
                                <div class="w-12 h-12 rounded-2xl ring-2 {{ $ringC[$color] }} flex items-center justify-center shrink-0 bg-white dark:bg-slate-700">
                                    <span class="text-xl font-black {{ $numC[$color] }}">{{ number_format($val) }}</span>
                                </div>
                                <div>
                                    <p class="text-sm font-black text-slate-900 dark:text-slate-100">{{ $label }}</p>
                                    <p class="text-[11px] font-semibold text-slate-400 dark:text-slate-500 mt-0.5">{{ $sublabel }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-2xl border border-blue-200 dark:border-blue-800 p-5">
                        <p class="text-xs font-bold text-blue-700 dark:text-blue-300">
                            {{ $t(
                                'لإدارة الأدوار والحسابات بشكل كامل، انتقل إلى صفحة المستخدمين من الـ Sidebar.',
                                'Pour gérer les rôles, accédez à la section Utilisateurs depuis le menu.',
                                'To manage roles and accounts, navigate to Users from the Sidebar.'
                            ) }}
                        </p>
                    </div>
                </div>
            @endif

            {{-- TAB 3: APPEARANCE --}}
            @if($activeTab === 'appearance')
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-6 shadow-xs">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-base font-black text-slate-900 dark:text-slate-100">
                                {{ $t('استوديو المظهر والهوية الوطنية', 'Studio d\'Apparence', 'Appearance Studio') }}
                            </h3>
                            <p class="text-xs font-semibold text-slate-500 dark:text-slate-400 mt-1">
                                {{ $t('تعديل ألوان الهوية، الشعارات، الحواف والـ Design Tokens ديناميكياً.', 'Modifiez les couleurs, logos et tokens de design.', 'Edit brand colors, logos, and design tokens dynamically.') }}
                            </p>
                        </div>
                        <a href="{{ route('admin.appearance') }}"
                           class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs transition shadow-sm shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">{!! $svgPaths['paint'] !!}</svg>
                            {{ $t('فتح الاستوديو', 'Ouvrir Studio', 'Open Studio') }}
                        </a>
                    </div>
                </div>
            @endif

            {{-- TAB 4: CMS & MEDIA --}}
            @if($activeTab === 'cms_media')
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    @foreach([
                        ['admin.cms.homepage', 'home',      $t('محرر الصفحة الرئيسية',    'Page d\'Accueil',    'Homepage Editor'),  $t('العناوين والفيديو المميز', 'Titre & Vidéo',  'Titles & Featured Video')],
                        ['admin.cms.legal',    'clipboard', $t('الشروط القانونية',         'Mentions Légales',  'Legal Content'),    $t('الخصوصية وشروط الاستخدام','Politique & CGU', 'Privacy & ToS')],
                        ['admin.media.dashboard','newspaper',$t('المركز الإعلامي',          'Centre Médias',     'Media Center'),     $t('الأخبار والصور والفيديوهات','Actualités',     'News, Photos & Videos')],
                        ['live-tv',            'trophy',    $t('بث الشاشات المباشرة (Live TV)', 'Direct TV (Écrans)', 'Live TV Screen Broadcast'), $t('عرض الترتيب والميداليات والشريط الإخباري', 'Résultats en direct & Ticker', 'Live Results & Ticker')],
                    ] as [$route, $icon, $label, $desc])
                        <a href="{{ route($route) }}"
                           class="flex flex-col gap-4 p-5 rounded-2xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:shadow-md hover:border-blue-300 dark:hover:border-blue-700 transition group">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-700 flex items-center justify-center">
                                <svg class="w-5 h-5 text-slate-600 dark:text-slate-300 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    {!! $svgPaths[$icon] !!}
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-slate-900 dark:text-slate-100">{{ $label }}</h4>
                                <p class="text-[11px] font-semibold text-slate-500 dark:text-slate-400 mt-1">{{ $desc }}</p>
                            </div>
                            <svg class="w-4 h-4 text-slate-300 group-hover:text-blue-500 mt-auto transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                {!! $svgPaths['arrow-right'] !!}
                            </svg>
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- TAB 5: SECURITY --}}
            @if($activeTab === 'security_governance')
                <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
                    <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-700 flex items-center gap-3">
                        <svg class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            {!! $svgPaths['shield'] !!}
                        </svg>
                        <h3 class="text-sm font-black text-slate-900 dark:text-slate-100">
                            {{ $t('سجلات الأمان والرقابة الوطنية', 'Journaux de Sécurité', 'Security & Audit Logs') }}
                        </h3>
                    </div>
                    <div class="p-6 space-y-2">
                        @forelse($recentAuditLogs as $log)
                            <div class="flex items-center justify-between p-3.5 rounded-xl bg-slate-50 dark:bg-slate-700/50 border border-slate-100 dark:border-slate-700 text-xs">
                                <div class="flex items-center gap-3 min-w-0">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 shrink-0"></span>
                                    <div class="min-w-0">
                                        <span class="font-black text-slate-900 dark:text-slate-100 block truncate">{{ $log->event }}</span>
                                        <span class="font-semibold text-slate-500 dark:text-slate-400 text-[10px] block">
                                            IP: {{ $log->ip_address }} · {{ $log->created_at?->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                                <span class="font-mono font-black text-slate-500 dark:text-slate-400 bg-slate-200 dark:bg-slate-600 px-2 py-0.5 rounded-md text-[10px] shrink-0 ms-2">
                                    #{{ $log->id }}
                                </span>
                            </div>
                        @empty
                            <div class="text-center py-8 flex flex-col items-center gap-3">
                                <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
