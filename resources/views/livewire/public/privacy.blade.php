<div class="py-12 sm:py-16 bg-[#F4F7FC]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-br from-[#0B2A6F] via-[#081F54] to-[#040E26] text-white rounded-3xl p-8 sm:p-12 shadow-xl border border-white/10 relative overflow-hidden text-right" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
            <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 space-y-3">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-xs font-bold text-amber-300">
                    <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    <span>{{ platform()->name() }}</span>
                </div>
                <h1 class="text-2xl sm:text-4xl font-black text-white leading-tight">
                    {{ app()->getLocale() === 'fr' ? 'Politique de Confidentialité & Protection des Données' : (app()->getLocale() === 'en' ? 'Privacy Policy & Data Security' : 'سياسة الخصوصية وحماية البيانات الشخصية') }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-200 font-medium max-w-2xl">
                    {{ app()->getLocale() === 'fr' ? 'Engagement officiel de protection de la vie privée et de sécurité des informations des participants.' : (app()->getLocale() === 'en' ? 'Official commitment to participant privacy and information security.' : 'التزام رسمي بحماية سرية وأمان معلومات جميع المشاركين والزوار بالمنتدى.') }}
                </p>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-md border border-slate-200/80 space-y-8 text-right" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
            
            <!-- Summary Callout -->
            <div class="p-5 rounded-2xl bg-blue-50/70 border border-blue-200/80 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-[#0B2A6F] text-white flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <div class="space-y-1">
                    <h3 class="text-sm font-black text-[#0B2A6F]">
                        {{ app()->getLocale() === 'fr' ? 'Engagement De Confidentialité' : (app()->getLocale() === 'en' ? 'Privacy Commitment' : 'الالتزام بحماية الخصوصية') }}
                    </h3>
                    <p class="text-xs text-slate-700 leading-relaxed font-medium">
                        {{ $content }}
                    </p>
                </div>
            </div>

            <!-- Meta Details -->
            <div class="flex items-center justify-between text-xs text-slate-500 pt-4 border-t border-slate-100">
                <span class="font-bold">Version {{ $version }}</span>
                <span>{{ app()->getLocale() === 'fr' ? 'Dernière mise à jour:' : (app()->getLocale() === 'en' ? 'Last Updated:' : 'آخر تحديث:') }} {{ $updatedAt }}</span>
            </div>

        </div>
    </div>
</div>
