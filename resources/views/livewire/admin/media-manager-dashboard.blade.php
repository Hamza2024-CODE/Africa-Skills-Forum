<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                {{ app()->getLocale() === 'fr' ? 'Centre Média & Couverture Presse' : (app()->getLocale() === 'en' ? 'Media & Press Control Center' : 'لوحة إدارة الإعلام والأخبار والمحتوى الرقمي') }}
            </h1>
            <p class="text-xs font-bold text-slate-500 mt-1">
                {{ app()->getLocale() === 'fr' ? 'Gestion des articles, galeries photos, vidéos et annonces officielles.' : (app()->getLocale() === 'en' ? 'Manage news articles, photo galleries, video feeds, and announcements.' : 'لوحة إدارة الإعلام والأخبار والمحتوى الرقمي — إدارة المقالات ومعارض الصور والفيديوهات.') }}
            </p>
        </div>
        <a href="{{ route('admin.cms.homepage') }}" class="px-4 py-2 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-bold text-xs transition touch-target inline-flex items-center gap-2 self-start sm:self-auto">
            <span>{{ app()->getLocale() === 'fr' ? 'Nouveau Contenu' : (app()->getLocale() === 'en' ? 'Publish Content' : 'إضافة مقال جديد') }}</span>
        </a>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <x-dashboard.stat-card 
            :title="app()->getLocale() === 'fr' ? 'Articles Publiés' : (app()->getLocale() === 'en' ? 'News Articles' : 'المقالات المنشورة')" 
            :value="$newsCount" 
            badge="CMS Active" 
            color="blue" />
        <x-dashboard.stat-card 
            :title="app()->getLocale() === 'fr' ? 'Événements' : (app()->getLocale() === 'en' ? 'Events' : 'التظاهرات والأحداث')" 
            :value="$eventsCount" 
            badge="Calendar" 
            color="emerald" />
        <x-dashboard.stat-card 
            :title="app()->getLocale() === 'fr' ? 'Albums Photos' : (app()->getLocale() === 'en' ? 'Photo Albums' : 'ألبومات المعرض')" 
            :value="$albumsCount" 
            badge="Gallery" 
            color="purple" />
        <x-dashboard.stat-card 
            :title="app()->getLocale() === 'fr' ? 'Vidéos' : (app()->getLocale() === 'en' ? 'Videos' : 'مكتبة الفيديوهات')" 
            :value="$videosCount" 
            badge="Video Center" 
            color="amber" />
    </div>

    <!-- Media Modules Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="glass-card rounded-2xl p-6 space-y-4">
            <h3 class="text-sm font-black text-slate-900">
                {{ app()->getLocale() === 'fr' ? 'Gestionnaire CMS Articles' : (app()->getLocale() === 'en' ? 'CMS Article Manager' : 'محرر الأخبار والتغطيات') }}
            </h3>
            <p class="text-xs font-bold text-slate-500 leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Rédigez, modifiez et traduisez des articles en trois langues (Arabe, Français, Anglais).' : (app()->getLocale() === 'en' ? 'Draft, edit, and translate news articles in 3 languages.' : 'تحرير الأخبار الرسمية وتصنيفها ونشرها باللغات الثلاث (العربية، الفرنسية، الإنجليزية) عبر الهيكل المعياري.') }}
            </p>
            <a href="{{ route('admin.cms.homepage') }}" class="inline-flex items-center gap-2 text-xs font-black text-brand-600 hover:text-brand-700">
                <span>{{ app()->getLocale() === 'fr' ? 'Accéder au CMS' : (app()->getLocale() === 'en' ? 'Open CMS' : 'الانتقال إلى محرر الأخبار') }} &rarr;</span>
            </a>
        </div>

        <div class="glass-card rounded-2xl p-6 space-y-4">
            <h3 class="text-sm font-black text-slate-900">
                {{ app()->getLocale() === 'fr' ? 'Médiathèque et Galerie' : (app()->getLocale() === 'en' ? 'Media Library & Gallery' : 'مكتبة الصور والفيديوهات') }}
            </h3>
            <p class="text-xs font-bold text-slate-500 leading-relaxed">
                {{ app()->getLocale() === 'fr' ? 'Téléversez des visuels officiels et des vidéos de haute qualité sans compromettre les performances.' : (app()->getLocale() === 'en' ? 'Upload media assets and high quality video feeds.' : 'رفع الصور الرسمية وإدارة ألبومات التخصصات والفيديوهات وتحديد المعاينات الفنية للتظاهرة.') }}
            </p>
            <span class="inline-flex items-center gap-1.5 text-xs font-black text-emerald-600">
                <span>MySQL Asset Protection</span>
            </span>
        </div>
    </div>
</div>
