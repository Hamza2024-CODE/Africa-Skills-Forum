@php
$locale = app()->getLocale();
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto space-y-3">
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-black uppercase tracking-wider">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
                <span>{{ $t('مركز الفيديوهات والبث المباشر', 'Centre Vidéos & Direct', 'Video Center & Live Streams') }}</span>
            </div>

            <h1 class="text-3xl sm:text-5xl font-black text-[#06205C] tracking-tight">
                {{ $t('فيديوهات وبث أولمبياد المهن', 'Vidéos & Couverture Média Directe', 'WorldSkills Videos & Media Coverage') }}
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 font-medium leading-relaxed max-w-2xl mx-auto">
                {{ $t('شاهد التغطيات المرئية، الأفلام الترويجية وتوثيقات المسابقات والورشات التنافسية من مختلف الولايات.', 'Regardez les reportages vidéo, films promotionnels et moments forts des épreuves.', 'Watch video highlights, promotional trailers and trade competition coverage across Algeria.') }}
            </p>
        </div>

        <!-- Official YouTube Channel Banner -->
        <div class="bg-gradient-to-r from-red-600 via-red-700 to-[#06205C] rounded-3xl p-6 sm:p-8 text-white shadow-2xl flex flex-col md:flex-row items-center justify-between gap-6 border border-red-500/30">
            <div class="flex items-center gap-5 text-[#{{ app()->getLocale() === 'ar' ? 'right' : 'left' }}">
                <div class="w-16 h-16 rounded-2xl bg-white text-red-600 flex items-center justify-center font-black text-2xl shadow-xl shrink-0">
                    <svg class="w-10 h-10 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                </div>
                <div>
                    <span class="px-3 py-0.5 rounded-full bg-white/20 text-white text-[10px] font-black uppercase tracking-wider">
                        {{ $t('القناة الرسمية المعتمدة', 'Chaîne Officielle', 'Official YouTube Channel') }}
                    </span>
                    <h2 class="text-xl sm:text-2xl font-black mt-1">WorldSkills Algeria — @WorldSkillsAlgeria</h2>
                    <p class="text-xs text-red-100 mt-0.5 font-medium">
                        {{ $t('تابع جميع التغطيات المباشرة، الكواليس والأفلام الوثائقية الرسمية لمنافسات أولمبياد المهن.', 'Abonnez-vous pour suivre tous les directs et reportages officiels.', 'Subscribe to watch all official live streams, behind-the-scenes and documentaries.') }}
                    </p>
                </div>
            </div>

            <a href="https://www.youtube.com/@WorldSkillsAlgeria/videos" target="_blank" class="w-full md:w-auto px-7 py-3.5 rounded-2xl bg-white hover:bg-slate-100 text-red-600 font-extrabold text-xs shadow-xl transition flex items-center justify-center gap-2.5 shrink-0 transform hover:-translate-y-1">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                <span>{{ $t('زيارة قائمة فيديوهات القناة (@WorldSkillsAlgeria/videos)', 'Visiter les Vidéos YouTube', 'Visit YouTube Videos (@WorldSkillsAlgeria/videos)') }}</span>
            </a>
        </div>

        <!-- Video Grid (2 Columns Exact Matching User Screenshot) -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10">
            @forelse($videos as $video)
                @php
                    $thumbUrl = $video->thumbnail_url;
                @endphp
                <div wire:click="playVideo({{ $video->id }})"
                     class="bg-white rounded-[28px] overflow-hidden border border-slate-200/90 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 group cursor-pointer flex flex-col justify-between">
                    
                    {{-- Thumbnail Layer --}}
                    <div class="h-64 sm:h-72 bg-slate-950 relative overflow-hidden">
                        <img src="{{ $thumbUrl }}" alt="{{ $video->getLocalized('title') }}"
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-95">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-black/20 to-black/10 group-hover:opacity-90 transition-opacity"></div>

                        {{-- Bright Electric Blue Play Button Overlay --}}
                        <div class="absolute inset-0 flex items-center justify-center">
                            <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-[#0066FF] hover:bg-[#0052CC] text-white flex items-center justify-center shadow-2xl shadow-blue-500/60 group-hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 sm:w-10 sm:h-10 fill-current translate-x-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>

                        {{-- Duration Badge (Bottom-Right) --}}
                        <div class="absolute bottom-4 end-4 px-3.5 py-1.5 rounded-full bg-black/85 backdrop-blur-md text-white text-xs font-mono font-bold flex items-center gap-1.5 border border-white/20 shadow-md">
                            <span>{{ is_numeric($video->duration) ? gmdate("i:s", (int)$video->duration) : ($video->duration ?: '04:15') }}</span>
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>

                        {{-- Video Type Badge (Top-Start) --}}
                        <div class="absolute top-4 start-4 px-4 py-1.5 rounded-full bg-[#0066FF] text-white text-[11px] font-black uppercase tracking-wider shadow-md">
                            {{ strtoupper($video->video_type ?: 'YOUTUBE') }}
                        </div>
                    </div>

                    {{-- Content Details (Matching Centered Layout) --}}
                    <div class="p-6 sm:p-8 space-y-4 flex-1 flex flex-col justify-between text-center">
                        <div class="space-y-3">
                            <h3 class="text-lg sm:text-xl font-black text-[#06205C] group-hover:text-[#0066FF] transition-colors leading-snug">
                                {{ $video->getLocalized('title') }}
                            </h3>
                            @if($video->getLocalized('description'))
                            <p class="text-xs sm:text-sm text-slate-500 line-clamp-2 leading-relaxed font-medium">
                                {{ $video->getLocalized('description') }}
                            </p>
                            @endif
                        </div>

                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-extrabold text-[#0066FF] group-hover:text-[#0052CC]">
                            <svg class="w-4 h-4 transform group-hover:-translate-x-1.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                            </svg>

                            <span class="flex items-center gap-2">
                                <span>{{ $t('مشاهدة الفيديو المباشر', 'Regarder la vidéo', 'Watch Video Stream') }}</span>
                                <div class="w-6 h-6 rounded-full bg-blue-50 text-[#0066FF] flex items-center justify-center border border-blue-100">
                                    <svg class="w-3.5 h-3.5 fill-current translate-x-0.5" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-16 text-center text-slate-400 font-bold text-sm border border-slate-200 shadow-sm space-y-3">
                    <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <p>{{ $t('لا تتوفر فيديوهات حالياً.', 'Aucune vidéo disponible pour le moment.', 'No videos available currently.') }}</p>
                </div>
            @endforelse
        </div>

    </div>

    {{-- ════ INLINE VIDEO PLAYER MODAL ════ --}}
    @if($showVideoModal && $activeVideo)
        <div class="fixed inset-0 z-50 bg-black/85 backdrop-blur-md flex items-center justify-center p-4 sm:p-6">
            <div class="bg-slate-900 rounded-3xl overflow-hidden max-w-4xl w-full shadow-2xl border border-slate-700 space-y-0 relative text-white">

                {{-- Modal Header --}}
                <div class="p-5 bg-slate-800/90 border-b border-slate-700 flex items-center justify-between gap-4">
                    <div>
                        <h3 class="text-base sm:text-lg font-black text-white leading-tight">{{ $activeVideo->getLocalized('title') }}</h3>
                        <p class="text-xs text-slate-400 font-medium mt-0.5">{{ $activeVideo->getLocalized('description') }}</p>
                    </div>

                    <button wire:click="closeVideoModal" class="w-10 h-10 rounded-full bg-slate-700 hover:bg-slate-600 text-white flex items-center justify-center transition shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Video Player Container --}}
                <div class="aspect-video w-full bg-black relative">
                    <iframe class="w-full h-full"
                            src="{{ $activeVideo->formatted_embed_url }}"
                            title="{{ $activeVideo->getLocalized('title') }}"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>

            </div>
        </div>
    @endif
</div>
