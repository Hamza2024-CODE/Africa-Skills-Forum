@php
    $locale = app()->getLocale();
    $t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-6 pb-12 font-sans" dir="{{ $locale === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- HEADER BANNER --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-[#06205C] text-white p-6 rounded-3xl shadow-xl relative overflow-hidden">
        <div class="space-y-1 relative z-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-300 text-[11px] font-black tracking-wider uppercase border border-emerald-400/30">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>WSAP V8.4 — SUPER ADMIN COMMAND CENTER</span>
            </div>
            <h1 class="text-2xl font-black text-white">
                {{ $t('لوحة القيادة والإدارة العليا للمنصة', 'Tableau de Bord Super Admin', 'Super Admin Command Dashboard') }}
            </h1>
            <p class="text-xs text-blue-100/80 font-medium">
                {{ $t('المنظومة المركزية لإدارة وتأطير أولمبياد المهن الجزائرية، الوفود الوطنية، والتخصصات الأولمبية.', 'Système centralisé de gestion des Olympiades des Métiers et des délégations.', 'Centralized management system for Vocational Skills Olympics and national delegations.') }}
            </p>
        </div>

        <div class="flex items-center gap-3 relative z-10">
            <a href="{{ route('admin.operations') }}" class="px-5 py-2.5 rounded-2xl bg-emerald-500 hover:bg-emerald-600 text-white font-black text-xs transition shadow-lg flex items-center gap-2 border border-emerald-400/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                <span>{{ $t('غرفة العمليات الميدانية المباشرة', 'Centre des Opérations en Direct', 'Live Operations Center') }}</span>
            </a>
        </div>
    </div>

    {{-- SYSTEM KPIs GRID --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">{{ $t('إجمالي الحسابات المسجلة', 'Total des Comptes Registrés', 'Total Registered Accounts') }}</div>
                <div class="text-2xl font-black text-slate-900 font-mono">{{ number_format($totalUsers) }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">{{ $t('التسجيلات المعتمدة', 'Inscriptions Approuvées', 'Approved Registrations') }}</div>
                <div class="text-2xl font-black text-emerald-600 font-mono">{{ number_format($approvedRegistrations) }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">{{ $t('الوفود والدول المشاركة', 'Délégations & Pays', 'Delegations & Countries') }}</div>
                <div class="text-2xl font-black text-slate-900 font-mono">{{ number_format($totalCountries) }}</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
            </div>
            <div>
                <div class="text-xs text-slate-500 font-bold">{{ $t('التخصصات الأولمبية', 'Compétitions & Métiers', 'Skills & Competitions') }}</div>
                <div class="text-2xl font-black text-amber-600 font-mono">{{ number_format($totalSkills) }}</div>
            </div>
        </div>
    </div>

    {{-- QUICK OPERATIONAL MODULES CARDS --}}
    <div class="space-y-3">
        <h3 class="text-base font-black text-[#06205C]">
            {{ $t('الوحدات والأنظمة التشغيلية السريعة', 'Modules Opérationnels Rapides', 'Quick Operational Modules') }}
        </h3>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs font-bold">
            <a href="{{ route('admin.operations') }}" class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div>
                    <h4 class="font-black text-slate-900 text-sm">{{ $t('غرفة العمليات الميدانية', 'Centre des Opérations', 'Live Operations Center') }}</h4>
                    <p class="text-[11px] text-slate-500">{{ $t('بث حي لعمليات المسح، المطاعم، السكن والنقل.', 'Suivi en direct des accès, hébergement et transport.', 'Live telemetry for access, catering, and transport.') }}</p>
                </div>
            </a>

            <a href="{{ route('admin.schedule.index') }}" class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h4 class="font-black text-slate-900 text-sm">{{ $t('محرك الجدولة الميداني', 'Gestionnaire de Planning', 'Field Schedule Engine') }}</h4>
                    <p class="text-[11px] text-slate-500">{{ $t('إدارة تقويم الأحداث، الجولات والاجتماعات.', 'Gestion du calendrier des événements et réunions.', 'Manage event calendar, tours, and meetings.') }}</p>
                </div>
            </a>

            <a href="{{ route('admin.notifications.index') }}" class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                </div>
                <div>
                    <h4 class="font-black text-slate-900 text-sm">{{ $t('مركز التواصل والتنبيهات', 'Notifications & Broadcast', 'Broadcast & Notifications') }}</h4>
                    <p class="text-[11px] text-slate-500">{{ $t('إرسال التنبيهات الموجهة وتحليلات التسليم.', 'Diffusion d\'alertes et notifications ciblées.', 'Send targeted alerts and delivery analytics.') }}</p>
                </div>
            </a>

            <a href="{{ route('admin.scanner') }}" class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                </div>
                <div>
                    <h4 class="font-black text-slate-900 text-sm">{{ $t('الماسح الموحد للشارات', 'Scanner QR Universel', 'Unified Badge QR Scanner') }}</h4>
                    <p class="text-[11px] text-slate-500">{{ $t('فحص وتفكيك الـ QR لجميع كواد المنصة.', 'Contrôle et vérification instantanée des badges.', 'Instant QR badge verification and access check.') }}</p>
                </div>
            </a>

            <a href="{{ route('admin.accreditations') }}" class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5z"/></svg>
                </div>
                <div>
                    <h4 class="font-black text-slate-900 text-sm">{{ $t('مركز الاعتمادات والشارات', 'Centre d\'Accréditation', 'Accreditation & Badge Hub') }}</h4>
                    <p class="text-[11px] text-slate-500">{{ $t('تصميم وطباعة الشارات PVC الفردية والجماعية.', 'Conception et impression de badges PVC 3D.', 'Design and print 3D PVC physical badges.') }}</p>
                </div>
            </a>

            <a href="{{ route('admin.live-tv') }}" class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <h4 class="font-black text-slate-900 text-sm">{{ $t('إعداد البث المباشر والشاشات', 'Gestion Live TV & Écrans', 'Live TV Broadcast & Screens') }}</h4>
                    <p class="text-[11px] text-slate-500">{{ $t('تعديل رابط البث الحي، الشريط الإخباري والشرائح.', 'Gestion du flux vidéo en direct et annonces.', 'Manage live video feeds, slides, and tickers.') }}</p>
                </div>
            </a>

            <a href="{{ route('admin.restaurants') }}" class="p-5 rounded-3xl bg-white border border-slate-200/80 shadow-sm hover:shadow-md transition flex items-center gap-4">
                <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                </div>
                <div>
                    <h4 class="font-black text-slate-900 text-sm">{{ $t('إدارة المطاعم واللوجستيك', 'Restauration & Logistique', 'Catering & Logistics Hub') }}</h4>
                    <p class="text-[11px] text-slate-500">{{ $t('إدارة المطاعم، خانات الوجبات، وتوزيع السكن.', 'Gestion de la restauration et de l\'hébergement.', 'Manage restaurants, meal slots, and housing.') }}</p>
                </div>
            </a>
        </div>
    </div>

    {{-- RECENT REGISTRATIONS TABLE --}}
    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-md p-6 space-y-4">
        <div class="flex items-center justify-between">
            <h3 class="text-base font-black text-[#06205C]">
                {{ $t('أحدث تسجيلات المشاركين بالمنصة', 'Inscriptions Récentes', 'Recent Candidate Registrations') }}
            </h3>
            <a href="{{ route('admin.registrations') }}" class="text-xs font-bold text-emerald-600 hover:underline">
                {{ $t('عرض كافة التسجيلات ←', 'Voir toutes les inscriptions →', 'View all registrations →') }}
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="bg-slate-50 text-[11px] font-black uppercase text-slate-500 border-b border-slate-200">
                        <th class="px-4 py-3 text-start">{{ $t('المستخدم', 'Utilisateur', 'User') }}</th>
                        <th class="px-4 py-3 text-start">{{ $t('التخصص الأولمبي', 'Spécialité / Métier', 'Specialization / Skill') }}</th>
                        <th class="px-4 py-3 text-start">{{ $t('الوفد / الدولة', 'Pays / Délégation', 'Country / Delegation') }}</th>
                        <th class="px-4 py-3 text-start">{{ $t('الحالة', 'Statut', 'Status') }}</th>
                        <th class="px-4 py-3 text-end">{{ $t('التاريخ', 'Date', 'Date') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 font-semibold">
                    @forelse($recentRegistrations as $reg)
                    <tr>
                        <td class="px-4 py-3 text-slate-900 font-bold">{{ $reg->user?->name ?: $t('مشارك', 'Participant', 'Participant') }}</td>
                        <td class="px-4 py-3 text-indigo-700 font-bold">{{ $reg->skill?->getLocalized('name') ?: '—' }}</td>
                        <td class="px-4 py-3 text-emerald-700 font-bold">{{ $reg->country?->name_ar ?: 'الجزائر' }}</td>
                        <td class="px-4 py-3">
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-black border {{ $reg->status === 'APPROVED' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 'bg-amber-100 text-amber-800 border-amber-200' }}">
                                {{ $reg->status === 'APPROVED' ? $t('مقبول ومعتمد', 'Approuvé', 'Approved') : $t('قيد الدراسة', 'En attente', 'Pending Review') }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-end font-mono text-slate-400">{{ $reg->created_at->format('Y-m-d') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-slate-400 font-bold">
                            {{ $t('لا توجد تسجيلات حديثة.', 'Aucune inscription récente.', 'No recent registrations.') }}
                        </td>
                    </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
