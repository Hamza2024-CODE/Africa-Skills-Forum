<div class="w-full font-sans space-y-6" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <!-- Header -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#0066FF] flex items-center justify-center font-black">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </div>
            <div>
                <h1 class="text-lg font-black text-[#06205C]">
                    {{ app()->getLocale() === 'fr' ? 'Gestion du Guide & Règlements (CMS)' : (app()->getLocale() === 'en' ? 'Guide & Regulations CMS' : 'إدارة محتوى الدليل واللوائح التنظيمية (CMS)') }}
                </h1>
                <p class="text-xs text-slate-500 font-medium mt-0.5">
                    {{ app()->getLocale() === 'fr' ? 'Modifier les textes et règlements officiels (AR / FR / EN).' : (app()->getLocale() === 'en' ? 'Edit guide texts, icons, and official regulations in 3 languages.' : 'تعديل نصوص وأيقونات أقسام صفحة اللوائح والدليل باللغات الثلاث (العربية / الفرنسية / الإنجليزية).') }}
                </p>
            </div>
        </div>
        <a href="{{ route('guide.regulations') }}" target="_blank" class="px-4 py-2 rounded-xl bg-blue-50 text-[#0066FF] hover:bg-blue-100 font-bold text-xs transition flex items-center gap-1.5 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            <span>{{ app()->getLocale() === 'fr' ? 'Aperçu de la Page' : (app()->getLocale() === 'en' ? 'Preview Public Page' : 'معاينة الصفحة العامة') }}</span>
        </a>
    </div>

    @if($successMessage)
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ $successMessage }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

        <!-- Sidebar Section List -->
        <div class="lg:col-span-1 bg-white p-4 rounded-3xl border border-slate-200 shadow-sm space-y-1.5 h-fit">
            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest px-2 pb-1 border-b border-slate-100 mb-2">
                {{ app()->getLocale() === 'fr' ? 'Sélectionner une Section' : (app()->getLocale() === 'en' ? 'Select Section' : 'اختر القسم للتعديل') }}
            </p>
            @foreach($sections as $sec)
                <button
                    wire:click="loadSection('{{ $sec->section_key }}')"
                    class="w-full text-right px-3.5 py-2.5 rounded-2xl text-xs font-black transition flex items-center justify-between gap-2 {{ $activeSectionKey === $sec->section_key ? 'bg-[#0066FF] text-white shadow-md' : 'text-slate-700 hover:bg-slate-50' }}"
                >
                    <span class="truncate">{{ $sec->sort_order }}. {{ $sec->getLocalized('title') }}</span>
                    @if(!$sec->is_active)
                        <span class="px-1.5 py-0.5 rounded bg-rose-100 text-rose-700 text-[9px] shrink-0">{{ app()->getLocale() === 'fr' ? 'Inactif' : (app()->getLocale() === 'en' ? 'Inactive' : 'معطل') }}</span>
                    @endif
                </button>
            @endforeach
        </div>

        <!-- Form Area -->
        <div class="lg:col-span-3 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-5">
            <form wire:submit.prevent="saveSection" class="space-y-6">

                <!-- Meta & Status -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                    <div>
                        <label class="block text-xs font-black text-[#06205C] mb-1">Key Identifier</label>
                        <input type="text" value="{{ $activeSectionKey }}" disabled class="w-full px-3 py-2 rounded-xl bg-slate-200 text-slate-500 text-xs font-mono font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-[#06205C] mb-1">{{ app()->getLocale() === 'fr' ? 'Ordre (Sort Order)' : (app()->getLocale() === 'en' ? 'Sort Order' : 'الترتيب (Sort Order)') }}</label>
                        <input type="number" wire:model="sort_order" min="1" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 text-xs font-bold">
                    </div>
                    <div>
                        <label class="block text-xs font-black text-[#06205C] mb-1">{{ app()->getLocale() === 'fr' ? 'Statut d\'Affichage' : (app()->getLocale() === 'en' ? 'Display Status' : 'حالة العرض') }}</label>
                        <select wire:model="is_active" class="w-full px-3 py-2 rounded-xl bg-white border border-slate-300 text-xs font-bold">
                            <option value="1">{{ app()->getLocale() === 'fr' ? 'Actif (Public)' : (app()->getLocale() === 'en' ? 'Active (Public)' : 'مفعّل (ظاهر للعامة)') }}</option>
                            <option value="0">{{ app()->getLocale() === 'fr' ? 'Inactif (Masqué)' : (app()->getLocale() === 'en' ? 'Inactive (Hidden)' : 'مخفي (معطل)') }}</option>
                        </select>
                    </div>
                </div>

                <!-- Titles in 3 Languages -->
                <div class="space-y-3">
                    <h3 class="text-xs font-black text-[#06205C] uppercase tracking-wider pb-1 border-b border-slate-100">
                        {{ app()->getLocale() === 'fr' ? 'Titre de la section (AR / FR / EN)' : (app()->getLocale() === 'en' ? 'Section Title (AR / FR / EN)' : 'العنوان باللغات الثلاث') }}
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">العنوان (العربية)</label>
                            <input type="text" wire:model="title_ar" required class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Titre (Français)</label>
                            <input type="text" wire:model="title_fr" dir="ltr" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Title (English)</label>
                            <input type="text" wire:model="title_en" dir="ltr" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                        </div>
                    </div>
                </div>

                <!-- Bodies in 3 Languages -->
                <div class="space-y-3">
                    <h3 class="text-xs font-black text-[#06205C] uppercase tracking-wider pb-1 border-b border-slate-100">
                        {{ app()->getLocale() === 'fr' ? 'Contenu détaillé (AR / FR / EN)' : (app()->getLocale() === 'en' ? 'Detailed Content (AR / FR / EN)' : 'المحتوى والتفاصيل باللغات الثلاث') }}
                    </h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">المحتوى الرئيسي (العربية)</label>
                            <textarea wire:model="body_ar" rows="4" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-medium leading-relaxed"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Contenu principal (Français)</label>
                            <textarea wire:model="body_fr" dir="ltr" rows="4" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-medium leading-relaxed"></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Main content (English)</label>
                            <textarea wire:model="body_en" dir="ltr" rows="4" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-medium leading-relaxed"></textarea>
                        </div>
                    </div>
                </div>

                <!-- SVG Icon -->
                <div class="space-y-2">
                    <label class="block text-xs font-black text-[#06205C]">SVG Icon Path (`d` attribute)</label>
                    <input type="text" wire:model="icon_svg" dir="ltr" placeholder="M13 16h-1v-4h-1m1-4h.01M21 12..." class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-mono">
                </div>

                <!-- Submit Button -->
                <div class="pt-4 border-t border-slate-100 flex justify-end">
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-bold text-xs transition shadow-md flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Enregistrer Modifications' : (app()->getLocale() === 'en' ? 'Save Changes' : 'حفظ وتطبيق التغييرات') }}</span>
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
