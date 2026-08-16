<div class="pt-28 pb-16 bg-slate-50/80 min-h-screen relative overflow-hidden"
     x-data="{
         draftRestored: false,
         draft: {
             role: @entangle('role'),
             countryId: @entangle('countryId'),
             firstNameAr: @entangle('firstNameAr'),
             lastNameAr: @entangle('lastNameAr'),
             firstNameLatin: @entangle('firstNameLatin'),
             lastNameLatin: @entangle('lastNameLatin'),
             email: @entangle('email'),
             phone: @entangle('phone'),
             dateOfBirth: @entangle('dateOfBirth'),
             gender: @entangle('gender'),
             organizationName: @entangle('organizationName'),
             jobTitle: @entangle('jobTitle'),
             presentationTopic: @entangle('presentationTopic'),
             skillId: @entangle('skillId'),
             nationalId: @entangle('nationalId'),
             passportNumber: @entangle('passportNumber')
         },
         init() {
             const saved = localStorage.getItem('asf_registration_draft_v6');
             if (saved && !@js($isSubmitted)) {
                 try {
                     const data = JSON.parse(saved);
                     let restoredAny = false;
                     Object.keys(data).forEach(key => {
                         if (data[key] !== null && data[key] !== undefined && data[key] !== '') {
                             $wire.set(key, data[key], false);
                             restoredAny = true;
                         }
                     });
                     if (restoredAny) {
                         this.draftRestored = true;
                     }
                 } catch (e) {}
             }

             if (@js($isSubmitted)) {
                 localStorage.removeItem('asf_registration_draft_v6');
             }

             this.$watch('draft', (val) => {
                 if (!@js($isSubmitted)) {
                     localStorage.setItem('asf_registration_draft_v6', JSON.stringify(val));
                 }
             }, { deep: true });
         },
         clearDraft() {
             localStorage.removeItem('asf_registration_draft_v6');
             location.reload();
         }
     }"
     dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- PRINT STYLES FOR CLEAN A4 PRINTING --}}
    <style>
    @media print {
        header, footer, nav, .print\:hidden, .banner-header-container {
            display: none !important;
        }

        body, html, main {
            background: #ffffff !important;
            color: #0f172a !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .pt-28 {
            padding-top: 0 !important;
            padding-bottom: 0 !important;
        }

        .max-w-4xl {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .printable-voucher {
            border: 2px solid #092C1D !important;
            border-radius: 20px !important;
            padding: 24px !important;
            box-shadow: none !important;
            margin: 0 auto !important;
            page-break-inside: avoid !important;
            background: white !important;
        }

        .status-banner-print {
            background: #041B2D !important;
            color: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        @page {
            size: A4 portrait;
            margin: 8mm;
        }
    }
    </style>

    @php
        $locale = app()->getLocale();
    @endphp

    @php
        $t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
    @endphp

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- BANNER HEADER -->
        <div class="banner-header-container mb-8 rounded-3xl bg-gradient-to-r from-[#041B2D] via-[#092C1D] to-[#35A536] p-8 sm:p-10 text-white shadow-2xl relative overflow-hidden border border-emerald-500/20 print:hidden">
            <div class="relative z-10 max-w-2xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-xs font-black mb-3">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $t('البوابة الرسمية لطلب الاعتماد والتسجيل', 'Portail d\'Accréditation Officiel', 'Official Accreditation Portal') }}</span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-black tracking-tight leading-tight">
                    {{ $t('تسجيل وتوثيق طلب الاعتماد الرسمي', 'Inscription des Intervenants, Visiteurs & Experts', 'Speakers, Visitors & Experts Registration') }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 mt-2 font-medium">
                    {{ $t('أدخل بياناتك الرسمية وحمّل صورتك الشخصية أدناه لإرسال وتوثيق طلبك فوراً.', 'Remplissez vos informations ci-dessous et téléchargez votre photo pour soumettre votre demande.', 'Fill out your official details below and upload your photo to submit your accreditation.') }}
                </p>
            </div>
        </div>

        @if(!($isOpen ?? false) && !$isSubmitted)
            <div class="bg-white rounded-3xl p-8 sm:p-12 shadow-xl border border-slate-200 text-center space-y-6">
                <div class="w-16 h-16 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center mx-auto text-2xl font-bold border border-amber-200">
                    🔒
                </div>
                <div class="space-y-2 max-w-md mx-auto">
                    <h2 class="text-xl font-black text-[#06205C]">
                        {{ $t('التسجيل المباشر مغلق حالياً', 'Inscriptions Publiques Fermées', 'Public Self-Registration Currently Closed') }}
                    </h2>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        {{ $t('تم توقيف وإغلاق استلام طلبات التسجيل المباشر عبر البوابة العامة. يتم منح الحسابات وشارات الاعتماد حصرياً عن طريق إدارة الفعالية ورؤساء الوفود الوطنية.', 'Les inscriptions publiques directes sont actuellement fermées. Les accréditations sont attribuées exclusivement par l\'administration officielle et les chefs de délégation.', 'Public self-registrations are currently closed. Official accreditations and accounts are issued directly by the event administration and national delegation heads.') }}
                    </p>
                </div>
                <div class="pt-4 border-t border-slate-100 flex justify-center">
                    <a href="{{ route('login') }}" class="px-6 py-3 rounded-2xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-black text-xs shadow-md transition">
                        {{ $t('تسجيل الدخول للحسابات الرسمية 🔑', 'Se Connecter', 'Official Account Login') }}
                    </a>
                </div>
            </div>
        @elseif($isSubmitted)

            {{-- SUCCESS / ACCOUNT CREATED VOUCHER SCREEN --}}
            <div class="printable-voucher bg-white rounded-3xl p-8 sm:p-12 shadow-2xl border border-slate-200 space-y-8 animate-in fade-in zoom-in-95">
                
                {{-- Official Voucher Top Bar --}}
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4 border-b border-slate-200 pb-6">
                    <div class="flex items-center gap-4">
                        <img src="/ministry-logo.png" alt="Ministry Logo" class="h-14 w-auto object-contain">
                        <img src="/africa-logo-trimmed.png" alt="African Union" class="h-12 w-auto object-contain">
                    </div>
                    <div class="px-4 py-2 rounded-full bg-emerald-100 text-emerald-800 font-black text-xs border border-emerald-300 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-emerald-600 print:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ $t('وصل التسجيل والاعتماد الرسمي — Official Voucher', 'Reçu Officiel d\'Accréditation — Official Voucher', 'Official Accreditation Voucher') }}</span>
                    </div>
                </div>

                {{-- Status Banner --}}
                <div class="status-banner-print bg-gradient-to-r from-[#041B2D] to-[#092C1D] text-white p-6 sm:p-8 rounded-2xl shadow-xl text-center space-y-3">
                    <div class="w-16 h-16 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-400/40 flex items-center justify-center mx-auto print:hidden">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="text-xl sm:text-2xl font-black">
                        {{ $t('تم إرسال وتسجيل طلب الاعتماد بنجاح!', 'Demande d\'accréditation enregistrée avec succès !', 'Accreditation request registered successfully!') }}
                    </h2>
                    <div class="inline-block px-5 py-2 rounded-2xl bg-amber-400/20 border border-amber-300/40 text-amber-200 font-black text-sm sm:text-base my-1 shadow-inner">
                        📞 {{ $t('سيتم الاتصال بك عبر البريد الإلكتروني أو رقم الهاتف فقط', 'Vous serez contacté par e-mail ou par téléphone uniquement.', 'You will be contacted via email or phone only.') }}
                    </div>
                    <p class="text-xs text-slate-200 font-medium max-w-xl mx-auto">
                        {{ $t('تم تسجيل معلوماتك وصورتك الشخصية وتوليد رقم التوثيق والاعتماد الخاص بك بنجاح لدى أمانة المنتدى.', 'Vos informations et photo ont été enregistrées avec succès auprès du comité d\'organisation.', 'Your details and photo have been registered with the competition committee.') }}
                    </p>
                </div>

                {{-- REGISTRATION CODE VOUCHER CARD --}}
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200 space-y-4">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-200 pb-3">
                        <svg class="w-5 h-5 text-blue-600 print:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $t('رقم التسجيل ورمز الاعتماد الرسمي (Registration Code):', 'Code Officiel d\'Inscription (Registration Code) :', 'Official Registration Code:') }}</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-bold">
                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                            <div>
                                <span class="text-slate-500 block mb-1">{{ $t('رمز التسجيل والاعتماد:', 'Code d\'Inscription :', 'Registration Code:') }}</span>
                                <span class="font-mono text-lg font-black text-emerald-700 tracking-wider">{{ $registrationNumber }}</span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold">
                                🆔
                            </div>
                        </div>

                        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs flex items-center justify-between">
                            <div>
                                <span class="text-slate-500 block mb-1">{{ $t('البريد المسجّل للتواصل:', 'Email de contact :', 'Contact Email:') }}</span>
                                <span class="font-mono text-xs font-black text-slate-900 truncate block" dir="ltr">{{ $email }}</span>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold">
                                ✉️
                            </div>
                        </div>
                    </div>
                </div>

                {{-- PARTICIPANT SUMMARY DETAILS FOR PRINT --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-5 rounded-2xl border border-slate-200 text-xs font-bold">
                    <div class="space-y-2">
                        <div class="flex justify-between border-b border-slate-200 pb-1.5">
                            <span class="text-slate-500">{{ $t('اسم المترشح:', 'Nom & Prénom :', 'Candidate Name:') }}</span>
                            <span class="font-black text-slate-900">{{ $firstNameAr ?: $firstNameLatin }} {{ $lastNameAr ?: $lastNameLatin }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-1.5">
                            <span class="text-slate-500">{{ $t('الاسم باللاتينية:', 'Nom en latin :', 'Latin Name:') }}</span>
                            <span class="font-black text-slate-900" dir="ltr">{{ $firstNameLatin }} {{ $lastNameLatin }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-1.5">
                            <span class="text-slate-500">{{ $t('صفة المشاركة:', 'Qualité / Rôle :', 'Registration Role:') }}</span>
                            <span class="font-black text-emerald-700">{{ $role === 'SPEAKER' ? $t('محاضر رئيسي', 'Conférencier Principal', 'Keynote Speaker') : ($role === 'EXPERT' ? $t('خبير محكّم', 'Expert Juge', 'Expert Judge') : $t('زائر معتمد', 'Visiteur Accrédité', 'Accredited Visitor')) }}</span>
                        </div>
                    </div>
                    <div class="space-y-2">
                        <div class="flex justify-between border-b border-slate-200 pb-1.5">
                            <span class="text-slate-500">{{ $t('الهاتف الشخصي:', 'Téléphone :', 'Phone Number:') }}</span>
                            <span class="font-mono text-slate-900" dir="ltr">{{ $phone }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-1.5">
                            <span class="text-slate-500">{{ $t('المؤسسة / الهيئة:', 'Organisme / Établissement :', 'Organization / Institution:') }}</span>
                            <span class="font-black text-slate-900">{{ $organizationName }}</span>
                        </div>
                        <div class="flex justify-between border-b border-slate-200 pb-1.5">
                            <span class="text-slate-500">{{ $t('الوظيفة / المسمى:', 'Fonction / Intitulé :', 'Job Title / Position:') }}</span>
                            <span class="font-black text-slate-900">{{ $jobTitle }}</span>
                        </div>
                    </div>
                </div>

                {{-- BADGE APPROVAL STATUS EXPLANATION --}}
                <div class="bg-amber-50/80 border-2 border-amber-300 rounded-2xl p-6 space-y-2 text-xs text-amber-900 font-bold">
                    <div class="flex items-center gap-2 text-amber-800 font-black text-sm">
                        <svg class="w-5 h-5 text-amber-600 print:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $t('تنبيه هام بشأن المراجعة والتواصل:', 'Note importante concernant le suivi :', 'Important Notice Regarding Approval & Contact:') }}</span>
                    </div>
                    <p class="leading-relaxed">
                        {{ $t('طلبك حالياً قيد المراجعة والدراسة لدى أمانة المنتدى واللجنة التنفيذية. عند صدور الموافقة والاعتماد النهائي، سيتم التواصل معك مباشرة وإرسال الشارة ووصل الدخول عبر البريد الإلكتروني أو رقم الهاتف المسجل في طلبك.', 'Votre demande est actuellement en cours d\'examen par la commission. Dès validation, vous serez contacté directement par e-mail ou par téléphone.', 'Your application is currently under review. Upon final approval, you will be contacted directly via email or phone.') }}
                    </p>
                </div>

                {{-- ACTION BUTTONS --}}
                <div class="pt-4 flex flex-wrap items-center justify-center gap-4 print:hidden">
                    <button type="button" onclick="window.print()"
                            class="px-8 py-4 bg-gradient-to-r from-[#041B2D] to-[#092C1D] hover:bg-black text-white font-black rounded-2xl text-xs sm:text-sm shadow-xl transition-all duration-300 flex items-center gap-2 hover:scale-105 border border-emerald-500/30">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>{{ $t('طباعة وصل التسجيل والاعتماد الرسمي 🖨️', 'Imprimer le Reçu Officiel 🖨️', 'Print Official Registration Voucher 🖨️') }}</span>
                    </button>
                </div>

            </div>

        @else

            <!-- SINGLE UNIFIED HIGHLY PRACTICAL REGISTRATION FORM -->
            <div class="bg-white/95 backdrop-blur-2xl border border-slate-200/90 rounded-3xl p-6 sm:p-10 shadow-[0_20px_60px_-15px_rgba(0,0,0,0.07)] space-y-8 print:hidden">

                <!-- Section 1: Role Selection & Delegation Country -->
                <div class="space-y-4">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-200 pb-3">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        <span>{{ $t('1. صفة التسجيل والدولة (Role & Delegation Country):', '1. Rôle & Pays de la Délégation :', '1. Role & Delegation Country:') }}</span>
                    </h3>

                    <!-- Role Capacity Cards -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <!-- Speaker Option -->
                        <label class="relative flex flex-col p-5 rounded-2xl border-2 cursor-pointer transition-all duration-300 {{ $role === 'SPEAKER' ? 'border-[#35A536] bg-emerald-50/60 shadow-lg ring-4 ring-[#35A536]/15 scale-[1.02]' : 'border-slate-200 hover:border-slate-300 bg-slate-50/40 hover:bg-white' }}">
                            <input type="radio" wire:model.live="role" value="SPEAKER" class="sr-only">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-emerald-700 text-white flex items-center justify-center shadow-md">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                                </div>
                                <span class="w-6 h-6 rounded-full border-2 flex items-center justify-center {{ $role === 'SPEAKER' ? 'border-[#35A536] bg-[#35A536]' : 'border-slate-300' }}">
                                    @if($role === 'SPEAKER') <span class="w-2.5 h-2.5 rounded-full bg-white"></span> @endif
                                </span>
                            </div>
                            <span class="font-black text-slate-900 text-base">
                                {{ $t('محاضر رئيسي / متحدث', 'Intervenant / Conférencier', 'Keynote Speaker') }}
                            </span>
                            <span class="text-xs text-slate-500 mt-1 font-medium leading-relaxed">
                                {{ $t('مشاركة بأوراق بحثية ومداخلات', 'Gérer ou animer des sessions', 'Deliver speeches & panels') }}
                            </span>
                        </label>

                        <!-- Visitor Option -->
                        <label class="relative flex flex-col p-5 rounded-2xl border-2 cursor-pointer transition-all duration-300 {{ $role === 'VISITOR' ? 'border-sky-600 bg-sky-50/60 shadow-lg ring-4 ring-sky-600/15 scale-[1.02]' : 'border-slate-200 hover:border-slate-300 bg-slate-50/40 hover:bg-white' }}">
                            <input type="radio" wire:model.live="role" value="VISITOR" class="sr-only">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-sky-500 to-sky-700 text-white flex items-center justify-center shadow-md">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                </div>
                                <span class="w-6 h-6 rounded-full border-2 flex items-center justify-center {{ $role === 'VISITOR' ? 'border-sky-600 bg-sky-600' : 'border-slate-300' }}">
                                    @if($role === 'VISITOR') <span class="w-2.5 h-2.5 rounded-full bg-white"></span> @endif
                                </span>
                            </div>
                            <span class="font-black text-slate-900 text-base">
                                {{ $t('زائر معتمد / مشارك', 'Visiteur Accrédité / Participant', 'Accredited Visitor / Participant') }}
                            </span>
                            <span class="text-xs text-slate-500 mt-1 font-medium leading-relaxed">
                                {{ $t('حضور الجلسات وتغطية المنتدى', 'Assister aux conférences & salon', 'Attend sessions & exhibition') }}
                            </span>
                        </label>

                        <!-- Expert Option -->
                        <label class="relative flex flex-col p-5 rounded-2xl border-2 cursor-pointer transition-all duration-300 {{ $role === 'EXPERT' ? 'border-indigo-600 bg-indigo-50/60 shadow-lg ring-4 ring-indigo-600/15 scale-[1.02]' : 'border-slate-200 hover:border-slate-300 bg-slate-50/40 hover:bg-white' }}">
                            <input type="radio" wire:model.live="role" value="EXPERT" class="sr-only">
                            <div class="flex items-center justify-between mb-3">
                                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-500 to-indigo-700 text-white flex items-center justify-center shadow-md">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                </div>
                                <span class="w-6 h-6 rounded-full border-2 flex items-center justify-center {{ $role === 'EXPERT' ? 'border-indigo-600 bg-indigo-600' : 'border-slate-300' }}">
                                    @if($role === 'EXPERT') <span class="w-2.5 h-2.5 rounded-full bg-white"></span> @endif
                                </span>
                            </div>
                            <span class="font-black text-slate-900 text-base">
                                {{ $t('خبير محكّم / خبير دولي', 'Expert / Juge Technique', 'Expert Judge') }}
                            </span>
                            <span class="text-xs text-slate-500 mt-1 font-medium leading-relaxed">
                                {{ $t('إشراف وتحكيم تقني تخصصي', 'Évaluation & encadrement technique', 'Technical evaluation & skill mentor') }}
                            </span>
                        </label>
                    </div>

                    <!-- Delegation Country -->
                    <div>
                        <label class="block text-sm font-bold text-slate-800 mb-1.5">
                            {{ $t('اختر دولة الوفد المشارك *', 'Pays de la Délégation *', 'Delegation Country *') }}
                        </label>
                        <select wire:model.live="countryId"
                                class="w-full rounded-2xl border-slate-200 focus:border-[#35A536] focus:ring-4 focus:ring-[#35A536]/10 text-slate-900 font-bold text-sm py-3.5 bg-slate-100/70 hover:bg-white focus:bg-white transition-all">
                            @foreach($countries as $country)
                                <option value="{{ $country->id }}">
                                    {{ $locale === 'fr' ? ($country->name_fr ?: $country->name_en) : ($locale === 'en' ? $country->name_en : $country->name_ar) }}
                                    ({{ $country->iso2 }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Section 2: Personal Information -->
                <div class="space-y-4">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-200 pb-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-6 0h6"/></svg>
                        <span>{{ $t('2. البيانات الشخصية (Personal Information):', '2. Informations Personnelles :', '2. Personal Information:') }}</span>
                    </h3>

                    <!-- Names in Arabic -->
                    @if($isArabicCountry)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-1.5">{{ $t('الاسم الشخصي بالعربية *', 'Prénom en Arabe *', 'First Name in Arabic *') }}</label>
                                <input type="text" wire:model.live="firstNameAr" placeholder="{{ $t('مثال: محمد', 'Ex: Mohamed', 'Ex: Mohamed') }}"
                                       class="w-full rounded-2xl border-slate-200 focus:border-[#35A536] focus:ring-4 focus:ring-[#35A536]/10 text-slate-900 font-bold text-sm py-3.5 bg-slate-100/70 hover:bg-white focus:bg-white transition-all">
                                @error('firstNameAr') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-slate-800 mb-1.5">{{ $t('اللقب العائلي بالعربية *', 'Nom de famille en Arabe *', 'Last Name in Arabic *') }}</label>
                                <input type="text" wire:model.live="lastNameAr" placeholder="{{ $t('مثال: الجزائري', 'Ex: Al-Jazairi', 'Ex: Al-Jazairi') }}"
                                       class="w-full rounded-2xl border-slate-200 focus:border-[#35A536] focus:ring-4 focus:ring-[#35A536]/10 text-slate-900 font-bold text-sm py-3.5 bg-slate-100/70 hover:bg-white focus:bg-white transition-all">
                                @error('lastNameAr') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endif

                    <!-- Names in Latin/French -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-1.5">{{ $t('الاسم باللاتينية / Prénom *', 'Prénom en Latin *', 'First Name in Latin *') }}</label>
                            <input type="text" wire:model.live="firstNameLatin" placeholder="Ex: Mohamed"
                                   class="w-full rounded-2xl border-slate-200 focus:border-[#35A536] focus:ring-4 focus:ring-[#35A536]/10 text-slate-900 font-bold text-sm py-3.5 bg-slate-100/70 hover:bg-white focus:bg-white transition-all">
                            @error('firstNameLatin') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-1.5">{{ $t('اللقب باللاتينية / Nom *', 'Nom en Latin *', 'Last Name in Latin *') }}</label>
                            <input type="text" wire:model.live="lastNameLatin" placeholder="Ex: DJAZAIRI"
                                   class="w-full rounded-2xl border-slate-200 focus:border-[#35A536] focus:ring-4 focus:ring-[#35A536]/10 text-slate-900 font-bold text-sm py-3.5 bg-slate-100/70 hover:bg-white focus:bg-white transition-all">
                            @error('lastNameLatin') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Email & Phone -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-1.5">{{ $t('البريد الإلكتروني الرسمي *', 'Adresse Email Officielle *', 'Official Email Address *') }}</label>
                            <input type="email" wire:model.live="email" placeholder="delegate@domain.com"
                                   class="w-full rounded-2xl border-slate-200 focus:border-[#35A536] focus:ring-4 focus:ring-[#35A536]/10 text-slate-900 font-bold text-sm py-3.5 bg-slate-100/70 hover:bg-white focus:bg-white transition-all" dir="ltr">
                            @error('email') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-1.5">{{ $t('رقم الهاتف الشخصي *', 'Numéro de Téléphone *', 'Personal Phone Number *') }}</label>
                            <input type="text" wire:model.live="phone" placeholder="{{ $this->phonePlaceholder }}"
                                   class="w-full rounded-2xl border-slate-200 focus:border-[#35A536] focus:ring-4 focus:ring-[#35A536]/10 text-slate-900 font-bold text-sm py-3.5 bg-slate-100/70 hover:bg-white focus:bg-white transition-all" dir="ltr">
                            @error('phone') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- DOB & Gender -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-1.5">{{ $t('تاريخ الميلاد *', 'Date de Naissance *', 'Date of Birth *') }}</label>
                            <input type="date" wire:model.live="dateOfBirth"
                                   class="w-full rounded-2xl border-slate-200 focus:border-[#35A536] focus:ring-4 focus:ring-[#35A536]/10 text-slate-900 font-bold text-sm py-3.5 bg-slate-100/70 hover:bg-white focus:bg-white transition-all">
                            @error('dateOfBirth') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-1.5">{{ $t('الجنس *', 'Genre *', 'Gender *') }}</label>
                            <select wire:model.live="gender"
                                    class="w-full rounded-2xl border-slate-200 focus:border-[#35A536] focus:ring-4 focus:ring-[#35A536]/10 text-slate-900 font-bold text-sm py-3.5 bg-slate-100/70 hover:bg-white focus:bg-white transition-all">
                                <option value="male">{{ $t('ذكر', 'Masculin', 'Male') }}</option>
                                <option value="female">{{ $t('أنثى', 'Féminin', 'Female') }}</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Professional Details -->
                <div class="space-y-4">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-200 pb-3">
                        <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 1320 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v8z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1"/></svg>
                        <span>{{ $t('3. المؤسسة والوظيفة والتخصص (Professional & Domain):', '3. Organisme & Spécialité :', '3. Organization & Specialty:') }}</span>
                    </h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-1.5">{{ $t('اسم المؤسسة / الهيئة / الجامعة *', 'Nom de l\'Établissement / Organisme *', 'Institution / Organization Name *') }}</label>
                            <input type="text" wire:model.live="organizationName" placeholder="{{ $t('مثال: وزارة التكوين، جامعة وهران...', 'Ex: Ministère, Université d\'Oran...', 'Ex: Ministry, University of Oran...') }}"
                                   class="w-full rounded-2xl border-slate-200 focus:border-[#35A536] focus:ring-4 focus:ring-[#35A536]/10 text-slate-900 font-bold text-sm py-3.5 bg-slate-100/70 hover:bg-white focus:bg-white transition-all">
                            @error('organizationName') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-1.5">{{ $t('الصفة المهنية / المسمى الوظيفي *', 'Fonction / Intitulé du Poste *', 'Job Title / Position *') }}</label>
                            <input type="text" wire:model.live="jobTitle" placeholder="{{ $t('مثال: أستاذ محاضر، مدير هيئة...', 'Ex: Professeur, Directeur...', 'Ex: Lecturer, Director...') }}"
                                   class="w-full rounded-2xl border-slate-200 focus:border-[#35A536] focus:ring-4 focus:ring-[#35A536]/10 text-slate-900 font-bold text-sm py-3.5 bg-slate-100/70 hover:bg-white focus:bg-white transition-all">
                            @error('jobTitle') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    @if($role === 'SPEAKER')
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-1.5">{{ $t('عنوان المحاضرة أو المداخلة (اختياري)', 'Sujet de l\'Intervention (Optionnel)', 'Presentation Topic (Optional)') }}</label>
                            <input type="text" wire:model.live="presentationTopic" placeholder="{{ $t('مثال: مستقبل التعليم المهني في إفريقيا...', 'Ex: L\'avenir de la formation professionnelle...', 'Ex: Future of Vocational Training in Africa...') }}"
                                   class="w-full rounded-2xl border-slate-200 focus:border-[#35A536] focus:ring-4 focus:ring-[#35A536]/10 text-slate-900 font-bold text-sm py-3.5 bg-slate-100/70 hover:bg-white focus:bg-white transition-all">
                        </div>
                    @endif

                    @if($role === 'EXPERT')
                        <div>
                            <label class="block text-sm font-bold text-slate-800 mb-1.5">{{ $t('مجال التخصص والخبرة الفنية *', 'Domaine d\'Expertise Technique *', 'Technical Expertise Skill *') }}</label>
                            <select wire:model.live="skillId"
                                    class="w-full rounded-2xl border-slate-200 focus:border-indigo-600 focus:ring-4 focus:ring-indigo-600/10 text-slate-900 font-bold text-sm py-3.5 bg-slate-100/70 hover:bg-white focus:bg-white transition-all">
                                <option value="">-- {{ $t('اختر مجال التخصص والمهنة', 'Sélectionner le métier', 'Select Specialty / Skill') }} --</option>
                                @foreach($skills as $skill)
                                    <option value="{{ $skill->id }}">{{ $skill->code }} — {{ $skill->getLocalized('name') }}</option>
                                @endforeach
                            </select>
                            @error('skillId') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>

                <!-- Section 4: Official Photo & Identity -->
                <div class="space-y-4 bg-slate-50 p-6 rounded-2xl border border-slate-200">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-wider flex items-center gap-2 border-b border-slate-200 pb-3">
                        <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>{{ $t('4. الصورة الشخصية الرسمية ورقم الهوية (Photo & Identity):', '4. Photo Officielle & Identité :', '4. Official Photo & Identity:') }}</span>
                    </h3>

                    <!-- Photo Upload Container -->
                    <div>
                        <label class="block text-xs font-black text-slate-900 mb-2">
                            {{ $t('الصورة الشخصية الرسمية (تحميل من جهازك أو هاتفك) *', 'Photo d\'Identité Officielle (Télécharger depuis votre appareil) *', 'Official Identity Photo (Upload from device) *') }}
                        </label>
                        
                        <div class="relative border-2 border-dashed border-slate-300 hover:border-emerald-500 rounded-3xl p-8 text-center bg-white hover:bg-emerald-50/40 transition-all cursor-pointer group shadow-sm">
                            <input type="file" wire:model="photoFile" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-20">
                            <div class="space-y-3">
                                <div class="w-16 h-16 rounded-2xl bg-emerald-100 text-emerald-600 flex items-center justify-center mx-auto group-hover:scale-110 transition-transform shadow-sm">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                                <div>
                                    <span class="text-sm font-black text-slate-900 block">
                                        {{ $t('اضغط هنا لاختيار أو رفع صورتك الشخصية الرسمية من معرض الصور / الجهاز', 'Cliquez ici pour sélectionner votre photo d\'identité officielle', 'Click here to upload your official identity photo') }}
                                    </span>
                                    <span class="text-xs text-slate-500 block mt-1">
                                        {{ $t('يجب أن تكون الصورة واضحة بخلفية بيضاء (JPG, PNG, WEBP — Max 5MB)', 'La photo doit être claire sur fond blanc (JPG, PNG, WEBP — Max 5MB)', 'Photo must be clear on a white background (JPG, PNG, WEBP — Max 5MB)') }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($photoFile)
                            <div class="mt-3 p-4 bg-emerald-50 rounded-2xl border border-emerald-300 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $photoFile->temporaryUrl() }}" class="w-14 h-14 rounded-2xl object-cover border-2 border-emerald-500 shadow-md">
                                    <div>
                                        <span class="text-xs font-black text-emerald-900 block">{{ $t('تم اختيار صورتك الشخصية بنجاح', 'Photo sélectionnée avec succès', 'Photo selected successfully') }}</span>
                                        <span class="text-[11px] font-mono text-emerald-700 block">{{ $t('جاهزة للاعتماد والطباعة على شارتك الـ 3D', 'Prête pour le badge 3D', 'Ready for 3D badge printing') }}</span>
                                    </div>
                                </div>
                                <span class="px-3 py-1 bg-emerald-200 text-emerald-900 text-xs font-bold rounded-xl">{{ $t('جاهز ✅', 'Prêt ✅', 'Ready ✅') }}</span>
                            </div>
                        @endif
                        @error('photoFile') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- National NIN (Algeria) or Passport (International) - STRICTLY MAX 18 CHARS -->
                    @if($isAlgeria)
                        <div>
                            <label class="block text-xs font-bold text-slate-800 mb-1.5">{{ $t('رقم التعريف الوطني (NIN - 18 رقماً بالضبط) *', 'Numéro d\'Identité Nationale (NIN - 18 chiffres) *', 'National Identification Number (NIN - 18 digits) *') }}</label>
                            <input type="text" wire:model.live="nationalId" maxlength="18" placeholder="123456789012345678"
                                   class="w-full rounded-2xl border-slate-200 focus:border-[#35A536] focus:ring-4 focus:ring-[#35A536]/10 text-slate-900 font-mono font-bold text-sm py-3.5 bg-white transition-all">
                            @error('nationalId') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    @else
                        <div>
                            <label class="block text-xs font-bold text-slate-800 mb-1.5">{{ $t('رقم جواز السفر الرسمـي (لا يتجاوز 18 رقماً/حرفاً) *', 'Numéro de Passeport Officiel (Max 18 caractères) *', 'Official Passport Number (Max 18 characters) *') }}</label>
                            <input type="text" wire:model.live="passportNumber" maxlength="18" placeholder="A12345678"
                                   class="w-full rounded-2xl border-slate-200 focus:border-[#35A536] focus:ring-4 focus:ring-[#35A536]/10 text-slate-900 font-mono font-bold text-sm py-3.5 bg-white transition-all" dir="ltr">
                            @error('passportNumber') <span class="text-xs text-red-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="pt-4 text-center">
                    <button type="button" wire:click="submitRegistration"
                            class="w-full sm:w-auto px-12 py-4 rounded-2xl bg-gradient-to-r from-[#35A536] via-emerald-700 to-[#092C1D] hover:scale-105 text-white font-black text-base shadow-xl hover:shadow-2xl transition-all duration-300 flex items-center justify-center gap-3 border border-emerald-400 mx-auto">
                        <svg class="w-5 h-5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $t('إرسال وتوثيق طلب الاعتماد والتسجيل الرسمي', 'Soumettre & Valider la Demande d\'Accréditation', 'Submit & Verify Official Accreditation Request') }}</span>
                    </button>
                </div>

            </div>

        @endif

    </div>

</div>
