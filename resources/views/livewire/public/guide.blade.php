@php
    $locale = app()->getLocale();
    $t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };

    $title = platform()->get("guide_title_{$locale}", $t('دليل ورؤية منتدى المهارات الإفريقية 2026', 'Guide & Vision — Africa Skills Forum 2026', 'Africa Skills Forum Guide & Vision 2026'));
    $subtitle = platform()->get("guide_subtitle_{$locale}", $t('البوابة المعرفية الرسمية لفهم أهداف المنتدى القاري، المحاور الفكرية، المعرض التكنولوجي، وآليات الاعتماد المباشر بوهران.', 'Portail officiel pour comprendre la vision du forum, les conférences continentales et l\'accréditation.', 'Official portal to understand continental forum goals, policy conferences, and accreditation.'));
    $heroImg = platform()->get('guide_card1_image', '/images/hero_slide_1.png');
@endphp

<div class="py-10 bg-slate-50/70 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header Stage with Dynamic Image Banner Backdrop -->
        <div class="relative bg-gradient-to-br from-[#061B2E] via-[#082F1D] to-[#0A4223] rounded-3xl p-8 sm:p-12 text-white overflow-hidden shadow-2xl border border-emerald-900/50">
            <!-- Background Image Overlay -->
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none opacity-30">
                <img src="{{ asset($heroImg) }}" alt="Forum Header Background" class="w-full h-full object-cover filter brightness-75 scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-[#061B2E] via-[#061B2E]/80 to-transparent"></div>
            </div>

            <!-- Dynamic Glow Beams -->
            <div class="absolute -top-12 -start-12 w-72 h-72 bg-[#35A536]/25 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -end-12 w-72 h-72 bg-[#F5A800]/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 text-center max-w-3xl mx-auto space-y-4">

                
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-white tracking-tight leading-tight drop-shadow-md">
                    {{ $title }}
                </h1>
                
                <p class="text-xs sm:text-sm text-emerald-100/90 font-medium leading-relaxed max-w-2xl mx-auto">
                    {{ $subtitle }}
                </p>
            </div>
        </div>

        <!-- MAIN ABOUT AFRICA SKILLS FORUM SECTION -->
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/90 shadow-xl space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Main Image Illustration -->
                <div class="lg:col-span-5 relative rounded-2xl overflow-hidden shadow-lg border border-slate-200 aspect-video lg:aspect-square">
                    <img src="{{ asset('/images/hero_slide_1.png') }}" class="w-full h-full object-cover hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 start-4 end-4 text-white">
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#F5A800] block mb-1">
                            {{ $t('مركز المؤتمرات بوهران — الجزائر', 'Centre des Conventions d\'Oran', 'CCO Oran Convention Center') }}
                        </span>
                        <h4 class="text-base font-black">
                            {{ $t('16 — 21 نوفمبر 2026', '16 — 21 Novembre 2026', '16 — 21 November 2026') }}
                        </h4>
                    </div>
                </div>

                <!-- Explanation Text & Overview -->
                <div class="lg:col-span-7 space-y-5">


                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 leading-snug">
                        {{ $t('ما هو منتدى المهارات الإفريقية (Africa Skills Forum)؟', 'Qu\'est-ce qu\'Africa Skills Forum ?', 'What is Africa Skills Forum?') }}
                    </h2>

                    <p class="text-slate-600 text-sm leading-relaxed font-medium">
                        {{ $t('منتدى المهارات الإفريقية هو منظومة قارية استراتيجية رفيعة المستوى تُقام تحت احتضان الجمهورية الجزائرية الديمقراطية الشعبية بمركز المؤتمرات محمد بن أحمد بولاية وهران، لجمع الوفود الرسمية، الوزراء، الخبراء الدوليين، والفاعلين في التكوين والتعليم المهني من مختلف دول القارة الإفريقية.', 'Africa Skills Forum est un rassemblement continental stratégique de haut niveau organisé en Algérie au Centre des Conventions d\'Oran, réunissant les délégations officielles, ministres, experts internationaux et acteurs de la formation professionnelle à travers l\'Afrique.', 'Africa Skills Forum is a high-level strategic continental summit hosted in Algeria at the Mohamed Ben Ahmed Convention Center in Oran, bringing together official delegations, ministers, international experts, and vocational education stakeholders across Africa.') }}
                    </p>

                    <p class="text-slate-600 text-sm leading-relaxed font-medium">
                        {{ $t('يهدف المنتدى إلى تعزيز التميز المهني، وتبادل التجارب والتكنولوجيات الحديثة، وربط مؤسسات التكوين المهني بالشركاء الصناعيين وتأطير السياسات المستقبلية للنهوض بالمهارات والشباب الإفريقي.', 'Le forum vise à promouvoir l\'excellence professionnelle, échanger les technologies modernes, relier la formation aux partenaires industriels et façonner l\'avenir des compétences africaines.', 'The forum aims to promote vocational excellence, exchange modern technologies, link training institutes with industrial partners, and shape the future of African skills.') }}
                    </p>

                    <div class="pt-2 flex flex-wrap gap-4">
                        <a href="{{ route('registration') }}"
                           class="px-6 py-3.5 bg-gradient-to-r from-[#35A536] via-emerald-700 to-[#092C1D] text-white font-black rounded-2xl text-xs shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $t('التسجيل والاعتماد الرسمي', 'Inscription & Accréditation', 'Official Registration') }}</span>
                        </a>

                        <a href="{{ route('events') }}"
                           class="px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold rounded-2xl text-xs transition flex items-center gap-2">
                            <span>{{ $t('برنامج الجلسات والمؤتمرات', 'Programme des Conférences', 'Conferences Agenda') }}</span>
                            <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- 4 PILLARS / AXES OF AFRICA SKILLS FORUM -->
        <div class="space-y-6">
            <div class="text-center max-w-2xl mx-auto space-y-2">
                <h3 class="text-2xl font-black text-slate-900">
                    {{ $t('محاور وأهداف المنتدى الإفريقي', 'Piliers & Objectifs du Forum', 'Forum Core Pillars & Objectives') }}
                </h3>
                <p class="text-xs text-slate-500 font-bold">
                    {{ $t('أربعة أبعاد رئيسية ترسم مستقبل الكفاءات والتكنولوجيا في القارة الإفريقية', 'Quatre piliers façonnant l\'avenir des compétences en Afrique', 'Four main pillars shaping the future of skills in Africa') }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                
                <!-- Pillar 1 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-md hover:shadow-xl transition space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#35A536] flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6m-6 0V10m6 11V10m-6 0a2 2 0 012-2h2a2 2 0 012 2m-6 0V6a2 2 0 012-2h2a2 2 0 012 2v4"/>
                        </svg>
                    </div>
                    <h4 class="text-base font-black text-slate-900 group-hover:text-[#35A536] transition">
                        {{ $t('السياسات والتأطير القاري', 'Gouvernance & Politiques', 'Policy & Governance') }}
                    </h4>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        {{ $t('مناقشة وصياغة الاستراتيجيات القارية لتطوير أنظمة التكوين المهني ومواكبة متطلبات التحول الرقمي.', 'Développer des stratégies continentales pour moderniser la formation professionnelle.', 'Drafting continental strategies to modernize vocational education and digital transformation.') }}
                    </p>
                </div>

                <!-- Pillar 2 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-md hover:shadow-xl transition space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-[#061B2E] flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                        </svg>
                    </div>
                    <h4 class="text-base font-black text-slate-900 group-hover:text-blue-700 transition">
                        {{ $t('الجلسات والمؤتمرات', 'Conférences & Débats', 'Panels & Keynotes') }}
                    </h4>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        {{ $t('جلسات حوارية ومداخلات دولية يقودها محاضرون وخبراء لتسليط الضوء على مهن المستقبل والتكنولوجيا.', 'Sessions et panels animés par des conférenciers de renommée internationale.', 'High-level panels delivered by keynote speakers on future skills and tech.') }}
                    </p>
                </div>

                <!-- Pillar 3 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-md hover:shadow-xl transition space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-[#F5A800] flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h4 class="text-base font-black text-slate-900 group-hover:text-amber-600 transition">
                        {{ $t('الشراكات الاستراتيجية', 'Alliances & Partenariats', 'Strategic Alliances') }}
                    </h4>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        {{ $t('بناء جسور التضامن والتعاون الشامل بين المؤسسات التعليمية والشركاء الصناعيين والتكنولوجيين.', 'Construire des partenariats durables entre instituts et industriels.', 'Building strong partnerships between training institutes and industry leaders.') }}
                    </p>
                </div>

                <!-- Pillar 4 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-md hover:shadow-xl transition space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                        </svg>
                    </div>
                    <h4 class="text-base font-black text-slate-900 group-hover:text-indigo-700 transition">
                        {{ $t('الاعتماد المباشر والوفود', 'Accréditation & Délégations', 'Accreditation & Delegations') }}
                    </h4>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        {{ $t('تسهيل وإعادة إصدار شارات الاعتماد الرقمية الذكية المزودة برمز QR للدخول السريع لجميع المشاركين.', 'Faciliter l\'accréditation numérique 3D et le badge d\'accès sécurisé.', 'Smart 3D accreditation badges with QR code for quick venue entrance.') }}
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>
