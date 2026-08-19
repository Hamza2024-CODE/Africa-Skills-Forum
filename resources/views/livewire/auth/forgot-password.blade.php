<div class="min-h-screen bg-[#F4F7FC] flex flex-col justify-center py-10 px-4 sm:px-6 lg:px-8 relative overflow-hidden" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <!-- Light Ambient Backdrop Glows -->
    <div class="absolute -top-32 -end-32 w-96 h-96 bg-[#35A536]/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -start-32 w-96 h-96 bg-[#F5A800]/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl w-full mx-auto bg-white rounded-3xl shadow-2xl border border-slate-200/90 overflow-hidden grid grid-cols-1 lg:grid-cols-12 relative z-10">
        
        <!-- Left Column: Official Pan-African Leadership Header Card -->
        <div class="lg:col-span-5 bg-gradient-to-br from-[#0B2A6F] via-[#081F54] to-[#040E26] p-8 sm:p-10 text-white flex flex-col justify-between relative overflow-hidden">
            
            <!-- Subtle Radial Light Accent -->
            <div class="absolute top-0 end-0 w-64 h-64 bg-[#35A536]/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="space-y-6 relative z-10">
                
                <!-- 1. Republic Official Name -->
                <div class="border-b border-white/15 pb-4">
                    <p class="text-[11px] sm:text-xs font-black text-amber-300/90 uppercase tracking-widest leading-relaxed">
                        {{ app()->getLocale() === 'fr' ? 'République Algérienne Démocratique et Populaire' : (app()->getLocale() === 'en' ? 'People\'s Democratic Republic of Algeria' : 'الجمهورية الجزائرية الديمقراطية الشعبية') }}
                    </p>
                </div>

                <!-- 2. Event Title & Official Logo -->
                <div class="flex items-center gap-3 pt-2">
                    <img src="/AFRICA.png" alt="{{ platform()->name() }}" class="h-14 sm:h-16 w-auto object-contain filter drop-shadow-xl shrink-0">
                    <div>
                        <h1 class="font-black text-xl sm:text-2xl text-white leading-tight">
                            {{ app()->getLocale() === 'fr' ? 'Africa Skills Forum 2026' : (app()->getLocale() === 'en' ? 'Africa Skills Forum 2026' : 'منتدى المهارات الإفريقية 2026') }}
                        </h1>
                        <span class="text-[10px] font-bold text-slate-300 block mt-1">
                            {{ app()->getLocale() === 'fr' ? 'Récupération de Compte Sécurisée' : (app()->getLocale() === 'en' ? 'Secure Account Recovery' : 'خدمة استرجاع الحساب والتحقق') }}
                        </span>
                    </div>
                </div>

                <!-- 3. Brief Description -->
                <p class="text-xs text-blue-100/80 leading-relaxed font-medium pt-2">
                    {{ app()->getLocale() === 'fr' 
                        ? 'Vérification d\'identité par numéro NIN (18 chiffres) ou numéro de passeport officiel pour la réinitialisation de votre mot de passe.' 
                        : (app()->getLocale() === 'en' 
                            ? 'Identity verification via National Identification Number (NIN) or Passport number to safely reset your account password.' 
                            : 'نظام التحقق الآمن من الهوية بواسطة رقم التعريف الوطني (NIN 18 رقماً) أو رقم جواز السفر لاسترجاع الحساب وضبط كلمة مرور جديدة.') }}
                </p>

            </div>

            <!-- Footer Badge -->
            <div class="pt-6 relative z-10 border-t border-white/15 mt-8 flex items-center justify-between">
                <span class="text-[11px] font-bold text-blue-100/90 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#35A536] animate-ping"></span>
                    <span>{{ app()->getLocale() === 'fr' ? 'Portail d\'Authentification' : (app()->getLocale() === 'en' ? 'Authentication Portal' : 'بوابة التحقق من الهوية والأمان') }}</span>
                </span>
            </div>
        </div>

        <!-- Right Column: Reset Form Interface -->
        <div class="lg:col-span-7 p-8 sm:p-12 flex flex-col justify-center space-y-6 bg-white">
            
            <!-- Step Indicators -->
            <div class="flex items-center gap-2 mb-2">
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-black {{ $step === 1 ? 'bg-[#0B2A6F] text-white shadow-md' : 'bg-emerald-600 text-white' }}">
                        @if($step > 1)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        @else
                            1
                        @endif
                    </span>
                    <span class="text-xs font-bold {{ $step === 1 ? 'text-[#0B2A6F]' : 'text-slate-500' }}">
                        {{ app()->getLocale() === 'fr' ? 'Vérification' : (app()->getLocale() === 'en' ? 'Verification' : 'التحقق') }}
                    </span>
                </div>
                <div class="flex-1 h-0.5 {{ $step >= 2 ? 'bg-emerald-500' : 'bg-slate-200' }}"></div>
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-black {{ $step === 2 ? 'bg-[#0B2A6F] text-white shadow-md' : ($step === 3 ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-400') }}">
                        @if($step > 2)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        @else
                            2
                        @endif
                    </span>
                    <span class="text-xs font-bold {{ $step === 2 ? 'text-[#0B2A6F]' : 'text-slate-500' }}">
                        {{ app()->getLocale() === 'fr' ? 'Nouveau Mot de Passe' : (app()->getLocale() === 'en' ? 'New Password' : 'كلمة المرور') }}
                    </span>
                </div>
                <div class="flex-1 h-0.5 {{ $step === 3 ? 'bg-emerald-500' : 'bg-slate-200' }}"></div>
                <div class="flex items-center gap-2">
                    <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-black {{ $step === 3 ? 'bg-emerald-600 text-white shadow-md' : 'bg-slate-100 text-slate-400' }}">
                        3
                    </span>
                    <span class="text-xs font-bold {{ $step === 3 ? 'text-emerald-700' : 'text-slate-500' }}">
                        {{ app()->getLocale() === 'fr' ? 'Confirmation' : (app()->getLocale() === 'en' ? 'Done' : 'الإنهاء') }}
                    </span>
                </div>
            </div>

            <!-- STEP 1: IDENTITY VERIFICATION -->
            @if($step === 1)
                <div class="space-y-2">
                    <h2 class="text-2xl font-black text-[#0B2A6F]">
                        {{ app()->getLocale() === 'fr' ? 'Récupération du compte' : (app()->getLocale() === 'en' ? 'Account Password Reset' : 'استرجاع حساب الحساب / كلمة المرور') }}
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ app()->getLocale() === 'fr' 
                            ? 'Veuillez saisir votre numéro NIN (18 chiffres) ou numéro de passeport pour identifier votre compte.' 
                            : (app()->getLocale() === 'en' 
                                ? 'Enter your National Identification Number (NIN) or Passport Number to locate your account.' 
                                : 'أدخل رقم التعريف الوطني (NIN 18 رقماً) أو رقم جواز السفر الخاص بك والمطابق في قاعدة البيانات.') }}
                    </p>
                </div>

                <form wire:submit.prevent="verifyIdentity" class="space-y-5 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            {{ app()->getLocale() === 'fr' ? 'Numéro NIN (18 chiffres) ou N° Passeport *' : (app()->getLocale() === 'en' ? 'NIN Number (18 digits) or Passport No. *' : 'رقم التعريف الوطني (NIN) أو رقم جواز السفر *') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 pointer-events-none flex items-center ps-3.5 text-slate-400">
                                <svg class="w-4 h-4 text-[#0B2A6F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3 3 0 00-3 3h6a3 3 0 00-3-3z"/></svg>
                            </div>
                            <input type="text" wire:model.defer="identifier" required placeholder="{{ app()->getLocale() === 'fr' ? 'Ex: 109820000000000000 ou 123456789' : (app()->getLocale() === 'en' ? 'e.g. 109820000000000000 or 123456789' : 'مثال: 109820000000000000 أو رقم جواز السفر') }}" class="w-full ps-10 pe-4 py-3.5 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#0B2A6F] focus:outline-none focus:ring-2 focus:ring-[#0B2A6F] focus:bg-white transition shadow-xs">
                        </div>
                        @error('identifier') <span class="text-[11px] text-rose-600 font-bold mt-1.5 block bg-rose-50 p-2 rounded-xl border border-rose-100">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-[#0B2A6F] to-[#35A536] hover:from-[#35A536] hover:to-[#0B2A6F] text-white font-black text-xs shadow-xl shadow-emerald-900/20 transition-all duration-300 flex items-center justify-center gap-2 transform hover:scale-[1.01] border border-white/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Vérifier l\'identité' : (app()->getLocale() === 'en' ? 'Verify Identity' : 'التحقق من الهوية والمتابعة') }}</span>
                    </button>
                </form>
            @endif

            <!-- STEP 2: SET NEW PASSWORD -->
            @if($step === 2)
                <div class="space-y-2">
                    <h2 class="text-2xl font-black text-[#0B2A6F]">
                        {{ app()->getLocale() === 'fr' ? 'Définir un nouveau mot de passe' : (app()->getLocale() === 'en' ? 'Set New Password' : 'إدخال كلمة السر الجديدة') }}
                    </h2>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ app()->getLocale() === 'fr' ? 'Veuillez saisir votre nouveau mot de passe sécurisé.' : (app()->getLocale() === 'en' ? 'Please choose a new password for your account.' : 'قم بإدخال كلمة المرور الجديدة وتأكيدها لحماية حسابك.') }}
                    </p>
                </div>

                <!-- Verified User Banner -->
                <div class="bg-emerald-50 border border-emerald-200 rounded-2xl p-4 flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 text-white flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-xs font-black text-emerald-950">{{ $userName }}</p>
                        <p class="text-[11px] font-mono text-emerald-700 dir-ltr text-start">{{ $userMaskedEmail }}</p>
                    </div>
                </div>

                <form wire:submit.prevent="resetPassword" class="space-y-4 pt-1">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            {{ app()->getLocale() === 'fr' ? 'Nouveau mot de passe *' : (app()->getLocale() === 'en' ? 'New Password *' : 'كلمة المرور الجديدة *') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 pointer-events-none flex items-center ps-3.5 text-slate-400">
                                <svg class="w-4 h-4 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </div>
                            <input type="password" wire:model.defer="password" required placeholder="••••••••" class="w-full ps-10 pe-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#0B2A6F] focus:outline-none focus:ring-2 focus:ring-[#0B2A6F] focus:bg-white transition shadow-xs">
                        </div>
                        @error('password') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1.5">
                            {{ app()->getLocale() === 'fr' ? 'Confirmer le nouveau mot de passe *' : (app()->getLocale() === 'en' ? 'Confirm New Password *' : 'تأكيد كلمة المرور الجديدة *') }}
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 start-0 pointer-events-none flex items-center ps-3.5 text-slate-400">
                                <svg class="w-4 h-4 text-[#0B2A6F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                            </div>
                            <input type="password" wire:model.defer="password_confirmation" required placeholder="••••••••" class="w-full ps-10 pe-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#0B2A6F] focus:outline-none focus:ring-2 focus:ring-[#0B2A6F] focus:bg-white transition shadow-xs">
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-[#0B2A6F] to-[#35A536] hover:from-[#35A536] hover:to-[#0B2A6F] text-white font-black text-xs shadow-xl shadow-emerald-900/20 transition-all duration-300 flex items-center justify-center gap-2 transform hover:scale-[1.01] border border-white/20">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        <span>{{ app()->getLocale() === 'fr' ? 'Enregistrer le mot de passe' : (app()->getLocale() === 'en' ? 'Save New Password' : 'حفظ كلمة المرور الجديدة') }}</span>
                    </button>
                </form>
            @endif

            <!-- STEP 3: SUCCESS CONFIRMATION -->
            @if($step === 3)
                <div class="text-center py-6 space-y-4">
                    <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-600 mx-auto flex items-center justify-center shadow-inner">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>

                    <div class="space-y-1">
                        <h2 class="text-2xl font-black text-[#0B2A6F]">
                            {{ app()->getLocale() === 'fr' ? 'Mot de passe modifié avec succès !' : (app()->getLocale() === 'en' ? 'Password Changed Successfully!' : 'تم تغيير كلمة المرور بنجاح!') }}
                        </h2>
                        <p class="text-xs text-slate-600 font-medium max-w-md mx-auto">
                            {{ app()->getLocale() === 'fr' 
                                ? 'Votre mot de passe a été mis à jour. Vous pouvez maintenant vous connecter à votre compte.' 
                                : (app()->getLocale() === 'en' 
                                    ? 'Your account password has been updated. You can now log in.' 
                                    : 'تم تحديث كلمة المرور الخاصة بحسابك بنجاح. يمكنك الآن الدخول باستخدام كلمة المرور الجديدة.') }}
                        </p>
                    </div>

                    <div class="pt-4">
                        <a href="{{ route('login') }}" class="w-full py-3.5 px-6 rounded-2xl bg-gradient-to-r from-[#0B2A6F] to-[#35A536] hover:from-[#35A536] hover:to-[#0B2A6F] text-white font-black text-xs shadow-xl shadow-emerald-900/20 transition-all duration-300 inline-flex items-center justify-center gap-2 transform hover:scale-[1.01] border border-white/20">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                            <span>{{ app()->getLocale() === 'fr' ? 'Se connecter maintenant' : (app()->getLocale() === 'en' ? 'Log In Now' : 'تسجيل الدخول الآن') }}</span>
                        </a>
                    </div>
                </div>
            @endif

            <div class="pt-4 border-t border-slate-100 text-center">
                <a href="{{ route('login') }}" class="text-xs font-bold text-[#0B2A6F] hover:text-[#35A536] inline-flex items-center gap-1.5 transition">
                    <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Retour à la connexion' : (app()->getLocale() === 'en' ? 'Back to login' : 'العودة إلى صفحة تسجيل الدخول') }}</span>
                </a>
            </div>

        </div>

    </div>
</div>
