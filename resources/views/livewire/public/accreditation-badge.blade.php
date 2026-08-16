<div class="min-h-screen py-10 px-4 flex flex-col items-center justify-center bg-white font-sans print:bg-white print:py-0 print:px-0">
    
    {{-- html2canvas for High-Res Image Export --}}
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>

    {{-- Absolute Single-Page PVC Badge Print CSS Engine --}}
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@700;800;900&display=swap');

    @media print {
        @page {
            size: portrait;
            margin: 0 !important;
        }
        html, body {
            width: 100vw !important;
            height: 100vh !important;
            margin: 0 !important;
            padding: 0 !important;
            background: #ffffff !important;
            overflow: hidden !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        body * {
            visibility: hidden !important;
        }
        nav, header, footer, .print\:hidden {
            display: none !important;
            visibility: hidden !important;
        }
        .print-badge-container, .print-badge-container * {
            visibility: visible !important;
        }
        .print-badge-container {
            position: absolute !important;
            left: 50% !important;
            top: 50% !important;
            transform: translate(-50%, -50%) !important;
            margin: 0 !important;
            box-shadow: none !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
        }
    }

    /* Mobile Responsiveness for small phone screens */
    @media (max-width: 480px) {
        .card-body-3d {
            width: 330px !important;
            min-height: 580px !important;
            padding: 16px 12px 22px 12px !important;
            border-radius: 30px !important;
        }
        .text-embroidered-white {
            font-size: 17px !important;
            white-space: normal !important;
            word-break: break-word !important;
        }
        .text-embroidered-accent {
            font-size: 9px !important;
        }
    }

    /* 3D Deep Physics Styles */
    .card-body-3d {
        width: 380px;
        min-height: 650px;
        border-radius: 40px;
        position: relative;
        background: var(--theme-card-bg, linear-gradient(145deg, #3B225C 0%, #221235 100%));
        box-shadow: 
            20px 30px 50px -10px rgba(0, 0, 0, 0.6),
            0px 15px 30px rgba(0, 0, 0, 0.4),
            inset 6px 6px 12px rgba(255, 255, 255, 0.2),
            inset -6px -6px 15px rgba(0, 0, 0, 0.7);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 22px 20px 30px 20px;
        z-index: 10;
        transform: rotateX(2deg) rotateY(-2deg);
        transform-style: preserve-3d;
        transition: transform 0.3s ease;
    }
    .card-body-3d:hover {
        transform: rotateX(0deg) rotateY(0deg) scale(1.02);
    }
    .lanyard-hole-3d {
        width: 72px;
        height: 20px;
        background: #ffffff !important;
        border-radius: 12px;
        margin-top: 5px;
        position: relative;
        z-index: 20;
        box-shadow: 
            inset 0 4px 8px rgba(0, 0, 0, 0.8),
            0 0 0 3px #ffffff,
            0 4px 10px rgba(0, 0, 0, 0.5);
    }
    .lanyard-hole-3d::before {
        content: '';
        position: absolute;
        top: -4px; left: -4px; right: -4px; bottom: -4px;
        border-radius: 16px;
        background: #ffffff !important;
        z-index: -1;
        box-shadow: 0 4px 6px rgba(0,0,0,0.5);
    }
    /* Soft Glow & Embroidered Fabric Stitch Effect */
    .text-embroidered-white {
        color: #FFFFFF;
        font-family: 'Cairo', system-ui, -apple-system, sans-serif !important;
        text-shadow: 
            0px 2px 4px rgba(0,0,0,0.9),
            0px 1px 2px rgba(0,0,0,0.7);
        letter-spacing: 0.02em;
        line-height: 1.4 !important;
        padding-top: 4px;
        padding-bottom: 4px;
    }
    .text-embroidered-accent {
        color: var(--theme-text-accent, #87CEEB);
        font-family: system-ui, -apple-system, sans-serif;
        text-shadow: 0px 1.5px 2px rgba(0,0,0,0.9);
        letter-spacing: 0.04em;
        line-height: 1.3 !important;
    }
    .divider-stitched-line {
        width: 100%;
        height: 0px;
        border-top: 1.5px dashed var(--theme-text-accent, rgba(255,255,255,0.45));
        margin: 4px 0;
        opacity: 0.85;
    }
    </style>

    @php
        $u = auth()->user();
        $badgeBackRoute = route('home');
        if ($u) {
            $badgeBackRoute = match($u->roles->first()?->name ?? '') {
                'SUPER_ADMIN', 'NATIONAL_ADMIN' => route('admin.dashboard'),
                'EXECUTIVE_VIEWER'              => route('executive.dashboard'),
                'COUNTRY_ADMIN'                 => route('country.dashboard'),
                'ORGANIZATION_ADMIN'            => route('organization.dashboard'),
                'JUDGE', 'EXPERT'               => route('judge.dashboard'),
                'PARTICIPANT'                   => route('participant.dashboard'),
                'MEDIA_MANAGER'                 => route('admin.media.dashboard'),
                default                         => route('profile'),
            };
        }
    @endphp

    <!-- Top Action Bar (Hidden when printing) -->
    <div class="w-full max-w-xl mb-8 flex flex-wrap items-center justify-between gap-3 text-slate-900 print:hidden bg-white border border-slate-200 p-4 rounded-2xl shadow-xl">
        <a href="{{ $badgeBackRoute }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-200 text-xs font-bold text-slate-800 transition flex items-center gap-1.5 shadow-xs">
            <svg class="w-4 h-4 text-[#06205C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Retour' : (app()->getLocale() === 'en' ? 'Back' : 'الرجوع') }}</span>
        </a>
        
        <div class="flex items-center gap-2">
            <!-- Download Image PNG Button -->
            <button type="button" onclick="downloadBadgeAsImage()" class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs shadow-md transition flex items-center gap-2 border border-emerald-500">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                <span>{{ app()->getLocale() === 'fr' ? 'Télécharger Image (PNG)' : (app()->getLocale() === 'en' ? 'Download Image (HD)' : 'تحميل الشارة كصورة HD 🖼️') }}</span>
            </button>

            <!-- Print PVC Button -->
            <button onclick="window.print()" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-[#06205C] to-[#0A3580] hover:from-[#041640] hover:to-[#06205C] text-amber-300 font-black text-xs shadow-lg shadow-[#06205C]/20 transition flex items-center gap-2 border border-amber-400/40">
                <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>{{ app()->getLocale() === 'fr' ? 'Imprimer PVC' : (app()->getLocale() === 'en' ? 'Print PVC Badge' : 'طباعة الشارة الرسمية 🖨️') }}</span>
            </button>
        </div>
    </div>

    @php
        $roleKey = strtoupper($roleTitle);
        $theme = match($roleKey) {
            'ORGANIZER', 'SUPER_ADMIN', 'NATIONAL_ADMIN', 'ORGANIZATION_ADMIN' => [
                'card_bg' => 'linear-gradient(145deg, #092C1D 0%, #03150D 45%, #061B2E 100%)',
                'lanyard_filter' => 'hue-rotate(60deg) saturate(2.5) brightness(0.85)',
                'edge_color' => '#02140C',
                'rim_grad' => '#ffffff',
                'text_accent' => '#F5D061',
                'divider_glow' => '#F5A800',
                'badge' => 'منظم رسمي — ORGANIZER',
                'badge_bar_bg' => 'linear-gradient(90deg, rgba(53,165,54,0.3) 0%, rgba(245,168,0,0.4) 50%, rgba(53,165,54,0.3) 100%)',
                'bar_border' => '#F5A800',
            ],
            'MEDIA', 'MEDIA_MANAGER', 'PRESS' => [
                'card_bg' => 'linear-gradient(145deg, #9A3412 0%, #451A03 50%, #1C0701 100%)',
                'lanyard_filter' => 'hue-rotate(180deg) saturate(3) brightness(1.1)',
                'edge_color' => '#2B1003',
                'rim_grad' => '#ffffff',
                'text_accent' => '#FDE68A',
                'divider_glow' => '#F59E0B',
                'badge' => 'وفد إعلامي — MEDIA / PRESS',
                'badge_bar_bg' => 'linear-gradient(90deg, rgba(245,158,11,0.3) 0%, rgba(217,119,6,0.5) 50%, rgba(245,158,11,0.3) 100%)',
                'bar_border' => '#F59E0B',
            ],
            'VIP', 'VIP DIPLOMATIC', 'MINISTERIAL_OBSERVER', 'MINISTERIAL EXECUTIVE OBSERVER', 'EXECUTIVE_VIEWER', 'MINISTER' => [
                'card_bg' => 'linear-gradient(145deg, #4C1D95 0%, #2E1065 50%, #0F011F 100%)',
                'lanyard_filter' => 'hue-rotate(240deg) saturate(2) brightness(0.9)',
                'edge_color' => '#100224',
                'rim_grad' => '#ffffff',
                'text_accent' => '#FDE047',
                'divider_glow' => '#EAB308',
                'badge' => 'وزير / عضو حكومي — MINISTER / DIPLOMATIC VIP',
                'badge_bar_bg' => 'linear-gradient(90deg, rgba(168,85,247,0.3) 0%, rgba(234,179,8,0.4) 50%, rgba(168,85,247,0.3) 100%)',
                'bar_border' => '#FDE047',
            ],
            'DELEGATION HEAD', 'DELEGATION_HEAD' => [
                'card_bg' => 'linear-gradient(145deg, #065F46 0%, #022C22 50%, #011C15 100%)',
                'lanyard_filter' => 'hue-rotate(80deg) saturate(2) brightness(0.8)',
                'edge_color' => '#011711',
                'rim_grad' => '#ffffff',
                'text_accent' => '#6EE7B7',
                'divider_glow' => '#34D399',
                'badge' => 'مسؤول الوفد — DELEGATION HEAD',
                'badge_bar_bg' => 'linear-gradient(90deg, rgba(16,185,129,0.3) 0%, rgba(52,211,153,0.4) 50%, rgba(16,185,129,0.3) 100%)',
                'bar_border' => '#34D399',
            ],
            'EXPERT JUDGE', 'EXPERT', 'JUDGE' => [
                'card_bg' => 'linear-gradient(145deg, #312E81 0%, #1E1B4B 50%, #0F172A 100%)',
                'lanyard_filter' => 'hue-rotate(210deg) saturate(2.5) brightness(0.95)',
                'edge_color' => '#0A0F1D',
                'rim_grad' => '#ffffff',
                'text_accent' => '#93C5FD',
                'divider_glow' => '#60A5FA',
                'badge' => 'خبير دولي — INTERNATIONAL EXPERT',
                'badge_bar_bg' => 'linear-gradient(90deg, rgba(99,102,241,0.3) 0%, rgba(59,130,246,0.4) 50%, rgba(99,102,241,0.3) 100%)',
                'bar_border' => '#60A5FA',
            ],
            'VOLUNTEER' => [
                'card_bg' => 'linear-gradient(145deg, #0D9488 0%, #115E59 50%, #042F2E 100%)',
                'lanyard_filter' => 'hue-rotate(130deg) saturate(2) brightness(1.0)',
                'edge_color' => '#021F1D',
                'rim_grad' => '#ffffff',
                'text_accent' => '#99F6E4',
                'divider_glow' => '#2DD4BF',
                'badge' => 'متطوع — VOLUNTEER',
                'badge_bar_bg' => 'linear-gradient(90deg, rgba(20,184,166,0.3) 0%, rgba(45,212,191,0.4) 50%, rgba(20,184,166,0.3) 100%)',
                'bar_border' => '#2DD4BF',
            ],
            'SPEAKER' => [
                'card_bg' => 'linear-gradient(145deg, #831843 0%, #500724 50%, #20010E 100%)',
                'lanyard_filter' => 'hue-rotate(290deg) saturate(2.5) brightness(0.95)',
                'edge_color' => '#1F010D',
                'rim_grad' => '#ffffff',
                'text_accent' => '#FBCFE8',
                'divider_glow' => '#F472B6',
                'badge' => 'محاضر رئيسي — KEYNOTE SPEAKER',
                'badge_bar_bg' => 'linear-gradient(90deg, rgba(236,72,153,0.3) 0%, rgba(244,114,182,0.4) 50%, rgba(236,72,153,0.3) 100%)',
                'bar_border' => '#F472B6',
            ],
            default => [
                'card_bg' => 'linear-gradient(145deg, #0369A1 0%, #0C4A6E 50%, #03192E 100%)',
                'lanyard_filter' => 'none',
                'edge_color' => '#021324',
                'rim_grad' => '#ffffff',
                'text_accent' => '#7DD3FC',
                'divider_glow' => '#38BDF8',
                'badge' => 'مشارك معتمد — DELEGATE / PARTICIPANT',
                'badge_bar_bg' => 'linear-gradient(90deg, rgba(2,132,199,0.3) 0%, rgba(56,189,248,0.4) 50%, rgba(2,132,199,0.3) 100%)',
                'bar_border' => '#38BDF8',
            ],
        };

        $verifyUrl = route('verify', ['token' => $token]);
        $qrCodeUrl = \App\Services\QrCodeService::generateDataUri($verifyUrl, 350);
        $nameAr = $registration?->participant?->first_name_ar ? ($registration->participant->first_name_ar . ' ' . $registration->participant->last_name_ar) : ($user?->name ?? $badge?->user?->name ?? 'عضو معتمد');
        $nameLatin = $registration?->participant?->first_name_latin ? ($registration->participant->first_name_latin . ' ' . $registration->participant->last_name_latin) : ($user?->email ?? 'Accredited Member');
        $nameLatin = str_replace('@worldskills.dz', '@worldskills.africa', $nameLatin);

        // Load africa-full.svg or storage/africa.svg and highlight Algeria (id="DZ") in Emerald Green & Gold
        $svgPath = public_path('africa-full.svg');
        if (!file_exists($svgPath)) {
            $svgPath = public_path('storage/africa.svg');
        }
        $africaSvg = '';
        if (file_exists($svgPath)) {
            $rawSvg = file_get_contents($svgPath);
            // 1. Clean container <svg> tag style and dimensions
            $rawSvg = preg_replace('/width="[0-9]+px"/i', 'width="100%"', $rawSvg);
            $rawSvg = preg_replace('/height="[0-9]+px"/i', 'height="100%"', $rawSvg);
            
            // 2. Replace all country path styles with bright crisp white & white border
            $rawSvg = preg_replace('/style="fill:rgba[^"]+"/i', 'style="fill:#ffffff; fill-opacity:0.85; stroke:#ffffff; stroke-opacity:0.95; stroke-width:2.5px;"', $rawSvg);
            
            // 3. Highlight Algeria (DZ) in bright Emerald Green with Gold border
            $rawSvg = preg_replace('/id="DZ"([\s\S]*?style=")[^"]*(")/i', 'id="DZ"$1fill:#35A536; fill-opacity:1; stroke:#F5A800; stroke-width:7px; filter:drop-shadow(0 0 25px #35A536);$2', $rawSvg);
            
            $africaSvg = $rawSvg;
        }
    @endphp


    <!-- REALISTIC ROLE-COLORED 3D LANYARD FABRIC STRAP & METALLIC CLIP -->
    <div class="relative flex flex-col items-center z-50 -mb-10 print:hidden pointer-events-none">
        <img src="/lanyard-strap.png" alt="Official Lanyard Strap & Swivel Clip"
             class="w-72 sm:w-80 h-auto object-contain drop-shadow-[0_25px_40px_rgba(0,0,0,0.85)] translate-x-12 sm:translate-x-14 translate-y-3.5 sm:translate-y-4"
             style="filter: {{ $theme['lanyard_filter'] }};">
    </div>

    <!-- DYNAMIC ROLE-BASED 3D DEEP PHYSICAL BADGE -->
    <div class="print-badge-container card-body-3d" style="--theme-card-bg: {{ $theme['card_bg'] }}; --theme-text-accent: {{ $theme['text_accent'] }}; --theme-edge-color: {{ $theme['edge_color'] }}; --theme-rim-grad: {{ $theme['rim_grad'] }};">
        
        <!-- ══════════════════════════════════════════════════════════════════ -->
        <!-- OFFICIAL AFRICA CONTINENT MAP WATERMARK (/storage/africa.webp) -->
        <!-- ══════════════════════════════════════════════════════════════════ -->
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden rounded-[40px] flex items-center justify-center p-1">
            <img src="/storage/africa.webp" alt="Africa Continent Map" class="w-full h-full object-contain opacity-40 scale-110 translate-y-6 filter drop-shadow-[0_4px_14px_rgba(0,0,0,0.6)]">
        </div>



        <!-- 100% PURE WHITE 3D LANYARD PUNCH HOLE -->
        <div class="lanyard-hole-3d">
            <div style="position: absolute; top:-4px; left:-4px; right:-4px; bottom:-4px; border-radius:16px; background: #ffffff; z-index:-1; box-shadow: 0 4px 6px rgba(0,0,0,0.5);"></div>
        </div>

        <div class="relative z-20 w-full flex flex-col flex-grow justify-between mt-2 overflow-hidden">
            
            <!-- Top Section: Official Host Ministry Logo Header (/ministry-logo.png) -->
            <div class="w-full flex justify-center items-center text-center pt-1 pb-1 px-2 mx-auto">
                <img src="/ministry-logo.png" alt="Ministry of Vocational Training and Education" class="w-auto max-w-[92%] object-contain mx-auto" style="height: 64px; filter: drop-shadow(0px 3px 8px rgba(0,0,0,0.95));">
            </div>

            <!-- Center: Ultra-Translucent Frosted Glassmorphic QR Plate (Map Shines Cleanly From Behind) -->
            <div class="w-full flex justify-center items-center my-1 z-30 mx-auto">
                <div class="relative w-[155px] sm:w-[175px] h-[155px] sm:h-[175px] bg-white/20 backdrop-blur-md rounded-3xl p-2.5 flex flex-col items-center justify-between border border-white/40 shadow-[0_8px_32px_rgba(0,0,0,0.4)]">
                    <div class="w-[110px] sm:w-[125px] h-[110px] sm:h-[125px] flex items-center justify-center p-1 bg-white/95 rounded-2xl shadow-md border border-white">
                        <img src="{{ $qrCodeUrl }}" alt="Encrypted QR Code" class="w-full h-full object-contain">
                    </div>
                    <div class="text-[6.5px] font-mono font-black text-white uppercase tracking-widest text-center drop-shadow-md">SECURED BY WSAP ZERO-TRUST</div>
                </div>
            </div>

            <!-- Bottom Details Section -->
            <div class="w-full px-3 mt-1 text-right">
                <h2 class="text-embroidered-white text-[19px] sm:text-[21px] font-black mb-0.5 leading-normal tracking-wide text-right whitespace-nowrap overflow-visible">{{ $nameAr }}</h2>
                <div class="divider-stitched-line" style="border-top-color: {{ $theme['divider_glow'] }};"></div>
                <div class="text-embroidered-accent text-[9.5px] font-sans uppercase tracking-wider font-bold text-right truncate" dir="ltr">{{ $nameLatin }}</div>
            </div>

            <!-- African Union Logo Centered Above Role Banner -->
            <div class="w-full flex justify-center items-center my-1">
                <img src="/africa-logo-trimmed.png" alt="African Union" class="h-10 sm:h-12 w-auto max-w-[55%] object-contain filter drop-shadow-[0_4px_10px_rgba(0,0,0,0.85)]">
            </div>

            <!-- Bi-Lingual Role Title Banner with Role Color Accent -->
            <div class="w-full text-center mt-1 mb-2 px-3 py-1.5 rounded-2xl shadow-lg border backdrop-blur-md"
                 style="background: {{ $theme['badge_bar_bg'] }}; border-color: {{ $theme['bar_border'] }};">
                <h3 class="text-embroidered-white text-[14px] sm:text-[16px] font-black tracking-wide uppercase text-center whitespace-nowrap overflow-visible" dir="ltr"
                    style="text-shadow: 0 2px 4px rgba(0,0,0,0.9);">
                    {{ $theme['badge'] }}
                </h3>
            </div>

        </div>
    </div>


    <!-- JS Function to export Badge as High Resolution Image -->
    <script>
    function downloadBadgeAsImage() {
        const card = document.querySelector('.card-body-3d');
        if (!card) return;

        const origTransform = card.style.transform;
        const origBoxShadow = card.style.boxShadow;

        card.style.transform = 'none';
        card.style.boxShadow = 'none';

        html2canvas(card, {
            scale: 4,
            useCORS: true,
            allowTaint: true,
            backgroundColor: null,
            logging: false,
            onclone: (clonedDoc) => {
                const clonedCard = clonedDoc.querySelector('.card-body-3d');
                if (clonedCard) {
                    clonedCard.style.transform = 'none';
                    clonedCard.style.boxShadow = 'none';
                    clonedCard.style.overflow = 'visible';
                }
                const elements = clonedDoc.querySelectorAll('.text-embroidered-white, h2, h3');
                elements.forEach(el => {
                    el.style.overflow = 'visible';
                    el.style.paddingTop = '6px';
                    el.style.paddingBottom = '6px';
                    el.style.lineHeight = '1.6';
                    el.style.textShadow = '0px 2px 4px rgba(0,0,0,0.9)';
                });
            }
        }).then(canvas => {
            card.style.transform = origTransform;
            card.style.boxShadow = origBoxShadow;

            const link = document.createElement('a');
            link.download = 'badge-accreditation-wsap-{{ Str::slug($nameLatin ?: "official") }}.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
        }).catch(err => {
            card.style.transform = origTransform;
            card.style.boxShadow = origBoxShadow;
            console.error('Error exporting image:', err);
            alert('حدث خطأ أثناء تحميل الصورة.');
        });
    }
    </script>

</div>
