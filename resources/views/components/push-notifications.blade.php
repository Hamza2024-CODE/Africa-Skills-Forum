<!-- Premium Social Media Notification Toast Card -->
<div x-data="{
    activeToast: null,
    lastCheckedId: parseInt(localStorage.getItem('asf_last_notif_id') || '0'),
    
    async init() {
        // If lastCheckedId is 0 (first visit), initialize it with the latest existing ID to avoid showing historic alerts
        if (this.lastCheckedId === 0) {
            try {
                const res = await fetch('/api/v1/notifications/latest?last_id=0');
                if (res.ok) {
                    const data = await res.json();
                    if (data && data.notification) {
                        this.lastCheckedId = data.notification.id;
                        localStorage.setItem('asf_last_notif_id', this.lastCheckedId.toString());
                    }
                }
            } catch (e) {}
        }

        // Poll for new admin-dispatched notifications every 12 seconds
        setInterval(() => {
            this.checkForNewNotifications();
        }, 12000);
    },

    async checkForNewNotifications() {
        try {
            const res = await fetch('/api/v1/notifications/latest?last_id=' + this.lastCheckedId);
            if (!res.ok) return;
            const data = await res.json();
            if (data && data.notification) {
                const notif = data.notification;
                this.lastCheckedId = notif.id;
                localStorage.setItem('asf_last_notif_id', notif.id.toString());
                
                // Show Social Media Toast Card
                this.showToast(notif);
                
                // Native System Push Notification
                if ('Notification' in window && Notification.permission === 'granted') {
                    new Notification(notif.title, {
                        body: notif.body,
                        icon: '/icon-192.png',
                        badge: '/icon-192.png',
                        tag: 'asf-notif-' + notif.id,
                    });
                }
            }
        } catch (e) {}
    },

    showToast(notif) {
        this.activeToast = notif;
        setTimeout(() => {
            if (this.activeToast && this.activeToast.id === notif.id) {
                this.activeToast = null;
            }
        }, 7000);
    }
}"
x-init="init()"
class="fixed top-4 end-4 z-[9999] max-w-xs sm:max-w-sm w-full px-3 print:hidden pointer-events-none select-none"
dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <!-- Sleek Social Media Notification Card (iOS / X / Facebook Style) -->
    <template x-if="activeToast">
        <div x-show="activeToast"
             x-cloak
             x-transition:enter="transition ease-out duration-400 transform"
             x-transition:enter-start="-translate-y-8 opacity-0 scale-95"
             x-transition:enter-end="translate-y-0 opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-250 transform"
             x-transition:leave-start="translate-y-0 opacity-100 scale-100"
             x-transition:leave-end="-translate-y-8 opacity-0 scale-95"
             class="pointer-events-auto bg-slate-900/95 text-white rounded-2xl p-3.5 shadow-2xl border border-slate-700/80 backdrop-blur-xl relative overflow-hidden flex flex-col gap-2 border-s-4"
             :class="{
                 'border-s-amber-400': activeToast.priority === 'HIGH' || activeToast.priority === 'URGENT',
                 'border-s-emerald-400': activeToast.priority !== 'HIGH' && activeToast.priority !== 'URGENT'
             }">
            
            <!-- Social Media Header Row -->
            <div class="flex items-center justify-between gap-2 border-b border-slate-800/80 pb-2">
                <div class="flex items-center gap-2 min-w-0">
                    <!-- App Avatar Icon -->
                    <div class="w-7 h-7 rounded-full bg-[#0B2A6F] border border-amber-400/50 flex items-center justify-center text-amber-300 font-bold text-xs shrink-0 shadow-inner">
                        ASF
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-[11px] font-bold text-slate-200 truncate">
                            {{ app()->getLocale() === 'fr' ? 'Africa Skills Forum' : (app()->getLocale() === 'en' ? 'Africa Skills Forum' : 'منتدى المهارات الإفريقي') }}
                        </span>
                        <span class="text-[9px] text-slate-400 font-medium">
                            {{ app()->getLocale() === 'fr' ? 'À l\'instant' : (app()->getLocale() === 'en' ? 'Just now' : 'الآن') }}
                        </span>
                    </div>
                </div>

                <!-- Close Button -->
                <button @click="activeToast = null" type="button" class="text-slate-400 hover:text-white transition p-1 rounded-full hover:bg-slate-800 shrink-0 cursor-pointer">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <!-- Social Media Content Body -->
            <div class="space-y-0.5 pt-0.5">
                <h6 class="text-xs font-extrabold text-amber-300 leading-snug truncate" x-text="activeToast.title"></h6>
                <p class="text-[11px] text-slate-300 font-medium leading-normal line-clamp-2" x-text="activeToast.body"></p>
            </div>
        </div>
    </template>
</div>
