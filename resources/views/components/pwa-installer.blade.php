<!-- PWA Service Worker Registration & Installation Prompt Banner -->
<div x-data="{
    deferredPrompt: window.deferredPwaPrompt || null,
    showBanner: false,
    isIOS: false,
    isAndroid: false,
    showAndroidGuide: false,
    init() {
        // Register Service Worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js')
                    .then(reg => console.log('PWA ServiceWorker registered with scope:', reg.scope))
                    .catch(err => console.warn('PWA ServiceWorker registration failed:', err));
            });
        }

        // Check if running in standalone PWA mode
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
        if (isStandalone) {
            return; // Already installed as PWA!
        }

        // Detect OS
        const ua = window.navigator.userAgent;
        this.isIOS = /iPad|iPhone|iPod/.test(ua) && !window.MSStream;
        this.isAndroid = /Android/.test(ua);

        // Check window global prompt if already captured
        if (window.deferredPwaPrompt) {
            this.deferredPrompt = window.deferredPwaPrompt;
            this.showBanner = true;
        }

        // Capture Android / Chrome install prompt
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            this.deferredPrompt = e;
            window.deferredPwaPrompt = e;
            this.showBanner = true;
        });

        // Show banner for mobile devices if not dismissed recently
        if ((this.isIOS || this.isAndroid) && !localStorage.getItem('asf_pwa_dismissed')) {
            this.showBanner = true;
        }
    },
    installApp() {
        if (this.deferredPrompt) {
            this.deferredPrompt.prompt();
            this.deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted PWA install prompt');
                }
                this.deferredPrompt = null;
                window.deferredPwaPrompt = null;
                this.showBanner = false;
            });
        } else if (this.isAndroid) {
            this.showAndroidGuide = true;
        }
    },
    dismissBanner() {
        this.showBanner = false;
        localStorage.setItem('asf_pwa_dismissed', 'true');
    }
}" x-init="init()" x-show="showBanner" x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-full opacity-0" x-transition:enter-end="translate-y-0 opacity-100" x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="translate-y-full opacity-0" class="fixed bottom-20 md:bottom-6 start-4 end-4 sm:start-auto sm:end-6 sm:max-w-md z-50 print:hidden select-none" x-cloak dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <div class="bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0052CC] text-white p-4 rounded-3xl shadow-2xl border border-white/20 backdrop-blur-xl relative overflow-hidden">
        <!-- Subtle Glow -->
        <div class="absolute -top-12 -right-12 w-32 h-32 bg-amber-500/20 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10 flex items-center justify-between gap-3">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-white p-1 shadow-md border border-white/30 shrink-0 flex items-center justify-center overflow-hidden">
                    <img src="/icon-192.png" alt="Africa Skills Forum" class="w-full h-full object-contain rounded-xl">
                </div>
                <div class="space-y-0.5">
                    <h4 class="text-xs sm:text-sm font-black text-white leading-tight">
                        {{ app()->getLocale() === 'fr' ? 'Application Africa Skills Forum 📱' : (app()->getLocale() === 'en' ? 'Africa Skills Forum App 📱' : 'تطبيق منتدى المهارات الإفريقية 📱') }}
                    </h4>
                    <p class="text-[10px] text-blue-100 font-bold leading-tight">
                        <template x-if="!isIOS">
                            <span>{{ app()->getLocale() === 'fr' ? 'Installer sur votre téléphone pour un accès rapide' : (app()->getLocale() === 'en' ? 'Install on your device for fast offline access' : 'ثبّت التطبيق على هاتفك للوصول السريع بدون إنترنت') }}</span>
                        </template>
                        <template x-if="isIOS">
                            <span>{{ app()->getLocale() === 'fr' ? 'Appuyez sur Partager ⎋ puis "Sur l\'écran d\'accueil ➕"' : (app()->getLocale() === 'en' ? 'Tap Share ⎋ then "Add to Home Screen ➕"' : 'اضغط زر المشاركة ⎋ ثم "إضافة إلى الشاشة الرئيسية ➕"') }}</span>
                        </template>
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-2 shrink-0">
                <template x-if="!isIOS">
                    <button type="button" @click="installApp()" class="px-3.5 py-2 rounded-xl bg-gradient-to-r from-amber-400 to-[#F5A800] hover:from-amber-500 hover:to-amber-600 text-slate-950 font-black text-xs shadow-lg transition transform active:scale-95 whitespace-nowrap cursor-pointer">
                        {{ app()->getLocale() === 'fr' ? 'Installer' : (app()->getLocale() === 'en' ? 'Install' : 'تثبيت الآن') }}
                    </button>
                </template>

                <button type="button" @click="dismissBanner()" class="p-1.5 rounded-full text-slate-300 hover:text-white hover:bg-white/10 transition cursor-pointer" title="إغلاق">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        <!-- Android Step-by-Step Manual Guide Fallback Modal -->
        <div x-show="showAndroidGuide" x-transition class="mt-3 pt-3 border-t border-white/15 text-xs space-y-2 text-amber-200">
            <p class="font-bold flex items-center gap-1.5">
                <svg class="w-4 h-4 text-amber-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>طريقة التثبيت المباشر على أندرويد:</span>
            </p>
            <ol class="list-decimal list-inside text-[11px] text-white/90 space-y-1 font-medium">
                <li>اضغط خيارات المتصفح <strong class="text-amber-300">⋮ (الثلاث نقاط بالخيارات العلوية)</strong>.</li>
                <li>اختر <strong class="text-amber-300">"التثبيت في الشاشة الرئيسية" (Add to Home screen / Install app)</strong>.</li>
            </ol>
        </div>
    </div>
</div>
