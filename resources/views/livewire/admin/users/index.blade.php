@php
$locale = app()->getLocale();
$t = fn($ar,$fr,$en) => match($locale){'fr'=>$fr,'en'=>$en,default=>$ar};

$roleBadge = [
    'SUPER_ADMIN'        => ['bg-rose-50 text-rose-700 border-rose-200',       $t('أدمن مسؤول المنصة كاملة','Super Admin','Platform Master Admin')],
    'MEDIA_MANAGER'      => ['bg-amber-50 text-amber-700 border-amber-200',     $t('أدمن مسؤول الإعلام والتغطية','Responsable Média','Media Manager')],
    'COUNTRY_ADMIN'      => ['bg-blue-50 text-blue-700 border-blue-200',        $t('مسؤول وفد دولة فقط','Chef Délégation Pays','Country Delegation Head')],
    'NATIONAL_ADMIN'     => ['bg-rose-50 text-rose-700 border-rose-200',       $t('أدمن مسؤول المنصة كاملة','National Admin','National Admin')],
];
@endphp

<div class="space-y-6 pb-12" x-data="{ drawerOpen: @entangle('drawerOpen'), roleModalOpen: @entangle('roleModalOpen'), createModalOpen: @entangle('createModalOpen'), deleteConfirmOpen: @entangle('deleteConfirmOpen') }">

    {{-- ── Page Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-200 dark:border-slate-700 pb-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-slate-100 tracking-tight">
                {{ $t('إدارة المستخدمين وحسابات الوفود والحكام والصحافة', 'Gestion des Utilisateurs & Comptes', 'User Accounts & Delegations Management') }}
            </h1>
            <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-1">
                {{ $t('إجمالي الحسابات','Total comptes','Total accounts') }}: <span class="font-bold text-blue-600 dark:text-blue-400">{{ $totalUsers }}</span>
                — {{ $t('الحسابات النشطة','Comptes actifs','Active accounts') }}: <span class="font-bold text-emerald-600 dark:text-emerald-400">{{ $activeUsers }}</span>
            </p>
        </div>
        <div class="flex flex-wrap items-center gap-2">
            <button wire:click="toggleOfficialRegistration" class="flex items-center gap-2 px-4 py-2.5 rounded-xl {{ $officialRegistrationOpen ? 'bg-amber-600 hover:bg-amber-700 text-white' : 'bg-emerald-600 hover:bg-emerald-700 text-white' }} text-xs font-black transition shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <span>{{ $officialRegistrationOpen
                    ? $t('إغلاق التسجيل الرسمي','Fermer les inscriptions','Close Official Registration')
                    : $t('فتح التسجيل الرسمي','Ouvrir les inscriptions','Open Official Registration') }}</span>
            </button>
            <a href="{{ route('official.registration') }}" target="_blank" class="flex items-center gap-1.5 px-3 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-800 dark:text-slate-200 text-xs font-bold transition border border-slate-300 dark:border-slate-700">
                <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                <span>{{ $t('معاينة صفحة التسجيل','Aperçu inscription','Preview Registration Page') }}</span>
            </a>
            <button wire:click="exportExcel" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-black transition shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>{{ $t('تصدير Excel (CSV)','Exporter Excel','Export Excel') }}</span>
            </button>
            <button wire:click="openCreateModal" class="flex items-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-black transition shadow-xs">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                <span>{{ $t('إنشاء حساب جديد','Nouveau compte','Create New Account') }}</span>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 text-emerald-800 text-xs font-bold rounded-2xl border border-emerald-200 flex items-center justify-between shadow-xs">
            <span>✓ {{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div class="p-4 bg-rose-50 text-rose-800 text-xs font-bold rounded-2xl border border-rose-200 flex items-center justify-between shadow-xs">
            <span>⚠ {{ session('error') }}</span>
        </div>
    @endif

    {{-- ── Filters Bar ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 p-4 flex flex-col sm:flex-row gap-3 shadow-xs">
        <div class="relative flex-1">
            <input wire:model.live.debounce.300ms="search" type="search"
                   placeholder="{{ $t('بحث بالاسم أو البريد الإلكتروني...','Rechercher...','Search by name or email...') }}"
                   class="w-full px-4 py-2.5 text-xs rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500"/>
        </div>
        <select wire:model.live="filterRole"
                class="px-3 py-2.5 text-xs rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">{{ $t('كل الأدوار','Tous les rôles','All Roles') }}</option>
            @foreach($allRoles as $role)
                <option value="{{ $role }}">{{ $role }}</option>
            @endforeach
        </select>
        <select wire:model.live="filterStatus"
                class="px-3 py-2.5 text-xs rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 dark:text-slate-100 font-bold focus:outline-none focus:ring-2 focus:ring-blue-500">
            <option value="">{{ $t('كل الحالات','Tous statuts','All Statuses') }}</option>
            <option value="1">{{ $t('نشط','Actif','Active') }}</option>
            <option value="0">{{ $t('معطل','Désactivé','Inactive') }}</option>
        </select>
    </div>

    {{-- ── Data Table ── --}}
    <div class="bg-white dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-700 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-right text-xs">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-700/60 text-slate-500 dark:text-slate-400 font-bold border-b border-slate-200 dark:border-slate-700">
                        <th class="p-3.5">{{ $t('المستخدم','Utilisateur','User') }}</th>
                        <th class="p-3.5">{{ $t('الدور / الرتبة الرسمية','Rôle','Role') }}</th>
                        <th class="p-3.5">{{ $t('الحالة','Statut','Status') }}</th>
                        <th class="p-3.5">{{ $t('صلاحية الـ QR','Permission QR','QR Scan') }}</th>
                        <th class="p-3.5 text-left">{{ $t('الإجراءات','Actions','Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700 font-medium">
                    @forelse($users as $user)
                        @php
                            $roleName = $user->roles->first()?->name ?? 'USER';
                            [$rbg, $rlabel] = $roleBadge[$roleName] ?? ['bg-slate-100 text-slate-600 border-slate-200', $roleName];
                        @endphp
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-700/40 transition">
                            <td class="p-3.5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-indigo-800 flex items-center justify-center text-white text-xs font-black shrink-0 shadow-xs">
                                        {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                                    </div>
                                    <div class="min-w-0">
                                        <button wire:click="openDrawer({{ $user->id }})" class="text-xs font-black text-slate-900 dark:text-white hover:text-blue-600 text-right truncate block max-w-[200px]">
                                            {{ $user->name }}
                                        </button>
                                        <span class="text-[10px] font-mono text-slate-400 truncate block max-w-[200px]">{{ $user->email }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="p-3.5">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black border {{ $rbg }}">{{ $rlabel }}</span>
                            </td>

                            <td class="p-3.5">
                                @if($user->is_active)
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                        {{ $t('نشط','Actif','Active') }}
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-100 text-rose-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                        {{ $t('معطل','Désactivé','Inactive') }}
                                    </span>
                                @endif
                            </td>

                            <td class="p-3.5">
                                <button wire:click="toggleScanQrPermission({{ $user->id }})"
                                        title="{{ $t('منح/إلغاء صلاحية مسح QR','Activer/Désactiver scanner QR','Toggle QR scan permission') }}"
                                        class="px-2.5 py-1 rounded-xl font-black text-[10px] transition border flex items-center gap-1 shrink-0 {{ $user->can_scan_qr ? 'bg-emerald-50 text-emerald-700 border-emerald-300 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border-slate-200 hover:bg-slate-200' }}">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                    <span>{{ $user->can_scan_qr ? $t('ماسح مفعّل','Scanner actif','Scanner ON') : $t('تفعيل الماسح','Activer scanner','Enable Scanner') }}</span>
                                </button>
                            </td>

                            <td class="p-3.5 text-left">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button wire:click="openDrawer({{ $user->id }})"
                                            title="عرض تفاصيل الحساب"
                                            class="p-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </button>

                                    <button wire:click="openRoleModal({{ $user->id }})"
                                            title="{{ $t('تغيير الدور والصلاحيات','Changer le rôle','Change Role') }}"
                                            class="p-1.5 rounded-lg bg-amber-50 hover:bg-amber-100 text-amber-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 5.25a3 3 0 013 3m3 0a6 6 0 01-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1121.75 8.25z"/></svg>
                                    </button>

                                    <button wire:click="toggleActive({{ $user->id }})"
                                            title="{{ $user->is_active ? $t('تعطيل الحساب','Désactiver','Deactivate') : $t('تفعيل الحساب','Activer','Activate') }}"
                                            class="p-1.5 rounded-lg {{ $user->is_active ? 'bg-slate-100 hover:bg-rose-50 text-slate-500 hover:text-rose-600' : 'bg-emerald-50 hover:bg-emerald-100 text-emerald-600' }} transition">
                                        @if($user->is_active)
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        @endif
                                    </button>

                                    <button wire:click="confirmDelete({{ $user->id }})"
                                            title="{{ $t('حذف الحساب نهائياً','Supprimer','Delete Account') }}"
                                            class="p-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 text-rose-600 transition">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-medium">
                                {{ $t('لا توجد نتائج مطابقة لخيارات البحث والتصفية','Aucun résultat trouvé','No matching user accounts found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
            <div class="px-5 py-3.5 border-t border-slate-100 dark:border-slate-700">
                {{ $users->links() }}
            </div>
        @endif
    </div>

    {{-- ════ 1. USER DETAILS DRAWER ════ --}}
    @if(!empty($drawerOpen) && !empty($selectedUser))
        <div class="fixed inset-0 z-50 overflow-hidden" x-show="drawerOpen">
            <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity" wire:click="closeDrawer"></div>
            <div class="fixed inset-y-0 text-right max-w-full flex {{ $locale==='ar'?'left-0':'right-0' }}">
                <div class="w-screen max-w-md bg-white dark:bg-slate-800 shadow-2xl p-6 flex flex-col justify-between space-y-6">
                    <div class="space-y-5">
                        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-4">
                            <h3 class="text-base font-black text-slate-900 dark:text-white">تفاصيل حساب المستخدم</h3>
                            <button wire:click="closeDrawer" class="p-1 rounded-lg text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        <div class="flex items-center gap-4 bg-slate-50 dark:bg-slate-700/50 p-4 rounded-2xl border border-slate-200 dark:border-slate-700">
                            <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white font-black text-xl flex items-center justify-center">
                                {{ mb_strtoupper(mb_substr($selectedUser->name, 0, 1)) }}
                            </div>
                            <div>
                                <h4 class="text-base font-black text-slate-900 dark:text-white">{{ $selectedUser->name }}</h4>
                                <p class="text-xs font-mono text-slate-500">{{ $selectedUser->email }}</p>
                            </div>
                        </div>
                        <div class="space-y-3 text-xs font-bold text-slate-700 dark:text-slate-300">
                            <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-700">
                                <span class="text-slate-400">الدور الحالي:</span>
                                <span class="text-blue-600 font-black">{{ $selectedUser->roles->first()?->name ?? '—' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-700">
                                <span class="text-slate-400">حالة الحساب:</span>
                                <span class="{{ $selectedUser->is_active ? 'text-emerald-600' : 'text-rose-600' }}">{{ $selectedUser->is_active ? 'نشط' : 'معطل' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-700">
                                <span class="text-slate-400">صلاحية مسح الـ QR:</span>
                                <span class="{{ $selectedUser->can_scan_qr ? 'text-emerald-600' : 'text-slate-500' }}">{{ $selectedUser->can_scan_qr ? 'مفعّلة' : 'غير مفعّلة' }}</span>
                            </div>
                            <div class="flex justify-between py-2 border-b border-slate-100 dark:border-slate-700">
                                <span class="text-slate-400">تاريخ الإنشاء:</span>
                                <span>{{ $selectedUser->created_at ? $selectedUser->created_at->format('Y-m-d H:i') : '—' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-700 flex gap-2">
                        <button wire:click="openRoleModal({{ $selectedUser->id }})" class="flex-1 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-white font-black text-xs transition">تعديل الصلاحية</button>
                        <button wire:click="closeDrawer" class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs">إغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ════ 2. EDIT ROLE MODAL ════ --}}
    @if(!empty($roleModalOpen) && !empty($selectedUser))
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 w-full max-w-md shadow-2xl border border-slate-200 dark:border-slate-700 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white">تغيير دور وصلاحيات المستخدم</h3>
                    <button wire:click="$set('roleModalOpen', false)" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-3 text-xs">
                    <p class="font-bold text-slate-600 dark:text-slate-300">تغيير الصلاحية الرسمية لـ: <span class="text-blue-600 font-black">{{ $selectedUser->name }}</span></p>
                    <select wire:model="newRole" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white font-bold text-xs">
                        @foreach($allRoles as $r)
                            <option value="{{ $r }}">{{ $r }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('roleModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl">إلغاء</button>
                    <button wire:click="saveRole" class="px-6 py-2.5 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md">حفظ التغييرات</button>
                </div>
            </div>
        </div>
    @endif

    {{-- ════ 3. DELETE CONFIRMATION MODAL ════ --}}
    @if(!empty($deleteConfirmOpen))
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 w-full max-w-sm shadow-2xl border border-slate-200 dark:border-slate-700 text-center space-y-4">
                <div class="w-12 h-12 rounded-full bg-rose-100 text-rose-600 mx-auto flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="text-base font-black text-slate-900 dark:text-white">تأكيد حذف الحساب</h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">هل أنت تأكد من رغبتك في حذف هذا الحساب نهائياً من قاعدة البيانات؟ لا يمكن التراجع عن هذا الإجراء.</p>
                </div>
                <div class="flex items-center justify-center gap-3 pt-2">
                    <button wire:click="$set('deleteConfirmOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl">إلغاء</button>
                    <button wire:click="deleteUser" class="px-6 py-2.5 text-xs font-black text-white bg-rose-600 hover:bg-rose-700 rounded-xl shadow-md">حذف نهائياً</button>
                </div>
            </div>
        </div>
    @endif

    {{-- ════ 4. CREATE USER MODAL ════ --}}
    @if(!empty($createModalOpen))
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 w-full max-w-md shadow-2xl border border-slate-200 dark:border-slate-700 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-700 pb-3">
                    <h3 class="text-base font-black text-slate-900 dark:text-white">
                        {{ $t('إنشاء حساب وتوليد بيانات الدخول','Créer un compte','Create New Account') }}
                    </h3>
                    <button wire:click="$set('createModalOpen', false)" class="text-slate-400 hover:text-slate-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>
                <div class="space-y-3 text-xs font-semibold">
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">{{ $t('الاسم الكامل / الجهة *','Nom complet / Entité *','Full Name / Entity *') }}</label>
                        <input wire:model="create_name" type="text"
                               placeholder="{{ $t('مثال: مسؤول الوفد الجزائري','Ex: Admin Délégation Algérie','Ex: Algerian Delegation Admin') }}"
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white font-bold">
                    </div>
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">{{ $t('البريد الإلكتروني الرسمي *','Email officiel *','Official Email *') }}</label>
                        <input wire:model="create_email" type="email" placeholder="official@worldskills.dz"
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white font-bold">
                    </div>
                    <div>
                        <label class="block text-slate-700 dark:text-slate-300 font-bold mb-1">{{ $t('نوع الحساب والصلاحية *','Type de compte *','Account Type *') }}</label>
                        <select wire:model="create_role" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white font-bold">
                            <option value="COUNTRY_ADMIN">{{ $t('مسؤول وفد دولة فقط','Chef Délégation Pays','Country Admin') }}</option>
                            <option value="MEDIA_MANAGER">{{ $t('أدمن مسؤول الإعلام والتغطية','Responsable Média','Media Manager') }}</option>
                            <option value="SUPER_ADMIN">{{ $t('أدمن مسؤول المنصة كاملة','Super Admin','Platform Master Admin') }}</option>
                        </select>
                    </div>
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label class="block text-slate-700 dark:text-slate-300 font-bold">{{ $t('كلمة السر *','Mot de passe *','Password *') }}</label>
                            <button type="button" wire:click="generateNewPassword" class="text-[10px] text-blue-600 hover:underline font-bold">
                                {{ $t('توليد كلمة سر عشوائية','Générer aléatoirement','Generate Random') }}
                            </button>
                        </div>
                        <input wire:model="create_password" type="text"
                               class="w-full px-3 py-2.5 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-700 text-slate-900 dark:text-white font-mono font-bold text-center text-sm tracking-wider">
                    </div>
                </div>
                <div class="flex items-center justify-end gap-2 pt-3 border-t border-slate-100 dark:border-slate-700">
                    <button wire:click="$set('createModalOpen', false)" class="px-4 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 rounded-xl">
                        {{ $t('إلغاء','Annuler','Cancel') }}
                    </button>
                    <button wire:click="saveUser" class="px-6 py-2.5 text-xs font-black text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-md">
                        {{ $t('حفظ وإنشاء الحساب','Enregistrer','Save & Create') }}
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
