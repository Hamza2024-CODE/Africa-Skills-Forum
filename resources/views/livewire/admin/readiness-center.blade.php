@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="py-12 bg-brand-bg dark:bg-slate-900 min-h-screen" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-black text-brand-dark dark:text-white flex items-center gap-2">
                    <svg class="w-7 h-7 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $t('مركز متابعة الجاهزية الرقمية للمشاركين', 'Centre de Suivi de la Préparation & Readiness', 'Global Participant Readiness Center') }}</span>
                </h1>
                <p class="text-xs text-brand-muted dark:text-slate-400 mt-1">
                    {{ $t('متابعة حية وحساب برمجي لنسبة جاهزية المتربصين والوفود بدون أرقام وهمية.', 'Évaluation dynamique du taux de préparation par délégué et établissement.', 'Dynamic readiness score calculation based on verified metrics.') }}
                </p>
            </div>
        </div>

        <!-- KPI Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
            <div class="glass-card dark:bg-slate-800 dark:border-slate-700 rounded-3xl p-6">
                <span class="text-xs font-bold text-brand-muted dark:text-slate-400 block uppercase">{{ $t('معدل الجاهزية العامة للمنصة', 'Taux Global de Préparation', 'Overall Readiness Score') }}</span>
                <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400 mt-2 block">{{ $readinessSummary['average_score'] }}%</span>
            </div>
            <div class="glass-card dark:bg-slate-800 dark:border-slate-700 rounded-3xl p-6">
                <span class="text-xs font-bold text-brand-muted dark:text-slate-400 block uppercase">{{ $t('المشاركون الجاهزون تماماً', 'Participants Prêts', 'Fully Ready Participants') }}</span>
                <span class="text-3xl font-black text-brand-dark dark:text-white mt-2 block">{{ $readinessSummary['ready_count'] }}</span>
            </div>
            <div class="glass-card dark:bg-slate-800 dark:border-slate-700 rounded-3xl p-6">
                <span class="text-xs font-bold text-brand-muted dark:text-slate-400 block uppercase">{{ $t('المشاركون قيد استكمال الملفات', 'En Cours de Complétion', 'Pending Completion') }}</span>
                <span class="text-3xl font-black text-amber-600 dark:text-amber-400 mt-2 block">{{ $readinessSummary['pending_count'] }}</span>
            </div>
        </div>

    </div>
</div>
