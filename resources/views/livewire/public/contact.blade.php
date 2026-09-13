<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <h1 class="text-3xl sm:text-4xl font-black text-[#06205C]">
                {{ polyTrans('الاتصال باللجنة التنفيذية لمنتدى السياسات الأفريقية للمهارات', 'Contactez le Comité d\'Organisation — Forum des Politiques Africaines des Compétences', 'Contact African Skills Policy Forum Executive Committee') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed">
                {{ app()->getLocale() === 'pt' ? (__('يسعدنا استقبال استفسارات المتربصين والوفود المشاركة والشركاء.') !== 'يسعدنا استقبال استفسارات المتربصين والوفود المشاركة والشركاء.' ? __('يسعدنا استقبال استفسارات المتربصين والوفود المشاركة والشركاء.') : 'We are at your disposal for any inquiries regarding the competition and delegations.') : (polyTrans('يسعدنا استقبال استفسارات المتربصين والوفود المشاركة والشركاء.', 'Nous sommes à votre disposition pour toute question concernant la compétition et les délégations.', 'We are at your disposal for any inquiries regarding the competition and delegations.')) }}
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 max-w-5xl mx-auto">
            <!-- Left Info Card -->
            <div class="lg:col-span-5 space-y-6">
                <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-lg space-y-6">
                    <h3 class="text-lg font-black text-[#06205C]">
                        {{ app()->getLocale() === 'pt' ? (__('العنوان والمقر الرسمي') !== 'العنوان والمقر الرسمي' ? __('العنوان والمقر الرسمي') : 'Official Headquarters') : (polyTrans('العنوان والمقر الرسمي', 'Siège Officiel & Coordonnées', 'Official Headquarters')) }}
                    </h3>
                    <div class="space-y-4 text-xs text-slate-600 font-medium">
                        <div class="flex items-start gap-3">
                            <svg class="w-5 h-5 text-brand-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Rue des Frères Aissou, Ben Aknoun, Alger, Algérie</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span class="font-mono">skillsolympics@mfep.gov.dz</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span class="font-mono" dir="ltr">+213 23 25 52 66</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Form Card -->
            <div class="lg:col-span-7">
                <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-lg">
                    @if (session()->has('message'))
                        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            {{ session('message') }}
                        </div>
                    @endif

                    <form wire:submit.prevent="submit" class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-[#06205C] mb-1">
                                {{ app()->getLocale() === 'pt' ? (__('الاسم الكامل *') !== 'الاسم الكامل *' ? __('الاسم الكامل *') : 'Full Name') : (polyTrans('الاسم الكامل *', 'Nom Complet', 'Full Name')) }}
                            </label>
                            <input type="text" wire:model="name" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                            @error('name') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#06205C] mb-1">
                                {{ app()->getLocale() === 'pt' ? (__('البريد الإلكتروني الرسمي *') !== 'البريد الإلكتروني الرسمي *' ? __('البريد الإلكتروني الرسمي *') : 'Email Address') : (polyTrans('البريد الإلكتروني الرسمي *', 'Adresse Email', 'Email Address')) }}
                            </label>
                            <input type="email" wire:model="email" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                            @error('email') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#06205C] mb-1">
                                {{ app()->getLocale() === 'pt' ? (__('موضوع الرسالة *') !== 'موضوع الرسالة *' ? __('موضوع الرسالة *') : 'Subject') : (polyTrans('موضوع الرسالة *', 'Sujet', 'Subject')) }}
                            </label>
                            <input type="text" wire:model="subject" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition">
                            @error('subject') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-[#06205C] mb-1">
                                {{ app()->getLocale() === 'pt' ? (__('محتوى الرسالة *') !== 'محتوى الرسالة *' ? __('محتوى الرسالة *') : 'Message Content') : (polyTrans('محتوى الرسالة *', 'Message', 'Message Content')) }}
                            </label>
                            <textarea wire:model="message" rows="4" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 border border-slate-200 text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-brand-500 focus:bg-white transition"></textarea>
                            @error('message') <span class="text-[10px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="w-full py-3.5 rounded-xl bg-brand-500 hover:bg-brand-600 text-white font-bold text-xs shadow-lg transition">
                            {{ app()->getLocale() === 'pt' ? (__('إرسال الرسالة') !== 'إرسال الرسالة' ? __('إرسال الرسالة') : 'Send Message') : (polyTrans('إرسال الرسالة', 'Envoyer le Message', 'Send Message')) }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
