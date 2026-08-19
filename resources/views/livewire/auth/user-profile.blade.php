@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
$userRole = $user?->roles->first()?->name ?? 'PARTICIPANT';

$userRoleKey = match($userRole) {
    'EXECUTIVE_VIEWER'                  => 'MINISTERIAL EXECUTIVE OBSERVER',
    'COUNTRY_ADMIN'                     => 'DELEGATION HEAD',
    'JUDGE', 'EXPERT'                   => 'EXPERT JUDGE',
    'MEDIA_MANAGER'                     => 'MEDIA',
    'ORGANIZATION_ADMIN', 'SUPER_ADMIN' => 'ORGANIZER',
    default                             => 'COMPETITOR',
};

$badgeTheme = match($userRoleKey) {
    'MINISTERIAL EXECUTIVE OBSERVER' => [
        'bg'     => 'linear-gradient(145deg, #311B92 0%, #0D0536 100%)',
        'badge'  => 'وزير / مراقب تنفيذي — MINISTERIAL EXECUTIVE OBSERVER',
        'accent' => '#FFD700',
    ],
    'DELEGATION HEAD' => [
        'bg'     => 'linear-gradient(145deg, #023E28 0%, #011F14 100%)',
        'badge'  => 'مسؤول الوفد — DELEGATION HEAD',
        'accent' => '#F3E5AB',
    ],
    'EXPERT JUDGE' => [
        'bg'     => 'linear-gradient(145deg, #1E1B4B 0%, #0B1021 100%)',
        'badge'  => 'خبير محكّم — EXPERT JUDGE',
        'accent' => '#87CEEB',
    ],
    'MEDIA' => [
        'bg'     => 'linear-gradient(145deg, #78350F 0%, #240C02 100%)',
        'badge'  => 'وفد إعلامي — MEDIA / PRESS',
        'accent' => '#FDE68A',
    ],
    'ORGANIZER' => [
        'bg'     => 'linear-gradient(145deg, #1E293B 0%, #0F172A 100%)',
        'badge'  => 'منظم رسمي — ORGANIZER',
        'accent' => '#CBD5E1',
    ],
    default => [
        'bg'     => 'linear-gradient(145deg, #06205C 0%, #01091C 100%)',
        'badge'  => 'متنافس رسمي — COMPETITOR',
        'accent' => '#BAE6FD',
    ],
};

$roleLabel = match($userRoleKey) {
    'MINISTERIAL EXECUTIVE OBSERVER' => $t('وزير / مراقب تنفيذي', 'Ministre / Observateur Exécutif', 'Minister & Executive Observer'),
    'DELEGATION HEAD'                => $t('مسؤول الوفد (Head of Delegation)', 'Chef de Délégation', 'Head of Delegation'),
    'EXPERT JUDGE'                   => $t('خبير محكّم', 'Expert Juge', 'Expert Judge'),
    'MEDIA'                          => $t('مسؤول الإعلام والصحافة', 'Responsable Médias & Presse', 'Press & Media Manager'),
    'ORGANIZER'                      => $t('منظم رئيسي للمسابقة', 'Organisateur Officiel', 'Official Organizer'),
    default                          => $t('متنافس رسمي', 'Compétiteur Officiel', 'Official Competitor'),
};

$countryName = $user?->country ? ($locale === 'fr' ? ($user->country->name_fr ?? $user->country->name_en) : ($locale === 'en' ? $user->country->name_en : $user->country->name_ar)) : $t('الجمهورية الجزائرية', 'Algérie', 'Algeria');

$badgeVerifyUrl = route('accreditation.badge', ['identifier' => $user?->uuid ?? $user?->id]);
$badgeQrUrl = \App\Services\QrCodeService::generateDataUri($badgeVerifyUrl, 300);
@endphp

