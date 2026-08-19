<div class="space-y-8">
    <!-- Studio Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200">
        <div>
            <div class="flex items-center gap-3">
                <div class="p-2.5 rounded-2xl bg-brand-50 text-brand-600 border border-brand-200">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-23" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                        {{ app()->getLocale() === 'fr' ? 'Studio d\'Apparence & Design Tokens' : (app()->getLocale() === 'en' ? 'Platform Appearance & Design Tokens Studio' : 'استوديو مظهر المنصة والهوية البصرية') }}
                    </h1>
                    <p class="text-xs font-bold text-slate-500 mt-0.5">
                        {{ app()->getLocale() === 'fr' ? 'Personnalisez dynamiquement la charte graphique et les éléments visuels de la plateforme sans modifier le code source.' : (app()->getLocale() === 'en' ? 'Dynamically control design tokens, colors, branding, and assets across all portals without touching code.' : 'إدارة رموز التصميم، ألوان الهوية الوطنية، ومرفقات المنصة ديناميكياً بدون لمس الكود.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button wire:click="resetDefaults" wire:confirm="{{ __('هل أنت أصلًا متأكد من إعادة ضبط رموز المظهر إلى الافتراضيات؟') }}" class="px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold text-xs transition touch-target">
                {{ app()->getLocale() === 'fr' ? 'Réinitialiser' : (app()->getLocale() === 'en' ? 'Reset Defaults' : 'إعادة ضبط الافتراضيات') }}
            </button>
            <button wire:click="saveAppearance" class="px-5 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-black text-xs shadow-md transition touch-target flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ app()->getLocale() === 'fr' ? 'Enregistrer les Changements' : (app()->getLocale() === 'en' ? 'Save Appearance Tokens' : 'حفظ رموز المظهر') }}</span>
            </button>
        </div>
    </div>

    <!-- Alert Feedback -->
    @if ($savedMessage)
        <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-3">
            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
            <span>{{ $savedMessage }}</span>
        </div>
    @endif

    <!-- ════ MAINTENANCE / COMING SOON MODE CONTROL SECTION ════ -->
    <div class="p-6 rounded-3xl bg-gradient-to-br from-amber-500/10 via-amber-500/5 to-transparent border-2 border-amber-400/40 shadow-xl space-y-5">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-amber-500 text-white flex items-center justify-center font-black shadow-lg shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h2 class="text-lg font-black text-slate-900 dark:text-slate-100 flex items-center gap-2">
                        <span>وضع "انتظرونا قريباً / Coming Soon" للواجهة العامة</span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-mono font-bold {{ $maintenance_mode ? 'bg-amber-500 text-slate-950' : 'bg-slate-200 text-slate-600' }}">
                            {{ $maintenance_mode ? 'مفعّل حالياً (الواجهة مخفية للزوار)' : 'معطّل (الواجهة تعمل طبيعياً)' }}
                        </span>
                    </h2>
                    <p class="text-xs text-slate-600 dark:text-slate-400 font-medium">
                        عند تفعيل هذا الخيار، سيتم حجب كامل محتوى الواجهة العامة وإظهار صفحة "انتظرونا قريباً" المستقلة للزوار فقط، بينما يمكنك كأدمن الاستمرار في تصفح وضبط المنصة بحرية.
                    </p>
                </div>
            </div>

            <!-- Toggle Switch -->
            <label class="relative inline-flex items-center cursor-pointer shrink-0">
                <input type="checkbox" wire:model.live="maintenance_mode" class="sr-only peer">
                <div class="w-14 h-7 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-slate-600 peer-checked:bg-amber-500"></div>
                <span class="ms-3 text-xs font-black text-slate-800 dark:text-slate-200">{{ $maintenance_mode ? 'مفعّل' : 'معطّل' }}</span>
            </label>
        </div>

        @if($maintenance_mode)
            <div class="pt-4 border-t border-amber-200/60 dark:border-slate-700 grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">عنوان انتظرونا قريباً (بالعربية)</label>
                    <input type="text" wire:model="coming_soon_title_ar" class="w-full px-3.5 py-2 text-xs font-bold rounded-xl border border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">عنوان (بالفرنسية)</label>
                    <input type="text" wire:model="coming_soon_title_fr" class="w-full px-3.5 py-2 text-xs font-bold rounded-xl border border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">عنوان (بالإنجليزية)</label>
                    <input type="text" wire:model="coming_soon_title_en" class="w-full px-3.5 py-2 text-xs font-bold rounded-xl border border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Form Controls -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Branding Section -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-6">
                <h2 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>🏛️</span>
                    <span>{{ app()->getLocale() === 'fr' ? 'Charte & Identité Visuelle' : (app()->getLocale() === 'en' ? 'Branding & Assets' : 'الهوية البصرية والرموز الرسمية') }}</span>
                </h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 mb-1.5">{{ __('اسم المنصة الرسمي') }}</label>
                        <input type="text" wire:model="site_name" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-bold text-slate-900 focus:ring-2 focus:ring-brand-500">
                        @error('site_name') <span class="text-[11px] text-rose-600 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-extrabold text-slate-700 mb-1.5">{{ __('شعار المنصة (Logo)') }}</label>
                        <input type="file" wire:model="site_logo_file" class="w-full text-xs font-semibold text-slate-600">
                        @error('site_logo_file') <span class="text-[11px] text-rose-600 font-semibold">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <!-- ═══ Registration Page Banner Section ═══ -->
            <div class="glass-card rounded-2xl p-6 border border-amber-200/80 shadow-xs space-y-5 bg-amber-50/30">
                <h2 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>🖼️</span>
                    <span>{{ app()->getLocale() === 'fr' ? 'Bannière Page d\'Inscription' : (app()->getLocale() === 'en' ? 'Registration Page Banner' : 'صورة بانر صفحة التسجيل الرسمي') }}</span>
                </h2>

                <p class="text-[11px] text-slate-500 font-semibold">
                    {{ app()->getLocale() === 'en' ? 'This image appears as the hero banner on the Official Registration page (/registration). Recommended: 1920×500px, JPG/PNG/WEBP.' : 'هذه الصورة تظهر كخلفية في هيدر صفحة التسجيل الرسمي (/registration). المقترح: 1920×500 بكسل، JPG/PNG/WEBP.' }}
                </p>

                <!-- Live Preview -->
                @if($accreditation_banner_url)
                <div class="relative rounded-2xl overflow-hidden h-40 border border-slate-200 shadow-inner bg-slate-900">
                    <img src="{{ asset($accreditation_banner_url) }}" alt="Registration Banner Preview"
                         class="w-full h-full object-cover object-center opacity-70">
                    <div class="absolute inset-0 bg-gradient-to-r from-[#0B2A6F]/80 to-transparent flex items-center px-6">
                        <div class="space-y-1">
                            <div class="text-white text-xs font-black opacity-90">{{ __('معاينة بانر التسجيل') }}</div>
                            <div class="text-[#4ADE80] text-[10px] font-bold">{{ $accreditation_banner_url }}</div>
                        </div>
                    </div>
                    <div class="absolute top-2 right-2 px-2 py-1 bg-emerald-500 text-white text-[9px] font-black rounded-lg shadow">LIVE</div>
                </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Upload File -->
                    <div class="space-y-2">
                        <label class="block text-xs font-extrabold text-slate-700">{{ __('رفع صورة جديدة (JPG/PNG/WEBP)') }}</label>
                        <input type="file" wire:model="accreditation_banner_file" accept="image/*"
                               class="w-full text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-[#0B2A6F]/10 file:text-[#0B2A6F] hover:file:bg-[#0B2A6F]/20 transition">
                        <div wire:loading wire:target="accreditation_banner_file" class="text-xs text-amber-600 font-bold flex items-center gap-1.5">
                            <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            {{ __('جاري رفع الصورة...') }}
                        </div>
                        @error('accreditation_banner_file') <span class="text-[11px] text-rose-600 font-semibold">{{ $message }}</span> @enderror
                    </div>

                    <!-- Or URL -->
                    <div class="space-y-2">
                        <label class="block text-xs font-extrabold text-slate-700">{{ __('أو أدخل رابط URL للصورة') }}</label>
                        <input type="text" wire:model="accreditation_banner_url"
                               placeholder="/images/channels4_banner.jpg"
                               class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-xs font-mono text-slate-700 focus:ring-2 focus:ring-[#0B2A6F] bg-white">
                        <p class="text-[10px] text-slate-400 font-semibold">{{ __('مسار نسبي من public/ أو رابط خارجي') }}</p>
                    </div>
                </div>

                <!-- Quick select from existing images -->
                <div class="space-y-2">
                    <label class="block text-xs font-extrabold text-slate-600">{{ __('اختيار سريع من الصور المتوفرة') }}</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['/images/channels4_banner.jpg', '/images/hero_slide_1.png', '/images/hero_slide_2.png', '/images/hero_slide_3.png', '/images/gallery_header_bg.png', '/images/news_header_bg.png'] as $img)
                        <button type="button" wire:click="$set('accreditation_banner_url', '{{ $img }}')"
                                class="px-3 py-1.5 rounded-xl text-[10px] font-black border transition {{ $accreditation_banner_url === $img ? 'bg-[#0B2A6F] text-white border-[#0B2A6F]' : 'bg-white text-slate-600 border-slate-200 hover:border-[#0B2A6F] hover:text-[#0B2A6F]' }}">
                            {{ basename($img) }}
                        </button>
                        @endforeach
                    </div>
                </div>
            </div>


            <!-- Color Tokens Studio -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-6">
                <h2 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>🌈</span>
                    <span>{{ app()->getLocale() === 'fr' ? 'Palette de Couleurs (Design Tokens)' : (app()->getLocale() === 'en' ? 'Color Tokens Palette' : 'لوحة الألوان ورموز الهوية') }}</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <!-- Brand Colors -->
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                        <label class="block text-xs font-extrabold text-slate-800">{{ __('اللون الرئيسي (Primary)') }}</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model.live="primary_color" class="w-10 h-10 rounded-lg border-0 cursor-pointer">
                            <input type="text" wire:model.live="primary_color" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-mono font-bold uppercase">
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                        <label class="block text-xs font-extrabold text-slate-800">{{ __('الرئيسي الداكن (Primary Dark)') }}</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model.live="primary_dark" class="w-10 h-10 rounded-lg border-0 cursor-pointer">
                            <input type="text" wire:model.live="primary_dark" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-mono font-bold uppercase">
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                        <label class="block text-xs font-extrabold text-slate-800">{{ __('اللون الثانوي (Accent)') }}</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model.live="accent_color" class="w-10 h-10 rounded-lg border-0 cursor-pointer">
                            <input type="text" wire:model.live="accent_color" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-mono font-bold uppercase">
                        </div>
                    </div>

                    <!-- Status Colors -->
                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                        <label class="block text-xs font-extrabold text-emerald-800">{{ __('لون النجاح (Success)') }}</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model.live="success_color" class="w-10 h-10 rounded-lg border-0 cursor-pointer">
                            <input type="text" wire:model.live="success_color" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-mono font-bold uppercase">
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                        <label class="block text-xs font-extrabold text-amber-800">{{ __('لون التنبيه (Warning)') }}</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model.live="warning_color" class="w-10 h-10 rounded-lg border-0 cursor-pointer">
                            <input type="text" wire:model.live="warning_color" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-mono font-bold uppercase">
                        </div>
                    </div>

                    <div class="p-3.5 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                        <label class="block text-xs font-extrabold text-rose-800">{{ __('لون الخطر (Danger)') }}</label>
                        <div class="flex items-center gap-3">
                            <input type="color" wire:model.live="danger_color" class="w-10 h-10 rounded-lg border-0 cursor-pointer">
                            <input type="text" wire:model.live="danger_color" class="w-full px-3 py-1.5 rounded-lg border border-slate-300 text-xs font-mono font-bold uppercase">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Shape & Border Radius Tokens -->
            <div class="glass-card rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-6">
                <h2 class="text-base font-black text-slate-900 flex items-center gap-2">
                    <span>⭕</span>
                    <span>{{ app()->getLocale() === 'fr' ? 'Rayon de Bordure (Border Radii)' : (app()->getLocale() === 'en' ? 'Border Radius Tokens' : 'درجة انحناء الحواف والأشكال') }}</span>
                </h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Small Radius</label>
                        <select wire:model="radius_sm" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                            <option value="0">0 (Flat)</option>
                            <option value="0.25rem">0.25rem (4px)</option>
                            <option value="0.375rem">0.375rem (6px)</option>
                            <option value="0.5rem">0.5rem (8px)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Medium Radius</label>
                        <select wire:model="radius_md" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                            <option value="0.5rem">0.5rem (8px)</option>
                            <option value="0.75rem">0.75rem (12px)</option>
                            <option value="1rem">1rem (16px)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Large Radius</label>
                        <select wire:model="radius_lg" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                            <option value="0.75rem">0.75rem (12px)</option>
                            <option value="1rem">1rem (16px)</option>
                            <option value="1.5rem">1.5rem (24px)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 mb-1">Extra Large</label>
                        <select wire:model="radius_xl" class="w-full px-3 py-2 rounded-xl border border-slate-300 text-xs font-bold">
                            <option value="1rem">1rem (16px)</option>
                            <option value="1.5rem">1.5rem (24px)</option>
                            <option value="2rem">2rem (32px)</option>
                            <option value="9999px">Pill (Full Round)</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Live Preview Sidebar Pane -->
        <div class="lg:col-span-4 space-y-6">
            <div class="glass-card rounded-2xl p-6 border border-slate-200/80 shadow-xs space-y-4 sticky top-6"
                style="--preview-surface: {{ $surface_color }}; --preview-text: {{ $text_color }}; --preview-muted: {{ $muted_text_color }}; --preview-primary: {{ $primary_color }}; --preview-dark: {{ $primary_dark }}; --preview-success: {{ $success_color }}; --preview-warning: {{ $warning_color }}; --preview-danger: {{ $danger_color }}; --preview-radius-md: {{ $radius_md }}; --preview-radius-lg: {{ $radius_lg }}; --preview-radius-xl: {{ $radius_xl }};">
                
                <div class="flex items-center justify-between gap-2">
                    <h3 class="text-xs font-black text-slate-500 uppercase tracking-wider flex items-center gap-2">
                        <span>👁️</span>
                        <span>{{ app()->getLocale() === 'fr' ? 'Aperçu en Direct' : (app()->getLocale() === 'en' ? 'Live Preview' : 'المعاينة الحية') }}</span>
                    </h3>
                    <div class="flex items-center gap-1 bg-slate-100 p-1 rounded-xl text-[10px] font-black">
                        <button wire:click="setPreviewDevice('desktop')" class="px-2 py-0.5 rounded-lg transition {{ $previewDevice === 'desktop' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">🖥️ Desktop</button>
                        <button wire:click="setPreviewDevice('tablet')" class="px-2 py-0.5 rounded-lg transition {{ $previewDevice === 'tablet' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">📱 Tablet</button>
                        <button wire:click="setPreviewDevice('mobile')" class="px-2 py-0.5 rounded-lg transition {{ $previewDevice === 'mobile' ? 'bg-white text-slate-900 shadow-xs' : 'text-slate-500 hover:text-slate-800' }}">📲 Mobile</button>
                    </div>
                </div>

                <!-- Live Sample Card -->
                <div class="p-5 rounded-2xl border border-slate-200/80 space-y-4 transition-all duration-300 {{ $previewDevice === 'mobile' ? 'max-w-xs mx-auto' : ($previewDevice === 'tablet' ? 'max-w-md mx-auto' : 'w-full') }}" style="background-color: var(--preview-surface); border-radius: var(--preview-radius-lg);">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-black" style="color: var(--preview-text);">{{ $site_name }}</span>
                        <span class="px-2.5 py-1 text-[10px] font-black rounded-full text-white shadow-xs" style="background-color: var(--preview-primary); border-radius: var(--preview-radius-xl);">
                            LIVE PREVIEW
                        </span>
                    </div>

                    <p class="text-xs font-medium leading-relaxed" style="color: var(--preview-muted);">
                        معاينة حية لتنسيق العناصر والبطاقات والألوان الديناميكية على المنصة الوطنية.
                    </p>

                    <div class="flex items-center gap-2">
                        <button class="px-4 py-2 text-xs font-bold text-white shadow-xs" style="background-color: var(--preview-primary); border-radius: var(--preview-radius-md);">
                            {{ __('زر رئيسي') }}
                        </button>
                        <button class="px-4 py-2 text-xs font-bold text-white shadow-xs" style="background-color: var(--preview-dark); border-radius: var(--preview-radius-md);">
                            {{ __('زر ثنائي') }}
                        </button>
                    </div>
                </div>

                <!-- Status Badges Live Preview -->
                <div class="p-4 rounded-xl bg-slate-50 border border-slate-200/60 space-y-2">
                    <span class="text-[11px] font-extrabold text-slate-600 block">{{ __('معاينة شارات الحالة (Status Badges)') }}</span>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-2.5 py-1 text-[10px] font-black text-white rounded-full" style="background-color: var(--preview-success);">اعتماد معتمد</span>
                        <span class="px-2.5 py-1 text-[10px] font-black text-white rounded-full" style="background-color: var(--preview-warning);">قيد التدقيق</span>
                        <span class="px-2.5 py-1 text-[10px] font-black text-white rounded-full" style="background-color: var(--preview-danger);">حالة مرفوضة</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
