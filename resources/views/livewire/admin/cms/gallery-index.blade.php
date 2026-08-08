<div class="space-y-6 pb-8">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 dark:text-slate-100">إدارة ألبومات ومعارض الصور التفاعلية</h1>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">إجمالي الألبومات: <span class="text-blue-600 dark:text-blue-400 font-bold">{{ $totalAlbums }}</span> ألبوم — رفع الصور، تعيين الغلاف، والتنظيم</p>
                </div>
            </div>
        </div>
        <button wire:click="openCreate"
            class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-sm font-black transition shadow-sm shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            <span>إنشاء ألبوم صور جديد</span>
        </button>
    </div>

    {{-- ALBUMS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($albums as $album)
            @php
                $coverUrl = $album->coverMedia ? asset($album->coverMedia->storage_path) : ($album->mediaItems->first() ? asset($album->mediaItems->first()->storage_path) : null);
            @endphp
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-blue-500 rounded-3xl p-5 shadow-xs hover:shadow-lg transition flex flex-col justify-between overflow-hidden group">
                <div>
                    <!-- Album Cover Thumbnail -->
                    <div class="relative w-full h-44 rounded-2xl bg-slate-100 dark:bg-slate-700 overflow-hidden mb-4 border border-slate-200 dark:border-slate-600">
                        @if($coverUrl)
                            <img src="{{ $coverUrl }}" alt="{{ $album->title_ar }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400">
                                <svg class="w-10 h-10 mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span class="text-xs font-bold">لا يوجد غلاف (انقر لرفع صور)</span>
                            </div>
                        @endif
                        <div class="absolute top-3 right-3 flex gap-1">
                            @if($album->is_featured)
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black bg-amber-500 text-white shadow-xs">مميز</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex justify-between items-start mb-2">
                        <h3 class="font-black text-slate-900 dark:text-slate-100 text-base">{{ $album->title_ar }}</h3>
                    </div>
                    <p class="text-xs text-slate-500 mb-4 line-clamp-2">{{ $album->description_ar ?: 'بدون وصف' }}</p>
                </div>

                <div class="flex justify-between items-center text-xs font-bold pt-3 border-t border-slate-100 dark:border-slate-700">
                    <span class="text-blue-600 dark:text-blue-400 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>{{ $album->media_items_count }} صورة</span>
                    </span>
                    <div class="flex items-center gap-1">
                        <button wire:click="openDrawer({{ $album->id }})" class="px-3 py-1.5 rounded-xl bg-blue-50 text-blue-700 hover:bg-blue-100 transition font-bold text-xs flex items-center gap-1" title="معاينة ورفع الصور">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <span>فتح الألبوم والرفع</span>
                        </button>
                        <button wire:click="openEdit({{ $album->id }})" class="p-1.5 text-slate-500 hover:text-amber-600 rounded-lg hover:bg-slate-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                        <button wire:click="confirmDelete({{ $album->id }})" class="p-1.5 text-slate-500 hover:text-rose-600 rounded-lg hover:bg-slate-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-400 font-medium bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700">لا توجد ألبومات صور مسجلة بعد</div>
        @endforelse
    </div>

    {{-- MODAL FORM (CREATE / EDIT ALBUM WITH PHOTO UPLOADER) --}}
    @if($formOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 max-w-lg w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-2xl overflow-y-auto max-h-[90vh]">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">{{ $isEditing ? 'تعديل بيانات الألبوم' : 'إنشاء ألبوم صور جديد' }}</h3>
                    <button wire:click="$set('formOpen', false)" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="space-y-4 text-xs font-semibold">
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">اسم الألبوم (بالعربية) *</label>
                        <input wire:model="title_ar" type="text" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold">
                    </div>
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">اسم الألبوم (بالفرنسية) *</label>
                        <input wire:model="title_fr" type="text" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold">
                    </div>
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">وصف الألبوم</label>
                        <textarea wire:model="description_ar" rows="2" class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100"></textarea>
                    </div>

                    <!-- Photo Upload Input Dropzone -->
                    <div class="space-y-1">
                        <label class="block text-slate-700 dark:text-slate-300 font-bold">رفع صور الألبوم (حدد صورة أو عدة صور):</label>
                        <div class="border-2 border-dashed border-blue-300 dark:border-blue-700 rounded-2xl p-4 bg-blue-50/50 dark:bg-blue-900/10 text-center hover:bg-blue-50 transition cursor-pointer relative">
                            <input type="file" wire:model="newPhotos" multiple accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <svg class="w-8 h-8 text-blue-600 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-xs font-black text-blue-700 dark:text-blue-300 block">اضغط هنا لاختيار صور من جهازك أو اسحبها إلى هنا</span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">يدعم صور PNG, JPG, WEBP عالية الجودة</span>
                        </div>
                        @if($newPhotos)
                            <div class="text-[10px] font-black text-emerald-600">تم اختيار {{ count($newPhotos) }} صورة لرفعها</div>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('formOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="save" class="px-6 py-2.5 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md">حفظ الألبوم ورَفْع الصور</button>
                </div>
            </div>
        </div>
    @endif

    {{-- ALBUM DRAWER & PHOTO GALLERY VIEWER --}}
    @if($drawerOpen && $selectedAlbum)
        <div class="fixed inset-0 z-50 overflow-hidden bg-slate-900/60 backdrop-blur-xs flex justify-end transition-opacity">
            <div class="w-full max-w-3xl bg-white dark:bg-slate-800 h-full shadow-2xl flex flex-col justify-between overflow-y-auto animate-in slide-in-from-left duration-300">
                
                <!-- Drawer Header -->
                <div class="p-6 bg-gradient-to-r from-[#06205C] to-blue-600 text-white relative flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-black text-white flex items-center gap-2">
                            <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>{{ $selectedAlbum->title_ar }}</span>
                        </h2>
                        <p class="text-xs text-blue-100 font-medium mt-1">معرض الصور التفصيلي — إجمالي الصور: {{ $selectedAlbum->mediaItems->count() }} صورة</p>
                    </div>
                    <button wire:click="$set('drawerOpen', false)" class="w-8 h-8 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center font-bold text-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Photos Grid & Quick Uploader inside Drawer -->
                <div class="p-6 space-y-6 flex-1">
                    
                    <!-- Quick Upload Section inside Drawer -->
                    <div class="p-4 rounded-2xl bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 space-y-3">
                        <span class="text-xs font-black text-blue-900 dark:text-blue-100 block">إضافة ورفع صور جديدة لهذا الألبوم فوراً:</span>
                        <div class="flex flex-col sm:flex-row gap-2">
                            <input type="file" wire:model="newPhotos" multiple accept="image/*" class="text-xs text-slate-700 bg-white dark:bg-slate-700 p-2 rounded-xl border border-slate-300 dark:border-slate-600 flex-1">
                            <button wire:click="uploadPhotosToSelectedAlbum" class="px-5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-black text-xs shadow-md transition shrink-0 flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                <span>رفع الصور المختارة</span>
                            </button>
                        </div>
                    </div>

                    <!-- Photo Thumbnails Grid -->
                    <div>
                        <h3 class="text-xs font-black text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2 mb-4">الصور المحفوظة بالألبوم</h3>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @forelse($selectedAlbum->mediaItems as $photo)
                                @php $photoUrl = asset($photo->storage_path); @endphp
                                <div class="relative group rounded-2xl overflow-hidden border border-slate-200 dark:border-slate-700 bg-slate-100 dark:bg-slate-900 aspect-square shadow-xs">
                                    <img src="{{ $photoUrl }}" alt="{{ $photo->original_filename }}" class="w-full h-full object-cover">
                                    
                                    @if($selectedAlbum->cover_media_id == $photo->id)
                                        <div class="absolute top-2 right-2 px-2 py-0.5 rounded-full text-[9px] font-black bg-emerald-600 text-white shadow-md">
                                            غلاف الألبوم
                                        </div>
                                    @endif

                                    <!-- Hover Actions -->
                                    <div class="absolute inset-0 bg-slate-900/60 opacity-0 group-hover:opacity-100 transition flex flex-col items-center justify-center gap-2 p-2">
                                        @if($selectedAlbum->cover_media_id != $photo->id)
                                            <button wire:click="setCoverMedia({{ $photo->id }})" class="px-2.5 py-1 bg-white text-slate-900 rounded-lg font-bold text-[10px] hover:bg-blue-50 transition shadow-sm">
                                                تعيين كغلاف
                                            </button>
                                        @endif
                                        <button wire:click="deleteMediaItem({{ $photo->id }})" class="px-2.5 py-1 bg-rose-600 text-white rounded-lg font-bold text-[10px] hover:bg-rose-700 transition shadow-sm">
                                            حذف الصورة
                                        </button>
                                    </div>
                                </div>
                            @empty
                                <div class="col-span-full py-8 text-center text-slate-400 font-medium">لا توجد صور مرفوعة في هذا الألبوم بعد. استخدم المربع أعلاه لرفع صور جديدة.</div>
                            @endforelse
                        </div>
                    </div>

                </div>

                <!-- Drawer Footer Actions -->
                <div class="p-4 border-t border-slate-100 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 flex justify-end">
                    <button wire:click="$set('drawerOpen', false)" class="px-5 py-2 rounded-xl border border-slate-300 dark:border-slate-600 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-white transition">
                        إغلاق النافذة
                    </button>
                </div>

            </div>
        </div>
    @endif

    {{-- DELETE CONFIRM MODAL --}}
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 w-full max-w-md shadow-2xl border border-slate-200 dark:border-slate-700 text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mx-auto text-xl font-bold">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">تأكيد حذف الألبوم نهائياً</h3>
                <p class="text-xs text-slate-500 font-medium">هل أنت تأكد من رغبتك في حذف هذا الألبوم وكافة الصور المرتبطة به؟</p>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-bold text-xs hover:bg-slate-50 transition">إلغاء</button>
                    <button wire:click="deleteAlbum" class="px-6 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-black text-xs shadow-md transition">تأكيد الحذف</button>
                </div>
            </div>
        </div>
    @endif

</div>
