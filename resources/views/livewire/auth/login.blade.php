<div class="min-h-screen bg-[#F4F7FC] flex flex-col justify-center py-10 px-4 sm:px-6 lg:px-8 relative overflow-hidden" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <!-- Elegant Light Ambient Backdrop Glows -->
    <div class="absolute -top-32 -end-32 w-96 h-96 bg-[#35A536]/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -start-32 w-96 h-96 bg-[#F5A800]/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl w-full mx-auto bg-white rounded-3xl shadow-2xl border border-slate-200/90 overflow-hidden grid grid-cols-1 lg:grid-cols-12 relative z-10">
        
        <!-- Left Column: Official Pan-African Leadership Header Card -->
        <div class="lg:col-span-5 bg-gradient-to-br from-[#0B2A6F] via-[#081F54] to-[#040E26] p-8 sm:p-10 text-white flex flex-col justify-between relative overflow-hidden">
            
            <!-- Subtle Radial Light Accent -->
            <div class="absolute top-0 end-0 w-64 h-64 bg-[#35A536]/20 rounded-full blur-3xl pointer-events-none"></div>

            <div class="space-y-6 relative z-10">
                
                <!-- 1. Republic Official Name (FIRST at the VERY TOP above everything else) -->
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
                            {{ app()->getLocale() === 'fr' ? 'Oran, Algérie — CCO' : (app()->getLocale() === 'en' ? 'Oran, Algeria — CCO' : 'وهران، الجزائر — مركز المؤتمرات CCO') }}
                        </span>
                    </div>
                </div>

                <!-- 3. Brief Portal Description -->
                <p class="text-xs text-blue-100/80 leading-relaxed font-medium pt-2">
                    {{ app()->getLocale() === 'fr' ? 'Portail sécurisé pour le Centre de Commandement, la Présidence du Forum, les Délégations et le Centre des Médias.' : (app()->getLocale() === 'en' ? 'Secure portal access for Command Center, Forum Directorate, Official Delegations, and Media Center.' : 'بوابة الوصول الآمن لمركز القيادة المخصص لمدراء النظام، الوفود الوطنية والدولية، والمركز الإعلامي.') }}
                </p>

            </div>

            <!-- Footer Badge -->
            <div class="pt-6 relative z-10 border-t border-white/15 mt-8 flex items-center justify-between">
                <span class="text-[11px] font-bold text-blue-100/90 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#35A536] animate-ping"></span>
                    <span>{{ app()->getLocale() === 'fr' ? 'Portail Officiel d\'Accréditation' : (app()->getLocale() === 'en' ? 'Official Accreditation Portal' : 'البوابة الرسمية للاعتماد والدخول') }}</span>
                </span>
            </div>
        </div>

        <!-- Right Column: Luxury Executive Login Form -->
        <div class="lg:col-span-7 p-8 sm:p-12 flex flex-col justify-center space-y-8 bg-white">
            
            <div class="space-y-2">
                <h2 class="text-2xl font-black text-[#0B2A6F]">
                    {{ app()->getLocale() === 'fr' ? 'Connexion au Portail Officiel' : (app()->getLocale() === 'en' ? 'Official Portal Login' : 'تسجيل الدخول إلى المنصة الرسمية') }}
                </h2>
                <p class="text-xs text-slate-500 font-medium">
                    {{ app()->getLocale() === 'fr' ? 'Veuillez saisir votre identifiant et votre mot de passe.' : (app()->getLocale() === 'en' ? 'Please enter your username/email and password to continue.' : 'يرجى إدخال اسم المستخدم أو البريد الإلكتروني وكلمة المرور للدخول.') }}
                </p>
            </div>

            <form wire:submit.prevent="login" class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        {{ __('messages.email_or_username') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 pointer-events-none flex items-center ps-3.5 text-slate-400">
                            <svg class="w-4 h-4 text-[#0B2A6F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <input type="text" wire:model="loginInput" required placeholder="{{ __('messages.email_or_username_placeholder') }}" class="w-full ps-10 pe-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#0B2A6F] focus:outline-none focus:ring-2 focus:ring-[#0B2A6F] focus:bg-white transition shadow-xs">
                    </div>
                    @error('loginInput') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        {{ __('messages.password_label') }}
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 pointer-events-none flex items-center ps-3.5 text-slate-400">
                            <svg class="w-4 h-4 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <input type="password" wire:model="password" required placeholder="••••••••" class="w-full ps-10 pe-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#0B2A6F] focus:outline-none focus:ring-2 focus:ring-[#0B2A6F] focus:bg-white transition shadow-xs">
                    </div>
                    @error('password') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="remember" class="rounded border-slate-300 text-[#0B2A6F] focus:ring-[#0B2A6F]">
                        <span class="text-xs font-bold text-slate-600">
                            {{ __('messages.remember_me') }}
                        </span>
                    </label>

                    <a href="{{ route('password.request') }}" class="text-xs font-bold text-[#0B2A6F] hover:text-[#35A536] transition">
                        {{ app()->getLocale() === 'fr' ? 'Mot de passe oublié ?' : (app()->getLocale() === 'en' ? 'Forgot password?' : 'نسيت كلمة المرور / الحساب؟') }}
                    </a>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-2xl bg-gradient-to-r from-[#0B2A6F] to-[#35A536] hover:from-[#35A536] hover:to-[#0B2A6F] text-white font-black text-xs shadow-xl shadow-emerald-900/20 transition-all duration-300 flex items-center justify-center gap-2 transform hover:scale-[1.01] border border-white/20">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    <span>{{ __('messages.login_button') }}</span>
                </button>
            </form>

            <div class="pt-4 border-t border-slate-100 text-center">
                <a href="{{ route('home') }}" class="text-xs font-bold text-[#0B2A6F] hover:text-[#35A536] inline-flex items-center gap-1.5 transition">
                    <svg class="w-4 h-4 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>{{ __('messages.back_to_main_portal') }}</span>
                </a>
            </div>
        </div>

    </div>
</div>
