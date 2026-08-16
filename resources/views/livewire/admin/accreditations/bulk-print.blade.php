<div class="min-h-screen py-8 px-4 bg-slate-100 font-sans print:bg-white print:py-0 print:px-0">
    
    {{-- A4 PVC Multi-Badge Print CSS Engine --}}
    <style>
    @media print {
        @page {
            size: A4 portrait;
            margin: 10mm !important;
        }
        html, body {
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        nav, header, footer, .print\:hidden {
            display: none !important;
            visibility: hidden !important;
        }
        .badge-print-grid {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 15mm !important;
            page-break-inside: auto !important;
        }
        .badge-item-print {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            margin: 0 auto !important;
        }
    }

    .card-body-3d-print {
        width: 320px;
        height: 520px;
        border-radius: 30px;
        position: relative;
        background: var(--theme-card-bg, linear-gradient(145deg, #06205C 0%, #01091C 100%));
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
        z-index: 10;
        box-sizing: border-box;
    }
    .lanyard-hole-3d-print {
        width: 55px;
        height: 14px;
        background: #ffffff;
        border-radius: 10px;
        margin-top: 2px;
        border: 2px solid #cbd5e1;
    }
    .text-embroidered-white-print {
        color: #FFFFFF;
        text-shadow: 0px 1px 2px rgba(0,0,0,0.8);
    }
    .text-embroidered-accent-print {
        color: var(--theme-text-accent, #87CEEB);
    }
    @php
        $svgPath = public_path('africa-full.svg');
        if (!file_exists($svgPath)) {
            $svgPath = public_path('storage/africa.svg');
        }
        $africaSvg = '';
        if (file_exists($svgPath)) {
            $rawSvg = file_get_contents($svgPath);
            $rawSvg = preg_replace('/width="[0-9]+px"/i', 'width="100%"', $rawSvg);
            $rawSvg = preg_replace('/height="[0-9]+px"/i', 'height="100%"', $rawSvg);
            $rawSvg = preg_replace('/style="fill:rgba[^"]+"/i', 'style="fill:#ffffff; fill-opacity:0.85; stroke:#ffffff; stroke-opacity:0.95; stroke-width:2.5px;"', $rawSvg);
            $rawSvg = preg_replace('/id="DZ"([\s\S]*?style=")[^"]*(")/i', 'id="DZ"$1fill:#35A536; fill-opacity:1; stroke:#F5A800; stroke-width:7px; filter:drop-shadow(0 0 25px #35A536);$2', $rawSvg);
            $africaSvg = $rawSvg;
        }
    @endphp

    <!-- Top Action Bar (Hidden when printing) -->
    <div class="max-w-6xl mx-auto mb-8 bg-white border border-slate-200 p-6 rounded-3xl shadow-xl space-y-4 print:hidden" dir="rtl">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-4">
            <div>
                <h1 class="text-xl font-black text-[#06205C]">
                    🖨️ {{ app()->getLocale() === 'fr' ? 'Impression Groupée des Badges' : (app()->getLocale() === 'en' ? 'Bulk PVC Badges Printing' : 'الطباعة الجماعية لبطاقات الاعتماد الرسمية') }}
                </h1>
                <p class="text-xs text-slate-500 font-bold mt-1">
                    {{ count($badgeItems) }} {{ app()->getLocale() === 'fr' ? 'badges générés prêts à l\'impression.' : (app()->getLocale() === 'en' ? 'generated PVC badges ready for batch printing.' : 'بطاقة اعتماد شارة جاهزة للطباعة الجماعية المباشرة.') }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.accreditations.index') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold text-xs transition">
                    ← {{ app()->getLocale() === 'fr' ? 'Retour' : (app()->getLocale() === 'en' ? 'Back' : 'الرجوع لمركز الاعتماد') }}
                </a>
                <button type="button" onclick="window.print()" class="px-6 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-black text-xs shadow-lg transition flex items-center gap-2">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Lancer l\'Impression Groupée (Print All)' : (app()->getLocale() === 'en' ? 'Print All Badges' : 'طـبـاعة جميع البطاقات الآن 🖨️') }}</span>
                </button>
            </div>
        </div>

        <!-- Filter Selector inside Bulk Print Page -->
        <form method="GET" action="{{ route('admin.accreditations.bulk-print') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">
                    {{ app()->getLocale() === 'fr' ? 'Filtrer par Rôle / Catégorie' : (app()->getLocale() === 'en' ? 'Filter by Category / Role' : 'تصفية حسب الصفة / الفئة المقبولة') }}
                </label>
                <select name="role" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold text-xs">
                    <option value="ALL" {{ $filterRole === 'ALL' ? 'selected' : '' }}>-- {{ app()->getLocale() === 'fr' ? 'Toutes les catégories' : (app()->getLocale() === 'en' ? 'All Roles' : 'جميع الفئات والصفات') }} --</option>
                    <option value="COMPETITOR" {{ $filterRole === 'COMPETITOR' ? 'selected' : '' }}>المتنافسون (Competitors)</option>
                    <option value="EXPERT JUDGE" {{ $filterRole === 'EXPERT JUDGE' ? 'selected' : '' }}>الحكام والخبراء (Expert Judges)</option>
                    <option value="DELEGATION HEAD" {{ $filterRole === 'DELEGATION HEAD' ? 'selected' : '' }}>رؤساء الوفود (Delegation Heads)</option>
                    <option value="MEDIA" {{ $filterRole === 'MEDIA' ? 'selected' : '' }}>الوفد الإعلامي (Press / Media)</option>
                    <option value="ORGANIZER" {{ $filterRole === 'ORGANIZER' ? 'selected' : '' }}>المنظمون (Organizers)</option>
                    <option value="VIP" {{ $filterRole === 'VIP' ? 'selected' : '' }}>المراقبون والوزراء (VIP Observers)</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">
                    {{ app()->getLocale() === 'fr' ? 'Filtrer par Pays' : (app()->getLocale() === 'en' ? 'Filter by Country' : 'تصفية حسب الدولة') }}
                </label>
                <select name="country" onchange="this.form.submit()" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold text-xs">
                    <option value="">-- {{ app()->getLocale() === 'fr' ? 'Tous les pays' : (app()->getLocale() === 'en' ? 'All Countries' : 'جميع الدول المشاركة') }} --</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->id }}" {{ (string)$filterCountry === (string)$c->id ? 'selected' : '' }}>{{ $c->name_ar }} ({{ $c->name_fr }})</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full py-2.5 rounded-xl bg-slate-900 hover:bg-slate-800 text-white font-bold text-xs transition">
                    {{ app()->getLocale() === 'fr' ? 'Appliquer Filtres' : (app()->getLocale() === 'en' ? 'Apply Filters' : 'تحديث القائمة 🔄') }}
                </button>
            </div>
        </form>
    </div>

    <!-- BULK BADGES PRINT GRID (2 BADGES PER ROW ON A4) -->
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 badge-print-grid">
        @forelse($badgeItems as $item)
            @php
                $cfg = $item['roleConfig'] ?? [];
                $cardBg = $cfg['gradient'] ?? 'linear-gradient(145deg, #06205C 0%, #01091C 100%)';
                $stripeBg = $cfg['stripeBg'] ?? '#0D9488';
                $stripeText = $cfg['stripeText'] ?? '#FFFFFF';
                $accentColor = $cfg['accentColor'] ?? '#38BDF8';
                $titleAr = $cfg['titleAr'] ?? $item['roleTitle'];
                $titleEn = $cfg['titleEn'] ?? $item['roleTitle'];
                $allowedZones = $cfg['zones'] ?? ['EXPO', 'CATERING'];
            @endphp

            <div class="badge-item-print flex flex-col items-center">
                {{-- 3D PVC Badge Card --}}
                <div class="card-body-3d-print relative overflow-hidden" style="background: {{ $cardBg }};">
                    
                    {{-- OFFICIAL AFRICA CONTINENT MAP WATERMARK (/storage/africa.webp) --}}
                    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden rounded-[30px] flex items-center justify-center p-1">
                        <img src="/storage/africa.webp" alt="Africa Continent Map" class="w-full h-full object-contain opacity-40 scale-110 translate-y-4 filter drop-shadow-[0_4px_14px_rgba(0,0,0,0.6)]">
                    </div>

                    {{-- Top Lanyard Hole --}}
                    <div class="lanyard-hole-3d-print"></div>

                    {{-- Header Dual Logos --}}
                    <div class="w-full flex items-center justify-between px-2 pt-3 pb-2 border-b border-white/20">
                        <img src="{{ asset('ministry-logo-trimmed.png') }}" alt="وزارة التكوين" class="h-7 w-auto object-contain shrink-0 filter brightness-200">
                        <img src="{{ asset('africa-logo-trimmed.png') }}" alt="African Union" class="h-7 w-auto object-contain shrink-0 filter brightness-200">
                    </div>

                    {{-- Role Color Stripe --}}
                    <div class="w-full py-2 px-3 my-2 text-center rounded-xl font-black shadow-md uppercase tracking-wider text-[11px]"
                         style="background: {{ $stripeBg }}; color: {{ $stripeText }}; text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                        <div>{{ $titleAr }}</div>
                        <div class="text-[9px] font-mono opacity-90 tracking-widest">{{ $titleEn }}</div>
                    </div>

                    {{-- Attendee Name & Details --}}
                    <div class="w-full text-center space-y-1 my-auto">
                        <h2 class="text-base font-black text-white leading-tight drop-shadow-md">
                            {{ $item['nameAr'] }}
                        </h2>
                        <p class="text-xs font-bold text-slate-200 uppercase tracking-wide">
                            {{ $item['nameLatin'] }}
                        </p>
                        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 text-white text-[10px] font-black mt-1">
                            <span class="w-1.5 h-1.5 rounded-full" style="background: {{ $accentColor }};"></span>
                            <span>{{ $item['country'] }}</span>
                            <span>•</span>
                            <span class="truncate max-w-[140px]">{{ $item['skill'] }}</span>
                        </div>
                    </div>

                    {{-- Access Zones Permission Pills --}}
                    <div class="w-full flex items-center justify-center gap-1 my-2">
                        @foreach(['VIP', 'PLENARY', 'EXPO', 'PRESS', 'CATERING'] as $z)
                            @php $isAllowed = in_array($z, $allowedZones); @endphp
                            <span class="px-2 py-0.5 rounded text-[9px] font-black border transition {{ $isAllowed ? 'bg-emerald-500 text-white border-emerald-400 font-black shadow-xs' : 'bg-white/10 text-white/30 border-white/10 line-through' }}">
                                {{ $z }}
                            </span>
                        @endforeach
                    </div>

                    {{-- Bottom QR Verification Code --}}
                    <div class="w-full flex items-center justify-between pt-2 border-t border-white/20 text-white">
                        <div class="text-start space-y-0.5">
                            <span class="text-[9px] text-slate-300 font-bold block uppercase tracking-wider">Africa Skills Forum 2026</span>
                            <span class="text-[8px] font-mono text-amber-300 font-black block">CCO Oran • Verified QR</span>
                        </div>
                        <div class="p-1 rounded-lg bg-white shrink-0">
                            <img src="{{ $item['qrCodeUrl'] }}" alt="QR Code" class="w-14 h-14 object-contain">
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white rounded-3xl border border-slate-200">
                <p class="text-sm font-bold text-slate-500">لا توجد بطاقات اعتماد متطابقة مع معايير البحث والتصفية المختارة.</p>
            </div>
        @endforelse
    </div>
                    </div>




                    <div class="w-full flex justify-center items-center my-1 z-30">
                        <div class="relative w-[180px] h-[180px] bg-white rounded-2xl p-2 flex flex-col items-center justify-between border border-slate-200 shadow-md">
                            <div class="w-[145px] h-[145px] flex items-center justify-center bg-white rounded-lg">
                                <img src="{{ $item['qrCodeUrl'] }}" alt="QR Code" class="w-full h-full object-contain">
                            </div>
                            <div class="text-[7px] font-mono font-black text-slate-500 uppercase tracking-wider">WSAP ZERO-TRUST</div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between w-full px-2 mt-1 gap-2">
                        <div class="text-right flex-1 min-w-0 flex flex-col justify-center">
                            <div class="text-white text-[13px] font-black leading-tight text-right truncate">{{ $item['nameAr'] }}</div>
                            <div class="text-slate-300 text-[7.5px] font-sans uppercase tracking-wider font-bold text-right truncate" dir="ltr" style="color: {{ $theme['text_accent'] }}">{{ $item['nameLatin'] }}</div>
                        </div>
                        <div class="flex items-center justify-center shrink-0" dir="ltr">
                            <img src="/AFRICA.png" alt="Logo" class="h-8 w-auto object-contain">
                        </div>
                    </div>

                    <div class="w-full text-center mt-1.5 mb-1 px-2 py-1 rounded-xl shadow border"
                         style="background: {{ $theme['badge_bar_bg'] }}; border-color: {{ $theme['bar_border'] }};">
                        <h3 class="text-white text-[11px] font-black tracking-wide uppercase truncate" dir="ltr">{{ $theme['badge'] }}</h3>
                    </div>
                </div>
            </div>

        @empty
            <div class="col-span-full p-12 bg-white rounded-3xl text-center text-slate-400 font-bold text-sm border border-slate-200">
                لا توجد بطاقات مطابقة لخيارات التصفية المحددة.
            </div>
        @endforelse
    </div>
</div>
