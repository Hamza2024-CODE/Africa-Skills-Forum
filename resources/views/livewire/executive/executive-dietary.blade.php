@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };

$dietaryOptions = [
    'gluten_free'  => ['title' => $t('خالٍ من الغلوتين', 'Sans Gluten', 'Gluten-Free'), 'icon' => 'wheat'],
    'lactose_free' => ['title' => $t('خالٍ من اللكتوز والحليب', 'Sans Lactose', 'Lactose-Free'), 'icon' => 'milk'],
    'nut_allergy'  => ['title' => $t('حساسية المكسرات والفول السوداني', 'Allergie Fruits à Coque', 'Nut Allergy'), 'icon' => 'nut'],
    'seafood_free' => ['title' => $t('حساسية الأسماك والمأكولات البحرية', 'Sans Fruits de Mer', 'Seafood Allergy'), 'icon' => 'fish'],
    'vegetarian'   => ['title' => $t('نباتي (Vegetarian)', 'Végétarien', 'Vegetarian'), 'icon' => 'leaf'],
    'diabetic'     => ['title' => $t('وجبات خاصة بمرضى السكري (سكر منخفض)', 'Régime Diabétique', 'Diabetic-Friendly'), 'icon' => 'heart'],
    'low_sodium'   => ['title' => $t('منخفض الصوديوم والأملاح', 'Faible en Sodium', 'Low Sodium'), 'icon' => 'salt'],
];
@endphp

<div class="space-y-6 pb-12" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 dark:border-slate-700 pb-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-rose-600 to-pink-700 text-white flex items-center justify-center font-bold shadow-md">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                        {{ $t('الملف الغذائي وتفضيلات الإطعام الوزارية', 'Régime Alimentaire & Allergies Ministérielles', 'Ministerial Dietary & Allergy Preferences') }}
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-slate-400 font-medium mt-0.5">
                        {{ $t('تخصيص الوجبات والأنظمة الغذائية الرسمية لمأدبة المباحثات والمؤتمرات الوزارية.', 'Gestion des préférences alimentaires pour les banquets et réceptions diplomatiques.', 'Manage meal preferences for diplomatic banquets and ministerial receptions.') }}
                    </p>
                </div>
            </div>
        </div>

        <button wire:click="saveDietaryInfo" class="px-5 py-2.5 rounded-2xl bg-emerald-600 hover:bg-emerald-700 text-white font-black text-xs transition shadow-md flex items-center gap-2 self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            <span>{{ $t('حفظ التفضيلات الغذائية', 'Enregistrer les Préférences', 'Save Dietary Preferences') }}</span>
        </button>
    </div>

    @if($flashMessage)
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold shadow-sm flex items-center gap-2">
            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ $flashMessage }}</span>
        </div>
    @endif

    {{-- DIETARY SELECTION CARDS --}}
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 shadow-md space-y-6">
        <div>
            <h3 class="text-sm font-black text-[#06205C] dark:text-white uppercase tracking-wider mb-1">
                {{ $t('حدد الأنظمة الغذائية والحساسيات الخاصة:', 'Sélectionnez vos régimes et allergies:', 'Select Your Dietary Requirements & Allergies:') }}
            </h3>
            <p class="text-xs text-slate-500 dark:text-slate-400">
                {{ $t('سيتم نقل هذه التفضيلات تلقائياً إلى الفريق التنفيذي المسؤول عن المأدبة والبروتوكول الوزاري.', 'Ces informations seront transmises à l\'équipe de restauration VIP et protocole.', 'These preferences will be automatically communicated to VIP catering & protocol team.') }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($dietaryOptions as $code => $opt)
                @php $selected = in_array($code, $requirements); @endphp
                <button type="button" wire:click="toggleRequirement('{{ $code }}')"
                        class="p-4 rounded-2xl border text-start transition-all flex items-center justify-between gap-3 cursor-pointer select-none
                        {{ $selected ? 'bg-rose-50 dark:bg-rose-950/40 border-rose-300 dark:border-rose-800 text-rose-900 dark:text-rose-200 shadow-xs' : 'bg-slate-50 dark:bg-slate-900/60 border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:border-slate-300' }}">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-xl {{ $selected ? 'bg-rose-600 text-white' : 'bg-slate-200 dark:bg-slate-800 text-slate-500' }} flex items-center justify-center text-xs font-black shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <span class="text-xs font-bold leading-tight">{{ $opt['title'] }}</span>
                    </div>

                    <span class="w-5 h-5 rounded-lg border flex items-center justify-center shrink-0 {{ $selected ? 'bg-rose-600 border-rose-600 text-white' : 'border-slate-300 dark:border-slate-600' }}">
                        @if($selected)
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        @endif
                    </span>
                </button>
            @endforeach
        </div>

        {{-- NOTES TEXTAREA --}}
        <div class="pt-4 border-t border-slate-100 dark:border-slate-700 space-y-2">
            <label class="block text-xs font-black text-slate-700 dark:text-slate-300">
                {{ $t('ملاحظات وتوجيهات خاصة لطاقم الضيافة والطهاة:', 'Instructions particulières pour les chefs:', 'Special Dietary Instructions & Notes:') }}
            </label>
            <textarea wire:model="dietaryNotes" rows="3"
                      placeholder="{{ $t('اكتب أي ملاحظات إضافية بخصوص وجبات الطعام والضيافة...', 'Saisissez toute instruction supplémentaire...', 'Enter any special instructions or notes...') }}"
                      class="w-full p-4 rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-rose-500"></textarea>
        </div>
    </div>
</div>
