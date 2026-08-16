@php
    $locale = app()->getLocale();
    $t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-8 pb-16 font-sans" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER BANNER & STAGE LAUNCHER --}}
    <div class="bg-gradient-to-r from-[#041B2D] via-[#0B2A6F] to-[#35A536] p-6 sm:p-8 rounded-3xl text-white shadow-2xl relative overflow-hidden flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 border border-emerald-500/20">
        <div class="space-y-2 relative z-10 max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-500/20 text-rose-300 text-[11px] font-black tracking-wider uppercase border border-rose-400/30">
                <span class="w-2.5 h-2.5 rounded-full bg-rose-500 animate-ping"></span>
                <span>LIVE BROADCAST STAGE COMMAND CENTER</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-white">
                {{ $t('مركز إدارة وتأطير البث المباشر والشاشات (Live TV)', 'Centre de Gestion de la Diffusion en Direct (Live TV)', 'Live TV Broadcast & Screen Control Center') }}
            </h1>
            <p class="text-xs text-blue-100/90 font-medium leading-relaxed">
                {{ $t('إدارة وتعديل رابط البث الحي، شريط الأخبار المتحرك، وشرائح العرض التقديمية لشاشات القاعات والمؤتمرات.', 'Gérez le flux vidéo en direct, les annonces défilantes et les diapositives pour les écrans.', 'Manage live video streams, ticker announcements, and slide presentations for hall monitors.') }}
            </p>
        </div>

        <div class="relative z-10 shrink-0">
            <a href="{{ route('live-tv') }}" target="_blank" class="px-6 py-3.5 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs transition-all duration-300 shadow-xl flex items-center gap-2.5 border border-rose-400/40 hover:scale-105">
                <svg class="w-5 h-5 text-white animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                <span>{{ $t('فتح شاشة البث المباشر (Live Stage) 📺', 'Lancer l\'Écran de Diffusion 📺', 'Launch Live TV Stage 📺') }}</span>
            </a>
        </div>
    </div>

    {{-- 1. LIVE STREAM URL CONFIGURATION CARD --}}
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-md p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-black text-[#0B2A6F]">
                        {{ $t('إعداد رابط البث المباشر الحي (Live Video Stream URL)', 'Configuration du Flux Vidéo en Direct', 'Live Video Stream URL Configuration') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('ادعم روابط YouTube Live أو HLS أو روابط الفيديو المباشرة (MP4/WebM).', 'Prend en charge les liens YouTube Live, HLS et vidéos directes.', 'Supports YouTube Live embeds, HLS feeds, and direct MP4 streams.') }}
                    </p>
                </div>
            </div>

            <span class="px-3 py-1 rounded-full text-xs font-black {{ !empty($liveStreamUrl) ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-slate-100 text-slate-600' }}">
                {{ !empty($liveStreamUrl) ? $t('البث المباشر مفعّل 🟢', 'En direct 🟢', 'Live Active 🟢') : $t('غير محدد (وضع الشرائح)', 'Mode diapositive', 'Slide Mode') }}
            </span>
        </div>

        @if(session()->has('success_stream'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-300 text-emerald-800 text-xs font-bold flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success_stream') }}</span>
            </div>
        @endif

        <form wire:submit.prevent="saveStreamUrl" class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-800 mb-1.5">
                    {{ $t('رابط البث المباشر (YouTube / HLS / MP4 Stream URL):', 'URL du Flux en Direct :', 'Live Stream Source URL:') }}
                </label>
                <div class="flex flex-col sm:flex-row gap-3">
                    <input type="url" wire:model.live="liveStreamUrl" placeholder="https://www.youtube.com/watch?v=XXXXXX"
                           class="flex-1 rounded-2xl border-slate-200 focus:border-rose-600 focus:ring-4 focus:ring-rose-600/10 text-xs font-mono font-bold text-slate-900 py-3.5 px-4 bg-slate-50 transition-all" dir="ltr">
                    <button type="submit" class="px-8 py-3.5 rounded-2xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs shadow-md transition-all shrink-0 flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/></svg>
                        <span>{{ $t('حفظ وتحديث البث المباشر', 'Enregistrer le flux', 'Save Stream URL') }}</span>
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- 2. TICKER ANNOUNCEMENTS MANAGEMENT CARD --}}
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-md p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-black text-[#0B2A6F]">
                        {{ $t('إدارة شريط الأخبار العاجلة والتنبيهات (Ticker Announcements)', 'Gestion du Bandeau Défilant (Ticker)', 'Ticker Announcements Manager') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('تظهر هذه التنبيهات والأخبار بصورة شريط متحرك في أسفل الشاشة.', 'Ces annonces défilent au bas de l\'écran de télévision.', 'These announcements scroll across the bottom ticker of the TV stage.') }}
                    </p>
                </div>
            </div>
        </div>

        @if(session()->has('success_ticker'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-300 text-emerald-800 text-xs font-bold flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success_ticker') }}</span>
            </div>
        @endif

        {{-- Add Ticker Form --}}
        <form wire:submit.prevent="createAnnouncement" class="space-y-4 bg-slate-50 p-5 rounded-2xl border border-slate-200">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1">{{ $t('نص الخبر العاجل بالعربية *', 'Texte en arabe *', 'Ticker Text in Arabic *') }}</label>
                    <input type="text" wire:model.live="tickerTextAr" placeholder="{{ $t('مثال: انطلاق الجلسات الافتتاحية بقاعة المؤتمرات الرئيسية...', 'Ex: Ouverture des sessions...', 'Ex: Opening ceremony starting in Main Hall...') }}"
                           class="w-full rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 text-xs font-bold py-3 px-4 bg-white">
                    @error('tickerTextAr') <span class="text-[11px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1">{{ $t('نص الخبر بالفرنسية / الإنجليزية (اختياري)', 'Texte en français (Optionnel)', 'Ticker Text in French / English (Optional)') }}</label>
                    <input type="text" wire:model.live="tickerTextFr" placeholder="Ex: Début de la cérémonie d'ouverture..."
                           class="w-full rounded-2xl border-slate-200 focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 text-xs font-bold py-3 px-4 bg-white">
                </div>
            </div>
            <div class="text-end">
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-amber-600 hover:bg-amber-700 text-white font-black text-xs shadow-md transition-all">
                    + {{ $t('إضافة تنبيه لشريط الأخبار', 'Ajouter au bandeau', 'Add Ticker Announcement') }}
                </button>
            </div>
        </form>

        {{-- Existing Tickers List --}}
        <div class="space-y-3">
            @forelse($announcements as $ann)
                <div class="flex items-center justify-between p-4 rounded-2xl bg-white border border-slate-200/90 shadow-xs gap-4">
                    <div class="space-y-1">
                        <div class="text-xs font-black text-slate-900">{{ $ann->ticker_text_ar }}</div>
                        @if($ann->ticker_text_fr)
                            <div class="text-[11px] font-medium text-slate-500">{{ $ann->ticker_text_fr }}</div>
                        @endif
                    </div>

                    <div class="flex items-center gap-3 shrink-0">
                        <button type="button" wire:click="toggleAnnouncement({{ $ann->id }})" class="px-3 py-1.5 rounded-xl text-[11px] font-black border transition {{ $ann->is_active ? 'bg-emerald-100 text-emerald-800 border-emerald-300' : 'bg-slate-100 text-slate-600 border-slate-200' }}">
                            {{ $ann->is_active ? $t('مفعّل 🟢', 'Actif 🟢', 'Active 🟢') : $t('معطّل ⚪', 'Inactif ⚪', 'Inactive ⚪') }}
                        </button>
                        <button type="button" wire:click="deleteAnnouncement({{ $ann->id }})" class="p-2 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 transition" title="Delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="p-6 text-center text-slate-400 font-bold text-xs bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    {{ $t('لا توجد تنبيهات عاجلة مضافة حالياً.', 'Aucune annonce défilante.', 'No ticker announcements added yet.') }}
                </div>
            @endforelse
        </div>
    </div>

    {{-- 3. EVENT SLIDES MANAGEMENT CARD --}}
    <div class="bg-white rounded-3xl border border-slate-200/90 shadow-md p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-black text-[#0B2A6F]">
                        {{ $t('إدارة شرائح العرض والتوجيه (TV Slides)', 'Gestion des Diapositives (Slides)', 'TV Presentation Slides Manager') }}
                    </h3>
                    <p class="text-xs text-slate-500 font-medium">
                        {{ $t('تعرض هذه الشرائح بصورة دورية في الشاشة عند عدم وجود بث فيديو حي.', 'Ces diapositives défilent lorsque aucun flux vidéo n\'est diffusé.', 'These slides rotate on screen when no live video stream is active.') }}
                    </p>
                </div>
            </div>
        </div>

        @if(session()->has('success_slide'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-300 text-emerald-800 text-xs font-bold flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('success_slide') }}</span>
            </div>
        @endif

        {{-- Add Slide Form --}}
        <form wire:submit.prevent="createSlide" class="space-y-4 bg-slate-50 p-5 rounded-2xl border border-slate-200">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1">{{ $t('عنوان الشريحة بالعربية *', 'Titre de la diapositive *', 'Slide Title in Arabic *') }}</label>
                    <input type="text" wire:model.live="slideTitleAr" placeholder="{{ $t('مثال: أهلاً بكم في منتدى المهارات الإفريقية...', 'Ex: Bienvenue au Forum...', 'Ex: Welcome to Africa Skills Forum...') }}"
                           class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-xs font-bold py-3 px-4 bg-white">
                    @error('slideTitleAr') <span class="text-[11px] text-rose-600 font-bold mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-800 mb-1">{{ $t('مدة العرض (بالثواني) *', 'Durée d\'affichage (sec) *', 'Display Duration (Seconds) *') }}</label>
                    <input type="number" wire:model.live="slideDuration" min="3" max="120"
                           class="w-full rounded-2xl border-slate-200 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 text-xs font-mono font-bold py-3 px-4 bg-white">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-800 mb-1">{{ $t('صورة خلفية الشريحة (اختياري)', 'Image de fond (Optionnel)', 'Slide Background Image (Optional)') }}</label>
                <input type="file" wire:model="slideImageFile" accept="image/*" class="w-full text-xs text-slate-500 bg-white p-2.5 rounded-2xl border border-slate-200">
            </div>

            <div class="text-end">
                <button type="submit" class="px-6 py-2.5 rounded-2xl bg-[#0B2A6F] hover:bg-blue-900 text-white font-black text-xs shadow-md transition-all">
                    + {{ $t('إضافة شريحة عرض جديدة', 'Ajouter une diapositive', 'Add New Presentation Slide') }}
                </button>
            </div>
        </form>

        {{-- Existing Slides Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($slides as $slide)
                <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-xs space-y-3 relative overflow-hidden flex flex-col justify-between">
                    <div class="space-y-2">
                        @if($slide->image_url)
                            <img src="{{ $slide->image_url }}" class="w-full h-32 rounded-xl object-cover border border-slate-200 shadow-xs">
                        @else
                            <div class="w-full h-32 rounded-xl bg-gradient-to-br from-blue-900 to-slate-900 text-white flex items-center justify-center p-4 text-center">
                                <span class="font-black text-xs">{{ $slide->title_ar }}</span>
                            </div>
                        @endif
                        <h4 class="font-black text-slate-900 text-sm">{ $slide->title_ar }}</h4>
                    </div>

                    <div class="flex items-center justify-between pt-2 border-t border-slate-100">
                        <span class="text-[11px] font-mono font-bold text-slate-500">⏱️ {{ $slide->display_duration_sec }}s</span>

                        <div class="flex items-center gap-2">
                            <button type="button" wire:click="toggleSlide({{ $slide->id }})" class="px-2.5 py-1 rounded-lg text-[10px] font-black border transition {{ $slide->is_active ? 'bg-emerald-100 text-emerald-800 border-emerald-300' : 'bg-slate-100 text-slate-600 border-slate-200' }}">
                                {{ $slide->is_active ? $t('مفعّل 🟢', 'Actif', 'Active') : $t('معطّل ⚪', 'Inactif', 'Inactive') }}
                            </button>
                            <button type="button" wire:click="deleteSlide({{ $slide->id }})" class="p-1.5 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 transition" title="Delete">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full p-6 text-center text-slate-400 font-bold text-xs bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                    {{ $t('لا توجد شرائح عرض مضافة حالياً.', 'Aucune diapositive enregistrée.', 'No presentation slides added yet.') }}
                </div>
            @endforelse
        </div>
    </div>

</div>
