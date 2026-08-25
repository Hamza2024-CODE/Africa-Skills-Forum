<div class="space-y-6 pb-12">

    <!-- ════════════════════════════════════════════════════════════════════════════════════
         1. AFRICAN UNION EXECUTIVE COMMISSION HEADER BANNER (Pristine Glassmorphic Gold/Green Theme)
         ════════════════════════════════════════════════════════════════════════════════════ -->
    <div class="relative bg-gradient-to-br from-[#004D25] via-[#006837] to-[#052D48] text-white rounded-3xl p-6 sm:p-8 shadow-2xl overflow-hidden border border-amber-400/30">
        <!-- Background Ambient Gold Lighting -->
        <div class="absolute -top-24 -left-24 w-80 h-80 bg-amber-400/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -right-24 w-80 h-80 bg-emerald-400/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6">
            
            <!-- Left Info Block -->
            <div class="space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-black/40 backdrop-blur-md border border-amber-400/40 text-amber-300 text-xs font-black">
                    <span class="w-2.5 h-2.5 rounded-full bg-amber-400 animate-ping"></span>
                    <span>{{ app()->getLocale() === 'fr' ? 'COMMISSION DE L\'UNION AFRICAINE' : (app()->getLocale() === 'en' ? 'AFRICAN UNION EXECUTIVE COMMISSION' : 'مفوضية الاتحاد الأفريقي — المقر التنفيذي للمراقبة') }}</span>
                </div>

                <h1 class="text-2xl sm:text-4xl font-black tracking-tight text-white flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-amber-400/20 border border-amber-400/40 text-amber-300 flex items-center justify-center font-mono font-black shrink-0 shadow-lg">
                        AU
                    </div>
                    <span>{{ app()->getLocale() === 'fr' ? 'Plateforme d\'Accréditation & Suivi des Délégations' : (app()->getLocale() === 'en' ? 'AU Accreditations & Delegations Command Portal' : 'منصة متابعة الاعتمادات والوفود الإفريقية الرسمية') }}</span>
                </h1>

                <p class="text-xs sm:text-sm text-emerald-100/90 max-w-3xl font-medium leading-relaxed">
                    {{ app()->getLocale() === 'fr' 
                        ? 'Espace de supervision et de contrôle de la Commission de l\'Union Africaine pour le Forum des Politiques Africaines des Compétences 2026.' 
                        : (app()->getLocale() === 'en' 
                            ? 'Executive monitoring dashboard for the African Union Commission for African Skills Policy Forum 2026.' 
                            : 'البوابة التنفيذية لمفوضية الاتحاد الأفريقي لمتابعة كشوفات الوفود الرسمية، بطاقات الاعتماد، والمناطق الأمنية وتذاكر الطيران في منتدى السياسات الأفريقية للمهارات 2026.') }}
                </p>
            </div>

            <!-- Right Status Badge & Account Info -->
            <div class="flex flex-col items-start lg:items-end justify-center gap-2 shrink-0 bg-black/30 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                <div class="text-[11px] text-amber-300 font-extrabold flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>africaunion@africaskill.DZ</span>
                </div>
                <div class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 border border-emerald-500/40 text-[10px] font-black uppercase tracking-wider">
                    🔒 {{ app()->getLocale() === 'fr' ? 'Accès Observation Restreint (Lecture Seule)' : (app()->getLocale() === 'en' ? 'Strict Executive Read-Only Access' : 'صلاحيات مراقبة تنفيذية مقيدة (عرض فقط)') }}
                </div>
            </div>

        </div>
    </div>


    <!-- ════════════════════════════════════════════════════════════════════════════════════
         2. HIGH-LEVEL EXECUTIVE METRICS GRID
         ════════════════════════════════════════════════════════════════════════════════════ -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
        
        <!-- KPI 1: African Countries -->
        <div class="bg-white dark:bg-[#031826] p-5 rounded-3xl border border-slate-200 dark:border-[#24BDC3]/30 shadow-md space-y-2 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-wide">{{ app()->getLocale() === 'fr' ? 'Pays Africains' : (app()->getLocale() === 'en' ? 'African Nations' : 'الدول الإفريقية') }}</span>
                <div class="w-8 h-8 rounded-xl bg-amber-100 dark:bg-amber-950/60 text-amber-600 dark:text-amber-300 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 012 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V14m-3 7c9 0 9-9 9-9s-9 0-9 9z"/></svg>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-[#006837] dark:text-amber-400 font-mono">
                {{ $totalCountries }}
            </div>
            <div class="text-[10px] text-slate-400 font-bold">
                {{ app()->getLocale() === 'fr' ? 'Délégations officielles enregistrées' : (app()->getLocale() === 'en' ? 'Registered Member States' : 'دول إفريقية مشاركة بوفود رسمية') }}
            </div>
        </div>

        <!-- KPI 2: Total Accredited Participants -->
        <div class="bg-white dark:bg-[#031826] p-5 rounded-3xl border border-slate-200 dark:border-[#24BDC3]/30 shadow-md space-y-2 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-wide">{{ app()->getLocale() === 'fr' ? 'المشاركين المسجلين' : (app()->getLocale() === 'en' ? 'Total Delegates' : 'إجمالي المشاركين') }}</span>
                <div class="w-8 h-8 rounded-xl bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-300 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-[#052D48] dark:text-teal-300 font-mono">
                {{ $totalParticipants }}
            </div>
            <div class="text-[10px] text-slate-400 font-bold">
                {{ app()->getLocale() === 'fr' ? 'Demandes d\'accréditation reçues' : (app()->getLocale() === 'en' ? 'Total Accreditation Applications' : 'إجمالي طلبات التسجيل والاعتماد') }}
            </div>
        </div>

        <!-- KPI 3: Ministerial & Diplomatic Delegations -->
        <div class="bg-white dark:bg-[#031826] p-5 rounded-3xl border border-slate-200 dark:border-[#24BDC3]/30 shadow-md space-y-2 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-wide">{{ app()->getLocale() === 'fr' ? 'Délégations الوزارية' : (app()->getLocale() === 'en' ? 'Ministerial & VIPs' : 'الوفود الوزارية والدبلوماسية') }}</span>
                <div class="w-8 h-8 rounded-xl bg-blue-100 dark:bg-blue-950/60 text-blue-600 dark:text-blue-300 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-purple-600 dark:text-purple-300 font-mono">
                {{ $ministerialCount }}
            </div>
            <div class="text-[10px] text-slate-400 font-bold">
                {{ app()->getLocale() === 'fr' ? 'Ministres, Ambassadeurs & VIP' : (app()->getLocale() === 'en' ? 'Ministers, Ambassadors & VIPs' : 'وزراء، سفراء، ومسؤولين رفيعين') }}
            </div>
        </div>

        <!-- KPI 4: Issued Accreditation Badges -->
        <div class="bg-white dark:bg-[#031826] p-5 rounded-3xl border border-slate-200 dark:border-[#24BDC3]/30 shadow-md space-y-2 hover:shadow-lg transition">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-wide">{{ app()->getLocale() === 'fr' ? 'Badges Validés' : (app()->getLocale() === 'en' ? 'Badges Approved' : 'البطاقات المعتمدة') }}</span>
                <div class="w-8 h-8 rounded-xl bg-teal-100 dark:bg-teal-950/60 text-teal-600 dark:text-teal-300 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-emerald-600 dark:text-emerald-300 font-mono">
                {{ $badgesApproved }}
            </div>
            <div class="text-[10px] text-slate-400 font-bold">
                {{ app()->getLocale() === 'fr' ? 'Badges d\'accès imprimés et validés' : (app()->getLocale() === 'en' ? 'Approved & Printed Accreditations' : 'بطاقات سارية ومطبوعة بالرموز الأمنية') }}
            </div>
        </div>

        <!-- KPI 5: Flight & Travel Bookings -->
        <div class="bg-white dark:bg-[#031826] p-5 rounded-3xl border border-slate-200 dark:border-[#24BDC3]/30 shadow-md space-y-2 hover:shadow-lg transition col-span-2 sm:col-span-1">
            <div class="flex items-center justify-between">
                <span class="text-xs font-black text-slate-500 dark:text-slate-400 uppercase tracking-wide">{{ app()->getLocale() === 'fr' ? 'Billets de Vol' : (app()->getLocale() === 'en' ? 'Flight Bookings' : 'رحلات الطيران المسجلة') }}</span>
                <div class="w-8 h-8 rounded-xl bg-sky-100 dark:bg-sky-950/60 text-sky-600 dark:text-sky-300 flex items-center justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-sky-600 dark:text-sky-300 font-mono">
                {{ $totalFlights }}
            </div>
            <div class="text-[10px] text-slate-400 font-bold">
                {{ app()->getLocale() === 'fr' ? 'Dossiers de vol et arrivées' : (app()->getLocale() === 'en' ? 'Flight itineraries confirmed' : 'بيانات الرحلات والتذاكر الموثقة') }}
            </div>
        </div>

    </div>


    <!-- ════════════════════════════════════════════════════════════════════════════════════
         3. NAVIGATION TABS BAR
         ════════════════════════════════════════════════════════════════════════════════════ -->
    <div class="flex flex-wrap items-center gap-2 bg-white dark:bg-[#031826] p-2 rounded-2xl border border-slate-200 dark:border-[#24BDC3]/30 shadow-sm">
        
        <button wire:click="setTab('overview')" type="button" 
                class="px-4 py-2.5 rounded-xl text-xs font-black transition-all flex items-center gap-2 {{ $activeTab === 'overview' ? 'bg-[#006837] text-white shadow-md' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Aperçu Général' : (app()->getLocale() === 'en' ? 'Executive Overview' : 'نظرة عامة وإحصائيات') }}</span>
        </button>

        <button wire:click="setTab('nations')" type="button" 
                class="px-4 py-2.5 rounded-xl text-xs font-black transition-all flex items-center gap-2 {{ $activeTab === 'nations' ? 'bg-[#006837] text-white shadow-md' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 012 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V14m-3 7c9 0 9-9 9-9s-9 0-9 9z"/></svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Délégations Africaines' : (app()->getLocale() === 'en' ? 'African Member States' : 'الوفود والدول الإفريقية') }}</span>
        </button>

        <button wire:click="setTab('accreditations')" type="button" 
                class="px-4 py-2.5 rounded-xl text-xs font-black transition-all flex items-center gap-2 {{ $activeTab === 'accreditations' ? 'bg-[#006837] text-white shadow-md' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Sujets Accrédités' : (app()->getLocale() === 'en' ? 'Accreditation Master List' : 'جدول الاعتمادات الموحد') }}</span>
        </button>

        <button wire:click="setTab('zones')" type="button" 
                class="px-4 py-2.5 rounded-xl text-xs font-black transition-all flex items-center gap-2 {{ $activeTab === 'zones' ? 'bg-[#006837] text-white shadow-md' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Zones de Sécurité' : (app()->getLocale() === 'en' ? 'Security Zones Matrix' : 'المناطق الأمنية والبطاقات') }}</span>
        </button>

        <button wire:click="setTab('logistics')" type="button" 
                class="px-4 py-2.5 rounded-xl text-xs font-black transition-all flex items-center gap-2 {{ $activeTab === 'logistics' ? 'bg-[#006837] text-white shadow-md' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Logistique & Vols' : (app()->getLocale() === 'en' ? 'Flight & Logistics' : 'تذاكر الطيران واللوجستيك') }}</span>
        </button>

    </div>


    <!-- ════════════════════════════════════════════════════════════════════════════════════
         4. TAB 1: EXECUTIVE OVERVIEW
         ════════════════════════════════════════════════════════════════════════════════════ -->
    @if($activeTab === 'overview')
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            
            <!-- Left: Member States Participation Ranking -->
            <div class="lg:col-span-7 bg-white dark:bg-[#031826] p-6 rounded-3xl border border-slate-200 dark:border-[#24BDC3]/30 shadow-xl space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#006837]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 012 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V14m-3 7c9 0 9-9 9-9s-9 0-9 9z"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Participation des États Membres de l\'UA' : (app()->getLocale() === 'en' ? 'African Member States Delegations' : 'مشاركة الوفود والدول الإفريقية الأعضاء') }}</span>
                    </h3>
                    <span class="text-xs font-bold text-[#006837] bg-emerald-50 dark:bg-emerald-950/60 px-3 py-1 rounded-full border border-emerald-200">
                        {{ $africanCountries->count() }} {{ app()->getLocale() === 'fr' ? 'Pays enregistrés' : (app()->getLocale() === 'en' ? 'Nations' : 'دولة مسجلة') }}
                    </span>
                </div>

                <div class="space-y-3 max-h-96 overflow-y-auto pr-1">
                    @foreach($africanCountries->take(8) as $country)
                        <div class="p-3.5 rounded-2xl bg-slate-50 dark:bg-[#052D48]/60 border border-slate-200/80 dark:border-slate-800 flex items-center justify-between hover:bg-emerald-50/40 transition">
                            <div class="flex items-center gap-3">
                                @if($country->flag_path)
                                    <img src="{{ asset($country->flag_path) }}" alt="{{ $country->name_en }}" class="w-7 h-5 object-cover rounded shadow-xs">
                                @else
                                    <div class="w-7 h-5 rounded bg-slate-200 dark:bg-slate-700 font-mono text-[9px] flex items-center justify-center font-bold">
                                        {{ $country->iso_code_2 ?: 'AU' }}
                                    </div>
                                @endif
                                <div>
                                    <div class="text-xs font-black text-slate-800 dark:text-slate-200">
                                        {{ app()->getLocale() === 'fr' ? ($country->name_fr ?: $country->name_ar) : (app()->getLocale() === 'en' ? ($country->name_en ?: $country->name_ar) : $country->name_ar) }}
                                    </div>
                                    <div class="text-[10px] text-slate-400 font-bold">{{ $country->iso_code_3 ?: $country->code }}</div>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-3 py-1 rounded-full bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 font-mono font-black text-xs border border-emerald-300">
                                    {{ $country->registrations_count }} {{ app()->getLocale() === 'fr' ? 'Délégués' : (app()->getLocale() === 'en' ? 'Delegates' : 'مشاركين') }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right: AU Security Zones Executive Summary -->
            <div class="lg:col-span-5 bg-white dark:bg-[#031826] p-6 rounded-3xl border border-slate-200 dark:border-[#24BDC3]/30 shadow-xl space-y-4">
                <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                    <h3 class="text-base font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Périmètres de Sécurité Officiels' : (app()->getLocale() === 'en' ? 'Official Security Zones Summary' : 'ملخص المناطق والمراكز الأمنية') }}</span>
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ app()->getLocale() === 'fr' 
                            ? 'Niveaux d\'accès et badges de sécurité émis pour la Commission UA et les délégations.' 
                            : (app()->getLocale() === 'en' 
                                ? 'Security clearance levels and access permissions issued for AU Commission and delegations.' 
                                : 'مستويات الوصول والتصاريح الأمنية الصادرة لمفوضية الاتحاد الأفريقي والوفود الوزارية.') }}
                    </p>
                </div>

                <div class="space-y-3">
                    @foreach($securityZones as $zone)
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-[#052D48]/60 border border-slate-200/80 dark:border-slate-800 space-y-1">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-black text-slate-800 dark:text-slate-200 flex items-center gap-2">
                                    <span class="w-3 h-3 rounded-full" style="background-color: {{ $zone['badge_color'] }}"></span>
                                    <span>{{ $zone['code'] }} — {{ app()->getLocale() === 'fr' ? $zone['name_fr'] : (app()->getLocale() === 'en' ? $zone['name_en'] : $zone['name_ar']) }}</span>
                                </span>
                                <span class="px-2 py-0.5 rounded text-[10px] font-mono font-black text-white" style="background-color: {{ $zone['badge_color'] }}">
                                    {{ $zone['access_level'] }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    @endif


    <!-- ════════════════════════════════════════════════════════════════════════════════════
         5. TAB 2: AFRICAN MEMBER STATES & DELEGATIONS
         ════════════════════════════════════════════════════════════════════════════════════ -->
    @if($activeTab === 'nations')
        <div class="bg-white dark:bg-[#031826] p-6 rounded-3xl border border-slate-200 dark:border-[#24BDC3]/30 shadow-xl space-y-6">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-4">
                <div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#006837]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 012 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V14m-3 7c9 0 9-9 9-9s-9 0-9 9z"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Délégations & États Membres Africains' : (app()->getLocale() === 'en' ? 'African Member States & Registered Delegations' : 'كشف الوفود والدول الإفريقية المسجلة في المنتدى') }}</span>
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">{{ app()->getLocale() === 'fr' ? 'Liste complète des 54 États membres et effectifs des délégations.' : (app()->getLocale() === 'en' ? 'Complete list of 54 African Member States and accredited delegation counts.' : 'عرض جميع الدول الإفريقية وتعداد الوفود المعتمدة رسميًا لكل دولة.') }}</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($africanCountries as $country)
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-[#052D48]/60 border border-slate-200/80 dark:border-slate-800 space-y-3 hover:border-[#006837] transition group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                @if($country->flag_path)
                                    <img src="{{ asset($country->flag_path) }}" alt="{{ $country->name_en }}" class="w-8 h-6 object-cover rounded shadow-xs">
                                @else
                                    <div class="w-8 h-6 rounded bg-slate-200 dark:bg-slate-700 font-mono text-xs flex items-center justify-center font-bold">
                                        {{ $country->iso_code_2 ?: 'AU' }}
                                    </div>
                                @endif
                                <div>
                                    <h4 class="text-sm font-black text-slate-900 dark:text-white group-hover:text-[#006837] transition">
                                        {{ app()->getLocale() === 'fr' ? ($country->name_fr ?: $country->name_ar) : (app()->getLocale() === 'en' ? ($country->name_en ?: $country->name_ar) : $country->name_ar) }}
                                    </h4>
                                    <span class="text-[10px] text-slate-400 font-mono font-bold">{{ $country->iso_code_3 ?: $country->code }}</span>
                                </div>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-[#006837]/10 text-[#006837] dark:text-emerald-300 font-mono font-black text-xs border border-[#006837]/30">
                                {{ $country->registrations_count }} {{ app()->getLocale() === 'fr' ? 'Délégués' : (app()->getLocale() === 'en' ? 'Delegates' : 'مشارك') }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif


    <!-- ════════════════════════════════════════════════════════════════════════════════════
         6. TAB 3: UNIFIED ACCREDITATION MASTER TABLE
         ════════════════════════════════════════════════════════════════════════════════════ -->
    <!-- ════════════════════════════════════════════════════════════════════════════════════
         6. TAB 3: UNIFIED ACCREDITATION MASTER TABLE
         ════════════════════════════════════════════════════════════════════════════════════ -->
    @if($activeTab === 'accreditations')
        <div class="bg-white dark:bg-[#031826] p-6 rounded-3xl border border-slate-200 dark:border-[#24BDC3]/30 shadow-xl space-y-6">
            
            <!-- Filters & Search Toolbar -->
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 dark:border-slate-800 pb-4">
                <div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#006837]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Registre des Accréditations & Délégués' : (app()->getLocale() === 'en' ? 'Accreditation Master List & Delegates' : 'السجل الموحد لبطاقات الاعتماد والمسجلين') }}</span>
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">{{ app()->getLocale() === 'fr' ? 'Consultation officielle en lecture seule des badges d\'accréditation.' : (app()->getLocale() === 'en' ? 'Official read-only accreditation master register.' : 'عرض تفاصيل بطاقات الاعتماد والوفود الرسمية بدون صلاحية التعديل.') }}</p>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    <!-- Search Input -->
                    <div class="relative">
                        <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ app()->getLocale() === 'fr' ? 'Rechercher nom, badge, passeport...' : (app()->getLocale() === 'en' ? 'Search name, badge number, passport...' : 'بحث بالاسم، رقم التسجيل، الجواز...') }}" class="ps-9 pe-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white w-64">
                        <svg class="w-4 h-4 text-slate-400 absolute start-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <!-- Role Filter -->
                    <select wire:model.live="roleFilter" class="px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white">
                        <option value="ALL">{{ app()->getLocale() === 'fr' ? 'Tous les Rôles' : (app()->getLocale() === 'en' ? 'All Roles' : 'جميع الصفات والأدوار') }}</option>
                        <option value="VIP">{{ app()->getLocale() === 'fr' ? 'Ministres & VIP' : (app()->getLocale() === 'en' ? 'Ministers & VIPs' : 'وزراء وكبار الشخصيات (VIP)') }}</option>
                        <option value="DELEGATE_HEAD">{{ app()->getLocale() === 'fr' ? 'Chefs de Délégation' : (app()->getLocale() === 'en' ? 'Heads of Delegation' : 'رؤساء الوفود الرسمية') }}</option>
                        <option value="OFFICIAL">{{ app()->getLocale() === 'fr' ? 'Délégués Officiels' : (app()->getLocale() === 'en' ? 'Official Delegates' : 'أعضاء الوفود الرسمية') }}</option>
                        <option value="EXPERT">{{ app()->getLocale() === 'fr' ? 'Experts & Intervenants' : (app()->getLocale() === 'en' ? 'Experts & Speakers' : 'الخبراء والمحاضرين') }}</option>
                        <option value="PRESS">{{ app()->getLocale() === 'fr' ? 'Presse & Médias' : (app()->getLocale() === 'en' ? 'Press & Media' : 'الصحافة والإعلام') }}</option>
                    </select>
                </div>
            </div>

            <!-- Accreditations Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-start border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-800 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                            <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'fr' ? 'N° Accréditation' : (app()->getLocale() === 'en' ? 'Accreditation N°' : 'رقم الاعتماد') }}</th>
                            <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'fr' ? 'Nom & Prénom' : (app()->getLocale() === 'en' ? 'Full Name' : 'الاسم واللقب') }}</th>
                            <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'fr' ? 'Pays / Délégation' : (app()->getLocale() === 'en' ? 'Country / Delegation' : 'الدولة / الوفد') }}</th>
                            <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'fr' ? 'Qualité / Rôle' : (app()->getLocale() === 'en' ? 'Role / Status' : 'الصفة / الدور') }}</th>
                            <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'fr' ? 'Statut' : (app()->getLocale() === 'en' ? 'Status' : 'حالة الاعتماد') }}</th>
                            <th class="py-3 px-4 text-center">{{ app()->getLocale() === 'fr' ? 'Aperçu Badge' : (app()->getLocale() === 'en' ? 'Badge Preview' : 'المعاينة الرسمية') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs font-bold text-slate-700 dark:text-slate-300">
                        @forelse($accreditations as $reg)
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                                <td class="py-3.5 px-4 font-mono font-black text-[#006837] dark:text-amber-400">
                                    {{ $reg->registration_number ?: ('WSAP-' . $reg->id) }}
                                </td>
                                <td class="py-3.5 px-4 font-black text-slate-900 dark:text-white">
                                    {{ $reg->participant ? ($reg->participant->first_name_ar . ' ' . $reg->participant->last_name_ar) : ($reg->user->name ?? 'مشارك') }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <div class="flex items-center gap-2">
                                        @if($reg->country && $reg->country->flag_path)
                                            <img src="{{ asset($reg->country->flag_path) }}" alt="" class="w-5 h-3.5 object-cover rounded shadow-2xs">
                                        @endif
                                        <span>{{ $reg->country ? (app()->getLocale() === 'fr' ? ($reg->country->name_fr ?: $reg->country->name_ar) : (app()->getLocale() === 'en' ? ($reg->country->name_en ?: $reg->country->name_ar) : $reg->country->name_ar)) : 'الاتحاد الأفريقي' }}</span>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-blue-50 dark:bg-blue-950/60 text-blue-800 dark:text-blue-300 border border-blue-200">
                                        {{ $reg->job_title ?: ($reg->participant?->user?->roles?->first()?->name ?? 'عضو وفد رسمي') }}
                                    </span>
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($reg->status && (is_object($reg->status) ? $reg->status->value === 'APPROVED' : $reg->status === 'APPROVED'))
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200">
                                            {{ app()->getLocale() === 'fr' ? 'Accrédité Officiellement ✅' : (app()->getLocale() === 'en' ? 'Officially Accredited ✅' : 'معتمد رسميًا ✅') }}
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-50 dark:bg-amber-950/60 text-amber-700 dark:text-amber-300 border border-amber-200">
                                            {{ app()->getLocale() === 'fr' ? 'En Cours ⏳' : (app()->getLocale() === 'en' ? 'Pending Review ⏳' : 'قيد المراجعة ⏳') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <button wire:click="openBadgeModal({{ $reg->id }})" type="button" class="px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 hover:bg-[#006837] hover:text-white font-bold text-xs transition inline-flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>{{ app()->getLocale() === 'fr' ? 'Aperçu' : (app()->getLocale() === 'en' ? 'Preview' : 'معاينة البطاقة') }}</span>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 font-bold text-xs">
                                    {{ app()->getLocale() === 'fr' ? 'Aucun enregistrement ne correspond aux critères.' : (app()->getLocale() === 'en' ? 'No accreditations match the search criteria.' : 'لا توجد تسجيلات مطابقة لخيارات البحث.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Links -->
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800">
                {{ $accreditations->links() }}
            </div>
        </div>
    @endif


    <!-- ════════════════════════════════════════════════════════════════════════════════════
         7. TAB 4: SECURITY ZONES MATRIX
         ════════════════════════════════════════════════════════════════════════════════════ -->
    @if($activeTab === 'zones')
        <div class="bg-white dark:bg-[#031826] p-6 rounded-3xl border border-slate-200 dark:border-[#24BDC3]/30 shadow-xl space-y-6">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                <h3 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Matrice des Zones de Sécurité & Accès' : (app()->getLocale() === 'en' ? 'Security Access Zones & Badges Matrix' : 'مصفوفة المناطق الأمنية وتصاريح الدخول للمركز') }}</span>
                </h3>
                <p class="text-xs text-slate-500 font-medium">{{ app()->getLocale() === 'fr' ? 'Système officiel d\'accréditation des zones pour le Forum 2026.' : (app()->getLocale() === 'en' ? 'Official security clearance levels for African Skills Policy Forum 2026.' : 'نظام التصاريح الأمنية الصادر لفعاليات وأعمال منتدى السياسات الأفريقية للمهارات 2026.') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($securityZones as $zone)
                    <div class="p-5 rounded-3xl bg-slate-50 dark:bg-[#052D48]/60 border-2 border-slate-200 dark:border-slate-800 space-y-4 shadow-sm hover:shadow-md transition">
                        
                        <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 pb-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-4 h-4 rounded-full shadow-xs" style="background-color: {{ $zone['badge_color'] }}"></div>
                                <span class="font-mono font-black text-sm text-slate-900 dark:text-white">{{ $zone['code'] }}</span>
                            </div>
                            <span class="px-3 py-1 rounded-full text-[10px] font-mono font-black text-white shadow-xs" style="background-color: {{ $zone['badge_color'] }}">
                                {{ $zone['access_level'] }}
                            </span>
                        </div>

                        <div class="space-y-1">
                            <h4 class="text-sm font-black text-slate-900 dark:text-white">
                                {{ app()->getLocale() === 'fr' ? $zone['name_fr'] : (app()->getLocale() === 'en' ? $zone['name_en'] : $zone['name_ar']) }}
                            </h4>
                        </div>

                        <div class="space-y-2 pt-2 border-t border-slate-200/60 dark:border-slate-800">
                            <div class="text-[11px] font-bold text-slate-500 uppercase tracking-wider">
                                {{ app()->getLocale() === 'fr' ? 'Catégories Autorisées:' : (app()->getLocale() === 'en' ? 'Authorized Categories:' : 'الفئات المصرح لها بالدخول:') }}
                            </div>
                            <div class="flex flex-wrap gap-1.5">
                                @php
                                    $rolesList = app()->getLocale() === 'fr' ? ($zone['allowed_roles_fr'] ?? $zone['allowed_roles_ar']) : (app()->getLocale() === 'en' ? ($zone['allowed_roles_en'] ?? $zone['allowed_roles_ar']) : $zone['allowed_roles_ar']);
                                @endphp
                                @foreach($rolesList as $roleName)
                                    <span class="px-2.5 py-1 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-[11px] font-bold text-slate-700 dark:text-slate-200">
                                        {{ $roleName }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    @endif


    <!-- ════════════════════════════════════════════════════════════════════════════════════
         8. TAB 5: FLIGHT TICKETS & LOGISTICS
         ════════════════════════════════════════════════════════════════════════════════════ -->
    @if($activeTab === 'logistics')
        <div class="bg-white dark:bg-[#031826] p-6 rounded-3xl border border-slate-200 dark:border-[#24BDC3]/30 shadow-xl space-y-6">
            <div class="border-b border-slate-100 dark:border-slate-800 pb-4">
                <h3 class="text-lg font-black text-slate-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Vols & Logistique des Délégations Officielles ✈️' : (app()->getLocale() === 'en' ? 'Official Flight Itineraries & Logistics ✈️' : 'كشف تذاكر الطيران ومواعيد وصول الوفود الإفريقية الرسمية ✈️') }}</span>
                </h3>
                <p class="text-xs text-slate-500 font-medium">{{ app()->getLocale() === 'fr' ? 'Suivi en temps réel des horaires d\'arrivée des délégations.' : (app()->getLocale() === 'en' ? 'Real-time flight arrival itinerary for ministerial delegations.' : 'سجل رحلات الطيران وتأكيد المواعيد للوفود الوزارية والدبلوماسية.') }}</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-start border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-800 text-[11px] font-black uppercase text-slate-400 tracking-wider">
                            <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'fr' ? 'Pays / Délégation' : (app()->getLocale() === 'en' ? 'Country / Delegation' : 'الدولة / الوفد') }}</th>
                            <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'fr' ? 'N° de Vol ✈️' : (app()->getLocale() === 'en' ? 'Flight N° ✈️' : 'رقم الرحلة ✈️') }}</th>
                            <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'fr' ? 'Aéroport Départ / Arrivée' : (app()->getLocale() === 'en' ? 'Departure / Arrival Airport' : 'مطار المغادرة / الوصول') }}</th>
                            <th class="py-3 px-4 text-start">{{ app()->getLocale() === 'fr' ? 'Date & Heure d\'Arrivée' : (app()->getLocale() === 'en' ? 'Arrival Date & Time' : 'تاريخ ووقت الوصول') }}</th>
                            <th class="py-3 px-4 text-center">{{ app()->getLocale() === 'fr' ? 'Nombre de Passagers' : (app()->getLocale() === 'en' ? 'Delegates Count' : 'عدد أفراد الوفد') }}</th>
                            <th class="py-3 px-4 text-center">{{ app()->getLocale() === 'fr' ? 'Statut Réservation' : (app()->getLocale() === 'en' ? 'Booking Status' : 'حالة الحجز') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs font-bold text-slate-700 dark:text-slate-300">
                        @php $hasFlights = false; @endphp

                        @foreach($memberArrivals as $mem)
                            @php $hasFlights = true; @endphp
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                                <td class="py-3.5 px-4 font-black text-slate-900 dark:text-white">
                                    <div class="flex items-center gap-2">
                                        @if($mem->delegation?->country?->flag_path)
                                            <img src="{{ asset($mem->delegation->country->flag_path) }}" alt="" class="w-5 h-3.5 object-cover rounded shadow-2xs">
                                        @endif
                                        <div>
                                            <div>{{ $mem->first_name }} {{ $mem->last_name }}</div>
                                            <div class="text-[10px] text-slate-400 font-medium">{{ $mem->delegation?->country ? (app()->getLocale() === 'fr' ? ($mem->delegation->country->name_fr ?: $mem->delegation->country->name_ar) : (app()->getLocale() === 'en' ? ($mem->delegation->country->name_en ?: $mem->delegation->country->name_ar) : $mem->delegation->country->name_ar)) : 'وفد رسمي' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3.5 px-4 font-mono font-black text-sky-600 dark:text-sky-400">
                                    {{ $mem->arrival_flight ?: '-' }}
                                </td>
                                <td class="py-3.5 px-4">
                                    {{ $mem->departure_flight ?: 'Algiers Airport (ALG)' }}
                                </td>
                                <td class="py-3.5 px-4 font-mono">
                                    {{ $mem->arrival_date ? (is_string($mem->arrival_date) ? $mem->arrival_date : $mem->arrival_date->format('Y-m-d H:i')) : '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-mono font-black">
                                    1
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200">
                                        {{ app()->getLocale() === 'fr' ? 'Billet Confirmé ✈️' : (app()->getLocale() === 'en' ? 'Confirmed Ticket ✈️' : 'تذكرة مؤكدة ✈️') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                        @foreach($arrivals as $arr)
                            @php $hasFlights = true; @endphp
                            <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/40 transition">
                                <td class="py-3.5 px-4 font-black text-slate-900 dark:text-white">
                                    {{ $arr->country ? (app()->getLocale() === 'fr' ? ($arr->country->name_fr ?: $arr->country->name_ar) : (app()->getLocale() === 'en' ? ($arr->country->name_en ?: $arr->country->name_ar) : $arr->country->name_ar)) : (app()->getLocale() === 'fr' ? 'Délégation Officielle' : (app()->getLocale() === 'en' ? 'Official Delegation' : 'وفد رسمي')) }}
                                </td>
                                <td class="py-3.5 px-4 font-mono font-black text-sky-600 dark:text-sky-400">
                                    {{ $arr->flight_number ?: '-' }}
                                </td>
                                <td class="py-3.5 px-4">
                                    @if($arr->departure_city || $arr->arrival_city)
                                        {{ $arr->departure_city ?: '-' }} ➔ {{ $arr->arrival_city ?: '-' }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 font-mono">
                                    {{ $arr->arrival_date ? (is_string($arr->arrival_date) ? $arr->arrival_date : $arr->arrival_date->format('Y-m-d H:i')) : '-' }}
                                </td>
                                <td class="py-3.5 px-4 text-center font-mono font-black">
                                    {{ $arr->passengers_count ?: 1 }}
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200">
                                        {{ app()->getLocale() === 'fr' ? 'Billet Confirmé ✈️' : (app()->getLocale() === 'en' ? 'Confirmed Ticket ✈️' : 'تذكرة مؤكدة ✈️') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach

                        @if(!$hasFlights)
                            <tr>
                                <td colspan="6" class="py-8 text-center text-slate-400 font-bold text-xs">
                                    {{ app()->getLocale() === 'fr' ? 'Aucun vol enregistré dans la base de données actuellement.' : (app()->getLocale() === 'en' ? 'No flight itineraries recorded in database yet.' : 'لا توجد بيانات رحلات طيران موثقة في قاعدة البيانات حالياً.') }}
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    @endif


    <!-- ════════════════════════════════════════════════════════════════════════════════════
         9. OFFICIAL BADGE PREVIEW MODAL (READ-ONLY)
         ════════════════════════════════════════════════════════════════════════════════════ -->
    @if($showBadgeModal && $viewingRegistration)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-950/80 backdrop-blur-md">
            <div class="bg-white dark:bg-[#031826] rounded-3xl max-w-md w-full p-6 shadow-2xl border border-amber-400/40 space-y-6 relative">
                
                <button wire:click="closeBadgeModal" type="button" class="absolute top-4 end-4 text-slate-400 hover:text-slate-600 dark:hover:text-white p-1 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <!-- Modal Header -->
                <div class="text-center space-y-1">
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300 border border-emerald-200 text-[10px] font-black uppercase">
                        <span>{{ app()->getLocale() === 'fr' ? 'Badge d\'Accréditation Officiel — Aperçu Validé' : (app()->getLocale() === 'en' ? 'Official Accreditation Badge — Verified Preview' : 'بطاقة الاعتماد الرسمية للمنتدى — معاينة موثقة') }}</span>
                    </div>
                    <h3 class="text-lg font-black text-slate-900 dark:text-white">
                        {{ $viewingRegistration->participant ? ($viewingRegistration->participant->first_name_ar . ' ' . $viewingRegistration->participant->last_name_ar) : ($viewingRegistration->user->name ?? 'مشارك') }}
                    </h3>
                    <div class="text-xs font-mono font-black text-[#006837] dark:text-amber-400">
                        {{ $viewingRegistration->registration_number ?: ('WSAP-' . $viewingRegistration->id) }}
                    </div>
                </div>

                <!-- Badge Graphic Card Preview -->
                <div class="p-5 rounded-3xl bg-gradient-to-br from-[#004D25] to-[#052D48] text-white border-2 border-amber-400 shadow-xl space-y-4">
                    <div class="flex items-center justify-between border-b border-white/20 pb-3">
                        <div class="text-xs font-black text-amber-300">African Skills Policy Forum 2026</div>
                        <div class="w-6 h-6 rounded-lg bg-amber-400/20 text-amber-300 font-mono font-black text-[10px] flex items-center justify-center">AU</div>
                    </div>

                    <div class="space-y-1 text-center py-2">
                        <div class="text-base font-black text-white">{{ $viewingRegistration->participant ? ($viewingRegistration->participant->first_name_ar . ' ' . $viewingRegistration->participant->last_name_ar) : ($viewingRegistration->user->name ?? 'مشارك') }}</div>
                        <div class="text-xs font-bold text-amber-200">{{ $viewingRegistration->country ? (app()->getLocale() === 'fr' ? ($viewingRegistration->country->name_fr ?: $viewingRegistration->country->name_ar) : (app()->getLocale() === 'en' ? ($viewingRegistration->country->name_en ?: $viewingRegistration->country->name_ar) : $viewingRegistration->country->name_ar)) : (app()->getLocale() === 'fr' ? 'Commission de l\'Union Africaine' : (app()->getLocale() === 'en' ? 'African Union Commission' : 'مفوضية الاتحاد الأفريقي')) }}</div>
                        <div class="inline-block mt-2 px-4 py-1 rounded-full bg-amber-400 text-slate-950 font-black text-xs">
                            {{ $viewingRegistration->job_title ?: ($viewingRegistration->participant?->user?->roles?->first()?->name ?? 'عضو وفد رسمي') }}
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-white/20 text-[10px] font-mono text-emerald-200">
                        <span>Accredited: APPROVED</span>
                        <span>Security: ZONE 1, 2, 3</span>
                    </div>
                </div>

                <!-- Footer button -->
                <button wire:click="closeBadgeModal" type="button" class="w-full py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-bold text-xs hover:bg-slate-200 transition">
                    {{ app()->getLocale() === 'fr' ? 'Fermer la Fenêtre' : (app()->getLocale() === 'en' ? 'Close Window' : 'إغلاق النافذة') }}
                </button>
            </div>
        </div>
    @endif

</div>
