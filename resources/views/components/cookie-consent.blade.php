<!-- GDPR & Privacy Cookie Consent Banner -->
<div x-data="{
    showConsent: false,
    init() {
        if (!localStorage.getItem('asf_cookie_consent_v2')) {
            setTimeout(() => {
                this.showConsent = true;
            }, 800);
        }
    },
    acceptAll() {
        localStorage.setItem('asf_cookie_consent_v2', 'accepted');
        document.cookie = 'asf_cookie_consent_v2=accepted; max-age=31536000; path=/; SameSite=Lax';
        this.showConsent = false;
        window.dispatchEvent(new CustomEvent('cookie-consent-dismissed'));
    },
    decline() {
        localStorage.setItem('asf_cookie_consent_v2', 'declined');
        document.cookie = 'asf_cookie_consent_v2=declined; max-age=31536000; path=/; SameSite=Lax';
        this.showConsent = false;
        window.dispatchEvent(new CustomEvent('cookie-consent-dismissed'));
    }
}" x-init="init()" x-show="showConsent" x-cloak x-transition:enter="transition ease-out duration-500 transform" x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-full opacity-0" class="fixed bottom-16 start-3 end-3 md:bottom-6 sm:start-6 sm:end-auto sm:max-w-md z-45 print:hidden select-none" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <div class="bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0A2666] text-white p-3.5 sm:p-5 rounded-2xl sm:rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.5)] border border-white/20 backdrop-blur-2xl relative overflow-hidden">
        <!-- Background Ambient Glow -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-[#F5A800]/20 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 space-y-2.5 sm:space-y-4">
            <!-- Icon & Title Header -->
            <div class="flex items-center sm:items-start gap-2.5 sm:gap-3.5">
                <div class="w-8 h-8 sm:w-11 sm:h-11 rounded-xl sm:rounded-2xl bg-gradient-to-br from-amber-400 to-[#F5A800] text-slate-950 flex items-center justify-center shrink-0 shadow-md border border-amber-300/40">
                    <svg class="w-4 h-4 sm:w-6 sm:h-6 text-slate-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div class="space-y-0.5 sm:space-y-1 flex-1">
                    <h4 class="text-xs sm:text-sm font-black text-white leading-tight">
                        {{ app()->getLocale() === 'fr' ? 'Gestion des Cookies & Confidentialité' : (app()->getLocale() === 'en' ? 'Cookies & Privacy Preferences' : 'إشعار ملفات تعريف الارتباط (Cookies)') }}
                    </h4>
                    <p class="text-[10px] sm:text-xs text-blue-100 font-medium leading-tight sm:leading-relaxed line-clamp-2 sm:line-clamp-none">
                        {{ app()->getLocale() === 'fr' 
                            ? 'Nous utilisons des cookies pour améliorer votre expérience de navigation et analyser le trafic du forum.' 
                            : (app()->getLocale() === 'en' 
                                ? 'We use cookies to enhance your navigation experience and secure forum services.' 
                                : 'نستخدم ملفات تعريف الارتباط لتحسين أداء المنصة وتخصيص المحتوى وضمان الأمان أثناء التصفح.') }}
                        <a href="{{ route('privacy') }}" class="underline font-bold text-amber-300 hover:text-amber-200 transition ms-1">
                            {{ app()->getLocale() === 'fr' ? 'En savoir plus' : (app()->getLocale() === 'en' ? 'Learn more' : 'سياسة الخصوصية') }}
                        </a>
                    </p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2 pt-0.5">
                <button type="button" @click="acceptAll()" class="flex-1 py-1.5 sm:py-2.5 px-3 sm:px-4 rounded-lg sm:rounded-xl bg-gradient-to-r from-amber-400 to-[#F5A800] hover:from-amber-500 hover:to-amber-600 text-slate-950 font-black text-[11px] sm:text-xs shadow-md transition transform active:scale-95 text-center cursor-pointer">
                    {{ app()->getLocale() === 'fr' ? 'Accepter Tout' : (app()->getLocale() === 'en' ? 'Accept All' : 'موافقة وقبول الكل') }}
                </button>
                <button type="button" @click="decline()" class="py-1.5 sm:py-2.5 px-3 sm:px-4 rounded-lg sm:rounded-xl bg-white/10 hover:bg-white/20 text-slate-200 hover:text-white border border-white/20 font-bold text-[11px] sm:text-xs transition transform active:scale-95 text-center cursor-pointer">
                    {{ app()->getLocale() === 'fr' ? 'Refuser' : (app()->getLocale() === 'en' ? 'Decline' : 'رفض') }}
                </button>
            </div>
        </div>
    </div>
</div>
