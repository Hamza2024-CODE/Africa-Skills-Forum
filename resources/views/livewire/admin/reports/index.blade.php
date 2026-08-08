<div class="space-y-6 pb-8">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 dark:border-slate-700 pb-5">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h1 class="text-2xl font-black text-slate-900 dark:text-slate-100">التقارير والإحصائيات الوطنية</h1>
            </div>
            <p class="text-sm font-medium text-slate-500 dark:text-slate-400">لوحة الإحصائيات التجميعية والتحليلات الرسمية لمنصة مهارات الجزائر</p>
        </div>
    </div>

    {{-- TOP KPI CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5 shadow-xs">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block mb-1">إجمالي طلبات التسجيل</span>
            <span class="text-3xl font-black text-slate-900 dark:text-slate-100 font-mono">{{ number_format($totalRegistrations) }}</span>
            <div class="flex items-center gap-2 mt-3 text-[11px]">
                <span class="text-emerald-600 dark:text-emerald-400 font-bold">{{ $approvedRegs }} مقبول</span>
                <span class="text-slate-300 dark:text-slate-600">•</span>
                <span class="text-amber-600 dark:text-amber-400 font-bold">{{ $pendingRegs }} قيد الدراسة</span>
            </div>
        </div>
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5 shadow-xs">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block mb-1">إجمالي الحسابات</span>
            <span class="text-3xl font-black text-blue-600 dark:text-blue-400 font-mono">{{ number_format($totalUsers) }}</span>
            <span class="text-xs font-medium text-slate-400 block mt-3">مستخدمين ومحكمين ومسؤولين</span>
        </div>
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5 shadow-xs">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block mb-1">التخصصات الأولمبية</span>
            <span class="text-3xl font-black text-purple-600 dark:text-purple-400 font-mono">{{ number_format($totalSkills) }}</span>
            <span class="text-xs font-medium text-slate-400 block mt-3">تخصص مهني معتمد</span>
        </div>
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-5 shadow-xs">
            <span class="text-xs font-bold text-slate-500 dark:text-slate-400 block mb-1">المؤسسات والمنظمات</span>
            <span class="text-3xl font-black text-cyan-600 dark:text-cyan-400 font-mono">{{ number_format($totalOrgs) }}</span>
            <span class="text-xs font-medium text-slate-400 block mt-3">مؤسسة تكوينية وجامعية</span>
        </div>
    </div>

    {{-- STATISTICAL BREAKDOWNS --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- TOP WILAYAS --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 space-y-4 shadow-xs">
            <h3 class="font-black text-base text-slate-900 dark:text-slate-100">أعلى الولايات تسجيلًا</h3>
            <div class="space-y-4">
                @forelse($topWilayas as $w)
                    @php
                        $pctW = $totalRegistrations > 0 ? min(100, (int) round(($w->registrations_count / $totalRegistrations) * 100)) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-bold text-slate-700 dark:text-slate-300">{{ sprintf('%02d', $w->code) }} — {{ $w->name_ar }}</span>
                            <span class="font-mono text-emerald-600 dark:text-emerald-400 font-bold">{{ $w->registrations_count }} تسجيل</span>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2 overflow-hidden">
                            <div class="bg-emerald-500 h-2 rounded-full transition-all duration-500" style="width: {{ $pctW }}%;"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-4">لا توجد بيانات تسجيلات بعد</p>
                @endforelse
            </div>
        </div>

        {{-- TOP SKILLS --}}
        <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 space-y-4 shadow-xs">
            <h3 class="font-black text-base text-slate-900 dark:text-slate-100">أعلى التخصصات إقبالاً</h3>
            <div class="space-y-4">
                @forelse($topSkills as $s)
                    @php
                        $pctS = $totalRegistrations > 0 ? min(100, (int) round(($s->registrations_count / $totalRegistrations) * 100)) : 0;
                    @endphp
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="font-bold text-slate-700 dark:text-slate-300">{{ $s->name_ar }}</span>
                            <span class="font-mono text-purple-600 dark:text-purple-400 font-bold">{{ $s->registrations_count }} متنافس</span>
                        </div>
                        <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-2 overflow-hidden">
                            <div class="bg-purple-500 h-2 rounded-full transition-all duration-500" style="width: {{ $pctS }}%;"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-4">لا توجد بيانات تخصصات بعد</p>
                @endforelse
            </div>
        </div>

    </div>

</div>
