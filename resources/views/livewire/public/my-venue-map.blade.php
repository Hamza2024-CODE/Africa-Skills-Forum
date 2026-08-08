<div class="w-full font-sans space-y-6" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-3xl border border-slate-200/90 shadow-sm">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#0066FF] flex items-center justify-center font-black">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/></svg>
            </div>
            <div>
                <h1 class="text-base sm:text-lg font-black text-[#06205C] tracking-wide">
                    {{ app()->getLocale() === 'fr' ? 'Carte Opérationnelle 3D du Village' : (app()->getLocale() === 'en' ? 'My Operational Map' : 'الخريطة الميدانية المخصصة للقرية الأورومتوسطية') }}
                </h1>
                <p class="text-xs text-[#0066FF] font-bold mt-0.5">
                    {{ app()->getLocale() === 'fr' ? 'Accès personnalisés selon votre badge officiel — ' : (app()->getLocale() === 'en' ? 'Customized access according to your official badge — ' : 'مخصصة وفقاً لشارتك الرسمية — ') }} {{ $user['name'] ?? 'مشارك معتمد' }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-2 px-4 py-2 rounded-2xl bg-emerald-50 text-emerald-800 border border-emerald-200 text-xs font-black shrink-0">
            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Badge Valide & Active' : (app()->getLocale() === 'en' ? 'Badge Valid & Active' : 'الشارة سارية المفعول') }}</span>
        </div>
    </div>

    <!-- Side-by-Side Clean Layout: Map (8 cols) + Allowed Zones Sidebar (4 cols) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
        
        <!-- 1. Satellite Map Frame (8 columns) -->
        <div class="lg:col-span-8 bg-white rounded-3xl border border-slate-200/90 shadow-md overflow-hidden relative h-[600px] min-h-[600px] w-full">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5329.450857207367!2d-0.5427541457406653!3d35.74718274427778!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd7e7d3c8df9e8f5%3A0x1823ea0b526356b2!2sMediterranean%20Village%20Oran!5e1!3m2!1sfr!2sdz!4v1785930530410!5m2!1sfr!2sdz" class="w-full h-full border-0 rounded-3xl" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
        </div>

        <!-- 2. Allowed & Restricted Zones Panel (4 columns) -->
        <div class="lg:col-span-4 bg-white p-5 rounded-3xl border border-slate-200/90 shadow-md space-y-4 max-h-[600px] overflow-y-auto">
            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                <h3 class="text-xs font-black text-[#06205C] uppercase tracking-wider">
                    {{ app()->getLocale() === 'fr' ? 'Zones & Salles Autorisées' : (app()->getLocale() === 'en' ? 'Permitted Zones & Facilities' : 'صلاحيات الدخول والمناطق المسموحة') }}
                </h3>
                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black bg-blue-50 text-[#0066FF] border border-blue-200">
                    {{ count($pois) }} {{ app()->getLocale() === 'fr' ? 'zones' : 'مناطق' }}
                </span>
            </div>

            <div class="space-y-3">
                @foreach($pois as $poi)
                    <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 transition-all hover:border-[#0066FF] space-y-2">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-[#0066FF] shrink-0 shadow-xs">
                                    {!! $poi['svg_raw'] ?? '' !!}
                                </div>
                                <div>
                                    <h4 class="text-xs font-black text-[#06205C]">{{ $poi['title_ar'] }}</h4>
                                    <p class="text-[10px] text-slate-500 font-semibold">{{ $poi['title_en'] }}</p>
                                </div>
                            </div>
                            @if($poi['is_allowed'])
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-800 border border-emerald-300 shrink-0">
                                    {{ app()->getLocale() === 'fr' ? 'Autorisé' : (app()->getLocale() === 'en' ? 'Permitted' : 'مسموح') }}
                                </span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-rose-100 text-rose-800 border border-rose-300 flex items-center gap-1 shrink-0">
                                    <svg class="w-3 h-3 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                    {{ app()->getLocale() === 'fr' ? 'Interdit' : (app()->getLocale() === 'en' ? 'Restricted' : 'محظور') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>
