<div class="min-h-screen py-10 px-4 flex flex-col items-center justify-center bg-white font-sans print:bg-white print:py-0 print:px-0">
    
    {{-- Absolute Single-Page PVC Badge Print CSS Engine --}}
    <style>
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
        .print\:hidden {
            display: none !important;
        }
    }

    /* 3D Deep Physics Styles */
    .card-body-3d {
        width: 380px;
        height: 620px;
        border-radius: 40px;
        position: relative;
        background: var(--theme-card-bg, linear-gradient(145deg, #3B225C 0%, #221235 100%));
        box-shadow: 
            30px 40px 60px -10px rgba(0, 0, 0, 0.7),
            0px 20px 40px rgba(0, 0, 0, 0.5),
            inset 8px 8px 15px rgba(255, 255, 255, 0.25),
            inset 2px 2px 5px rgba(255, 255, 255, 0.3),
            inset -8px -8px 20px rgba(0, 0, 0, 0.85),
            inset -2px -2px 5px var(--theme-edge-color, #020A24),
            0 0 0 4px rgba(255, 255, 255, 0.15);
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 25px;
        z-index: 10;
        transform: rotateX(2deg) rotateY(-2deg);
        transform-style: preserve-3d;
        transition: transform 0.3s ease;
    }
    .card-body-3d:hover {
        transform: rotateX(0deg) rotateY(0deg) scale(1.02);
    }
    .lanyard-hole-3d {
        width: 70px;
        height: 18px;
        background: radial-gradient(circle at center, #ffffff 0%, #e0e6ed 100%);
        border-radius: 12px;
        margin-top: 5px;
        position: relative;
        z-index: 20;
        box-shadow: 
            inset 0 8px 10px rgba(0,0,0,0.7),
            inset 0 -2px 5px rgba(255,255,255,0.4),
            0 2px 3px rgba(255,255,255,0.2);
    }
    .lanyard-hole-3d::before {
        content: '';
        position: absolute;
        top: -4px; left: -4px; right: -4px; bottom: -4px;
        border-radius: 16px;
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%);
        z-index: -1;
        box-shadow: 0 4px 6px rgba(0,0,0,0.5), inset 1px 1px 2px rgba(255,255,255,0.9);
    }
    /* Subtle Soft Glow & Embroidered Fabric Stitch Effect (برودري قماشي خفيف) */
    .text-embroidered-white {
        color: #FFFFFF;
        text-shadow: 
            0px -1px 0px rgba(255,255,255,0.55),
            0px 2px 3px rgba(0,0,0,0.88),
            1px 1px 1px rgba(0,0,0,0.65);
        letter-spacing: 0.03em;
    }
    .text-embroidered-accent {
        color: var(--theme-text-accent, #87CEEB);
        text-shadow: 
            0px -0.8px 0px rgba(255,255,255,0.5),
            0px 1.5px 2px rgba(0,0,0,0.9);
        letter-spacing: 0.05em;
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
    <div class="w-full max-w-md mb-8 flex items-center justify-between text-slate-900 print:hidden bg-white border border-slate-200 p-4 rounded-2xl shadow-xl">
        <a href="{{ $badgeBackRoute }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 border border-slate-200 text-xs font-bold text-slate-800 transition flex items-center gap-1.5 shadow-xs">
            <svg class="w-4 h-4 text-[#06205C]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Retour au tableau de bord' : (app()->getLocale() === 'en' ? 'Back to Dashboard' : 'الرجوع للوحة التحكم') }}</span>
        </a>
        
        <button onclick="window.print()" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-[#06205C] to-[#0A3580] hover:from-[#041640] hover:to-[#06205C] text-amber-300 font-black text-xs shadow-lg shadow-[#06205C]/20 transition flex items-center gap-2 border border-amber-400/40">
            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            <span>طباعة الشارة الرسمية (Print PVC Badge)</span>
        </button>
    </div>

    @php
        $roleKey = strtoupper($roleTitle);
        $theme = match($roleKey) {
            'SPEAKER' => [
                'card_bg' => 'linear-gradient(145deg, #4C1D95 0%, #1E0235 100%)',
                'edge_color' => '#1A032A',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#E9D5FF',
                'divider_glow' => '#C084FC',
                'badge' => 'محاضر رئيسي — SPEAKER',
            ],
            'MINISTERIAL EXECUTIVE OBSERVER', 'MINISTERIAL_OBSERVER' => [
                'card_bg' => 'linear-gradient(145deg, #311B92 0%, #0D0536 100%)',
                'edge_color' => '#0A0328',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#FFD700',
                'divider_glow' => '#FFC107',
                'badge' => 'وزير / مراقب تنفيذي — MINISTERIAL EXECUTIVE OBSERVER',
            ],
            'DELEGATION HEAD', 'DELEGATION_HEAD' => [
                'card_bg' => 'linear-gradient(145deg, #023E28 0%, #011F14 100%)',
                'edge_color' => '#011C13',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#F3E5AB',
                'divider_glow' => '#D4AF37',
                'badge' => 'مسؤول الوفد — DELEGATION HEAD',
            ],
            'VIP', 'VIP DIPLOMATIC' => [
                'card_bg' => 'linear-gradient(145deg, #023E28 0%, #011F14 100%)',
                'edge_color' => '#011C13',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#F3E5AB',
                'divider_glow' => '#D4AF37',
                'badge' => 'عضو دبلوماسي — VIP DIPLOMATIC',
            ],
            'EXPERT JUDGE' => [
                'card_bg' => 'linear-gradient(145deg, #1E1B4B 0%, #0B1021 100%)',
                'edge_color' => '#0A0F1D',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#87CEEB',
                'divider_glow' => '#4FC3F7',
                'badge' => 'خبير محكّم — EXPERT JUDGE',
            ],
            'MEDIA' => [
                'card_bg' => 'linear-gradient(145deg, #78350F 0%, #240C02 100%)',
                'edge_color' => '#2B1003',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#FDE68A',
                'divider_glow' => '#F59E0B',
                'badge' => 'وفد إعلامي — MEDIA / PRESS',
            ],
            'ORGANIZER' => [
                'card_bg' => 'linear-gradient(145deg, #1E293B 0%, #0F172A 100%)',
                'edge_color' => '#090D16',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#CBD5E1',
                'divider_glow' => '#94A3B8',
                'badge' => 'منظم رسمي — ORGANIZER',
            ],
            'VOLUNTEER' => [
                'card_bg' => 'linear-gradient(145deg, #134E4A 0%, #032624 100%)',
                'edge_color' => '#021F1D',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#99F6E4',
                'divider_glow' => '#2DD4BF',
                'badge' => 'متطوع — VOLUNTEER',
            ],
            default => [
                'card_bg' => 'linear-gradient(145deg, #06205C 0%, #01091C 100%)',
                'edge_color' => '#020A24',
                'rim_grad' => 'linear-gradient(135deg, #ffffff 0%, #f8fafc 50%, #e2e8f0 100%)',
                'text_accent' => '#BAE6FD',
                'divider_glow' => '#38BDF8',
                'badge' => 'متنافس رسمي — COMPETITOR',
            ],
        };

        $verifyUrl = route('verify', ['token' => $token]);
        $qrCodeUrl = \App\Services\QrCodeService::generateDataUri($verifyUrl, 350);
        $nameAr = $registration?->participant?->first_name_ar ? ($registration->participant->first_name_ar . ' ' . $registration->participant->last_name_ar) : ($user?->name ?? $badge?->user?->name ?? 'عضو معتمد');
        $nameLatin = $registration?->participant?->first_name_latin ? ($registration->participant->first_name_latin . ' ' . $registration->participant->last_name_latin) : ($user?->email ?? 'Accredited Member');
    @endphp

    <!-- REALISTIC 3D LANYARD FABRIC STRAP & METALLIC CLIP (PERFECTLY INSERTED INTO CENTER HOLE CUTOUT) -->
    <div class="relative flex flex-col items-center z-50 -mb-10 print:hidden pointer-events-none">
        <img src="/lanyard-strap.png" alt="Official Lanyard Strap & Swivel Clip" class="w-72 sm:w-80 h-auto object-contain drop-shadow-[0_25px_40px_rgba(0,0,0,0.85)] translate-x-12 sm:translate-x-14 translate-y-3.5 sm:translate-y-4">
    </div>

    <!-- DYNAMIC ROLE-BASED 3D DEEP PHYSICAL BADGE -->
    <div class="print-badge-container card-body-3d" style="--theme-card-bg: {{ $theme['card_bg'] }}; --theme-text-accent: {{ $theme['text_accent'] }}; --theme-edge-color: {{ $theme['edge_color'] }}; --theme-rim-grad: {{ $theme['rim_grad'] }};">
        
        <!-- Deep Lanyard Cutout -->
        <div class="lanyard-hole-3d">
            <div style="position: absolute; top:-4px; left:-4px; right:-4px; bottom:-4px; border-radius:16px; background: var(--theme-rim-grad); z-index:-1; box-shadow: 0 4px 6px rgba(0,0,0,0.5), inset 1px 1px 2px rgba(255,255,255,0.8);"></div>
        </div>

        <div class="relative z-20 w-full flex flex-col flex-grow justify-between mt-2 overflow-hidden">
            
            <!-- Top Section: Centered Official State Emblem Logo (Perfectly Sized & Clear) -->
            <div class="w-full flex justify-center items-center pt-2 pb-1 px-2">
                <img src="/LOGO01.png" alt="State Emblem Engraved" class="h-28 sm:h-30 w-auto max-w-[92%] object-contain" style="filter: drop-shadow(0px -1px 1px rgba(255,255,255,0.85)) drop-shadow(0px 4px 6px rgba(0,0,0,0.92));">
            </div>

            <!-- Center: 100% Perfect Centered 3D Extruded White QR Plate -->
            <div class="w-full flex justify-center items-center my-2 z-30">
                <div class="relative w-[250px] h-[250px] bg-white rounded-3xl p-4 flex flex-col items-center justify-between border-2 border-white/90 shadow-[0_14px_0_rgba(10,3,26,0.95),0_20px_35px_rgba(0,0,0,0.85)]">
                    <div class="w-[190px] h-[190px] flex items-center justify-center p-1 bg-white rounded-xl shadow-inner border border-slate-100">
                        <img src="{{ $qrCodeUrl }}" alt="Encrypted QR Code" class="w-full h-full object-contain">
                    </div>
                    <div class="text-[8px] font-mono font-black text-slate-600 uppercase tracking-widest text-center">SECURED BY WSAP ZERO-TRUST</div>
                </div>
            </div>

            <!-- Bottom Details Section (Name Right, WorldSkills Logo Left on Opposite Side) -->
            <div class="flex items-center justify-between w-full px-3 mt-1 gap-3">
                
                <!-- Name Right (Luxurious Embroidered Fabric Stitching) -->
                <div class="text-right flex-1 min-w-0 flex flex-col justify-center">
                    <h2 class="text-embroidered-white text-[19px] sm:text-[21px] font-extrabold mb-0.5 leading-tight tracking-wide text-right truncate">{{ $nameAr }}</h2>
                    <div class="divider-stitched-line"></div>
                    <div class="text-embroidered-accent text-[9.5px] font-sans uppercase tracking-wider font-bold text-right truncate" dir="ltr">{{ $nameLatin }}</div>
                </div>

                <!-- WorldSkills Logo Image (Opposite Left Side, Proportionally Sized to Match Name Height) -->
                <div class="flex items-center justify-center shrink-0" dir="ltr">
                    <img src="/logo.svg" alt="WorldSkills Logo" class="h-12 sm:h-13 w-auto object-contain filter brightness-0 invert drop-shadow-[0_4px_8px_rgba(0,0,0,0.85)]">
                </div>
            </div>

            <!-- Bi-Lingual Luxurious Embroidered Role Title Banner (Arabic & English) -->
            <div class="w-full text-center mt-2 mb-1 px-2">
                <h3 class="text-embroidered-white text-[17px] sm:text-[19px] font-serif font-extrabold tracking-wide uppercase text-center truncate" dir="ltr">{{ $theme['badge'] }}</h3>
            </div>

        </div>
    </div>

</div>
