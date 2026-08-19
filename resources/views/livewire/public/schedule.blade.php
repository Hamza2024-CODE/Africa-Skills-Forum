@php
$locale = app()->getLocale();
$t = function($ar, $fr, $en) use ($locale) { return match($locale) { 'fr' => $fr, 'en' => $en, default => $ar }; };
@endphp

<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 text-[#0B2A6F] border border-blue-200 text-xs font-black">
                <svg class="w-4 h-4 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ $t('الرزنامة والجدول الزمني العام للمنتدى', 'Calendrier Général du Forum', 'Official Forum Working Programme') }}</span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-black text-[#0B2A6F]">
                {{ $t('برنامج وأجندة منتدى السياسات الأفريقية للمهارات 2026', 'Programme & Agenda — Forum des Politiques Africaines des Compétences 2026', 'Official Working Programme — Africa Skills Policy Forum 2026') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                {{ $t('تتبع التسلسل الإجرائي ومواعيد الجلسات الوزارية، اعتماد الإعلان المشترك، الجلسات التخصصية، وحفل الاختتام بمركز المؤتمرات CCO بوهران.', 'Suivez le déroulement officiel des sessions ministérielles, l\'adoption de la Déclaration Conjointe et les panneaux d\'experts au CCO d\'Oran.', 'Follow the detailed sequence of ministerial roundtables, joint declaration adoption, expert panels, and closing ceremony at CCO Oran.') }}
            </p>
        </div>

        <!-- Timeline Forum Items -->
        <div class="max-w-4xl mx-auto space-y-6">
            
            {{-- Stage 1: Reception & Pre-Forum Registration --}}
            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-blue-600 border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <span class="px-3 py-1 rounded-xl bg-blue-50 text-blue-700 font-extrabold text-[11px] border border-blue-200 inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>{{ $t('المرحلة التحضيرية & استقبال الوفود', 'Accueil des Délégations & Pré-Forum', 'Delegations Arrival & Registration') }}</span>
                    </span>
                    <h3 class="text-lg font-black text-[#0B2A6F]">
                        {{ $t('استقبال الوزراء والوفود الإفريقية والدولية المسجلة', 'Accueil des Ministres et Délégations Africaines', 'Reception of African Ministers & International Delegations') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('الصالون الدبلوماسي وقاعة الاستقبال — مركز المؤتمرات محمد بن أحمد بوهران', 'Salons Diplomatiques — CCO Oran', 'Diplomatic Lounges — Mohamed Ben Ahmed Convention Center') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-[#0B2A6F] bg-slate-50 px-4 py-2.5 rounded-2xl border border-slate-200 shrink-0">
                    16 {{ $t('نوفمبر', 'Novembre', 'November') }} 2026
                </div>
            </div>

            {{-- Stage 2: Opening Ceremony --}}
            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-[#35A536] border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <span class="px-3 py-1 rounded-xl bg-emerald-50 text-[#35A536] font-extrabold text-[11px] border border-emerald-200 inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>{{ $t('حفل الافتتاح الرسمي', 'Cérémonie d\'Ouverture Officielle', 'Official Opening Ceremony') }}</span>
                    </span>
                    <h3 class="text-lg font-black text-[#0B2A6F]">
                        {{ $t('افتتاح منتدى السياسات الأفريقية للمهارات 2026 والكلمات الرسمية', 'Ouverture Officielle du Forum & Discours Ministériels', 'Official Forum Opening & Ministerial Keynote Addresses') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('القاعة الشرفية الكبرى CCO', 'Grand Amphithéâtre CCO', 'Main Plenary Hall CCO') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-[#35A536] bg-emerald-50 px-4 py-2.5 rounded-2xl border border-emerald-200 shrink-0">
                    17 {{ $t('نوفمبر', 'Novembre', 'November') }} 2026 — 09:00
                </div>
            </div>

            {{-- Stage 3: Ministerial Roundtable --}}
            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-[#F5A800] border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <span class="px-3 py-1 rounded-xl bg-amber-50 text-[#F5A800] font-extrabold text-[11px] border border-amber-200 inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        <span>{{ $t('المائدة المستديرة الوزارية (2 جلستان)', 'Tables Rondes Ministérielles (2 Sessions)', 'Ministerial Roundtable (2 Sessions)') }}</span>
                    </span>
                    <h3 class="text-lg font-black text-[#0B2A6F]">
                        {{ $t('جلسات الحوار الوزاري رفيع المستوى حول إصلاح سياسات التكوين والتمويل', 'Sessions de Dialogue Ministériel de Haut Niveau', 'High-Level Ministerial Dialogue on TVET Reform & Financing') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('قاعة الاجتماعات الوزارية القارية CCO', 'Amphithéâtre Ministériel CCO', 'Ministerial Conference Chamber CCO') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-[#F5A800] bg-amber-50 px-4 py-2.5 rounded-2xl border border-amber-200 shrink-0">
                    17 {{ $t('نوفمبر', 'Novembre', 'November') }} 2026 — 10:30
                </div>
            </div>

            {{-- Stage 4: Joint Declaration Adoption --}}
            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-purple-600 border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <span class="px-3 py-1 rounded-xl bg-purple-50 text-purple-700 font-extrabold text-[11px] border border-purple-200 inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $t('اعتماد الإعلان المشترك', 'Adoption de la Déclaration Conjointe', 'Joint Declaration Adoption') }}</span>
                    </span>
                    <h3 class="text-lg font-black text-[#0B2A6F]">
                        {{ $t('اعتماد إعلان مهارات المستقبل وتحديد الالتزامات القارية', 'Adoption Officielle de la Déclaration sur les Compétences de Demain', 'Official Adoption of Declaration on Skills for Tomorrow') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('القاعة الرئيسية للمؤتمرات CCO', 'Salle Principale des Déclarations CCO', 'Main Declaration Assembly CCO') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-purple-700 bg-purple-50 px-4 py-2.5 rounded-2xl border border-purple-200 shrink-0">
                    17 {{ $t('نوفمبر', 'Novembre', 'November') }} 2026 — 12:30
                </div>
            </div>

            {{-- Stage 5: Expert Panels (5+ High-Level Discussions) --}}
            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-sky-500 border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <span class="px-3 py-1 rounded-xl bg-sky-50 text-sky-600 font-extrabold text-[11px] border border-sky-200 inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <span>{{ $t('الجلسات التخصصية (+5 جلسات حوارية)', 'Panneaux d\'Experts (+5 Sessions)', 'Expert Panels (+5 High-Level Sessions)') }}</span>
                    </span>
                    <h3 class="text-lg font-black text-[#0B2A6F]">
                        {{ $t('جلسات النقاش حول الذكاء الاصطناعي، المهارات الخضراء، والتمويل بالتوازي', 'Sessions Thématiques: IA, Compétences Vertes & Financement', 'Thematic Panels: AI, Green Transition, & Financing') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('قاعات الجلسات التخصصية CCO', 'Salles de Panneaux Thématiques CCO', 'Thematic Panel Rooms CCO') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-sky-700 bg-sky-50 px-4 py-2.5 rounded-2xl border border-sky-200 shrink-0">
                    17 {{ $t('نوفمبر', 'Novembre', 'November') }} 2026 — 14:30
                </div>
            </div>

            {{-- Stage 6: Where Policy Meets Talent & Youth Capacity Building --}}
            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-teal-500 border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <span class="px-3 py-1 rounded-xl bg-teal-50 text-teal-700 font-extrabold text-[11px] border border-teal-200 inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span>{{ $t('حيث التلاقي بين السياسات والمواهب', 'Où les Politiques Rencontrent les Talents', 'Where Policy Meets Talent') }}</span>
                    </span>
                    <h3 class="text-lg font-black text-[#0B2A6F]">
                        {{ $t('برنامج بناء القدرات المخصص للشباب الأفريقي عبر 5 اختصاصات أولوية', 'Programme de Renforcement des Capacités des Jeunes Africains', 'Youth Capacity-Building Programme across 5 Priority Skills') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('جناح الابتكار وتطوير المهارات الشبابية CCO', 'Pavillon Innovation & Jeunesse CCO', 'Youth & Innovation Pavilion CCO') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-teal-700 bg-teal-50 px-4 py-2.5 rounded-2xl border border-teal-200 shrink-0">
                    17 {{ $t('نوفمبر', 'Novembre', 'November') }} 2026 — 16:30
                </div>
            </div>

            {{-- Stage 7: Closing Ceremony --}}
            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-rose-500 border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <span class="px-3 py-1 rounded-xl bg-rose-50 text-rose-600 font-extrabold text-[11px] border border-rose-200 inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        <span>{{ $t('حفل اختتام المنتدى', 'Cérémonie de Clôture du Forum', 'Forum Closing Ceremony') }}</span>
                    </span>
                    <h3 class="text-lg font-black text-[#0B2A6F]">
                        {{ $t('تلاوة توصيات المنتدى وحفل الاختتام الرسمي', 'Clôture Officielle du Forum & Recommandations', 'Official Forum Closing & Summary Recommendations') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('القاعة الشرفية الكبرى CCO', 'Grand Amphithéâtre CCO', 'Main Plenary Hall CCO') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-rose-700 bg-rose-50 px-4 py-2.5 rounded-2xl border border-rose-200 shrink-0">
                    17 {{ $t('نوفمبر', 'Novembre', 'November') }} 2026 — 17:30
                </div>
            </div>

        </div>
    </div>
</div>

