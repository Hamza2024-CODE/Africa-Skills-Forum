<div class="space-y-5 pb-8">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 dark:text-slate-100">إدارة مكتبة الفيديو والتغطيات</h1>
                    <p class="text-sm font-medium text-slate-500 dark:text-slate-400">إجمالي مقاطع الفيديو: <span class="text-blue-600 dark:text-blue-400 font-bold">{{ $totalVideos }}</span> فيديو</p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button wire:click="syncFromChannel"
                class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-red-600 hover:bg-red-700 text-white text-xs font-black transition shadow-sm shrink-0">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                استيراد تلقائي من القناة (@WorldSkillsAlgeria)
            </button>

            <button wire:click="openCreate"
                class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition shadow-sm shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                إضافة فيديو جديد
            </button>
        </div>
    </div>

    {{-- VIDEOS GRID --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($videos as $video)
            <div class="bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 hover:border-blue-500 rounded-2xl p-5 shadow-xs hover:shadow-md transition">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-bold text-slate-900 dark:text-slate-100 text-base">{{ $video->title_ar }}</h3>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-mono font-bold bg-blue-50 text-blue-700">{{ $video->video_type }}</span>
                </div>
                <p class="text-xs text-slate-500 mb-4 line-clamp-2">{{ $video->video_url }}</p>
                <div class="flex justify-between items-center text-xs font-bold pt-3 border-t border-slate-100 dark:border-slate-700">
                    <span class="text-slate-400">{{ $video->duration ?: '—' }}</span>
                    <div class="flex gap-1">
                        <button wire:click="openEdit({{ $video->id }})" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-slate-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg></button>
                        <button wire:click="confirmDelete({{ $video->id }})" class="p-1.5 text-slate-500 hover:text-red-600 rounded-lg hover:bg-slate-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg></button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center text-slate-400 font-medium bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700">لا توجد مقاطع فيديو مسجلة بعد</div>
        @endforelse
    </div>

    {{-- MODAL FORM --}}
    @if($formOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 max-w-lg w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-xl max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-lg font-black text-slate-900 dark:text-slate-100">{{ $isEditing ? 'تعديل الفيديو' : 'إضافة فيديو جديد' }}</h3>
                    <button wire:click="$set('formOpen', false)" class="text-slate-400 hover:text-slate-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">عنوان الفيديو (بالعربية) *</label>
                        <input wire:model="title_ar" type="text" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                        @error('title_ar') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">عنوان الفيديو (بالفرنسية) *</label>
                        <input wire:model="title_fr" type="text" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                        @error('title_fr') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">عنوان الفيديو (بالإنجليزية)</label>
                        <input wire:model="title_en" type="text" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">رابط الفيديو (URL / YouTube) *</label>
                        <input wire:model="video_url" type="url" placeholder="https://www.youtube.com/watch?v=..." class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                        @error('video_url') <span class="text-xs text-red-500 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">نوع المنصة</label>
                            <select wire:model="video_type" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                                <option value="YOUTUBE">YouTube</option>
                                <option value="VIMEO">Vimeo</option>
                                <option value="DIRECT">مباشر / فيديو آخر</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-600 dark:text-slate-400 mb-1">الحالة</label>
                            <select wire:model="status" class="w-full px-3 py-2 text-sm rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100">
                                <option value="PUBLISHED">منشور</option>
                                <option value="DRAFT">مسودة</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('formOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="save" class="px-5 py-2 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-xs">حفظ الفيديو</button>
                </div>
            </div>
        </div>
    @endif

    {{-- DELETE CONFIRM MODAL --}}
    @if($deleteConfirmOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-2xl p-6 max-w-sm w-full space-y-4 border border-slate-200 dark:border-slate-700 shadow-xl text-center">
                <div class="w-12 h-12 rounded-full bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </div>
                <h3 class="text-base font-black text-slate-900 dark:text-slate-100">تأكيد حذف الفيديو</h3>
                <p class="text-xs text-slate-500">هل أنت تأكد من إمكانية حذف هذا الفيديو من المكتبة؟ لا يمكن التراجع بعد ذلك.</p>
                <div class="flex justify-center gap-3 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="deleteVideo" class="px-5 py-2 text-xs font-black text-white bg-red-600 hover:bg-red-700 rounded-xl shadow-xs">تأكيد الحذف</button>
                </div>
            </div>
        </div>
    @endif

</div>
