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

                <button type="button" wire:click="setTab('hero_images')" 
                        class="px-5 py-3 rounded-t-2xl font-black text-xs transition flex items-center gap-2 border-b-2 {{ $activeTab === 'hero_images' ? 'bg-white text-[#06205C] border-[#F5A800] shadow-xs' : 'text-slate-500 hover:text-slate-800 border-transparent' }}">
                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>صور السلايدر الرئيسي</span>
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
                    
                    <!-- TAB: HERO SLIDER IMAGES -->
                    @if($activeTab === 'hero_images')
                    <div class="space-y-6 animate-fade-in">
                        
                        <div class="p-5 rounded-2xl bg-amber-50 border border-amber-200 flex items-center gap-3">
                            <svg class="w-5 h-5 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <div>
                                <span class="font-black text-xs text-amber-800 block">صور السلايدر الرئيسي — قابلة للتغيير من الأدمين</span>
                                <span class="text-[11px] text-amber-700">يمكنك رفع صورة جديدة (JPG/PNG/WEBP) أو إدخال رابط URL مباشر. الصور الفارغة لن تُعرض في السلايدر. يدعم حتى 5 صور.</span>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach([1,2,3,4,5] as $n)
                            @php
                                $urlField  = "hero_slide_{$n}_url";
                                $fileField = "hero_slide_{$n}_file";
                            @endphp
                            <div class="bg-white rounded-3xl border border-slate-200 shadow-lg overflow-hidden flex flex-col group hover:shadow-xl hover:border-[#F5A800]/50 transition-all duration-300">
                                
                                <!-- Slide Preview Image -->
                                <div class="h-40 relative overflow-hidden bg-slate-900">
                                    @if(!empty($this->$urlField))
                                        <img src="{{ asset($this->$urlField) }}" alt="Slide {{ $n }}" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-500">
                                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
                                    @else
                                        <div class="w-full h-full flex flex-col items-center justify-center bg-slate-100 text-slate-400 gap-2">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            <span class="text-xs font-bold">لا توجد صورة</span>
                                        </div>
                                    @endif

                                    <!-- Slide Number Badge -->
                                    <div class="absolute top-3 start-3 w-7 h-7 rounded-xl bg-[#0B2A6F] text-white text-xs font-black flex items-center justify-center shadow-lg">{{ $n }}</div>
                                </div>

                                <!-- Slide Controls -->
                                <div class="p-4 space-y-3">
                                    <div>
                                        <label class="block text-xs font-black text-slate-700 mb-1.5">رفع صورة جديدة (JPG/PNG/WEBP)</label>
                                        <input type="file" wire:model="{{ $fileField }}" accept="image/*" class="w-full text-xs text-slate-600 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-black file:bg-[#0B2A6F]/10 file:text-[#0B2A6F] hover:file:bg-[#0B2A6F]/20 transition">
                                        <div wire:loading wire:target="{{ $fileField }}" class="text-xs text-amber-600 font-bold mt-1 flex items-center gap-1">
                                            <svg class="animate-spin w-3 h-3" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                                            جاري رفع الصورة...
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-xs font-black text-slate-700 mb-1.5">أو أدخل رابط URL للصورة</label>
                                        <input type="text" wire:model="{{ $urlField }}" placeholder="/images/hero_slide_{{ $n }}.png" class="w-full px-3 py-2 rounded-xl border border-slate-200 text-xs font-mono text-slate-700 focus:outline-none focus:ring-2 focus:ring-[#0B2A6F] bg-slate-50">
                                    </div>

                                    @if(!empty($this->$urlField))
                                        <div class="flex items-center justify-between pt-1">
                                            <span class="text-[10px] text-emerald-600 font-black flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                صورة مضافة
                                            </span>
                                            <button type="button" wire:click="$set('{{ $urlField }}', '')" class="text-[10px] text-rose-500 hover:text-rose-700 font-black transition">× حذف الصورة</button>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-8 py-3 rounded-2xl bg-gradient-to-r from-[#0B2A6F] to-[#35A536] text-white text-xs font-black shadow-xl transition flex items-center gap-2 hover:shadow-2xl hover:scale-105">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                <span>حفظ صور السلايدر</span>
                            </button>
                        </div>

                    </div>
                    @elseif($activeTab === 'countdown')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="p-5 rounded-2xl bg-blue-50/60 border border-blue-200 flex items-center justify-between shadow-xs">
                                <div>
                                    <span class="font-black text-xs text-[#06205C] block">⏱️ تفعيل وإظهار العداد التنازلي التفاعلي</span>
                                    <span class="text-[11px] text-slate-600 font-medium">إظهار أو إخفاء العداد التنازلي من أسفل كافة الصفحات المخصصة للزوار والصفحة الرئيسية.</span>
                                </div>
                                <input type="checkbox" wire:model="countdown_enabled" class="w-6 h-6 text-emerald-600 rounded-lg border-slate-300 shadow-sm cursor-pointer">
                            </div>

                            <div class="p-5 rounded-2xl bg-emerald-50/60 border border-emerald-200 flex items-center justify-between shadow-xs">
                                <div>
                                    <span class="font-black text-xs text-emerald-900 block">🤝 تفعيل وإظهار قسم وصفحة الشركاء والرعاة</span>
                                    <span class="text-[11px] text-slate-600 font-medium">إظهار أو إخفاء صفحة وقسم الشركاء والرعاة الرسميين من المنصة والقوائم.</span>
                                </div>
                                <input type="checkbox" wire:model="show_partners_section" class="w-6 h-6 text-emerald-600 rounded-lg border-slate-300 shadow-sm cursor-pointer">
                            </div>
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
                                <input type="text" wire:model="countdown_target_date" required placeholder="2026-11-25 09:00:00" class="w-full px-4 py-3 rounded-2xl bg-slate-50 border border-slate-300 text-xs font-black font-mono text-[#06205C]">
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
                                    <option value="COMPLETED">🏆 منتهي (COMPLETED — انتهت الفعالية)</option>
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

                    <!-- TAB 4: Live Preview (Identical to Visitor View) -->
                    @if($activeTab === 'preview')
                    <div class="space-y-6 animate-fade-in">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-[#06205C]">معاينة حية وتفاعلية بنفس الشكل والتطابق التام 100% مع واجهة الزوار بالمنصة:</span>
                            <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-black">Live Visitor View Render</span>
                        </div>

                        <!-- Outer Dashboard Container Card -->
                        <div class="rounded-3xl bg-gradient-to-br from-[#F8FAFC] via-[#F1F5F9] to-[#E2E8F0] p-6 sm:p-10 shadow-2xl border border-slate-200 text-slate-900 space-y-8 relative overflow-hidden group/dashboard">
                            
                            <!-- Dynamic Background Ambient Lighting Orbs -->
                            <div class="absolute -top-32 -left-32 w-80 h-80 bg-[#35A536]/15 rounded-full blur-3xl pointer-events-none"></div>
                            <div class="absolute -bottom-32 -right-32 w-80 h-80 bg-[#F5A800]/15 rounded-full blur-3xl pointer-events-none"></div>

                            <!-- Top Row: Left Text/Info + Right Tech Map Illustration -->
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center relative z-10">
                                
                                <!-- Left Side (RTL Info) -->
                                <div class="lg:col-span-7 space-y-4 text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-[#35A536] animate-ping"></span>
                                        <h4 class="text-base sm:text-lg font-black text-slate-700 uppercase tracking-wide">
                                            الحدث القادم // UPCOMING STAGE
                                        </h4>
                                    </div>

                                    <h2 class="text-2xl sm:text-4xl font-black text-[#0B2A6F] leading-tight tracking-tight drop-shadow-xs">
                                        {{ $countdown_title_ar }}
                                    </h2>

                                    <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-2xl bg-white/90 backdrop-blur-md border border-slate-200 shadow-sm text-slate-700 text-xs font-bold">
                                        <svg class="w-4 h-4 text-[#0B2A6F] shrink-0 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span>مركز المؤتمرات محمد بن أحمد (CCO) — وهران، الجزائر</span>
                                    </div>
                                </div>

                                <!-- Right Side: Tech Orbital Africa Map Badge -->
                                <div class="lg:col-span-5 flex justify-center">
                                    <div class="relative w-64 h-64 sm:w-80 sm:h-80 flex items-center justify-center group/map">
                                        <div class="absolute inset-0 rounded-full border-2 border-[#35A536]/30 animate-spin pointer-events-none" style="animation-duration: 25s;"></div>
                                        <div class="absolute inset-3 rounded-full border border-dashed border-[#F5A800]/50 animate-spin pointer-events-none" style="animation-duration: 15s; animation-direction: reverse;"></div>
                                        <div class="absolute inset-8 rounded-full bg-gradient-to-tr from-emerald-100/60 via-white to-blue-50/60 shadow-xl flex items-center justify-center p-6 border border-white">
                                            <img src="/AFRICA.png" alt="Africa Skills Forum" class="w-full h-full object-contain filter drop-shadow-2xl">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Middle Row: 4 Symmetric Counter Cards + Date Card -->
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch relative z-10">

                                <!-- Left: 4 Symmetric Counter Cards -->
                                <div class="lg:col-span-8 bg-white/90 backdrop-blur-md rounded-3xl p-5 sm:p-6 shadow-xl border border-slate-200">
                                    <div class="grid grid-cols-4 gap-3 h-full">

                                        <!-- DAYS — Gold -->
                                        <div class="flex flex-col items-center justify-between gap-3 p-4 rounded-2xl bg-amber-50 border border-amber-200">
                                            <div class="w-9 h-9 rounded-xl bg-[#F5A800]/15 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            </div>
                                            <div class="text-4xl sm:text-5xl font-black font-mono text-[#F5A800] leading-none tabular-nums">102</div>
                                            <div class="text-[11px] font-black text-slate-600 uppercase tracking-widest">يوم</div>
                                            <div class="w-full h-1.5 bg-amber-100 rounded-full overflow-hidden">
                                                <div class="bg-gradient-to-r from-[#F5A800] to-amber-400 h-full rounded-full" style="width:80%"></div>
                                            </div>
                                        </div>

                                        <!-- HOURS — Green -->
                                        <div class="flex flex-col items-center justify-between gap-3 p-4 rounded-2xl bg-emerald-50 border border-emerald-200">
                                            <div class="w-9 h-9 rounded-xl bg-[#35A536]/15 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                            <div class="text-4xl sm:text-5xl font-black font-mono text-[#35A536] leading-none tabular-nums">17</div>
                                            <div class="text-[11px] font-black text-slate-600 uppercase tracking-widest">ساعة</div>
                                            <div class="w-full h-1.5 bg-emerald-100 rounded-full overflow-hidden">
                                                <div class="bg-gradient-to-r from-[#35A536] to-emerald-400 h-full rounded-full" style="width:60%"></div>
                                            </div>
                                        </div>

                                        <!-- MINUTES — Navy -->
                                        <div class="flex flex-col items-center justify-between gap-3 p-4 rounded-2xl bg-blue-50 border border-blue-200">
                                            <div class="w-9 h-9 rounded-xl bg-[#0B2A6F]/10 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-[#0B2A6F]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </div>
                                            <div class="text-4xl sm:text-5xl font-black font-mono text-[#0B2A6F] leading-none tabular-nums">46</div>
                                            <div class="text-[11px] font-black text-slate-600 uppercase tracking-widest">دقيقة</div>
                                            <div class="w-full h-1.5 bg-blue-100 rounded-full overflow-hidden">
                                                <div class="bg-gradient-to-r from-[#0B2A6F] to-blue-500 h-full rounded-full" style="width:75%"></div>
                                            </div>
                                        </div>

                                        <!-- SECONDS — Pulsing Green -->
                                        <div class="flex flex-col items-center justify-between gap-3 p-4 rounded-2xl bg-emerald-50 border border-emerald-300">
                                            <div class="w-9 h-9 rounded-xl bg-[#35A536]/15 flex items-center justify-center">
                                                <svg class="w-5 h-5 text-[#35A536] animate-spin" style="animation-duration:3s" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                            </div>
                                            <div class="text-4xl sm:text-5xl font-black font-mono text-[#35A536] leading-none animate-pulse tabular-nums">38</div>
                                            <div class="text-[11px] font-black text-[#35A536] uppercase tracking-widest">ثانية</div>
                                            <div class="w-full h-1.5 bg-emerald-200 rounded-full overflow-hidden">
                                                <div class="bg-gradient-to-r from-[#35A536] to-emerald-400 h-full w-full rounded-full animate-pulse"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right Dark Event Date Card -->
                                <div class="lg:col-span-4 bg-gradient-to-br from-[#0B2A6F] via-[#081F54] to-[#040E26] text-white rounded-3xl p-6 shadow-2xl flex flex-col justify-between text-center space-y-4 border border-[#35A536]/40">
                                    <div class="space-y-2">
                                        <div class="w-12 h-12 rounded-2xl bg-white/10 mx-auto flex items-center justify-center border border-white/20 shadow-md">
                                            <svg class="w-6 h-6 text-[#F5A800]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        </div>
                                        <h3 class="text-3xl sm:text-4xl font-black tracking-tight text-white drop-shadow-md">
                                            <span dir="ltr" class="inline-block font-mono">16 - 21</span>
                                        </h3>
                                        <p class="text-base font-black text-[#35A536]">نوفمبر 2026</p>
                                    </div>

                                    <div class="pt-3 border-t border-white/15 text-xs font-black text-amber-300/90 tracking-wide">
                                        6 أيام من التميز والإبداع الإفريقي
                                    </div>
                                </div>
                            </div>

                            <!-- Bottom Row: Event Timeline Stepper + About Forum Card -->
                            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 pt-2 relative z-10">
                                <!-- Event Timeline Stepper -->
                                <div class="lg:col-span-8 bg-white/90 backdrop-blur-md rounded-3xl p-6 shadow-xl border border-slate-200 space-y-5">
                                    <div class="flex items-center justify-between">
                                        <h4 class="text-base font-black text-[#0B2A6F] flex items-center gap-2">
                                            <svg class="w-5 h-5 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                            <span>مراحل الحدث الرئيسية</span>
                                        </h4>
                                        <span class="text-xs font-bold text-slate-400">4 محطات رسمية</span>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 relative pt-2">
                                        <div class="hidden sm:block absolute top-8 left-8 right-8 h-1 bg-slate-100 -z-0 rounded-full overflow-hidden">
                                            <div class="bg-gradient-to-r from-[#35A536] via-[#0B2A6F] to-[#F5A800] h-full w-full rounded-full animate-pulse"></div>
                                        </div>

                                        <!-- Step 1 -->
                                        <div class="text-center space-y-2 relative z-10">
                                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#35A536] border-2 border-emerald-300 flex items-center justify-center mx-auto shadow-md">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                            </div>
                                            <div class="text-xs font-black text-slate-800">الافتتاح</div>
                                            <div class="text-[11px] font-extrabold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full inline-block">16 نوفمبر</div>
                                        </div>

                                        <!-- Step 2 -->
                                        <div class="text-center space-y-2 relative z-10">
                                            <div class="w-12 h-12 rounded-2xl bg-blue-100 text-[#0B2A6F] border-2 border-blue-300 flex items-center justify-center mx-auto shadow-md">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            </div>
                                            <div class="text-xs font-black text-slate-800">المنافسات والورش</div>
                                            <div class="text-[11px] font-extrabold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full inline-block">17 - 19 نوفمبر</div>
                                        </div>

                                        <!-- Step 3 -->
                                        <div class="text-center space-y-2 relative z-10">
                                            <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-[#35A536] border-2 border-emerald-300 flex items-center justify-center mx-auto shadow-md">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                            </div>
                                            <div class="text-xs font-black text-slate-800">التصفيات النهائية</div>
                                            <div class="text-[11px] font-extrabold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full inline-block">20 نوفمبر</div>
                                        </div>

                                        <!-- Step 4 -->
                                        <div class="text-center space-y-2 relative z-10">
                                            <div class="w-12 h-12 rounded-2xl bg-amber-100 text-[#F5A800] border-2 border-amber-300 flex items-center justify-center mx-auto shadow-md">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7 7 7M5 19l7-7 7 7"/></svg>
                                            </div>
                                            <div class="text-xs font-black text-slate-800">حفل الختام</div>
                                            <div class="text-[11px] font-extrabold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full inline-block">21 نوفمبر</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- About Forum Card -->
                                <div class="lg:col-span-4 bg-white/90 backdrop-blur-md rounded-3xl p-6 shadow-xl border border-slate-200 flex flex-col justify-between space-y-4">
                                    <div class="space-y-3">
                                        <div class="flex items-center justify-between">
                                            <h4 class="text-xs font-black text-slate-700 uppercase tracking-wide">
                                                عن المنتدى // ABOUT FORUM
                                            </h4>
                                            <span class="w-8 h-8 rounded-xl bg-[#35A536]/15 flex items-center justify-center text-[#35A536]">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                            </span>
                                        </div>
                                        <p class="text-xs text-slate-600 font-bold leading-relaxed">
                                            منصة إفريقية رائدة تجمع المواهب والخبراء وصناع القرار لتمكين الشباب، تطوير المهارات، وقيادة مستقبل العمل في إفريقيا.
                                        </p>
                                    </div>

                                    <div class="inline-flex items-center gap-2 text-xs font-black text-[#35A536] pt-2">
                                        <span>المزيد عن المنتدى</span>
                                        <svg class="w-4 h-4 text-[#35A536]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
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
