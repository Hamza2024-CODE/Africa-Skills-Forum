<footer class="bg-[#0B2A6F] text-white border-t border-blue-900 py-12 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 pb-12 border-b border-blue-900/80">
            
            <!-- Col 1: Official Dual Logos & Summary -->
            <div class="space-y-4">
                <div class="flex items-center gap-3 bg-white p-2 px-4 sm:px-5 rounded-2xl inline-flex shadow-md border border-slate-200/60 overflow-hidden shrink-0">
                    <img src="{{ asset('ministry-logo-trimmed.png') }}" alt="وزارة التكوين والتعليم المهنيين" class="h-7 sm:h-8 w-auto object-contain shrink-0">
                    <div class="h-5 sm:h-6 w-px bg-slate-300 shrink-0"></div>
                    <img src="{{ asset('africa-logo-trimmed.png') }}" alt="African Union - Africa Skills Forum" class="h-7 sm:h-8 w-auto object-contain shrink-0">
                </div>


                <p class="text-xs text-blue-100/80 leading-relaxed">
                    {{ app()->getLocale() === 'fr' ? 'Rassemblement des délégations nationales et internationales au Centre des Conventions Mohamed Ben Ahmed à Oran.' : (app()->getLocale() === 'en' ? 'Gathering of national and international delegations at Mohamed Ben Ahmed Convention Center in Oran.' : 'تجمع الوفود الوطنية والدولية بمركز المؤتمرات محمد بن أحمد بولاية وهران.') }}
                </p>
            </div>

            <!-- Col 2: Africa Skills Forum Links -->
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">{{ app()->getLocale() === 'fr' ? 'Africa Skills Forum' : (app()->getLocale() === 'en' ? 'Africa Skills Forum' : 'منتدى المهارات الإفريقية') }}</h4>
                <ul class="space-y-2.5 text-xs text-blue-100/90 font-medium">
                    <li><a href="{{ route('guide') }}" class="hover:text-[#35A536] transition">{{ app()->getLocale() === 'fr' ? 'Guide & Agenda du Forum' : (app()->getLocale() === 'en' ? 'Forum Guide & Agenda' : 'دليل وبرنامج المنتدى') }}</a></li>
                    <li><a href="{{ route('events') }}" class="hover:text-[#35A536] transition">{{ app()->getLocale() === 'fr' ? 'Panels & Conférences' : (app()->getLocale() === 'en' ? 'Panels & Conferences' : 'الجلسات والمؤتمرات') }}</a></li>
                    @if(platform()->get('show_partners_section', true))
                        <li><a href="{{ route('partners') }}" class="hover:text-[#35A536] transition">{{ app()->getLocale() === 'fr' ? 'Exposition & Partenaires' : (app()->getLocale() === 'en' ? 'Expo & Partners' : 'المعرض والشركاء') }}</a></li>
                    @endif

                    <li><a href="{{ route('live-tv') }}" target="_blank" class="text-rose-400 hover:text-rose-300 font-bold transition flex items-center gap-1.5"><span>🔴 {{ app()->getLocale() === 'fr' ? 'Direct TV (Écrans)' : (app()->getLocale() === 'en' ? 'Live TV Broadcast' : 'شاشة البث المباشر (Live TV)') }}</span></a></li>
                </ul>
            </div>

            <!-- Col 3: Forum Quick Links -->
            <div>
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-4">{{ app()->getLocale() === 'fr' ? 'Informations & Accès' : (app()->getLocale() === 'en' ? 'Forum Info & Access' : 'الدليل والخدمات') }}</h4>
                <ul class="space-y-2.5 text-xs text-blue-100/90 font-medium">
                    <li><a href="{{ route('guide') }}" class="hover:text-[#35A536] transition">{{ app()->getLocale() === 'fr' ? 'Guide du Forum' : (app()->getLocale() === 'en' ? 'Forum Guide' : 'دليل المشاركة') }}</a></li>
                    <li><a href="{{ route('registration') }}" class="hover:text-[#35A536] transition">{{ app()->getLocale() === 'fr' ? 'Accréditation & Inscription' : (app()->getLocale() === 'en' ? 'Accreditation & Registration' : 'التسجيل والاعتماد الرسمي') }}</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-[#35A536] transition">{{ __('messages.faq') }}</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-[#35A536] transition">{{ __('messages.contact') }}</a></li>
                </ul>
            </div>

            <!-- Col 4: Newsletter & Socials -->
            <div class="space-y-4">
                <h4 class="text-xs font-bold text-white uppercase tracking-wider mb-2">
                    {{ app()->getLocale() === 'fr' ? 'Abonnez-vous à notre newsletter' : (app()->getLocale() === 'en' ? 'Subscribe to our newsletter' : 'اشترك في نشرتنا الإخبارية') }}
                </h4>
                <div class="flex items-center gap-2 bg-[#081F54] p-1.5 rounded-xl border border-blue-800">
                    <input type="email" placeholder="{{ app()->getLocale() === 'fr' ? 'Entrez votre email...' : (app()->getLocale() === 'en' ? 'Enter your email...' : 'أدخل بريدك الإلكتروني') }}" class="w-full bg-transparent px-3 text-xs text-white placeholder-blue-300 focus:outline-none">
                    <button class="px-4 py-2 rounded-lg bg-[#35A536] hover:bg-emerald-600 text-white font-bold text-xs transition">
                        {{ app()->getLocale() === 'fr' ? 'S\'abonner' : (app()->getLocale() === 'en' ? 'Subscribe' : 'اشترك') }}
                    </button>
                </div>
            </div>

        </div>

        <!-- Footer Bottom Bar -->
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 text-[11px] text-slate-500 font-medium">
            <p>© {{ date('Y') }} {{ platform()->name() }}. {{ app()->getLocale() === 'fr' ? 'Tous droits réservés.' : (app()->getLocale() === 'en' ? 'All rights reserved.' : 'جميع الحقوق محفوظة.') }}</p>
            <div class="flex items-center gap-4">
                <a href="{{ route('privacy') }}" class="hover:text-slate-400">
                    {{ app()->getLocale() === 'fr' ? 'Politique de confidentialité' : (app()->getLocale() === 'en' ? 'Privacy Policy' : 'سياسة الخصوصية') }}
                </a>
                <span>|</span>
                <a href="{{ route('terms') }}" class="hover:text-slate-400">
                    {{ app()->getLocale() === 'fr' ? 'Conditions d\'utilisation' : (app()->getLocale() === 'en' ? 'Terms of Use' : 'شروط الاستخدام') }}
                </a>
            </div>
        </div>
    </div>
</footer>
