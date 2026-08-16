<div class="min-h-screen py-8 px-4 bg-[#F4F7FC] text-[#06205C] print:bg-white print:py-0 print:px-0 font-sans" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@700;800;900&display=swap');

    @media print {
        @page {
            size: A4 portrait;
            margin: 0mm !important;
        }
        /* Hide all website navigation bars, headers, footers, sidebars */
        header, nav, aside, footer, .navbar, [role="navigation"], .no-print, .print\:hidden {
            display: none !important;
            height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            opacity: 0 !important;
            visibility: hidden !important;
        }
        *, html, body {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        html, body, div, main {
            overflow: visible !important;
        }
        html, body {
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 210mm !important;
            height: auto !important;
        }
        .a4-page-wrapper {
            width: 210mm !important;
            height: 295mm !important;
            page-break-after: always !important;
            break-after: page !important;
            page-break-before: auto !important;
            break-before: auto !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            box-sizing: border-box !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: center !important;
            align-items: center !important;
            position: relative !important;
        }
        .a4-page-wrapper:last-child {
            page-break-after: auto !important;
            break-after: auto !important;
        }
        .batch-cards-container {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            column-gap: 6mm !important;
            row-gap: 6mm !important;
            padding: 6mm 6mm !important;
            width: 210mm !important;
            height: 285mm !important;
            box-sizing: border-box !important;
            justify-items: center !important;
            align-content: center !important;
        }
        .batch-card-wrapper {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            forced-color-adjust: none !important;
            box-shadow: none !important;
            margin: 0 !important;
            padding: 0 !important;
        }
        .card-body-batch {
            width: 88mm !important;
            height: 128mm !important;
            min-height: 128mm !important;
            max-height: 128mm !important;
            border-radius: 22px !important;
            box-shadow: none !important;
            padding: 8px 8px 12px 8px !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            forced-color-adjust: none !important;
        }
    }

    /* 3D Executive Badge Styling */
    .card-body-batch {
        width: 330px;
        min-height: 570px;
        border-radius: 36px;
        position: relative;
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4), inset 4px 4px 8px rgba(255, 255, 255, 0.2);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 16px 14px 20px 14px;
        z-index: 10;
        overflow: hidden;
    }
    .lanyard-hole-batch {
        width: 60px;
        height: 16px;
        background: #ffffff !important;
        border-radius: 10px;
        margin-top: 2px;
        position: relative;
        z-index: 20;
        box-shadow: inset 0 3px 6px rgba(0, 0, 0, 0.8), 0 0 0 2px #ffffff;
    }
    .text-embroidered-white-batch {
        color: #FFFFFF;
        font-family: 'Cairo', system-ui, -apple-system, sans-serif !important;
        text-shadow: 0px 2px 4px rgba(0,0,0,0.9);
        letter-spacing: 0.02em;
        line-height: 1.3 !important;
    }
    .text-embroidered-accent-batch {
        font-family: system-ui, -apple-system, sans-serif;
        text-shadow: 0px 1.5px 2px rgba(0,0,0,0.9);
        letter-spacing: 0.03em;
        line-height: 1.2 !important;
    }
    .divider-stitched-line-batch {
        width: 100%;
        height: 0px;
        border-top: 1.5px dashed rgba(255,255,255,0.45);
        margin: 3px 0;
        opacity: 0.85;
    }
    </style>

    @php
        $locale = app()->getLocale();
        // Pre-load Africa SVG Map once for high performance
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

    <!-- Print Action Header -->
    <div class="max-w-6xl mx-auto mb-8 flex flex-col sm:flex-row items-center justify-between gap-4 print:hidden bg-white border border-slate-200 p-5 rounded-2xl shadow-xl">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs mb-1">
                <span>طباعة الشارات الجماعية الموثقة</span>
            </div>
            <h1 class="text-2xl font-black text-[#06205C]">طباعة دفعة شارات الاعتماد الرسمية (Batch Badge Print)</h1>
            <p class="text-xs text-slate-500 font-bold mt-0.5">جميع الشارات الرسمية تظهر بالتصميم الوزاري الأصلي الكامل (خريطة الجزائر والإفريقية + الشعارات + QR كود ثلاثي الأبعاد)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.accreditations') }}" class="px-5 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-200 text-xs font-bold text-[#06205C] transition shadow-xs">
                {{ $locale === 'fr' ? 'Retour' : ($locale === 'en' ? 'Back' : 'رجوع') }}
            </a>
            <button onclick="window.print()" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-[#35A536] via-emerald-700 to-[#092C1D] text-white font-black text-xs shadow-xl transition flex items-center gap-2 hover:scale-105 border border-emerald-400">
                <svg class="w-4 h-4 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>طباعة جميع الشارات (A4 Print)</span>
            </button>
        </div>
    </div>

    <!-- A4 Grid Layout for Printing Badges (Exactly 4 Badges Per Page) -->
    <div class="space-y-12 print:space-y-0">
        @foreach(collect($users)->chunk(4) as $pageIndex => $userChunk)
            <div class="a4-page-wrapper print:page-break-after-always">
                <div class="batch-cards-container max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8 print:grid-cols-2 print:gap-4 print:max-w-none print:w-full">
                    @foreach($userChunk as $u)
                        @php
                            $reg       = $u->participant?->registrations?->first();
                            $badge     = $u->badges->first();
                            $userRole  = $u->roles->first()?->name;

                            $isMinisterial = in_array($userRole, ['EXECUTIVE_VIEWER', 'MINISTERIAL_OBSERVER']) || 
                                             str_contains($u->email, '@gov.dz') || 
                                             str_contains(strtolower($u->email), 'mfep') ||
                                             \App\Models\MinisterialOfficial::where('user_id', $u->id)->exists();

                            $roleTitle = $badge?->role_title ?? match (true) {
                                $isMinisterial                                         => 'VIP DIPLOMATIC',
                                $userRole === 'MEDIA_MANAGER' || $userRole === 'PRESS' => 'MEDIA',
                                $userRole === 'COUNTRY_ADMIN'                          => 'DELEGATION HEAD',
                                $userRole === 'JUDGE' || $userRole === 'EXPERT'        => 'EXPERT JUDGE',
                                $userRole === 'ORGANIZATION_ADMIN' || $userRole === 'SUPER_ADMIN' => 'ORGANIZER',
                                $userRole === 'SPEAKER'                                => 'SPEAKER',
                                default                                                => 'PARTICIPANT',
                            };

                            $roleKey = strtoupper($roleTitle);
                            $theme = match($roleKey) {
                                'ORGANIZER', 'SUPER_ADMIN', 'NATIONAL_ADMIN', 'ORGANIZATION_ADMIN' => [
                                    'card_bg' => 'linear-gradient(145deg, #092C1D 0%, #03150D 45%, #061B2E 100%)',
                                    'text_accent' => '#F5D061',
                                    'badge' => 'منظم رسمي — ORGANIZER',
                                    'bar_border' => '#F5A800',
                                    'badge_bar_bg' => 'linear-gradient(90deg, rgba(53,165,54,0.3) 0%, rgba(245,168,0,0.4) 50%, rgba(53,165,54,0.3) 100%)',
                                ],
                                'MEDIA', 'MEDIA_MANAGER', 'PRESS' => [
                                    'card_bg' => 'linear-gradient(145deg, #9A3412 0%, #451A03 50%, #1C0701 100%)',
                                    'text_accent' => '#FDE68A',
                                    'badge' => 'وفد إعلامي — MEDIA / PRESS',
                                    'bar_border' => '#F59E0B',
                                    'badge_bar_bg' => 'linear-gradient(90deg, rgba(245,158,11,0.3) 0%, rgba(217,119,6,0.5) 50%, rgba(245,158,11,0.3) 100%)',
                                ],
                                'VIP', 'VIP DIPLOMATIC', 'MINISTERIAL_OBSERVER', 'MINISTERIAL EXECUTIVE OBSERVER', 'EXECUTIVE_VIEWER', 'MINISTER' => [
                                    'card_bg' => 'linear-gradient(145deg, #4C1D95 0%, #2E1065 50%, #0F011F 100%)',
                                    'text_accent' => '#FDE047',
                                    'badge' => 'وزير / عضو حكومي — MINISTER / DIPLOMATIC VIP',
                                    'bar_border' => '#FDE047',
                                    'badge_bar_bg' => 'linear-gradient(90deg, rgba(168,85,247,0.3) 0%, rgba(234,179,8,0.4) 50%, rgba(168,85,247,0.3) 100%)',
                                ],
                                'DELEGATION HEAD', 'DELEGATION_HEAD' => [
                                    'card_bg' => 'linear-gradient(145deg, #065F46 0%, #022C22 50%, #011C15 100%)',
                                    'text_accent' => '#6EE7B7',
                                    'badge' => 'مسؤول الوفد — DELEGATION HEAD',
                                    'bar_border' => '#34D399',
                                    'badge_bar_bg' => 'linear-gradient(90deg, rgba(16,185,129,0.3) 0%, rgba(52,211,153,0.4) 50%, rgba(16,185,129,0.3) 100%)',
                                ],
                                'EXPERT JUDGE', 'EXPERT', 'JUDGE' => [
                                    'card_bg' => 'linear-gradient(145deg, #312E81 0%, #1E1B4B 50%, #0F172A 100%)',
                                    'text_accent' => '#93C5FD',
                                    'badge' => 'خبير دولي — INTERNATIONAL EXPERT',
                                    'bar_border' => '#60A5FA',
                                    'badge_bar_bg' => 'linear-gradient(90deg, rgba(99,102,241,0.3) 0%, rgba(59,130,246,0.4) 50%, rgba(99,102,241,0.3) 100%)',
                                ],
                                'SPEAKER' => [
                                    'card_bg' => 'linear-gradient(145deg, #831843 0%, #500724 50%, #20010E 100%)',
                                    'text_accent' => '#FBCFE8',
                                    'badge' => 'محاضر رئيسي — KEYNOTE SPEAKER',
                                    'bar_border' => '#F472B6',
                                    'badge_bar_bg' => 'linear-gradient(90deg, rgba(236,72,153,0.3) 0%, rgba(244,114,182,0.4) 50%, rgba(236,72,153,0.3) 100%)',
                                ],
                                default => [
                                    'card_bg' => 'linear-gradient(145deg, #0369A1 0%, #0C4A6E 50%, #03192E 100%)',
                                    'text_accent' => '#7DD3FC',
                                    'badge' => 'مشارك معتمد — DELEGATE / PARTICIPANT',
                                    'bar_border' => '#38BDF8',
                                    'badge_bar_bg' => 'linear-gradient(90deg, rgba(2,132,199,0.3) 0%, rgba(56,189,248,0.4) 50%, rgba(2,132,199,0.3) 100%)',
                                ],
                            };

                            $token = $reg?->verification_token ?? $badge?->access_token ?? $u->uuid;
                            $verifyUrl = route('verify', ['token' => $token]);
                            $qrCodeUrl = \App\Services\QrCodeService::generateDataUri($verifyUrl, 300);
                            $nameAr = $u->participant?->first_name_ar ? ($u->participant->first_name_ar . ' ' . $u->participant->last_name_ar) : $u->name;
                            $nameLatin = $u->participant?->first_name_latin ? ($u->participant->first_name_latin . ' ' . $u->participant->last_name_latin) : $u->email;
                            $nameLatin = str_replace('@worldskills.dz', '@worldskills.africa', $nameLatin);
                        @endphp

                        <div class="batch-card-wrapper mx-auto flex flex-col items-center">
                            <!-- 100% ORIGINAL EXECUTIVE DYNAMIC BADGE CARD -->
                            <div class="card-body-batch" style="background: {{ $theme['card_bg'] }};">
                                
                                <!-- OFFICIAL AFRICA CONTINENT MAP WATERMARK (/storage/africa.webp) -->
                                <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden rounded-[36px] flex items-center justify-center p-1">
                                    <img src="/storage/africa.webp" alt="Africa Continent Map" class="w-full h-full object-contain opacity-40 scale-110 translate-y-6 filter drop-shadow-[0_4px_14px_rgba(0,0,0,0.6)]">
                                </div>

                                <!-- 100% PURE WHITE LANYARD HOLE CLIP -->
                                <div class="lanyard-hole-batch"></div>

                                <div class="relative z-20 w-full flex flex-col flex-grow justify-between mt-2 overflow-hidden">
                                    
                                    <!-- Top Header: Ministry Logo -->
                                    <div class="w-full flex justify-center items-center text-center pt-1 pb-1 px-2 mx-auto">
                                        <img src="/ministry-logo.png" alt="Ministry of Vocational Training" class="w-auto max-w-[92%] object-contain mx-auto" style="height: 56px; filter: drop-shadow(0px 3px 8px rgba(0,0,0,0.95));">
                                    </div>

                                    <!-- Center: Ultra-Translucent Frosted Glassmorphic QR Plate (Map Shines Cleanly From Behind) -->
                                    <div class="w-full flex justify-center items-center my-1 z-30 mx-auto">
                                        <div class="relative w-[140px] h-[140px] bg-white/20 backdrop-blur-md rounded-3xl p-2 flex flex-col items-center justify-between border border-white/40 shadow-[0_8px_25px_rgba(0,0,0,0.4)]">
                                            <div class="w-[100px] h-[100px] flex items-center justify-center p-1 bg-white/95 rounded-2xl shadow-md border border-white">
                                                <img src="{{ $qrCodeUrl }}" alt="Encrypted QR Code" class="w-full h-full object-contain">
                                            </div>
                                            <div class="text-[6px] font-mono font-black text-white uppercase tracking-widest text-center drop-shadow-md">SECURED BY WSAP ZERO-TRUST</div>
                                        </div>
                                    </div>

                                    <!-- Bottom Details Section (Name & Email) -->
                                    <div class="w-full px-2 mt-0.5 text-right">
                                        <h2 class="text-embroidered-white-batch text-[16px] font-black mb-0.5 leading-tight tracking-wide text-right whitespace-nowrap overflow-visible">{{ $nameAr }}</h2>
                                        <div class="divider-stitched-line-batch"></div>
                                        <div class="text-embroidered-accent-batch text-[9px] font-sans uppercase tracking-wider font-bold text-right truncate" style="color: {{ $theme['text_accent'] }};" dir="ltr">{{ $nameLatin }}</div>
                                    </div>

                                    <!-- African Union Logo Centered Above Role Banner -->
                                    <div class="w-full flex justify-center items-center my-1">
                                        <img src="/africa-logo-trimmed.png" alt="African Union" class="h-8 w-auto max-w-[50%] object-contain filter drop-shadow-[0_3px_6px_rgba(0,0,0,0.85)]">
                                    </div>

                                    <!-- Executive Role Title Banner -->
                                    <div class="w-full text-center mt-1 mb-1 px-2 py-1.5 rounded-2xl shadow-lg border backdrop-blur-md"
                                         style="background: {{ $theme['badge_bar_bg'] }}; border-color: {{ $theme['bar_border'] }};">
                                        <h3 class="text-embroidered-white-batch text-[12.5px] font-black tracking-wide uppercase text-center whitespace-nowrap overflow-visible" dir="ltr"
                                            style="text-shadow: 0 2px 4px rgba(0,0,0,0.9);">
                                            {{ $theme['badge'] }}
                                        </h3>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

</div>
