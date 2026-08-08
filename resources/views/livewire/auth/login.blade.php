<div class="min-h-screen bg-[#F4F7FC] flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden">
    
    <div class="absolute top-6 right-6 z-50">
        <x-language-switcher />
    </div>

    <!-- Soft Background Accents -->
    <div class="absolute top-0 right-1/4 w-96 h-96 bg-brand-200/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-1/4 w-96 h-96 bg-sky-200/40 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-4xl w-full mx-auto bg-white rounded-3xl shadow-2xl border border-slate-200 overflow-hidden grid grid-cols-1 lg:grid-cols-12">
        
        <!-- Left Column: Official WorldSkills Algeria Branding -->
        <div class="lg:col-span-5 bg-gradient-to-br from-[#0052CC] via-[#0066FF] to-[#00A3FF] p-8 sm:p-10 text-white flex flex-col justify-between relative overflow-hidden">
            <div class="space-y-8 relative z-10">
                <div class="flex items-center gap-3">
                    <img src="/logo.svg" alt="WorldSkills Algeria" class="h-12 w-auto filter drop-shadow-md">
                    <div>
                        <span class="font-black text-xl text-white leading-none block">WorldSkills Algeria</span>
                        <span class="text-[9px] font-bold text-blue-100 uppercase tracking-wider block mt-1">الجمهورية الجزائرية الديمقراطية الشعبية</span>
                    </div>
                </div>

                <div class="space-y-3 pt-4">
                    <span class="text-xs font-bold text-blue-200 bg-white/10 px-3 py-1 rounded-full border border-white/20 inline-block">
                        المنصة الوطنية الموحدة 2026 / 2027
                    </span>
                    <h2 class="text-2xl font-black leading-tight text-white">
                        أولمبياد المهن والتنافسية الوطنية والإفريقية
                    </h2>
                    <p class="text-xs text-blue-100 leading-relaxed font-medium">
                        بوابة الوصول الآمن لمركز القيادة المخصص لمدراء النظام، الوفود الوطنية والدولية، المحكّمين، والمركز الإعلامي لـ WorldSkills Algeria.
                    </p>
                </div>
            </div>

            <div class="pt-6 relative z-10 border-t border-white/20 mt-8">
                <span class="text-[11px] font-bold text-blue-100 flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>النظام المعياري الموحد — الإصدار WSAP V8.2</span>
                </span>
            </div>
        </div>

        <!-- Right Column: Clean Login Form (Email / Username + Password) -->
        <div class="lg:col-span-7 p-8 sm:p-12 flex flex-col justify-center space-y-8 bg-white">
            <div class="space-y-2">
                <h3 class="text-2xl font-black text-[#06205C]">
                    {{ app()->getLocale() === 'fr' ? 'Connexion à la Plateforme' : (app()->getLocale() === 'en' ? 'Sign In to WSAP' : 'تسجيل الدخول إلى المنصة الوطنية') }}
                </h3>
                <p class="text-xs text-slate-500 font-medium">أدخل البريد الإلكتروني أو اسم المستخدم وكلمة المرور للوصول لحسابك.</p>
            </div>

            <form wire:submit.prevent="login" class="space-y-5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        {{ app()->getLocale() === 'fr' ? 'Email ou Nom d\'utilisateur' : (app()->getLocale() === 'en' ? 'Email Address or Username' : 'البريد الإلكتروني أو اسم المستخدم *') }}
                    </label>
                    <input type="text" wire:model="loginInput" required placeholder="admin@worldskills.dz أو admin" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#06205C] focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition shadow-sm">
                    @error('loginInput') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1.5">
                        {{ app()->getLocale() === 'fr' ? 'Mot de passe' : (app()->getLocale() === 'en' ? 'Password' : 'كلمة المرور *') }}
                    </label>
                    <input type="password" wire:model="password" required placeholder="••••••••" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-200 text-xs font-mono font-bold text-[#06205C] focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition shadow-sm">
                    @error('password') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" wire:model="remember" class="rounded border-slate-300 text-brand-500 focus:ring-brand-500">
                        <span class="text-xs font-bold text-slate-500">
                            {{ app()->getLocale() === 'fr' ? 'Se souvenir de moi' : (app()->getLocale() === 'en' ? 'Remember Me' : 'تذكرني على هذا الجهاز') }}
                        </span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3.5 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-xl shadow-brand-500/20 transition flex items-center justify-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/></svg>
                    <span>{{ app()->getLocale() === 'fr' ? 'Se Connecter' : (app()->getLocale() === 'en' ? 'Sign In' : 'تسجيل الدخول إلى المنصة') }}</span>
                </button>
            </form>

            <div class="pt-4 border-t border-slate-100 text-center">
                <a href="{{ route('home') }}" class="text-xs font-bold text-brand-500 hover:text-brand-600 inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    <span>العودة للبوابة الرئيسية</span>
                </a>
            </div>
        </div>

    </div>
</div>
