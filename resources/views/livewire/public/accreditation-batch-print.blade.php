<div class="min-h-screen py-8 px-4 bg-[#F4F7FC] text-[#06205C] print:bg-white print:py-0 print:px-0">
    
    <style>
    @media print {
        @page {
            size: A4 portrait;
            margin: 10mm;
        }
        html, body {
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .print\:hidden {
            display: none !important;
        }
        .batch-card {
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            box-shadow: none !important;
        }
    }
    </style>

    <!-- Print Action Header -->
    <div class="max-w-5xl mx-auto mb-8 flex items-center justify-between print:hidden">
        <div>
            <h1 class="text-2xl font-black text-[#06205C]">طباعة دفعة شارات الاعتماد الرسمية (Batch Badge Print)</h1>
            <p class="text-xs text-slate-500 font-medium">طباعة الشارات الرسمية لجميع الأعضاء المعتمدين على ورق A4 (جاهزة للتقطيع والتعليق)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.accreditations') }}" class="px-4 py-2.5 rounded-xl bg-white hover:bg-slate-100 border border-slate-200 text-xs font-bold text-[#06205C] transition shadow-xs">
                رجوع
            </a>
            <button onclick="window.print()" class="px-6 py-2.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-white font-black text-xs shadow-lg shadow-emerald-500/30 transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                <span>طباعة جميع الشارات (A4 Print)</span>
            </button>
        </div>
    </div>

    <!-- A4 Sheet Grid Layout for Printing Badges -->
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 print:grid-cols-2 print:gap-4 print:max-w-none print:w-full">
        @foreach($users as $u)
            @php
                $reg       = $u->participant?->registrations?->first();
                $badge     = $u->badges->first();
                $userRole  = $u->roles->first()?->name;

                $roleTitle = $badge?->role_title ?? match ($userRole) {
                    'MEDIA_MANAGER'                     => 'MEDIA',
                    'EXECUTIVE_VIEWER', 'COUNTRY_ADMIN' => 'VIP DIPLOMATIC',
                    'JUDGE', 'EXPERT'                   => 'EXPERT JUDGE',
                    'ORGANIZATION_ADMIN', 'SUPER_ADMIN' => 'ORGANIZER',
                    default                             => 'COMPETITOR',
                };

                $roleKey = strtoupper($roleTitle);
                $theme = match($roleKey) {
                    'SPEAKER'                                  => ['bg' => 'from-[#2A0542] via-[#4C1D95] to-[#6B21A8]', 'text' => 'text-purple-300', 'badge' => 'SPEAKER'],
                    'VIP', 'VIP DIPLOMATIC', 'DELEGATION HEAD' => ['bg' => 'from-[#011C13] via-[#023E28] to-[#011F14]', 'text' => 'text-amber-300', 'badge' => 'VIP DIPLOMATIC'],
                    'EXPERT JUDGE'                             => ['bg' => 'from-[#0F172A] via-[#1E1B4B] to-[#4338CA]', 'text' => 'text-indigo-200', 'badge' => 'EXPERT JUDGE'],
                    'MEDIA'                                    => ['bg' => 'from-[#451A03] via-[#78350F] to-[#D97706]', 'text' => 'text-amber-200', 'badge' => 'MEDIA / PRESS'],
                    'ORGANIZER'                                => ['bg' => 'from-[#090D16] via-[#0F172A] to-[#334155]', 'text' => 'text-slate-300', 'badge' => 'ORGANIZER'],
                    'VOLUNTEER'                                => ['bg' => 'from-[#042F2C] via-[#134E4A] to-[#0D9488]', 'text' => 'text-teal-200', 'badge' => 'VOLUNTEER'],
                    default                                    => ['bg' => 'from-[#020A24] via-[#06205C] to-[#0066FF]', 'text' => 'text-sky-200', 'badge' => 'COMPETITOR'],
                };

                $token = $reg?->verification_token ?? $badge?->access_token ?? $u->uuid;
                $verifyUrl = route('verify', ['token' => $token]);
                $qrCodeUrl = \App\Services\QrCodeService::generateDataUri($verifyUrl, 250);
                $nameAr = $u->participant?->first_name_ar ? ($u->participant->first_name_ar . ' ' . $u->participant->last_name_ar) : $u->name;
                $nameLatin = $u->participant?->first_name_latin ? ($u->participant->first_name_latin . ' ' . $u->participant->last_name_latin) : $u->email;
            @endphp

            <div class="w-[310px] h-[500px] rounded-3xl bg-gradient-to-b {{ $theme['bg'] }} text-white p-5 shadow-2xl relative overflow-hidden flex flex-col justify-between border-2 border-white/30 mx-auto print:w-[300px] print:h-[480px] print:shadow-none print:break-inside-avoid batch-card">
                <!-- Top Logos Header -->
                <div class="flex items-center justify-between px-3 pt-2 pb-1">
                    <img src="/LOGO01.png" alt="Ministry Seal" class="h-14 w-auto filter brightness-0 invert drop-shadow-md shrink-0">
                    <img src="/logo.svg" alt="WorldSkills" class="h-10 w-auto filter brightness-0 invert shrink-0">
                </div>

                <!-- Central Encrypted QR Code Box -->
                <div class="my-auto text-center space-y-2">
                    <div class="bg-white rounded-2xl p-3 shadow-xl mx-auto w-44 h-44 flex flex-col items-center justify-center border border-white/80">
                        <img src="{{ $qrCodeUrl }}" alt="Encrypted QR Code" class="w-full h-full object-contain">
                    </div>

                    <!-- User Name & Details -->
                    <div class="space-y-0.5 px-1">
                        <h2 class="text-base font-black tracking-tight text-white line-clamp-1">
                            {{ $nameAr }}
                        </h2>
                        <p class="text-xs font-bold {{ $theme['text'] }} font-mono line-clamp-1 uppercase">
                            {{ $nameLatin }}
                        </p>
                    </div>
                </div>

                <!-- Role Banner -->
                <div class="bg-black/30 backdrop-blur-md rounded-2xl p-3 text-center border border-white/20">
                    <span class="text-xs font-black tracking-widest uppercase text-white drop-shadow-xs">
                        {{ $theme['badge'] }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

</div>
