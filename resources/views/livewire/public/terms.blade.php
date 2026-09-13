<div class="py-12 sm:py-16 bg-[#F4F7FC]">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-br from-[#0B2A6F] via-[#081F54] to-[#040E26] text-white rounded-3xl p-8 sm:p-12 shadow-xl border border-white/10 relative overflow-hidden text-right" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
            <div class="absolute top-0 right-0 w-64 h-64 bg-amber-500/10 rounded-full blur-3xl pointer-events-none"></div>
            <div class="relative z-10 space-y-3">
                <h1 class="text-2xl sm:text-4xl font-black text-white leading-tight">
                    {{ polyTrans('شروط وأحكام الاستخدام الرسمية', 'Conditions Générales d\'Utilisation', 'Terms & Conditions') }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-200 font-medium max-w-2xl">
                    {{ polyTrans('القواعد الرسمية المحددة لضوابط التسجيل، والاعتماد، والمشاركة بالمنتدى.', 'Règles d\'utilisation de la plateforme officielle du Forum des Politiques Africaines des Compétences.', 'Official terms governing platform registration, accreditation, and participation.') }}
                </p>
            </div>
        </div>

        <!-- Main Content Card -->
        <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-md border border-slate-200/80 space-y-8 text-right" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
            
            <!-- Summary Callout -->
            <div class="p-5 rounded-2xl bg-amber-50/70 border border-amber-200/80 flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-[#0B2A6F] text-white flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                    <svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div class="space-y-1">
                    <h3 class="text-sm font-black text-[#0B2A6F]">
                        {{ polyTrans('شروط وضوابط الاستخدام', 'Conditions & Règles D\'Utilisation', 'Terms of Service') }}
                    </h3>
                    <p class="text-xs text-slate-700 leading-relaxed font-medium">
                        {{ $content }}
                    </p>
                </div>
            </div>

            <!-- Meta Details -->
            <div class="flex items-center justify-between text-xs text-slate-500 pt-4 border-t border-slate-100">
                <span class="font-bold">Version {{ $version }}</span>
                <span>{{ app()->getLocale() === 'pt' ? (__('آخر تحديث:') !== 'آخر تحديث:' ? __('آخر تحديث:') : 'Last Updated:') : (polyTrans('آخر تحديث:', 'Dernière mise à jour:', 'Last Updated:')) }} {{ $updatedAt }}</span>
            </div>

        </div>
    </div>
</div>
