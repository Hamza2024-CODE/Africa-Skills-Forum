<div class="py-10 bg-[#F4F7FC] min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        
        <!-- Top Header Card (White & Royal Blue Theme) -->
        <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200 shadow-lg flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
            <div>
                <div class="flex items-center gap-3">
                    <span class="w-3.5 h-3.5 rounded-full bg-brand-500 animate-ping"></span>
                    <h1 class="text-2xl font-black text-[#06205C] tracking-tight">
                        إدارة وتخصيص محتوى المنصة والعداد التنازلي (WSAP V8.4 CMS Builder)
                    </h1>
                </div>
                <p class="text-xs text-slate-500 mt-1 font-bold">
                    التحكم الكامل في العداد الميكانيكي، العناوين، المستهدف الزمني، الألوان، التوقيت، والمعاينة الحية المباشرة.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3">
                <button type="button" wire:click="resetSettings" class="px-5 py-2.5 rounded-2xl bg-slate-100 hover:bg-slate-200 border border-slate-300 text-slate-700 text-xs font-black transition flex items-center gap-2 shadow-xs">
                    <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    <span>إعادة تعيين</span>
                </button>
                <button type="button" wire:click="saveSettings" class="px-6 py-2.5 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white text-xs font-black shadow-md transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <span>حفظ التغييرات</span>
                </button>
            </div>
        </div>

        @if($savedMessage)
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-black flex items-center gap-2 shadow-xs animate-fade-in">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>{{ $savedMessage }}</span>
            </div>
        @endif

        <!-- Main CMS Panel (Light Theme: White & Royal Blue Tabs) -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
            
            <!-- Navigation Tabs Bar (Royal Blue Styling) -->
            <div class="bg-slate-50 border-b border-slate-200 px-6 pt-4 flex items-center gap-2 overflow-x-auto">
                <button type="button" wire:click="setTab('countdown')" 
                        class="px-5 py-3 rounded-t-2xl font-black text-xs transition flex items-center gap-2 border-b-2 {{ $activeTab === 'countdown' ? 'bg-white text-[#06205C] border-brand-500 shadow-xs' : 'text-slate-500 hover:text-slate-800 border-transparent' }}">
                    <svg class="w-4 h-4 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>إعدادات العد التنازلي</span>
                </button>

                <button type="button" wire:click="setTab('design')" 
                        class="px-5 py-3 rounded-t-2xl font-black text-xs transition flex items-center gap-2 border-b-2 {{ $activeTab === 'design' ? 'bg-white text-[#06205C] border-brand-500 shadow-xs' : 'text-slate-500 hover:text-slate-800 border-transparent' }}">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/></svg>
                    <span>تصميم البطاقة والألوان</span>
                </button>

                <button type="button" wire:click="setTab('options')" 
                        class="px-5 py-3 rounded-t-2xl font-black text-xs transition flex items-center gap-2 border-b-2 {{ $activeTab === 'options' ? 'bg-white text-[#06205C] border-brand-500 shadow-xs' : 'text-slate-500 hover:text-slate-800 border-transparent' }}">
                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
                    <span>محتوى الصفحة الرئيسية والفيديو</span>
                </button>

                <button type="button" wire:click="setTab('preview')" 
                        class="px-5 py-3 rounded-t-2xl font-black text-xs transition flex items-center gap-2 border-b-2 {{ $activeTab === 'preview' ? 'bg-brand-500 text-white border-brand-600 shadow-sm' : 'text-[#0284C7] hover:text-[#06205C] border-transparent font-bold' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <span>معاينة مباشرة (Live Preview)</span>
                </button>
            </div>

            <!-- Tab Content Container -->
            <div class="p-8">
                
                <form wire:submit.prevent="saveSettings" class="space-y-8">
                    
                    <!-- TAB 1: Countdown Settings -->
                    @if($activeTab === 'countdown')
                    <div class="space-y-6 animate-fade-in">
                        
                        <div class="p-5 rounded-2xl bg-blue-50/60 border border-blue-200 flex items-center justify-between">
                            <div>
                                <span class="font-black text-xs text-[#06205C] block">تفعيل العداد التنازلي التفاعلي</span>
                                <span class="text-[11px] text-slate-600">إظهار أو إخفاء بطاقة المفكرة الورقية ثلاثية الأبعاد بالصفحة الرئيسية</span>
                            </div>
                            <input type="checkbox" wire:model="countdown_enabled" class="w-6 h-6 text-brand-600 rounded-lg border-slate-300">
                        </div>

                        <!-- Titles Section -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-[#06205C] mb-2">عنوان البطاقة (عربي)</label>
                                <input type="text" wire:model="countdown_title_ar" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold text-[#06205C]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#06205C] mb-2">عنوان البطاقة (فرنسي)</label>
                                <input type="text" wire:model="countdown_title_fr" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold text-[#06205C]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#06205C] mb-2">عنوان البطاقة (إنجليزي)</label>
                                <input type="text" wire:model="countdown_title_en" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold text-[#06205C]">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-[#06205C] mb-2">الوصف الفرعي (عربي)</label>
                                <input type="text" wire:model="countdown_subtitle_ar" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold text-[#06205C]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#06205C] mb-2">الوصف الفرعي (فرنسي)</label>
                                <input type="text" wire:model="countdown_subtitle_fr" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold text-[#06205C]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#06205C] mb-2">الوصف الفرعي (إنجليزي)</label>
                                <input type="text" wire:model="countdown_subtitle_en" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold text-[#06205C]">
                            </div>
                        </div>

                        <!-- Target Datetime & Timezone -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-slate-200">
                            <div>
                                <label class="block text-xs font-bold text-[#06205C] mb-2">تاريخ ووقت انطلاق الحدث (YYYY-MM-DD HH:MM:SS) *</label>
                                <input type="text" wire:model="countdown_target_date" required placeholder="2026-09-15 09:00:00" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-black font-mono text-[#06205C]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#06205C] mb-2">المنطقة الزمنية (Timezone)</label>
                                <select wire:model="countdown_timezone" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold text-[#06205C]">
                                    <option value="Africa/Algiers">Africa/Algiers (GMT+01:00)</option>
                                    <option value="UTC">UTC (GMT+00:00)</option>
                                    <option value="Europe/Paris">Europe/Paris (GMT+02:00)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#06205C] mb-2">حالة الحدث التنازلي</label>
                                <select wire:model="countdown_status" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-black text-[#06205C]">
                                    <option value="COUNTDOWN">⏱️ نشط (COUNTDOWN)</option>
                                    <option value="LIVE">🔴 مباشر (LIVE — الحدث جارٍ)</option>
                                    <option value="COMPLETED">🏆 منتهي (COMPLETED — انتهت الأولمبياد)</option>
                                    <option value="DISABLED">🚫 معطل (DISABLED — إخفاء)</option>
                                </select>
                            </div>
                        </div>

                    </div>
                    @endif

                    <!-- TAB 2: Card Design & Colors -->
                    @if($activeTab === 'design')
                    <div class="space-y-6 animate-fade-in">
                        
                        <h3 class="text-sm font-black text-[#06205C]">ألوان بطاقات العداد التنازلي الأربعة</h3>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                            <!-- Seconds Color -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2">
                                <label class="block text-xs font-bold text-slate-700">لون بطاقة الثواني</label>
                                <input type="color" wire:model="countdown_color_sec" class="w-16 h-12 mx-auto rounded-xl cursor-pointer border-0">
                                <span class="text-[10px] font-mono font-bold block text-slate-500">{{ $countdown_color_sec }}</span>
                            </div>

                            <!-- Minutes Color -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2">
                                <label class="block text-xs font-bold text-slate-700">لون بطاقة الدقائق</label>
                                <input type="color" wire:model="countdown_color_min" class="w-16 h-12 mx-auto rounded-xl cursor-pointer border-0">
                                <span class="text-[10px] font-mono font-bold block text-slate-500">{{ $countdown_color_min }}</span>
                            </div>

                            <!-- Hours Color -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2">
                                <label class="block text-xs font-bold text-slate-700">لون بطاقة الساعات</label>
                                <input type="color" wire:model="countdown_color_hrs" class="w-16 h-12 mx-auto rounded-xl cursor-pointer border-0">
                                <span class="text-[10px] font-mono font-bold block text-slate-500">{{ $countdown_color_hrs }}</span>
                            </div>

                            <!-- Days Color -->
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center space-y-2">
                                <label class="block text-xs font-bold text-slate-700">لون بطاقة الأيام</label>
                                <input type="color" wire:model="countdown_color_days" class="w-16 h-12 mx-auto rounded-xl cursor-pointer border-0">
                                <span class="text-[10px] font-mono font-bold block text-slate-500">{{ $countdown_color_days }}</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-200">
                            <div>
                                <label class="block text-xs font-bold text-[#06205C] mb-2">تصميم الورقة والخلفية</label>
                                <select wire:model="countdown_theme" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold text-[#06205C]">
                                    <option value="vintage_spiral_notebook">📒 دفتر ملاحظات ورقي ثلاثي الأبعاد مع حلزون معدني (Vintage Spiral Notebook)</option>
                                    <option value="clean_paper">📄 ورقة كلاسيكية بيضاء (Clean White Paper Sheet)</option>
                                    <option value="dark_card">🎴 بطاقات ألمنيوم حديثة (Modern Aluminum Card)</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#06205C] mb-2">نمط وحجم الأرقام</label>
                                <select wire:model="countdown_digit_style" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold text-[#06205C]">
                                    <option value="classic_mono">12 - خط أحادي عريض كلاسيكي (Classic Monospace)</option>
                                    <option value="modern_sans">12 - خط حديث ناعم (Modern Sans Bold)</option>
                                    <option value="cyber_digital">12 - خط رقمي تكنولوجي (Cyber Digital Display)</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                                <span class="text-xs font-bold text-[#06205C]">إظهار الأيقونات بالبطاقات</span>
                                <input type="checkbox" wire:model="countdown_show_icons" class="w-5 h-5 text-brand-600 rounded-lg">
                            </div>
                            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                                <span class="text-xs font-bold text-[#06205C]">تأثير الدوران وانطواء الورقة (3D Paper Flip)</span>
                                <input type="checkbox" wire:model="countdown_flip_animation" class="w-5 h-5 text-brand-600 rounded-lg">
                            </div>
                        </div>

                    </div>
                    @endif

                    <!-- TAB 3: Homepage Video & Hero Content -->
                    @if($activeTab === 'options')
                    <div class="space-y-6 animate-fade-in">
                        
                        <h3 class="text-sm font-black text-[#06205C]">1. قسم Hero وعناوين الصفحة</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-[#06205C] mb-2">العنوان (عربي)</label>
                                <input type="text" wire:model="hero_title_ar" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold text-[#06205C]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#06205C] mb-2">العنوان (فرنسي)</label>
                                <input type="text" wire:model="hero_title_fr" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold text-[#06205C]">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#06205C] mb-2">العنوان (إنجليزي)</label>
                                <input type="text" wire:model="hero_title_en" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold text-[#06205C]">
                            </div>
                        </div>

                        <h3 class="text-sm font-black text-[#06205C] pt-4 border-t border-slate-200">2. رابط فيديو YouTube المميز</h3>
                        <div>
                            <label class="block text-xs font-bold text-[#06205C] mb-2">رابط فيديو YouTube</label>
                            <input type="url" wire:model="featured_video_url" required class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-bold text-[#06205C] font-mono">
                        </div>

                    </div>
                    @endif

                    <!-- TAB 4: Live Preview -->
                    @if($activeTab === 'preview')
                    <div class="space-y-6 animate-fade-in">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-[#06205C]">معاينة حية وتفاعلية للمكون ثلاثي الأبعاد مباشرة بنفس طريقة ظهوره للمستخدم:</span>
                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black">Live Render Mode</span>
                        </div>

                        <div class="p-6 bg-[#F4F7FC] rounded-3xl border border-slate-300">
                            <!-- Live Render of the Vintage Spiral Paper Notebook Widget -->
                            <div class="max-w-4xl mx-auto relative">
                                
                                <!-- Spiral Binder Rings -->
                                <div class="flex items-center justify-around px-8 -mb-4 relative z-30 pointer-events-none">
                                    @for($i = 0; $i < 12; $i++)
                                        <div class="w-3 h-8 bg-gradient-to-r from-slate-400 via-slate-200 to-slate-500 rounded-full shadow-md border border-slate-400/80"></div>
                                    @endfor
                                </div>

                                <!-- Vintage Paper Card -->
                                <div class="bg-[#FDFBF7] rounded-3xl p-8 shadow-2xl border-2 border-[#EADFC9] relative overflow-hidden text-slate-900">
                                    
                                    <!-- Stamp -->
                                    <div class="absolute top-4 right-4 w-24 h-24 border-2 border-red-800/25 rounded-full flex flex-col items-center justify-center p-2 transform rotate-12 pointer-events-none">
                                        <span class="text-[8px] font-black text-red-900/40 uppercase tracking-widest text-center leading-tight">ALGERIA 2026<br>WORLDSKILLS</span>
                                    </div>

                                    <!-- Center Logo & Titles -->
                                    <div class="text-center space-y-2 mb-6">
                                        <img src="/logo.svg" alt="WorldSkills" class="h-12 w-auto mx-auto drop-shadow-xs mb-2">
                                        <h3 class="text-xl font-black text-[#06205C]">{{ $countdown_title_ar }}</h3>
                                        <p class="text-xs font-bold text-slate-600">★ {{ $countdown_subtitle_ar }} ★</p>
                                    </div>

                                    <!-- 4 Cards -->
                                    <div class="grid grid-cols-4 gap-4 text-center">
                                        <div class="space-y-1">
                                            <div style="background-color: var(--color-sec, {{ $countdown_color_sec }});" class="p-4 rounded-2xl border-2 border-white/40 shadow-lg relative overflow-hidden text-white font-mono text-4xl font-black">41</div>
                                            <span class="text-xs font-black text-slate-800 block">ثانية</span>
                                        </div>
                                        <div class="space-y-1">
                                            <div style="background-color: var(--color-min, {{ $countdown_color_min }});" class="p-4 rounded-2xl border-2 border-white/40 shadow-lg relative overflow-hidden text-white font-mono text-4xl font-black">00</div>
                                            <span class="text-xs font-black text-slate-800 block">دقيقة</span>
                                        </div>
                                        <div class="space-y-1">
                                            <div style="background-color: var(--color-hrs, {{ $countdown_color_hrs }});" class="p-4 rounded-2xl border-2 border-white/40 shadow-lg relative overflow-hidden text-white font-mono text-4xl font-black">22</div>
                                            <span class="text-xs font-black text-slate-800 block">ساعة</span>
                                        </div>
                                        <div class="space-y-1">
                                            <div style="background-color: var(--color-days, {{ $countdown_color_days }});" class="p-4 rounded-2xl border-2 border-white/40 shadow-lg relative overflow-hidden text-white font-mono text-4xl font-black">111</div>
                                            <span class="text-xs font-black text-slate-800 block">يوم</span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                    @endif

                    <!-- Submit Footer Bar -->
                    <div class="pt-6 border-t border-slate-200 flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-500">حفظ الإعدادات يطبق التغييرات مباشرة بالصفحة العامة ومكونات المنصة.</span>
                        <button type="submit" class="px-8 py-3 rounded-2xl bg-brand-500 hover:bg-brand-600 text-white font-black text-xs shadow-md transition flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span>حفظ التغييرات والنشر</span>
                        </button>
                    </div>

                </form>
            </div>

        </div>

    </div>
</div>
