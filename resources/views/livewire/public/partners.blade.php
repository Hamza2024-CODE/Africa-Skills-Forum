<div class="py-12 bg-[#F4F7FC] min-h-screen">
    @if(!platform()->get('show_partners_section', true))
        <div class="py-24 text-center">
            <div class="max-w-md mx-auto bg-white p-8 rounded-3xl shadow-xl border border-slate-200 space-y-4">
                <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center mx-auto">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-black text-slate-900">
                    {{ app()->getLocale() === 'fr' ? 'Section temporairement indisponible' : (app()->getLocale() === 'en' ? 'Section Temporarily Unavailable' : 'صفحة وقسم الشركاء والرعاة غير متاحة حالياً') }}
                </h3>
                <p class="text-xs text-slate-500 font-bold">
                    {{ app()->getLocale() === 'fr' ? 'L\'accès à cette page a été désactivé par l\'administration.' : (app()->getLocale() === 'en' ? 'Access to this page has been disabled by site administration.' : 'تم تعطيل إظهار هذه الصفحة مؤقتاً عبر إعدادات لوحة التحكم.') }}
                </p>
                <div class="pt-2">
                    <a href="{{ route('home') }}" class="px-6 py-2.5 bg-[#0B2A6F] text-white rounded-xl text-xs font-black shadow-md hover:bg-blue-900 inline-block transition">
                        {{ app()->getLocale() === 'fr' ? 'Retour à l\'accueil' : (app()->getLocale() === 'en' ? 'Back to Home' : 'العودة للصفحة الرئيسية') }}
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
            
            <!-- Header -->
            <div class="text-center max-w-3xl mx-auto space-y-3">
                <h1 class="text-3xl sm:text-4xl font-black text-[#0B2A6F]">
                    {{ app()->getLocale() === 'fr' ? 'Partenaires & Sponsors Officiels' : (app()->getLocale() === 'en' ? 'Official Partners & Sponsors' : 'الشركاء والجهات الراعية الرسمية') }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                    {{ app()->getLocale() === 'fr' ? 'Soutien institutionnel, industriel et technique pour le développement des compétences.' : (app()->getLocale() === 'en' ? 'Institutional, industrial and technical support for skill development.' : 'المؤسسات والهيئات الوطنية والشركاء الصناعيون الداعمون لتطوير الكفاءات الوطنية والتنافسية.') }}
                </p>
            </div>

            <!-- Animated Counters Overview for Partners -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <x-animated-counter :target="$stats['partners'] ?? 0" :label="app()->getLocale() === 'fr' ? 'Partenaires Stratégiques' : (app()->getLocale() === 'en' ? 'Strategic Partners' : 'الشركاء الاستراتيجيون')" :description="app()->getLocale() === 'fr' ? 'Accords & Conventions' : (app()->getLocale() === 'en' ? 'Agreements & Alliances' : 'الاتفاقيات والشراكات الفنية')" icon='<svg class="w-6 h-6 text-[#0B2A6F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>' color="text-[#0B2A6F]" />
                <x-animated-counter :target="$stats['organizations'] ?? 0" :label="app()->getLocale() === 'fr' ? 'Établissements Partenaires' : (app()->getLocale() === 'en' ? 'Partner Institutes' : 'المؤسسات التدريبية')" :description="app()->getLocale() === 'fr' ? 'Centres d\'excellence' : (app()->getLocale() === 'en' ? 'Centers of Excellence' : 'مراكز التميز والتكوين')" icon='<svg class="w-6 h-6 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6m-6 0V10m6 11V10m-6 0a2 2 0 012-2h2a2 2 0 012 2m-6 0V6a2 2 0 012-2h2a2 2 0 012 2v4"/></svg>' color="text-[#35A536]" />
                <x-animated-counter :target="$stats['skills'] ?? 0" :label="app()->getLocale() === 'fr' ? 'Métiers Sponsorisés' : (app()->getLocale() === 'en' ? 'Sponsored Skills' : 'المهن المدعومة')" :description="app()->getLocale() === 'fr' ? 'Toutes disciplines' : (app()->getLocale() === 'en' ? 'All Skill Sectors' : 'كافة القطاعات والتخصصات')" icon='<svg class="w-6 h-6 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>' color="text-[#F5A800]" />
                <x-animated-counter :target="$stats['countries'] ?? 0" :label="app()->getLocale() === 'fr' ? 'Pays Participants' : (app()->getLocale() === 'en' ? 'Participating Nations' : 'الدول المشاركة')" :description="app()->getLocale() === 'fr' ? 'Union Africaine' : (app()->getLocale() === 'en' ? 'African Union' : 'الاتحاد الإفريقي')" icon='<svg class="w-6 h-6 text-[#0B2A6F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 012 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V14m-3 7c9 0 9-9 9-9s-9 0-9 9z"/></svg>' color="text-[#0B2A6F]" />
            </div>

            <!-- 1. FEATURED PARTNERS GRID -->
            <div class="space-y-6">
                <div class="flex items-center justify-between border-b border-slate-200 pb-4">
                    <h2 class="text-xl font-black text-[#0B2A6F] flex items-center gap-2">
                        <svg class="w-6 h-6 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
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
                                        <img src="{{ $logoUrl }}" alt="{{ $p->getLocalized('name') }}" class="max-h-full max-w-full object-contain">
                                    @else
                                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 font-black text-lg flex items-center justify-center">
                                            {{ mb_substr($p->getLocalized('name'), 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                
                                <span class="inline-block px-3 py-1 rounded-full bg-amber-50 text-[#F5A800] text-[10px] font-black border border-amber-200/60 uppercase">
                                    {{ $p->sponsor_level ? strtoupper($p->sponsor_level) : 'PLATINUM SPONSOR' }}
                                </span>

                                <h3 class="text-lg font-black text-[#0B2A6F] group-hover:text-[#35A536] transition">
                                    {{ $p->getLocalized('name') }}
                                </h3>

                                <p class="text-xs text-slate-500 font-medium line-clamp-3 leading-relaxed">
                                    {{ $p->getLocalized('description') ?: (app()->getLocale() === 'fr' ? 'Partenaire officiel engagé dans le succès de l\'événement.' : (app()->getLocale() === 'en' ? 'Official partner dedicated to event success.' : 'شريك رسمي مساهم في تميز وتأطير فعاليات أولمبياد المهن 2026.')) }}
                                </p>
                            </div>

                            @if($p->website_url)
                                <a href="{{ $p->website_url }}" target="_blank" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-slate-50 hover:bg-[#0B2A6F] text-[#0B2A6F] hover:text-white text-xs font-black transition border border-slate-200/80 shadow-xs">
                                    <span>{{ app()->getLocale() === 'fr' ? 'Visiter le Site Web' : (app()->getLocale() === 'en' ? 'Visit Website' : 'زيارة الموقع الرسمي') }}</span>
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                </a>
                            @endif
                        </div>
                    @empty
                        <div class="col-span-full py-8 text-center text-xs text-slate-400 font-bold">
                            {{ app()->getLocale() === 'fr' ? 'Aucun partenaire majeur pour le moment.' : (app()->getLocale() === 'en' ? 'No featured partners at the moment.' : 'لا يوجد شركاء مميزون حالياً.') }}
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- 2. ALL PARTNERS LOGO STRIP / GRID -->
            <div class="space-y-6 pt-6">
                <div class="border-b border-slate-200 pb-4">
                    <h3 class="text-lg font-black text-[#06205C] tracking-wide">{{ app()->getLocale() === 'fr' ? 'Partenaires & Sponsors' : (app()->getLocale() === 'en' ? 'Partners & Sponsors' : 'الشركاء والرعاة') }}</h3>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6">
                    @forelse($allPartners as $p)
                        @php $logoUrl = $p->logo_path ? asset($p->logo_path) : null; @endphp
                        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-xs hover:shadow-md transition text-center flex flex-col items-center justify-center space-y-3 group">
                            <div class="h-14 w-full flex items-center justify-center">
                                @if($logoUrl)
                                    <img src="{{ $logoUrl }}" alt="{{ $p->getLocalized('name') }}" class="max-h-full max-w-full object-contain filter grayscale group-hover:grayscale-0 transition duration-300">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-slate-100 text-slate-600 font-black text-sm flex items-center justify-center">
                                        {{ mb_substr($p->getLocalized('name'), 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <span class="text-xs font-bold text-slate-700 group-hover:text-[#0B2A6F] transition line-clamp-1">
                                {{ $p->getLocalized('name') }}
                            </span>
                        </div>
                    @empty
                        <div class="col-span-full py-8 text-center text-xs text-slate-400 font-bold">
                            {{ app()->getLocale() === 'fr' ? 'Aucun partenaire enregistré.' : (app()->getLocale() === 'en' ? 'No partners registered.' : 'لا يوجد شركاء مسجلين.') }}
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    @endif
</div>
