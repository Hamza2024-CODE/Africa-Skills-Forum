@php
$locale = app()->getLocale();
$ministerGallery = [
    asset('images/news/minister_interview/news_minister_1.png'),
    asset('images/news/minister_interview/news_minister_2.png'),
    asset('images/news/minister_interview/news_minister_3.png'),
    asset('images/news/minister_interview/news_minister_4.png'),
    asset('images/news/minister_interview/news_minister_5.png'),
    asset('images/news/minister_interview/news_minister_6.png'),
    asset('images/news/minister_interview/news_minister_7.png'),
];
@endphp

<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Hero Header with Glassmorphism Effect -->
        <div class="relative rounded-[36px] overflow-hidden bg-slate-950/80 backdrop-blur-xl text-white p-8 sm:p-14 shadow-2xl border border-white/20">
            {{-- Background Image Overlay --}}
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/news_header_bg.png') }}" alt="News Header Background"
                     class="w-full h-full object-cover object-center opacity-40 transform scale-105 filter blur-xs">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/80 to-black/40"></div>
                <div class="absolute inset-0 bg-blue-950/30 mix-blend-overlay"></div>
            </div>

            {{-- Glassmorphism Glow Highlights --}}
            <div class="absolute -top-24 -end-24 w-96 h-96 rounded-full bg-blue-500/20 blur-3xl pointer-events-none"></div>
            <div class="absolute -bottom-24 -start-24 w-96 h-96 rounded-full bg-amber-500/20 blur-3xl pointer-events-none"></div>

            {{-- Header Content --}}
            <div class="relative z-10 text-center max-w-3xl mx-auto space-y-5">


                <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-2xl">
                    {{ $t('مستجدات وإعلانات منتدى المهارات الإفريقية', 'Actualités & Communiqués Officiels — ASF', 'Africa Skills Forum News & Official Announcements') }}
                </h1>
                <p class="text-xs sm:text-base text-slate-200 font-medium leading-relaxed max-w-2xl mx-auto drop-shadow-md">
                    {{ $t('تابع التغطية الحية والحوارات الرسمية الصادرة عن اللجنة العليا لمنتدى المهارات الإفريقية.', 'Suivez la couverture en direct du Forum des Compétences Africaines.', 'Follow live coverage and official interviews from Africa Skills Forum.') }}
                </p>
            </div>
        </div>

        <!-- News Cards Grid (Glassmorphism & White/Blue Theme) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10">
                        </svg>
                    </div>
                    <p>{{ $t('لا توجد مستجدات منشورة حالياً.', 'Aucune actualité publiée pour le moment.', 'No published news at the moment.') }}</p>
                </div>
            @endforelse
        </div>

    </div>

    {{-- ════ NEWS ARTICLE DETAIL MODAL WITH 100% FULL PHOTO VISIBILITY (WHITE & BLUE THEME) ════ --}}
    @if($modalOpen && $selectedArticle)
        <div class="fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-3 sm:p-6 overflow-y-auto">
            <div class="bg-white rounded-3xl overflow-hidden max-w-5xl w-full shadow-2xl border border-slate-200 relative text-slate-900 my-4">

                {{-- Modal Header (Navy Blue Title & White Crisp Theme) --}}
                <div class="p-6 bg-slate-50 border-b border-slate-200 flex items-center justify-between gap-4">
                    <div class="space-y-1.5">
                        <div class="flex items-center gap-2.5">
                            <span class="px-3.5 py-1 rounded-full bg-[#0066FF] text-white font-black text-[11px] uppercase tracking-wider shadow-sm">
                                {{ $selectedArticle->category === 'press_conference' ? 'ندوة صحفية وزارية' : ($selectedArticle->category === 'interview' ? 'حوار خاص وزاري' : 'إعلان رسمي') }}
                            </span>
                            <span class="text-xs text-slate-500 font-mono font-bold">
                                {{ optional($selectedArticle->published_at)->format('Y-m-d H:i') }}
                            </span>
                        </div>
                        <h2 class="text-xl sm:text-2xl font-black text-[#06205C] leading-snug">
                            {{ $selectedArticle->getLocalized('title') }}
                        </h2>
                    </div>

                    <button wire:click="closeArticle" type="button" class="w-10 h-10 rounded-full bg-slate-200 hover:bg-slate-300 text-slate-700 flex items-center justify-center transition shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                {{-- Modal Content --}}
                <div class="p-6 sm:p-8 space-y-6 max-h-[78vh] overflow-y-auto">
                    
                    {{-- Active Main Photo Display (100% FULL IMAGE - NO CROPPING!) --}}
                    <div class="relative bg-slate-950 rounded-2xl overflow-hidden border border-slate-300 shadow-xl min-h-[350px] max-h-[65vh] flex items-center justify-center p-3">
                        <img src="{{ $activePhoto ?: $selectedArticle->cover_url }}" alt="Article Media" class="max-w-full max-h-[60vh] object-contain mx-auto rounded-xl transition-all duration-300">
                    </div>

                    {{-- 7 Attached Photo Gallery Thumbnails (Only for Interview Article) --}}
                    @if($selectedArticle->category === 'interview')
                        <div class="space-y-3 bg-slate-50 p-4 rounded-2xl border border-slate-200">
                            <h4 class="text-xs font-black text-[#06205C] uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4 text-[#0066FF]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>معرض الصور التوثيقية المرفقة بالحوار (7 صور كاملة)</span>
                            </h4>
                            <div class="grid grid-cols-4 sm:grid-cols-7 gap-3">
                                @foreach($ministerGallery as $index => $photoUrl)
                                    <button wire:click="setActivePhoto('{{ $photoUrl }}')"
                                            type="button"
                                            class="h-20 sm:h-24 rounded-xl overflow-hidden border-2 transition transform hover:scale-105 cursor-pointer shadow-md bg-slate-950 p-1 flex items-center justify-center {{ ($activePhoto ?: $selectedArticle->cover_url) === $photoUrl ? 'border-[#0066FF] ring-2 ring-blue-500/50' : 'border-slate-300 opacity-70 hover:opacity-100' }}">
                                        <img src="{{ $photoUrl }}" alt="Photo {{ $index + 1 }}" class="w-full h-full object-contain">
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Excerpt Box --}}
                    @if($selectedArticle->getLocalized('excerpt'))
                        <div class="p-5 bg-blue-50 border-s-4 border-[#0066FF] rounded-2xl text-xs sm:text-sm font-bold text-[#06205C] leading-relaxed border border-blue-100 shadow-sm">
                            {{ $selectedArticle->getLocalized('excerpt') }}
                        </div>
                    @endif

                    {{-- Article Full Text --}}
                    <div class="text-sm sm:text-base text-slate-700 font-medium leading-relaxed space-y-4 pt-2">
                        {!! nl2br(e($selectedArticle->getLocalized('content'))) !!}
                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="p-5 bg-slate-50 border-t border-slate-200 flex justify-end">
                    <button wire:click="closeArticle" type="button" class="px-8 py-3 rounded-2xl bg-[#0066FF] hover:bg-[#0052CC] text-white font-extrabold text-xs transition shadow-xl">
                        إغلاق
                    </button>
                </div>

            </div>
        </div>
    @endif
</div>
