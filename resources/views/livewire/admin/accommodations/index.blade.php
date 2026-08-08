@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};
@endphp

<div class="space-y-6 pb-8 font-sans" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 border-b border-slate-200 dark:border-slate-700 pb-4">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-700 flex items-center justify-center text-white font-bold shadow-md">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <div>
                    <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                        {{ $t('إدارة الإقامة وتسكين الوفود والمشاركين', 'Gestion des Hébergements & Logements', 'Accommodations & Delegation Housing') }}
                    </h1>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-0.5">
                        {{ $t('مقرات الإقامة: ', 'Établissements: ', 'Total Hotels: ') }}<span class="text-blue-600 dark:text-blue-400 font-bold">{{ $totalAccommodations }}</span> — {{ $t('إجمالي الأسرة المتاحة: ', 'Capacité Totale: ', 'Total Beds Available: ') }}<span class="text-emerald-600 dark:text-emerald-400 font-bold">{{ number_format($totalCapacity) }}</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2.5">
            <button wire:click="exportExcel" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black transition shadow-sm shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>{{ $t('تصدير إلى Excel (CSV)', 'Exporter Excel (CSV)', 'Export to Excel (CSV)') }}</span>
            </button>
            <button wire:click="openAllocateModal" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition shadow-sm shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                <span>{{ $t('ربط وتسكين مشارك بغرفة', 'Affecter une Chambre', 'Assign Room to Member') }}</span>
            </button>
            <button wire:click="openCreate" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-slate-900 dark:bg-slate-700 hover:bg-slate-800 text-white text-xs font-black transition shadow-sm shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                <span>{{ $t('إضافة فندق / سكن', 'Ajouter un Hôtel', 'Add Hotel / Housing') }}</span>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="p-3 bg-emerald-50 text-emerald-700 text-xs font-bold rounded-xl border border-emerald-200">✓ {{ session('success') }}</div>
    @endif

    {{-- MULTI-DIMENSIONAL FILTERS BAR --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 space-y-3 shadow-xs">
        <div class="flex items-center justify-between">
            <h2 class="text-xs font-black text-slate-700 dark:text-slate-200 uppercase tracking-wider">
                {{ $t('الفلترة المتقدمة حسب وصول الوفود والتسكين والوجهات', 'Filtrage Avancé Hébergements & Délégations', 'Advanced Housing & Delegation Filters') }}
            </h2>
            <span class="text-[11px] text-slate-400 font-mono">الربط الشامل للأفراد والوفود</span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="بحث باسم الفندق أو العنوان..." class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 font-medium">
            </div>
            <div>
                <select wire:model.live="filterCountry" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 font-bold">
                    <option value="">كل الوفود والـالدول</option>
                    @foreach($countries as $c)
                        <option value="{{ $c->id }}">{{ $c->name_ar }} ({{ $c->iso2 }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="filterSkill" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 font-bold">
                    <option value="">كل التخصصات المعتمدة</option>
                    @foreach($skills as $s)
                        <option value="{{ $s->id }}">{{ $s->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="filterAccommodation" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 font-bold">
                    <option value="">كل الفنادق والمقرات</option>
                    @foreach($allAccommodationsList as $acc)
                        <option value="{{ $acc->id }}">{{ $acc->name_ar }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select wire:model.live="filterArrivalStatus" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 bg-slate-50 font-bold">
                    <option value="">حالة الوصول والتسكين</option>
                    <option value="ACTIVE">تم الوصول والتسكين</option>
                    <option value="PENDING">قيد الوصول / الانتظار</option>
                </select>
            </div>
        </div>
    </div>

    {{-- SECTION 1: ALLOCATIONS TABLE (الربط التفصيلي للمشاركين والوفود بحسب الوجهة والغرف) --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-black text-slate-900 text-sm flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                <span>جدول تسكين الأفراد والوفود الرسمية في الفنادق والغرف</span>
            </h2>
            <span class="text-xs font-mono text-slate-500">محدث تلقائياً</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-black uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="px-5 py-3.5 text-start">المشارك / عضو الوفد</th>
                        <th class="px-5 py-3.5 text-start">الوفد / الدولة</th>
                        <th class="px-5 py-3.5 text-start">التخصص</th>
                        <th class="px-5 py-3.5 text-start">مقر الإقامة / الفندق</th>
                        <th class="px-5 py-3.5 text-start">رقم الغرفة</th>
                        <th class="px-5 py-3.5 text-start">حالة الوصول والتسكين</th>
                        <th class="px-5 py-3.5 text-end">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($allocations as $alloc)
                        @php
                            $profile = $alloc->participantProfile;
                            $reg = $profile?->registrations?->first();
                        @endphp
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5">
                                <div class="font-bold text-slate-900">{{ $profile?->first_name_ar ?? $profile?->user?->name }} {{ $profile?->last_name_ar }}</div>
                                <div class="text-[10px] text-slate-400 font-mono">{{ $profile?->user?->email }}</div>
                            </td>
                            <td class="px-5 py-3.5 font-bold text-slate-700">
                                <span class="px-2 py-0.5 rounded bg-blue-50 text-blue-700 font-mono border border-blue-200">
                                    {{ $reg?->country?->name_ar ?? 'الوفد الجزائري' }}
                                </span>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 font-medium">{{ $reg?->skill?->name_ar ?? '—' }}</td>
                            <td class="px-5 py-3.5 font-bold text-emerald-800">{{ $alloc->room?->accommodation?->name_ar ?? '—' }}</td>
                            <td class="px-5 py-3.5 font-mono font-bold text-blue-600">غرفة {{ $alloc->room?->room_number ?? '—' }}</td>
                            <td class="px-5 py-3.5">
                                @if($alloc->status === 'ACTIVE')
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">✓ تم الوصول والتسكين</span>
                                @else
                                    <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">⏳ قيد الانتظار</span>
                                @endif
                            </td>
                            <td class="px-5 py-3.5 text-end">
                                <button wire:click="deleteAllocation({{ $alloc->id }})" class="px-2.5 py-1 rounded-lg text-[10px] font-bold bg-red-50 text-red-600 hover:bg-red-100">إلغاء التسكين</button>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-10 text-center text-slate-400 font-medium">لا توجد عمليات تسكين مطابقة للفلترة الحالية</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($allocations->hasPages())
            <div class="px-5 py-3 border-t border-slate-100">{{ $allocations->links() }}</div>
        @endif
    </div>

    {{-- SECTION 2: ACCOMMODATIONS & HOTELS TABLE --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h2 class="font-black text-slate-900 text-sm">قائمة مقرات الإقامة والفنادق المعتمدة</h2>
            <span class="text-xs text-slate-400 font-medium">الطاقة الاستيعابية والغرف</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-black uppercase tracking-wider text-slate-500 border-b border-slate-200">
                        <th class="px-5 py-3.5 text-start">الفندق / السكن</th>
                        <th class="px-5 py-3.5 text-start">العنوان</th>
                        <th class="px-5 py-3.5 text-start">الطاقة الإجمالية</th>
                        <th class="px-5 py-3.5 text-start">الغرف المتاحة</th>
                        <th class="px-5 py-3.5 text-start">الحالة</th>
                        <th class="px-5 py-3.5 text-end">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($accommodations as $acc)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-5 py-3.5 font-bold text-slate-900">
                                <button wire:click="openDrawer({{ $acc->id }})" class="hover:text-blue-600 transition">{{ $acc->name_ar }}</button>
                            </td>
                            <td class="px-5 py-3.5 text-slate-600 font-medium">{{ $acc->address ?: '—' }}</td>
                            <td class="px-5 py-3.5 font-mono text-xs font-bold text-slate-700">{{ $acc->total_capacity ?? 0 }} سرير</td>
                            <td class="px-5 py-3.5">
                                <button wire:click="openRooms({{ $acc->id }})" class="px-2.5 py-1 rounded-full text-xs font-bold bg-blue-50 text-blue-700">
                                    {{ $acc->rooms_count }} غرفة
                                </button>
                            </td>
                            <td class="px-5 py-3.5">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700">متاح</span>
                            </td>
                            <td class="px-5 py-3.5 text-end">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button wire:click="openEdit({{ $acc->id }})" class="p-1.5 text-slate-500 hover:text-blue-600 rounded-lg hover:bg-slate-100 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400 font-medium">لا توجد إقامات مسجلة</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ALLOCATE ROOM MODAL --}}
    @if($allocateModalOpen)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white rounded-3xl p-6 w-full max-w-lg shadow-2xl border border-slate-200 space-y-5">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-lg font-black text-[#06205C] flex items-center gap-2">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                        <span>ربط وتسكين مشارك بغرفة وموقع مبيت</span>
                    </h3>
                    <button wire:click="$set('allocateModalOpen', false)" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="space-y-4 text-xs font-semibold">
                    <div>
                        <label class="block text-slate-700 font-bold mb-1">اختر المشارك أو الفرد المعتمد *</label>
                        <select wire:model="selectedParticipantId" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                            <option value="">-- حدد المشارك من القائمة --</option>
                            @foreach($allParticipants as $part)
                                <option value="{{ $part->id }}">
                                    {{ $part->first_name_ar ?? $part->user?->name }} {{ $part->last_name_ar }} ({{ $part->user?->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-slate-700 font-bold mb-1">اختر الفندق والغرفة *</label>
                        <select wire:model="selectedRoomId" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-slate-900 font-bold">
                            <option value="">-- حدد الغرفة وموقع المبيت --</option>
                            @foreach($allRooms as $rm)
                                <option value="{{ $rm->id }}">
                                    {{ $rm->accommodation?->name_ar }} — غرفة {{ $rm->room_number }} (سعة {{ $rm->capacity }} أسرة)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100">
                    <button wire:click="$set('allocateModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 hover:bg-slate-100 rounded-xl">إلغاء</button>
                    <button wire:click="saveAllocation" class="px-6 py-2.5 text-xs font-black text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-md">ربط وتسكين المشارك</button>
                </div>
            </div>
        </div>
    @endif

</div>
