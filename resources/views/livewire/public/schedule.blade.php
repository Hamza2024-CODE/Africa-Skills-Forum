@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 text-[#0066FF] border border-blue-200 text-xs font-black">
                <svg class="w-4 h-4 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                <span>{{ $t('الرزنامة والجدول الزمني العام', 'Calendrier Général du Forum', 'General Forum Schedule') }}</span>
            </div>

            <h1 class="text-3xl sm:text-4xl font-black text-[#06205C]">
                {{ $t('جدول ومواعيد منتدى المهارات الإفريقية 2026', 'Programme & Agenda — Africa Skills Forum 2026', 'Official Agenda & Schedule — Africa Skills Forum 2026') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                {{ $t('تتبع المواعيد والبرنامج الزمني للقاءات، المحاضرات، الاجتماعات الرسمية، الجلسات رفيعة المستوى والندوات بمركز المؤتمرات CCO بوهران.', 'Suivez les étapes clés des rencontres, conférences, réunions officielles, sessions de haut niveau et séminaires au CCO d\'Oran.', 'Track the detailed schedule of encounters, lectures, official meetings, high-level sessions, and seminars at CCO Oran.') }}
            </p>
        </div>

        <!-- Timeline Forum Items -->
        <div class="max-w-4xl mx-auto space-y-6">
            
            {{-- Phase 1: High Level Sessions --}}
            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-[#F5A800] border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <span class="px-3 py-1 rounded-xl bg-amber-50 text-[#F5A800] font-extrabold text-[11px] border border-amber-200 inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                        <span>{{ $t('الجلسات رفيعة المستوى & الافتتاح', 'Sessions Haut Niveau & Ouverture', 'High-Level Policy Sessions & Opening') }}</span>
                    </span>
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ $t('الافتتاح الرسمي والجلسات الوزارية رفيعة المستوى', 'Ouverture Officielle & Sessions Ministérielles', 'Official Opening & High-Level Ministerial Panels') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('قاعة المؤتمرات الكبرى — مركز المؤتمرات محمد بن أحمد بوهران', 'Grand Amphithéâtre — CCO Oran', 'Main Auditorium — Mohamed Ben Ahmed Convention Center') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-[#06205C] bg-slate-50 px-4 py-2.5 rounded-2xl border border-slate-200 shrink-0">
                    15 - 16 {{ $t('سبتمبر', 'Septembre', 'September') }} 2026
                </div>
            </div>

            {{-- Phase 2: Assemblies & Delegation Meetings --}}
            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-[#0066FF] border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <span class="px-3 py-1 rounded-xl bg-blue-50 text-[#0066FF] font-extrabold text-[11px] border border-blue-200 inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h5m-5 0V9m0 4h.01M15 9h.01M15 13h.01M11 13h.01M11 17h.01M15 17h.01"/></svg>
                        <span>{{ $t('اجتماعات الوفود واللجان', 'Assemblées & Réunions Officielles', 'Assemblies & Official Meetings') }}</span>
                    </span>
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ $t('اجتماعات اللجان القارية ورؤساء الوفود المشاركة', 'Réunions des Commissions Continentales & Chefs de Délégations', 'Continental Commissions & Heads of Delegation Meetings') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('قاعات الاجتماعات الدبلوماسية ورؤساء الوفود CCO', 'Salles Délégués & Salons Diplomatiques CCO', 'Diplomatic & Delegation Meeting Rooms CCO') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-[#06205C] bg-slate-50 px-4 py-2.5 rounded-2xl border border-slate-200 shrink-0">
                    16 - 17 {{ $t('سبتمبر', 'Septembre', 'September') }} 2026
                </div>
            </div>

            {{-- Phase 3: Keynote Lectures --}}
            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-purple-500 border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <span class="px-3 py-1 rounded-xl bg-purple-50 text-purple-600 font-extrabold text-[11px] border border-purple-200 inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 100-6 3 3 0 000 6z"/></svg>
                        <span>{{ $t('محاضرات وعروض علمية', 'Conférences & Présentations', 'Lectures & Scientific Presentations') }}</span>
                    </span>
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ $t('محاضرات التمكين المهني والتكنولوجيا واقتصاد المعرفة', 'Conférences sur le Développement des Compétences & Technologies', 'Keynote Lectures on Vocational Skills & Knowledge Economy') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('جناح المحاضرات والابتكار CCO', 'Pavillon des Conférences & Innovation CCO', 'Conference & Innovation Pavilion CCO') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-[#06205C] bg-slate-50 px-4 py-2.5 rounded-2xl border border-slate-200 shrink-0">
                    17 {{ $t('سبتمبر', 'Septembre', 'September') }} 2026
                </div>
            </div>

            {{-- Phase 4: Seminars & Symposia --}}
            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-sky-500 border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <span class="px-3 py-1 rounded-xl bg-sky-50 text-sky-600 font-extrabold text-[11px] border border-sky-200 inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>{{ $t('ندوات وورشات العمل', 'Séminaires & Ateliers Pratiques', 'Seminars & Specialized Workshops') }}</span>
                    </span>
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ $t('ندوات قارية تخصصية وورشات الاستثمار في العنصر البشري', 'Séminaires Continentaux & Ateliers de Formation', 'Continental Seminars & Human Capital Workshops') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('قاعات الورشات والندوات الفرعية CCO', 'Salles d\'Ateliers & Séminaires CCO', 'Workshop & Seminar Rooms CCO') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-[#06205C] bg-slate-50 px-4 py-2.5 rounded-2xl border border-slate-200 shrink-0">
                    18 {{ $t('سبتمبر', 'Septembre', 'September') }} 2026
                </div>
            </div>

            {{-- Phase 5: Bilateral Meetings & B2B --}}
            <div class="bg-white rounded-3xl p-6 border-r-4 border-r-emerald-500 border-t border-b border-l border-slate-200/80 shadow-md hover:shadow-lg transition flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="space-y-1.5">
                    <span class="px-3 py-1 rounded-xl bg-emerald-50 text-emerald-600 font-extrabold text-[11px] border border-emerald-200 inline-flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span>{{ $t('لقاءات ثنائية وشراكات B2B', 'Rencontres Biliaires & Partenariats B2B', 'Bilateral Meetings & B2B Partnerships') }}</span>
                    </span>
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ $t('اللقاءات الثنائية وتوقيع اتفاقيات التعاون القاري', 'Rencontres Bilatérales & Signature d\'Accords', 'Bilateral Encounters & Continental Partnership Agreements') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('الصالون الرئاسي وصالونات اللقاءات الثنائية CCO', 'Salon Présidentiel & Salons B2B CCO', 'Presidential Lounge & B2B Business Lounges CCO') }}
                    </p>
                </div>
                <div class="font-mono text-xs font-bold text-[#06205C] bg-slate-50 px-4 py-2.5 rounded-2xl border border-slate-200 shrink-0">
                    18 - 19 {{ $t('سبتمبر', 'Septembre', 'September') }} 2026
                </div>
            </div>

        </div>
    </div>
</div>
