@php
$locale = app()->getLocale();
$dir = $locale === 'ar' ? 'rtl' : 'ltr';
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-8 font-sans text-slate-900 dark:text-white" dir="{{ $dir }}">
    
    <!-- Top Sovereign Header -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0A3580] p-8 border-2 border-amber-400/40 shadow-xl text-white">
        <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-sky-400/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/20 border border-amber-400/40 text-amber-300 text-xs font-black">
                    <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    <span>{{ $t('مركز القيادة اللوجستية والوصول', 'Centre de Commandement Logistique & Arrivées', 'Logistics Command & Arrivals Control') }}</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-black text-white tracking-tight">
                    {{ $t('لوحة التحكم الإستراتيجية لمواعيد وصول الوفود وتذاكر الطيران', 'Tableau de Bord Stratégique des Arrivées et Billets d\'Avion', 'Strategic Dashboard for Delegation Arrivals & Flight Tickets') }}
                </h1>
                <p class="text-slate-300 text-xs sm:text-sm max-w-2xl">
                    {{ $t('المعاينة المباشرة لتذاكر الطيران (PDF / الصورة) بقاعدة البيانات، وتخصيص الحافلات اللوجستية بمطار الهواري بومدين والمطارات الوطنية', 'Inspection en direct des billets d\'avion (PDF/Image) et attribution des navettes VIP aux aéroports nationaux', 'Direct in-platform flight ticket inspection (PDF/Image) and VIP shuttle bus dispatch across national airports') }}
                </p>
            </div>
            
            <div class="shrink-0 flex items-center gap-3">
                <img src="/LOGO01.png" alt="State Seal" class="h-16 w-auto object-contain filter drop-shadow-md">
                <img src="/logo.svg" alt="WorldSkills Logo" class="h-12 w-auto filter brightness-0 invert">
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-800 text-emerald-900 dark:text-emerald-200 text-xs font-bold flex items-center gap-3 shadow-md">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    <!-- Key Statistics Metric Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        
        <div class="p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-400 block">{{ $t('إجمالي الوفود المسجلة', 'Total Délégations', 'Total Delegations') }}</span>
                <span class="text-3xl font-black text-slate-900 dark:text-white font-mono">{{ $totalArrivalsCount }}</span>
                <span class="text-[10px] text-blue-600 dark:text-sky-400 block font-bold">{{ $t('رحلات جوية مؤكدة', 'Vols confirmés', 'Confirmed Flights') }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-blue-50 dark:bg-blue-950/60 border border-blue-200 dark:border-blue-800 flex items-center justify-center text-blue-700 dark:text-sky-300 text-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-400 block">{{ $t('مجموع المسافرين القادمين', 'Total Passagers', 'Total Passengers') }}</span>
                <span class="text-3xl font-black text-amber-600 dark:text-amber-300 font-mono">{{ $totalDelegatesCount }}</span>
                <span class="text-[10px] text-amber-700 dark:text-amber-400 block font-bold">{{ $t('عضو وفد إفريقي معتمد', 'Membres accrédités', 'Accredited Delegates') }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 flex items-center justify-center text-amber-700 dark:text-amber-300 text-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5 5 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-400 block">{{ $t('تذاكر قيد المعاينة والمراجعة', 'Billets en Attente', 'Pending Tickets') }}</span>
                <span class="text-3xl font-black text-amber-600 dark:text-amber-400 font-mono">{{ $pendingCount }}</span>
                <span class="text-[10px] text-amber-700 dark:text-amber-400 block font-bold">{{ $t('تتطلب تدقيق المسح', 'Requièrent vérification', 'Requires Verification') }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-amber-50 dark:bg-amber-950/60 border border-amber-200 dark:border-amber-800 flex items-center justify-center text-amber-700 dark:text-amber-400 text-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>

        <div class="p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md flex items-center justify-between">
            <div class="space-y-1">
                <span class="text-xs font-bold text-slate-400 dark:text-slate-400 block">{{ $t('الاستقبالات المعتمدة اللوجستية', 'Accueil Approuvé', 'Approved Pickups') }}</span>
                <span class="text-3xl font-black text-emerald-600 dark:text-emerald-400 font-mono">{{ $approvedCount }}</span>
                <span class="text-[10px] text-emerald-700 dark:text-emerald-400 block font-bold">{{ $t('تم تخصيص حافلات VIP', 'Navettes assignées', 'VIP Shuttles Assigned') }}</span>
            </div>
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 flex items-center justify-center text-emerald-700 dark:text-emerald-300 text-2xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
            </div>
        </div>

    </div>

    <!-- Filters & Search Toolbar -->
    <div class="p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 shadow-md flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="w-full md:w-96 relative">
            <input type="text" wire:model.live="search" placeholder="{{ $t('بحث باسم الدولة، رقم الرحلة، أو الشركة...', 'Rechercher par pays, vol, compagnie...', 'Search by country, flight, airline...') }}" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:ring-2 focus:ring-blue-500 outline-none">
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto">
            <select wire:model.live="statusFilter" class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl px-4 py-3 text-xs text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none font-bold">
                <option value="ALL">{{ $t('جميع الحالات', 'Tous les statuts', 'All Statuses') }}</option>
                <option value="PENDING">{{ $t('قيد المراجعة والمعاينة', 'En Attente', 'Pending Review') }}</option>
                <option value="APPROVED">{{ $t('معتمدة ومخصص لها الاستقبال', 'Approuvé & Assigné', 'Approved & Assigned') }}</option>
            </select>
        </div>
    </div>

    <!-- Arrivals Table & Interactive In-Platform Ticket Preview -->
    <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-3xl shadow-md overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
            <h2 class="text-lg font-extrabold text-[#06205C] dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600 dark:text-sky-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span>{{ $t('جدول وصول الوفود والمعاينة الفورية لتذاكر الطيران', 'Registre des Arrivées & Billets d\'Avion', 'Delegation Arrivals & Ticket Inspection Register') }}</span>
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs text-slate-700 dark:text-slate-300">
                <thead class="bg-slate-50 dark:bg-slate-900/90 text-slate-600 dark:text-slate-400 uppercase font-mono border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="py-4 px-6 text-start">{{ $t('الدولة والوفد', 'Pays & Délégation', 'Country & Delegation') }}</th>
                        <th class="py-4 px-6 text-start">{{ $t('شركة الطيران والرحلة', 'Compagnie & Vol', 'Airline & Flight') }}</th>
                        <th class="py-4 px-6 text-start">{{ $t('تاريخ ووقت الوصول', 'Date & Heure d\'Arrivée', 'Arrival Date & Time') }}</th>
                        <th class="py-4 px-6 text-start">{{ $t('عدد الركاب', 'Passagers', 'Passengers') }}</th>
                        <th class="py-4 px-6 text-start">{{ $t('مطار الوصول', 'Aéroport', 'Airport') }}</th>
                        <th class="py-4 px-6 text-center">{{ $t('معاينة تذكرة الطيران', 'Aperçu du Billet', 'Ticket Inspection') }}</th>
                        <th class="py-4 px-6 text-center">{{ $t('حالة الاستقبال', 'Statut Accueil', 'Status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                    @forelse ($arrivals as $item)
                        @php
                            $cName = $item->country ? ($locale === 'fr' ? ($item->country->name_fr ?? $item->country->name_en) : ($locale === 'en' ? $item->country->name_en : $item->country->name_ar)) : 'الجزائر';
                            $cCode = $item->country->code ?? 'DZA';
                        @endphp
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/40 transition">
                            <td class="py-4 px-6 font-bold">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-900 font-mono font-black flex items-center justify-center text-xs">
                                        {{ $cCode }}
                                    </div>
                                    <div>
                                        <span class="font-extrabold text-slate-900 dark:text-white text-sm block">{{ $cName }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-4 px-6 font-bold">
                                <span class="text-slate-900 dark:text-white block">{{ $item->airline_name }}</span>
                                <span class="font-mono text-[11px] text-blue-700 dark:text-sky-300">{{ $item->flight_number }}</span>
                            </td>

                            <td class="py-4 px-6 font-mono font-bold text-slate-900 dark:text-white">
                                {{ $item->arrival_date }} — {{ $item->arrival_time }}
                            </td>

                            <td class="py-4 px-6 font-bold text-[#06205C] dark:text-amber-300">
                                {{ $item->passenger_count }} {{ $t('شخص', 'personnes', 'delegates') }}
                            </td>

                            <td class="py-4 px-6 text-slate-600 dark:text-slate-400 font-medium">
                                {{ $item->arrival_airport }}
                            </td>

                            <td class="py-4 px-6 text-center">
                                @if($item->ticket_filename)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl bg-blue-50 dark:bg-blue-950 text-blue-700 dark:text-blue-200 border border-blue-200 text-xs font-bold">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>{{ $item->ticket_filename }}</span>
                                    </span>
                                @else
                                    <span class="text-slate-400 italic text-[11px]">{{ $t('تذكرة افتراضية معتمدة', 'Billet virtuel', 'Virtual Ticket') }}</span>
                                @endif
                            </td>

                            <td class="py-4 px-6 text-center">
                                <span class="px-3 py-1 rounded-full text-xs font-black {{ $item->status === 'APPROVED' ? 'bg-emerald-50 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-200 border border-emerald-200' : 'bg-amber-50 dark:bg-amber-950 text-amber-800 dark:text-amber-200 border border-amber-200' }}">
                                    {{ $item->status === 'APPROVED' ? $t('تم اعتماد الاستقبال', 'Accueil Confirmé', 'Arrival Confirmed') : $t('جاري مراجعة اللوجستيك', 'En Cours', 'Processing') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-8 text-center text-slate-400 text-xs font-bold">
                                {{ $t('لا توجد بيانات وصول مسجلة حالياً', 'Aucune arrivée enregistrée', 'No arrivals recorded yet') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
