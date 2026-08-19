@php
    $locale = app()->getLocale();
    $t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };

    $title = platform()->get("guide_title_{$locale}", $t('منتدى السياسات الأفريقية للمهارات 2026', 'Forum des Politiques Africaines des Compétences 2026', 'Africa Skills Policy Forum 2026'));
    $subtitle = platform()->get("guide_subtitle_{$locale}", $t('صياغة مستقبل المهارات، تمكين الشباب الأفريقي — البوابة الرسمية للرؤية القارية والأهداف والمحاور الاستراتيجية', 'Façonner l\'avenir des compétences, autonomiser la jeunesse africaine — Portail officiel de la vision continentale.', 'Shaping the Future of Skills, Empowering Africa\'s Youth — Official portal for continental vision and strategic objectives.'));
    $heroImg = platform()->get('guide_card1_image', '/images/hero_slide_1.png');
@endphp

<div class="py-10 bg-slate-50/70 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header Stage with Dynamic Image Banner Backdrop -->
        <div class="relative bg-gradient-to-br from-[#0B2A6F] via-[#081F54] to-[#040E26] rounded-3xl p-8 sm:p-12 text-white overflow-hidden shadow-2xl border border-emerald-900/50">
            <!-- Background Image Overlay -->
            <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none opacity-30">
                <img src="{{ asset($heroImg) }}" alt="Forum Header Background" class="w-full h-full object-cover filter brightness-75 scale-105">
                <div class="absolute inset-0 bg-gradient-to-t from-[#0B2A6F] via-[#0B2A6F]/80 to-transparent"></div>
            </div>

            <!-- Dynamic Glow Beams -->
            <div class="absolute -top-12 -start-12 w-72 h-72 bg-[#35A536]/25 rounded-full blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -end-12 w-72 h-72 bg-[#F5A800]/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="relative z-10 text-center max-w-4xl mx-auto space-y-4">
                
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 text-xs font-black text-amber-300">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#F5A800] animate-ping"></span>
                    <span>{{ $t('بشراكة بين وزارة التكوين والتعليم المهنيين بالجزائر ومفوضية الاتحاد الأفريقي', 'Co-organisé par le Ministère de la Formation d\'Algérie & la Commission de l\'Union Africaine', 'Co-organized by Algeria\'s Ministry of Vocational Training & Education and African Union Commission') }}</span>
                </div>

                <h1 class="text-3xl sm:text-5xl font-black text-white tracking-tight leading-tight drop-shadow-md">
                    {{ $forumData['name'] ?? $title }}
                </h1>

                <p class="text-lg sm:text-xl font-extrabold text-[#F5A800] italic">
                    "{{ $forumData['slogan'] ?? $t('صياغة مستقبل المهارات، تمكين الشباب الأفريقي', 'Façonner l\'avenir des compétences, autonomiser la jeunesse africaine', 'Shaping the Future of Skills, Empowering Africa\'s Youth') }}"
                </p>
                
                <p class="text-xs sm:text-sm text-slate-200 font-medium leading-relaxed max-w-3xl mx-auto pt-2">
                    {{ $subtitle }}
                </p>

                <!-- Quick Key Highlights Bar -->
                <div class="pt-4 flex flex-wrap items-center justify-center gap-4 text-xs font-black text-white">
                    <span class="px-4 py-2 rounded-xl bg-white/10 border border-white/20">{{ $forumData['stat_countries'] ?? '+30' }} {{ $t('دولة مشاركة', 'Pays', 'Countries') }}</span>
                    <span class="px-4 py-2 rounded-xl bg-white/10 border border-white/20">{{ $forumData['stat_ministers'] ?? '+20' }} {{ $t('وزيراً متوقعاً', 'Ministres attendus', 'Ministers expected') }}</span>
                    <span class="px-4 py-2 rounded-xl bg-white/10 border border-white/20">{{ $forumData['stat_roundtables'] ?? '2' }} {{ $t('موائد مستديرة وزارية', 'Tables rondes', 'Ministerial roundtables') }}</span>
                    <span class="px-4 py-2 rounded-xl bg-white/10 border border-white/20">2+ {{ $t('جلسات رفيعة المستوى', 'Panneaux de haut niveau', 'High-level panels') }}</span>
                    <span class="px-4 py-2 rounded-xl bg-white/10 border border-white/20">7 {{ $t('ورشات تخصصية', 'Axes thématiques', 'Thematic panels') }}</span>
                </div>
            </div>
        </div>

        <!-- MAIN ABOUT AFRICA SKILLS FORUM SECTION -->
        <div class="bg-white rounded-3xl p-8 sm:p-12 border border-slate-200/90 shadow-xl space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                
                <!-- Main Image Illustration -->
                <div class="lg:col-span-5 relative rounded-2xl overflow-hidden shadow-lg border border-slate-200 aspect-video lg:aspect-square">
                    <img src="{{ asset('/image.png') }}" class="w-full h-full object-cover hover:scale-105 transition duration-700">
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 start-4 end-4 text-white">
                        <span class="text-[10px] font-black uppercase tracking-widest text-[#F5A800] block mb-1">
                            {{ $t('مركز المؤتمرات بوهران — الجزائر', 'Centre des Conventions d\'Oran', 'Mohamed Ben Ahmed Convention Center — Oran') }}
                        </span>
                        <h4 class="text-base font-black">
                            {{ $forumData['dates'] ?? '16 — 18 نوفمبر 2026' }}
                        </h4>
                    </div>
                </div>

                <!-- Explanation Text & Overview -->
                <div class="lg:col-span-7 space-y-5">
                    
                    <span class="px-3 py-1 rounded-full bg-blue-50 text-[#0B2A6F] border border-blue-200 text-xs font-black inline-block">
                        {{ $t('الحدث السياسي الرفيع المستوى الرئيسي', 'Événement Politique Majeur', 'Principal High-Level Political Event') }}
                    </span>

                    <h2 class="text-2xl sm:text-3xl font-black text-slate-900 leading-snug">
                        {{ $t('ما هو منتدى السياسات الأفريقية للمهارات؟', 'Qu\'est-ce que le Forum des Politiques Africaines des Compétences ?', 'What is Africa’s Skills Policy Forum?') }}
                    </h2>

                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed font-medium">
                        {{ $forumData['description'] ?? $t(
                            'يُنظَّم منتدى السياسات الأفريقية للمهارات بشراكة بين وزارة التكوين والتعليم المهنيين بالجزائر ومفوضية الاتحاد الأفريقي، ليكون الحدث السياسي الرفيع المستوى الرئيسي. يجمع المنتدى الوزراء الأفارقة المكلفين بالتكوين والتعليم المهنيين، إلى جانب الخبراء التقنيين والشركاء المؤسساتيين والدوليين، في برنامج عمل يقوم على الحوار الوزاري والتعاون القاري والالتزام السياسي المشترك.',
                            'Le Forum des Politiques Africaines des Compétences est co-organisé par le Ministère de la Formation et de l\'Enseignement Professionnels d\'Algérie et la Commission de l\'Union Africaine, constituant le principal événement politique de haut niveau. Le Forum réunit les ministres africains chargés de l\'EFTP, des experts techniques et des partenaires institutionnels internationaux pour un programme d\'action fondé sur le dialogue ministériel, la coopération continentale et l\'engagement politique conjoint.',
                            'The African Skills Policy Forum is co-organized by Algeria\'s Ministry of Vocational Training and Education and the African Union Commission, serving as the principal high-level political summit. The Forum brings together African Ministers responsible for technical and vocational education and training, together with technical experts and institutional and international partners, for a working programme of ministerial dialogue, continental cooperation, and shared political commitment.'
                        ) }}
                    </p>

                    <!-- Founding Principle Spotlight -->
                    <div class="p-6 rounded-2xl bg-gradient-to-r from-emerald-50 via-slate-50 to-amber-50/50 border-s-4 border-[#35A536] border-y border-e border-slate-200 space-y-2 shadow-sm">
                        <div class="flex items-center gap-2 text-xs font-black text-[#35A536] uppercase tracking-wider">
                            <svg class="w-4 h-4 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            <span>{{ $t('المبدأ الأساسي للمنتدى', 'Principe Fondateur du Forum', 'Forum Founding Principle') }}</span>
                        </div>
                        <blockquote class="text-base sm:text-xl font-black text-[#0B2A6F] leading-snug italic">
                            "{{ $t('مستقبل المهارات في إفريقيا يجب أن يُصاغ من قِبل الأفارقة أنفسهم.', 'L\'avenir des compétences en Afrique doit être façonné par les Africains eux-mêmes.', 'Africa\'s skills future must be shaped by Africans.') }}"
                        </blockquote>
                    </div>

                    <div class="pt-2 flex flex-wrap gap-4">
                        <a href="{{ route('registration') }}"
                           class="px-6 py-3.5 bg-gradient-to-r from-[#35A536] via-emerald-700 to-[#092C1D] text-white font-black rounded-2xl text-xs shadow-lg hover:shadow-xl transition transform hover:-translate-y-0.5 flex items-center gap-2">
                            <svg class="w-4 h-4 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ $t('التسجيل والاعتماد الرسمي', 'Inscription & Accréditation', 'Official Registration') }}</span>
                        </a>

                        <a href="{{ route('schedule') }}"
                           class="px-6 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold rounded-2xl text-xs transition flex items-center gap-2">
                            <span>{{ $t('رزنامة الجلسات والبرنامج', 'Programme Officiel du Forum', 'Official Forum Agenda') }}</span>
                            <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>

        <!-- 6 THEMATIC TRACKS SECTION -->
        <div class="space-y-6">
            <div class="text-center max-w-3xl mx-auto space-y-2">
                <h3 class="text-2xl sm:text-3xl font-black text-slate-900">
                    {{ $t('المحاور الاستراتيجية الستة للمنتدى', 'Les 6 Axes Thématiques du Forum', 'The 6 Core Thematic Tracks') }}
                </h3>
                <p class="text-xs text-slate-500 font-bold">
                    {{ $t('أجندة العمل القارية لتطوير التكوين المهني ومهارات المستقبل في أفريقيا', 'Axes prioritaires pour moderniser l\'EFTP et préparer les compétences africaines', 'Priority policy tracks modernizing TVET and future-proofing African skills') }}
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Track 1 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-md hover:shadow-xl transition space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-blue-100 text-[#0B2A6F] flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h4 class="text-base font-black text-slate-900 group-hover:text-[#0B2A6F] transition">
                        1. {{ $t('إصلاح سياسات التكوين والتعليم المهني', 'Réforme des Politiques d\'EFTP', 'TVET Policy Reform') }}
                    </h4>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        {{ $t('النهوض بتحديث المنظومات الوطنية والتأطير القانوني، وتطوير مناهج تكوينية مرنة ومستجيبة لسوق العمل.', 'Moderniser les cadres nationaux et adapter les programmes de formation aux besoins réels du marché.', 'Modernizing national frameworks and reforming curricula to align with labor market demands.') }}
                    </p>
                </div>

                <!-- Track 2 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-md hover:shadow-xl transition space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#35A536] flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5m0 0h6m-6 0V10m6 11V10m-6 0a2 2 0 012-2h2a2 2 0 012 2m-6 0V6a2 2 0 012-2h2a2 2 0 012 2v4"/></svg>
                    </div>
                    <h4 class="text-base font-black text-slate-900 group-hover:text-[#35A536] transition">
                        2. {{ $t('المهارات للتصنيع', 'Compétences pour l\'Industrialisation', 'Skills for Industrialization') }}
                    </h4>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        {{ $t('تأهيل اليد العاملة والشباب لمواكبة خطط التصنيع القاري، البنية التحتية، والشراكات الصناعية الكبرى.', 'Préparer la main-d\'œuvre africaine pour soutenir l\'industrialisation et les grandes infrastructures.', 'Equipping African workforce for industrial expansion, manufacturing, and technical infrastructure.') }}
                    </p>
                </div>

                <!-- Track 3 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-md hover:shadow-xl transition space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-100 text-[#F5A800] flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h4 class="text-base font-black text-slate-900 group-hover:text-[#F5A800] transition">
                        3. {{ $t('تمويل تطوير المهارات', 'Financement du Développement des Compétences', 'Financing Skills Development') }}
                    </h4>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        {{ $t('صياغة آليات تمويل مستدامة، إشراك القطاع الخاص، وتوجيه الاستثمارات نحو التكوين المهني.', 'Développer des mécanismes de financement durables et renforcer le partenariat public-privé.', 'Developing sustainable financing models, engaging private sector funding, and skills investment.') }}
                    </p>
                </div>

                <!-- Track 4 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-md hover:shadow-xl transition space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h4 class="text-base font-black text-slate-900 group-hover:text-purple-600 transition">
                        4. {{ $t('الذكاء الاصطناعي ومستقبل التكوين المهني', 'IA & l\'Avenir de l\'EFTP', 'Artificial Intelligence & the Future of TVET') }}
                    </h4>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        {{ $t('دمج الذكاء الاصطناعي والأتمتة والتقنيات الرقمية في منظومة التكوين المهني لبناء كفاءات الرقمية.', 'Intégrer l\'intelligence artificielle, la numérisation et l\'automatisation dans la formation.', 'Integrating artificial intelligence, digital learning tools, and smart tech into TVET.') }}
                    </p>
                </div>

                <!-- Track 5 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-md hover:shadow-xl transition space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-700 flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 012 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.5a2.5 2.5 0 002.5-2.5V14m-3 7c9 0 9-9 9-9s-9 0-9 9z"/></svg>
                    </div>
                    <h4 class="text-base font-black text-slate-900 group-hover:text-teal-700 transition">
                        5. {{ $t('المهارات الخضراء والانتقال العادل', 'Compétences Vertes & Transition Juste', 'Green Skills & Just Transition') }}
                    </h4>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        {{ $t('تأهيل الكفاءات لمواكبة التحول نحو الطاقات المتجددة والاقتصاد الأخضر والتنمية المستدامة.', 'Former aux métiers de l\'énergie renouvelable, de l\'économie circulaire et du développement durable.', 'Preparing youth for green energy transitions, circular economies, and sustainable practices.') }}
                    </p>
                </div>

                <!-- Track 6 -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/90 shadow-md hover:shadow-xl transition space-y-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-700 flex items-center justify-center font-black group-hover:scale-110 transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h4 class="text-base font-black text-slate-900 group-hover:text-sky-700 transition">
                        6. {{ $t('التعاون القاري والحوكمة', 'Coopération Continentale & Gouvernance', 'Continental Cooperation & Governance') }}
                    </h4>
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        {{ $t('تعزيز الشراكات الثنائية والمتعددة الأطراف وتوحيد الرؤى القارية في الحوكمة وإعادة التأهيل.', 'Renforcer les partenariats bilatéraux et multilatéraux entre États membres africains.', 'Fostering bilateral and multilateral TVET partnerships and continental governance frameworks.') }}
                    </p>
                </div>

            </div>
        </div>

        <!-- 5 CORE OBJECTIVES GRID -->
        <div class="bg-white rounded-3xl p-8 sm:p-10 border border-slate-200/90 shadow-xl space-y-8">
            <div class="text-center max-w-3xl mx-auto space-y-2">
                <div class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-amber-50 text-[#F5A800] border border-amber-200 text-xs font-black">
                    <svg class="w-3.5 h-3.5 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    <span>{{ $t('التزامات المنتدى', 'Engagements du Forum', 'Forum Core Commitments') }}</span>
                </div>
                <h3 class="text-2xl sm:text-3xl font-black text-[#0B2A6F]">
                    {{ $t('الأهداف الاستراتيجية الـ 5 لمنتدى السياسات الأفريقية للمهارات', 'Les 5 Objectifs Majeurs du Forum', 'The 5 Strategic Objectives of the Forum') }}
                </h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <!-- Obj 1 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-3 hover:bg-white hover:shadow-lg transition group">
                    <div class="w-9 h-9 rounded-xl bg-[#0B2A6F] text-white flex items-center justify-center font-black text-xs">01</div>
                    <h4 class="text-base font-black text-[#0B2A6F]">
                        {{ $t('تنفيذ الاستراتيجية القارية (2025–2034)', 'Mettre en œuvre la Stratégie Continentale (2025–34)', 'Advance Continental TVET Strategy (2025–34)') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ $t(
                            'النهوض بتنفيذ الاستراتيجية القارية للتكوين المهني والتقني (2025–2034) عبر الدول الأعضاء الأفريقية، وترجمة الالتزامات القارية إلى إجراءات ملموسة.',
                            'Faire progresser la mise en œuvre de la stratégie continentale d\'EFTP (2025–34) dans les États membres africains et traduire les engagements en actions concrètes.',
                            'Advance the implementation of the Continental TVET Strategy (2025–34) across African Member States, translating continental commitments into concrete action.'
                        ) }}
                    </p>
                </div>

                <!-- Obj 2 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-3 hover:bg-white hover:shadow-lg transition group">
                    <div class="w-9 h-9 rounded-xl bg-[#35A536] text-white flex items-center justify-center font-black text-xs">02</div>
                    <h4 class="text-base font-black text-[#0B2A6F]">
                        {{ $t('منصة منظمة لتبادل التجارب الناجحة', 'Plateforme Structurée d\'Échange d\'Expériences', 'Structured TVET Knowledge Exchange Platform') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ $t(
                            'إنشاء منصة منظمة تتيح للوزارات الأفريقية تبادل التجارب الناجحة في مجال التكوين المهني — إصلاح المناهج، نماذج التمويل، الشراكات مع القطاع الصناعي، وأنظمة التمهين — بما يحوّل التجارب الوطنية المتفرقة إلى معرفة قارية مشتركة.',
                            'Créer une plateforme structurée permettant aux ministères africains d\'échanger des expériences éprouvées — réforme des programmes, modèles de financement et partenariats industriels.',
                            'Create a structured platform for African Ministries to exchange proven experience in TVET — curricula reform, financing models, industry partnerships, and apprenticeship systems.'
                        ) }}
                    </p>
                </div>

                <!-- Obj 3 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-3 hover:bg-white hover:shadow-lg transition group">
                    <div class="w-9 h-9 rounded-xl bg-[#F5A800] text-[#0B2A6F] flex items-center justify-center font-black text-xs">03</div>
                    <h4 class="text-base font-black text-[#0B2A6F]">
                        {{ $t('اعتماد إعلان حول مهارات المستقبل', 'Adopter la Déclaration sur les Compétences de Demain', 'Adopt Declaration on Skills for Tomorrow') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ $t(
                            'اعتماد إعلان حول مهارات المستقبل، يستشرف المهارات التقنية والمهنية التي ستحتاجها اقتصادات إفريقيا في السنوات القادمة، وليس فقط تلك المدرجة حاليًا في المناهج التكوينية.',
                            'Adopter une Déclaration sur les compétences de demain, anticipant les besoins futurs des économies africaines au-delà des programmes actuels.',
                            'Adopt a Declaration on Skills for Tomorrow, anticipating the technical and vocational skills Africa\'s economies will need in the years ahead, not only those already reflected in today\'s curricula.'
                        ) }}
                    </p>
                </div>

                <!-- Obj 4 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-3 hover:bg-white hover:shadow-lg transition group">
                    <div class="w-9 h-9 rounded-xl bg-sky-600 text-white flex items-center justify-center font-black text-xs">04</div>
                    <h4 class="text-base font-black text-[#0B2A6F]">
                        {{ $t('تعزيز الشراكات الثنائية والمتعددة الأطراف', 'Renforcer les Partenariats Bilatéraux & Multilatéraux', 'Strengthen Bilateral & Multilateral Partnerships') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ $t(
                            'تعزيز الشراكات الثنائية والمتعددة الأطراف في مجال التكوين المهني بين الدول الأفريقية الأعضاء والشركاء المؤسساتيين الدوليين.',
                            'Renforcer les partenariats bilatéraux et multilatéraux en matière d\'EFTP entre les États membres africains et les partenaires institutionnels internationaux.',
                            'Strengthen bilateral and multilateral partnerships in TVET between African Member States and international institutional partners.'
                        ) }}
                    </p>
                </div>

                <!-- Obj 5 -->
                <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200 space-y-3 hover:bg-white hover:shadow-lg transition group md:col-span-2 lg:col-span-1">
                    <div class="w-9 h-9 rounded-xl bg-purple-600 text-white flex items-center justify-center font-black text-xs">05</div>
                    <h4 class="text-base font-black text-[#0B2A6F]">
                        {{ $t('برنامج مخصص لبناء قدرات الشباب الأفريقي', 'Programme de Renforcement des Capacités des Jeunes', 'Youth Capacity-Building Programme') }}
                    </h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed">
                        {{ $t(
                            'تنفيذ برنامج مخصص لبناء القدرات لفائدة الشباب الأفريقي في خمسة اختصاصات ذات أولوية، بما يعزز القدرات التقنية للمشاركين خارج فضاء المنافسة.',
                            'Déployer un programme dédié au renforcement des capacités de la jeunesse africaine dans 5 compétences prioritaires, au-delà de la compétition.',
                            'Deliver a dedicated capacity-building programme for African youth across five priority skills, reinforcing technical capacities beyond the competition floor.'
                        ) }}
                    </p>
                </div>

            </div>
        </div>

    </div>
</div>
