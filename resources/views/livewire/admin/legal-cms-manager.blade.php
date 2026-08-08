<div class="space-y-8 p-6 max-w-7xl mx-auto">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-[#06205C]">إدارة المستندات القانونية والسياسات (Legal CMS)</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">إدارة المحتوى القانوني وسياسات الاستخدام والخصوصية بثلاث لغات (AR/FR/EN) في MySQL</p>
        </div>
        <span class="px-3 py-1 rounded-full bg-brand-50 text-brand-500 font-mono text-xs font-bold border border-brand-200">
            MySQL: wordskills
        </span>
    </div>

    @if($successMessage)
        <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-700 border border-emerald-200 font-bold text-xs">
            {{ $successMessage }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Navigation sidebar -->
        <div class="space-y-2">
            <button wire:click="loadKey('privacy')" class="w-full text-right px-4 py-3 rounded-xl text-xs font-bold transition flex items-center justify-between {{ $activeKey === 'privacy' ? 'bg-brand-500 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100' }}">
                <span>سياسة الخصوصية</span>
                <span class="text-[10px] opacity-75">privacy</span>
            </button>
            <button wire:click="loadKey('terms')" class="w-full text-right px-4 py-3 rounded-xl text-xs font-bold transition flex items-center justify-between {{ $activeKey === 'terms' ? 'bg-brand-500 text-white shadow-md' : 'bg-white text-slate-700 hover:bg-slate-100' }}">
                <span>شروط وأحكام الاستخدام</span>
                <span class="text-[10px] opacity-75">terms</span>
            </button>
        </div>

        <!-- Document Form Editor -->
        <div class="md:col-span-3 bg-white rounded-3xl p-6 border border-slate-200/80 shadow-md space-y-6">
            <form wire:submit.prevent="saveLegalDoc" class="space-y-6">
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">العنوان (بالعربية)</label>
                        <input type="text" wire:model="titleAr" class="w-full rounded-xl border-slate-200 p-2.5 text-xs focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Title (Français)</label>
                        <input type="text" wire:model="titleFr" class="w-full rounded-xl border-slate-200 p-2.5 text-xs focus:ring-brand-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Title (English)</label>
                        <input type="text" wire:model="titleEn" class="w-full rounded-xl border-slate-200 p-2.5 text-xs focus:ring-brand-500">
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">المحتوى الشامل (بالعربية)</label>
                        <textarea wire:model="contentAr" rows="5" class="w-full rounded-xl border-slate-200 p-3 text-xs focus:ring-brand-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Contenu (Français)</label>
                        <textarea wire:model="contentFr" rows="4" class="w-full rounded-xl border-slate-200 p-3 text-xs focus:ring-brand-500"></textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Content (English)</label>
                        <textarea wire:model="contentEn" rows="4" class="w-full rounded-xl border-slate-200 p-3 text-xs focus:ring-brand-500"></textarea>
                    </div>
                </div>

                <div class="flex items-center justify-between border-t border-slate-100 pt-4">
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 text-xs font-bold text-slate-700 cursor-pointer">
                            <input type="checkbox" wire:model="isPublished" class="rounded border-slate-300 text-brand-500 focus:ring-brand-500">
                            <span>مفعل ومعروض في الموقع</span>
                        </label>
                        <input type="text" wire:model="version" placeholder="رقم الإصدار (1.0)" class="w-24 rounded-xl border-slate-200 p-2 text-xs">
                    </div>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-md">
                        حفظ المستند في قاعدة البيانات
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