<div class="py-8 px-4 sm:px-6 lg:px-8 bg-slate-50 dark:bg-slate-900 min-h-screen text-slate-900 dark:text-white font-sans" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">
    <div class="max-w-4xl mx-auto space-y-8">
        
        <!-- Header Card with User Avatar & Role Badge -->
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 sm:p-8 border border-slate-200 dark:border-slate-700 shadow-md space-y-6">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-6 pb-6 border-b border-slate-100 dark:border-slate-700">
                <div class="flex flex-col sm:flex-row items-center gap-5 text-center sm:text-start">
                    <div class="relative group">
                        <img src="{{ ($photo ?? null) ? $photo->temporaryUrl() : ($user?->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode($user?->name ?? 'U')) }}" alt="Avatar" class="w-24 h-24 rounded-3xl object-cover border-4 border-[#06205C] dark:border-sky-400 shadow-lg">
                        <label for="photo-upload" class="absolute -bottom-2 -right-2 bg-[#06205C] hover:bg-blue-900 text-white p-2.5 rounded-2xl cursor-pointer shadow-md transition transform hover:scale-110 border border-white" title="{{ $t('تغيير الصورة الشخصية', 'Changer la photo', 'Change profile picture') }}">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </label>
                        <input type="file" id="photo-upload" wire:model="photo" accept="image/*" class="hidden">
                    </div>

                    <div class="space-y-1">
                        <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                            <h1 class="text-2xl font-black text-[#06205C] dark:text-white tracking-tight">{{ $user?->name }}</h1>
                            <span class="px-3 py-1 rounded-full text-xs font-black bg-amber-50 text-amber-900 border border-amber-300 dark:bg-amber-950 dark:text-amber-200">
                                {{ $roleLabel }}
                            </span>
                        </div>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 flex items-center justify-center sm:justify-start gap-2">
                            <span>🏛️ {{ $countryName }}</span>
                            <span class="text-slate-300">|</span>
                            <span>📧 {{ $user?->email }}</span>
                        </p>
                    </div>
                </div>

                <div class="flex flex-wrap sm:flex-col items-center gap-2 self-stretch justify-center">
                    <a href="{{ $badgeVerifyUrl }}" target="_blank" class="px-4 py-2.5 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-amber-300 font-black text-xs shadow-md transition flex items-center gap-2 border border-amber-400/40">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/></svg>
                        <span>{{ $t('فتح الشارة الرسمية عالية الدقة ↗', 'Ouvrir le Badge HD ↗', 'Open HD Badge Pass ↗') }}</span>
                    </a>
                </div>
            </div>

            @if($successMessage ?? null)
                <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-300 dark:border-emerald-800 text-emerald-900 dark:text-emerald-200 text-xs font-bold flex items-center gap-3 shadow-sm">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ $successMessage }}</span>
                </div>
            @endif

            <!-- SECTION: INLINE OFFICIAL DIPLOMATIC ACCREDITATION BADGE CARD -->
            <div class="p-6 rounded-3xl bg-slate-100 dark:bg-slate-900/80 border border-slate-200 dark:border-slate-700 space-y-6">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-700 pb-4">
                    <div>
                        <h3 class="text-base font-black text-[#06205C] dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/></svg>
                            <span>{{ $t('شارة الاعتماد الرسمية المعتمدة لصفة حسابك:', 'Votre Badge Officiel d\'Accréditation:', 'Your Official Accredited Sovereign Badge Pass:') }}</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                            {{ $t('تم توليد هذه الشارة بناءً على صفة ورتبة حسابك المعتمدة وتتضمن كود QR مفتاح الوصول الأمني المباشر.', 'Badge généré automatiquement selon votre rôle officiel avec QR code sécurisé.', 'Dynamically generated badge pass matching your official system role with encrypted QR access token.') }}
                        </p>
                    </div>

                    <a href="{{ $badgeVerifyUrl }}" target="_blank" class="px-4 py-2 rounded-xl bg-[#06205C] hover:bg-[#041640] text-amber-300 font-bold text-xs shadow-sm transition flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>{{ $t('طباعة الشارة (Print PVC)', 'Imprimer', 'Print Badge') }}</span>
                    </a>
                </div>

                <!-- 3D BADGE DISPLAY CARD -->
                <div class="flex justify-center my-4">
                    <div class="w-full max-w-sm rounded-3xl p-6 shadow-2xl border-4 border-white/80 space-y-4 text-white text-center transition transform hover:scale-102" style="background: {{ $badgeTheme['bg'] }};">
                        
                        <!-- Top Emblem Header -->
                        <div class="flex items-center justify-between border-b border-white/20 pb-3 px-1 gap-2">
                            <img src="/ministry-logo-white-trimmed.png" alt="وزارة التكوين والتعليم المهنيين" class="h-10 sm:h-11 w-auto max-w-[55%] object-contain filter drop-shadow">
                            <img src="/africa-logo-trimmed.png" alt="Africa Skills Forum 2026" class="h-9 sm:h-10 w-auto max-w-[40%] object-contain filter drop-shadow">
                        </div>

                        <!-- User Profile Name & Role -->
                        <div class="space-y-1 py-1">
                            <h2 class="text-xl font-black text-white tracking-tight truncate">{{ $user?->name }}</h2>
                            <p class="text-xs font-sans font-medium text-slate-300 truncate leading-normal py-0.5" dir="ltr">{{ $user?->email }}</p>
                        </div>

                        <!-- QR Code Center Box -->
                        <div class="w-44 h-44 bg-white p-2.5 rounded-2xl mx-auto shadow-inner flex flex-col items-center justify-center border-2 border-white/90">
                            <img src="{{ $badgeQrUrl }}" alt="QR Code Access Token" class="w-32 h-32 object-contain">
                            <span class="text-[7px] font-mono font-black text-slate-600 mt-1 uppercase">SECURED BY WSAP ZERO-TRUST</span>
                        </div>

                        <!-- Sovereign Role Title Banner -->
                        <div class="pt-2 border-t border-white/20">
                            <span class="text-xs font-bold font-sans uppercase block text-center" style="letter-spacing: 0 !important; color: {{ $badgeTheme['accent'] }};">
                                {{ $badgeTheme['badge'] }}
                            </span>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Comprehensive Account Overview Cards -->
            <div class="space-y-4 pt-4 border-t border-slate-100 dark:border-slate-700">
                <h3 class="text-sm font-black text-[#06205C] dark:text-white uppercase tracking-wider">
                    {{ $t('معلومات وسجل صاحب الحساب الشاملة:', 'Informations Complètes du Compte:', 'Comprehensive Account Overview:') }}
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 space-y-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">{{ $t('الرتبة والصفة المعتمدة', 'Rôle Officiel', 'Official Role') }}</span>
                        <span class="text-xs font-black text-slate-900 dark:text-white block">{{ $roleLabel }}</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 space-y-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">{{ $t('الدولة والوفد التابع له', 'Pays & Délégation', 'Country & Delegation') }}</span>
                        <span class="text-xs font-black text-blue-700 dark:text-sky-300 block">{{ $countryName }}</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 space-y-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">{{ $t('المؤسسة / القطاع المعين', 'Organisation / Secteur', 'Organization / Sector') }}</span>
                        <span class="text-xs font-black text-slate-900 dark:text-white block">{{ $user?->organization?->getLocalized('name') ?? $t('قطاع رسمي معتمد', 'Secteur Officiel', 'Official Sector') }}</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 space-y-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">{{ $t('الولاية / المنطقة الإقليمية', 'Wilaya / Région', 'Wilaya / Region') }}</span>
                        <span class="text-xs font-black text-slate-900 dark:text-white block">{{ $user?->wilaya?->name_ar ?? $t('الجزائر العاصمة', 'Alger', 'Algiers') }}</span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 space-y-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">{{ $t('حالة تفعيل الحساب', 'Statut du Compte', 'Account Status') }}</span>
                        <span class="text-xs font-black text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                            <span>{{ $t('مفعل ومعتمد رسمي (ACTIVE)', 'Compte Actif', 'Active Account') }}</span>
                        </span>
                    </div>

                    <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 space-y-1">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">{{ $t('طبعة المسابقة الرسمية', 'Édition de la Compétition', 'Official Edition') }}</span>
                        <span class="text-xs font-black text-amber-600 dark:text-amber-300 block">WorldSkills Africa 2027</span>
                    </div>
                </div>
            </div>

            <!-- Profile & Personal Details Form -->
            <form wire:submit.prevent="updateProfile" class="space-y-6 pt-4 border-t border-slate-100 dark:border-slate-700">
                <h3 class="text-sm font-black text-[#06205C] dark:text-white uppercase tracking-wider">
                    {{ $t('تحديث البيانات الشخصية والمعلومات الإضافية:', 'Mise à jour des informations personnelles:', 'Update Personal & Profile Details:') }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('الاسم الكامل للصاحب الحساب', 'Nom Complet', 'Full Name') }}
                        </label>
                        <input type="text" wire:model="name" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        @error('name') <span class="text-xs text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('البريد الإلكتروني المعتمد', 'Adresse E-mail', 'Email Address') }}
                        </label>
                        <input type="email" wire:model="email" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        @error('email') <span class="text-xs text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('رقم الهاتف للتواصل الرسمي', 'Numéro de Téléphone', 'Phone Number') }}
                        </label>
                        <input type="text" wire:model="phone" placeholder="+213..." class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        @error('phone') <span class="text-xs text-rose-500 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('اللغة المفضلة للنظام والواجهة', 'Langue Préférée', 'Preferred Language') }}
                        </label>
                        <select wire:model="locale" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                            <option value="ar">العربية (Arabic - RTL)</option>
                            <option value="fr">Français (French - LTR)</option>
                            <option value="en">English (English - LTR)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('رقم جواز السفر الدولي', 'Numéro de Passeport', 'Passport Number') }}
                        </label>
                        <input type="text" wire:model="passport_number" placeholder="DZ-1234567" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs font-mono font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('رقم التعريف الوطني (NIN)', 'Numéro NIN', 'NIN Number') }}
                        </label>
                        <input type="text" wire:model="nin_number" placeholder="10000200..." class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs font-mono font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="px-6 py-3 rounded-2xl bg-[#06205C] hover:bg-[#041640] text-white font-black text-xs shadow-md transition flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ $t('حفظ وتحديث البيانات الشخصية', 'Enregistrer les Modifications', 'Save Account Details') }}</span>
                    </button>
                </div>
            </form>

            <!-- Change Password Form -->
            <form wire:submit.prevent="updatePassword" class="space-y-6 pt-6 border-t border-slate-100 dark:border-slate-700">
                <h3 class="text-sm font-black text-[#06205C] dark:text-white uppercase tracking-wider">
                    {{ $t('تغيير كلمة المرور وتأمين الحساب:', 'Changer le Mot de Passe:', 'Change Password & Security:') }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('كلمة المرور الحالية', 'Mot de Passe Actuel', 'Current Password') }}
                        </label>
                        <input type="password" wire:model="current_password" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        @error('current_password') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('كلمة المرور الجديدة', 'Nouveau Mot de Passe', 'New Password') }}
                        </label>
                        <input type="password" wire:model="new_password" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                        @error('new_password') <span class="text-xs text-rose-500 mt-1 block font-bold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            {{ $t('تأكيد كلمة المرور الجديدة', 'Confirmer le Mot de Passe', 'Confirm New Password') }}
                        </label>
                        <input type="password" wire:model="new_password_confirmation" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs font-bold text-slate-900 dark:text-white focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>
                </div>

                <div class="flex items-center justify-end">
                    <button type="submit" class="px-6 py-3 rounded-2xl bg-slate-800 hover:bg-slate-900 text-white font-black text-xs shadow-md transition flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        <span>{{ $t('تحديث كلمة المرور', 'Mettre à jour le mot de passe', 'Update Password') }}</span>
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
