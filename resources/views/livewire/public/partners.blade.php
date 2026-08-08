<div class="py-12 bg-[#F4F7FC]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <h1 class="text-3xl sm:text-4xl font-black text-[#06205C]">
                {{ app()->getLocale() === 'fr' ? 'Partenaires & Sponsors Officiels' : (app()->getLocale() === 'en' ? 'Official Partners & Sponsors' : 'الشركاء والجهات الراعية الرسمية') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Soutien institutionnel, industriel et technique pour le développement des compétences.' : (app()->getLocale() === 'en' ? 'Institutional, industrial and technical support for skill development.' : 'المؤسسات والهيئات الوطنية والشركاء الصناعيون الداعمون لتطوير الكفاءات الوطنية والتنافسية.') }}
            </p>
        </div>

        <!-- Animated Counters Overview for Partners -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
            <x-animated-counter :target="$stats['partners'] ?? 0" :label="app()->getLocale() === 'fr' ? 'Partenaires Stratégiques' : (app()->getLocale() === 'en' ? 'Strategic Partners' : 'الشركاء الاستراتيجيون')" :description="app()->getLocale() === 'fr' ? 'Accords & Conventions' : (app()->getLocale() === 'en' ? 'Agreements & Alliances' : 'الاتفاقيات والشراكات الفنية')" image="/logo.svg" color="text-brand-500" />
            <x-animated-counter :target="$stats['organizations'] ?? 0" :label="app()->getLocale() === 'fr' ? 'Établissements Partenaires' : (app()->getLocale() === 'en' ? 'Partner Institutes' : 'المؤسسات التدريبية')" :description="app()->getLocale() === 'fr' ? 'Centres d\'excellence' : (app()->getLocale() === 'en' ? 'Centers of Excellence' : 'مراكز التميز والتكوين')" color="text-brand-sky" />
            <x-animated-counter :target="$stats['skills'] ?? 0" :label="app()->getLocale() === 'fr' ? 'Métiers Sponsorisés' : (app()->getLocale() === 'en' ? 'Sponsored Skills' : 'المهن المدعومة')" :description="app()->getLocale() === 'fr' ? 'Toutes disciplines' : (app()->getLocale() === 'en' ? 'All Skill Sectors' : 'كافة القطاعات والتخصصات')" color="text-purple-600" />
            <x-animated-counter :target="$stats['countries'] ?? 0" :label="app()->getLocale() === 'fr' ? 'Pays Participants' : (app()->getLocale() === 'en' ? 'Participating Nations' : 'الدول المشاركة')" :description="app()->getLocale() === 'fr' ? 'Union Africaine' : (app()->getLocale() === 'en' ? 'African Union' : 'الاتحاد الإفريقي')" color="text-emerald-600" />
        </div>

        <!-- 1. FEATURED PARTNERS GRID -->
        <div class="space-y-6">
            <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                <h2 class="text-xl font-black text-[#06205C] flex items-center gap-2">
                    <svg class="w-6 h-6 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Partenaires Majeurs & Sponsors Stratégiques' : (app()->getLocale() === 'en' ? 'Major Partners & Strategic Sponsors' : 'الشركاء المميزون والرعاة الاستراتيجيون') }}</span>
                </h2>
                <span class="text-xs font-bold text-slate-400">{{ app()->getLocale() === 'fr' ? 'Mise à jour en temps réel' : (app()->getLocale() === 'en' ? 'Live Admin Sync' : 'تزامن مباشر مع لوحة الإدارة') }}</span>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($featuredPartners as $p)
                    @php $logoUrl = $p->logo_path ? asset($p->logo_path) : null; @endphp
                    <div class="bg-white rounded-3xl p-8 text-center border border-slate-200/80 shadow-lg hover:shadow-xl transition flex flex-col justify-between space-y-6 group">
                        <div class="space-y-4">
                            <!-- Logo container -->
                            <div class="w-24 h-24 rounded-2xl bg-slate-50 p-4 border border-slate-100 flex items-center justify-center mx-auto shadow-sm group-hover:scale-105 transition-transform overflow-hidden">
                                @if($logoUrl)
                                    <img src="{{ $logoUrl }}" alt="{{ $p->name_ar }}" class="max-h-full max-w-full object-contain">
                                @else
                                    <span class="font-black text-xl text-blue-600 uppercase tracking-tight">{{ $p->name_en ?: $p->name_ar }}</span>
                                @endif
                            </div>
                            <div class="space-y-1">
                                <h3 class="text-lg font-black text-[#06205C]">{{ $p->name_ar }}</h3>
                                <p class="text-xs text-brand-500 font-bold font-mono">{{ $p->name_fr ?: $p->name_en }}</p>
                            </div>
                            <p class="text-xs text-slate-500 leading-relaxed font-medium">
                                {{ $p->description_ar ?: 'راعي رسمي ومساهم استراتيجي في منافسات أولمبياد المهن الجزائرية 2026.' }}
                            </p>
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-bold text-slate-400">
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 font-mono text-[10px]">★ {{ $p->partner_type }}</span>
                            @if($p->website_url)
                                <a href="{{ $p->website_url }}" target="_blank" class="text-blue-600 hover:underline font-mono text-[10px]">{{ app()->getLocale() === 'fr' ? 'Visiter le site →' : (app()->getLocale() === 'en' ? 'Visit Website →' : 'زيارة الموقع ←') }}</a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-12 text-center text-slate-400 font-medium bg-white rounded-3xl border border-slate-200">
                        {{ app()->getLocale() === 'fr' ? 'Aucun partenaire majeur pour le moment.' : (app()->getLocale() === 'en' ? 'No featured partners at the moment.' : 'لا يوجد شركاء مميزون حالياً.') }}
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 2. BANNER GRID MATCHING USER REFERENCE IMAGE -->
        <div class="space-y-4 pt-6">
            <div class="text-center">
                <h3 class="text-lg font-black text-[#06205C] tracking-wide">{{ app()->getLocale() === 'fr' ? 'Partenaires & Sponsors' : (app()->getLocale() === 'en' ? 'Partners & Sponsors' : 'الشركاء والرعاة') }}</h3>
            </div>

            <div class="bg-white rounded-3xl border border-slate-200 shadow-md p-6 sm:p-8 flex flex-wrap items-center justify-center gap-8 sm:gap-12">
                @forelse($allPartners as $p)
                    @php $logoUrl = $p->logo_path ? asset($p->logo_path) : null; @endphp
                    <div class="flex items-center justify-center transition transform hover:scale-110 cursor-pointer py-2 px-3">
                        @if($logoUrl)
                            <img src="{{ $logoUrl }}" alt="{{ $p->name_ar }}" class="h-10 sm:h-12 w-auto object-contain filter grayscale hover:grayscale-0 transition duration-300">
                        @else
                            <span class="font-black text-lg sm:text-xl font-sans tracking-tight {{ match($loop->index % 5) {
                                0 => 'text-blue-600',
                                1 => 'text-slate-700',
                                2 => 'text-teal-600',
                                3 => 'text-amber-500',
                                default => 'text-rose-600'
                            } }}">
                                {{ $p->name_en ?: $p->name_ar }}
                            </span>
                        @endif
                    </div>
                @empty
                    <div class="text-xs text-slate-400 font-bold">{{ app()->getLocale() === 'fr' ? 'Aucun partenaire enregistré.' : (app()->getLocale() === 'en' ? 'No partners registered.' : 'لا يوجد شركاء مسجلين.') }}</div>
                @endforelse
            </div>
        </div>

    </div>
</div>
