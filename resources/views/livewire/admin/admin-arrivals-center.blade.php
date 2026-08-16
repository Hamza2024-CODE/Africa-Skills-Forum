@php
$locale = app()->getLocale();
$dir = $locale === 'ar' ? 'rtl' : 'ltr';
$t = fn($ar, $fr, $en) => match($locale) { 'fr' => $fr, 'en' => $en, default => $ar };
@endphp

<div class="space-y-6 font-sans text-slate-900 dark:text-white" dir="{{ $dir }}">
    
    <!-- Header -->
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-[#020A24] via-[#06205C] to-[#0A3580] p-6 border-2 border-amber-400/40 shadow-xl text-white">
        <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="space-y-1.5">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-amber-400/20 border border-amber-400/40 text-amber-300 text-xs font-black">
                    <span>✈️ {{ $t('مركز متابعة تذاكر الطيران والوصول اللوجستي للوفود', 'Centre des Billets de Vol & Arrivées', 'Flight Tickets & Delegation Arrivals Control') }}</span>
                </div>
                <h1 class="text-xl sm:text-2xl font-black text-white">
                    {{ $t('المعاينة والتدقيق المباشر لتذاكر الطيران والمواعيد الرسمية', 'Inspection Directe des Billets de Vol (PDF/Image)', 'Live In-Platform Flight Tickets Inspection & Schedules') }}
                </h1>
                <p class="text-slate-300 text-xs max-w-2xl">
                    {{ $t('تُمكّن هذه اللوحة الإدارة المركزية من معاينة تذاكر الطيران المرفوعة من رؤساء الوفود (ملفات PDF والصور) ومتابعة مواعيد الوصول ورحلات المغادرة.', 'Permet d\'inspecter en direct les billets téléversés (PDF/Image) et de gérer les navettes.', 'Allows central administration to inspect uploaded flight tickets (PDF/Image) and manage logistics.') }}
                </p>
            </div>
            
            <div class="flex items-center gap-2">
                <div class="px-4 py-3 rounded-2xl bg-white/10 border border-white/20 text-center">
                    <span class="text-[10px] text-amber-300 block font-bold">{{ $t('تذاكر مرفوعة', 'Billets joints', 'Tickets Attached') }}</span>
                    <span class="text-2xl font-black text-white font-mono">{{ $totalMembersWithTickets }}</span>
                </div>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-300 text-emerald-900 dark:text-emerald-200 text-xs font-bold flex items-center justify-between gap-2 shadow-sm">
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <span>{{ session('message') }}</span>
            </div>
        </div>
    @endif

    <!-- Toolbar Filters -->
    <div class="bg-white dark:bg-slate-800 p-4 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-3">
        <div class="relative w-full sm:w-80">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="{{ $t('ابحث باسم العضو، رقم الجواز أو رحلة الطيران...', 'Rechercher nom, passeport ou vol...', 'Search name, passport or flight...') }}" class="w-full pl-9 pr-4 py-2.5 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white">
            <svg class="w-4 h-4 text-slate-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>

        <div class="flex flex-wrap items-center gap-2 w-full sm:w-auto">
            <select wire:model.live="filterCountry" class="px-3 py-2 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white">
                <option value="">{{ $t('جميع الدول والوفود', 'Tous les pays', 'All Countries') }}</option>
                @foreach($countries as $c)
                    <option value="{{ $c->id }}">{{ $c->getLocalized('name') }} ({{ $c->iso2 }})</option>
                @endforeach
            </select>

            <select wire:model.live="filterType" class="px-3 py-2 rounded-2xl bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-900 dark:text-white">
                <option value="TICKETS_ONLY">{{ $t('الأعضاء ذوو التذاكر والرحلات المرفوعة 📄✈️', 'Membres avec billets téléversés', 'Members with uploaded tickets') }}</option>
                <option value="ALL">{{ $t('جميع أعضاء الوفود', 'Tous les membres', 'All Members') }}</option>
            </select>
        </div>
    </div>

    <!-- Master Roster Table -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700 shadow-sm overflow-hidden">
        <div class="p-4 border-b border-slate-100 dark:border-slate-700 flex items-center justify-between">
            <h3 class="text-sm font-black text-[#06205C] dark:text-white flex items-center gap-2">
                <span>✈️ {{ $t('كشف تذاكر الطيران ورحلات وصول الوفود', 'Registre des Billets de Vol & Arrivées', 'Delegation Flight Tickets Register') }}</span>
            </h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-start text-xs">
                <thead class="bg-slate-50 dark:bg-slate-900/90 text-slate-500 uppercase font-mono border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="px-4 py-3.5 text-start">{{ $t('عضو الوفد', 'Membre', 'Member') }}</th>
                        <th class="px-4 py-3.5 text-start">{{ $t('الدولة والوفد', 'Pays', 'Country') }}</th>
                        <th class="px-4 py-3.5 text-start">{{ $t('الفئة / الدور', 'Rôle', 'Role') }}</th>
                        <th class="px-4 py-3.5 text-start">{{ $t('رحلة الوصول / المغادرة', 'Vols', 'Flight Nos') }}</th>
                        <th class="px-4 py-3.5 text-center">{{ $t('تذكرة الطيران (PDF / صورة)', 'Billet PDF/Image', 'Flight Ticket File') }}</th>
                        <th class="px-4 py-3.5 text-center">{{ $t('إجراءات الادمن', 'Actions', 'Actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-700 font-bold">
                    @forelse($members as $m)
                        @php
                            $c = $m->delegation?->country;
                        @endphp
                        <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-700/50 transition">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 overflow-hidden shrink-0 flex items-center justify-center font-bold text-slate-500">
                                        @if($m->photo_path)
                                            <img src="{{ str_starts_with($m->photo_path, '/') || str_starts_with($m->photo_path, 'http') ? $m->photo_path : '/storage/' . $m->photo_path }}" class="w-full h-full object-cover">
                                        @else
                                            {{ mb_substr($m->first_name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <span class="text-slate-900 dark:text-white block font-black">{{ $m->first_name }} {{ $m->last_name }}</span>
                                        <span class="text-[10px] text-slate-400 font-mono">Passport: {{ $m->passport_number ?: '—' }}</span>
                                    </div>
                                </div>
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-xl bg-blue-50 dark:bg-blue-950 text-[#0066FF] dark:text-sky-300 border border-blue-100 text-[11px] font-bold">
                                    {{ $c?->getLocalized('name') ?? 'الجزائر' }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-black uppercase bg-slate-100 text-slate-700">
                                    {{ $m->member_type }}
                                </span>
                            </td>

                            <td class="px-4 py-3 font-mono text-[11px]">
                                <span class="text-emerald-700 dark:text-emerald-300 block">🛬 Arr: {{ $m->arrival_flight ?: '—' }}</span>
                                <span class="text-rose-700 dark:text-rose-300 block">🛫 Dep: {{ $m->departure_flight ?: '—' }}</span>
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if($m->flight_ticket_path)
                                    <a href="{{ str_starts_with($m->flight_ticket_path, '/') || str_starts_with($m->flight_ticket_path, 'http') ? $m->flight_ticket_path : '/storage/' . $m->flight_ticket_path }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white text-[11px] font-black shadow-xs transition">
                                        <svg class="w-3.5 h-3.5 text-amber-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>{{ $t('معاينة تذكرة الطيران PDF / صورة', 'Aperçu Billet PDF/Image', 'View Flight Ticket PDF/Image') }} ↗</span>
                                    </a>
                                @else
                                    <span class="text-slate-400 text-[11px] italic">{{ $t('لم ترفع بعد', 'Non téléversé', 'Not Uploaded') }}</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-center">
                                <button wire:click="openTicketModal({{ $m->id }})" class="p-1.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold transition text-[11px]">
                                    🔍 {{ $t('معاينة الملف', 'Inspecter', 'Inspect') }}
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 font-bold">
                                {{ $t('لم يتم العثور على أعضاء مطابقين للبحث', 'Aucun membre trouvé', 'No matching members found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100 dark:border-slate-700">
            {{ $members->links() }}
        </div>
    </div>

    <!-- TICKET INSPECTOR MODAL -->
    @if($ticketModalOpen && $selectedMember)
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-data>
            <div class="bg-white dark:bg-slate-800 rounded-3xl max-w-2xl w-full p-6 space-y-6 shadow-2xl border border-slate-200 dark:border-slate-700">
                <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-700">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-blue-50 text-[#0066FF] flex items-center justify-center font-bold text-lg">✈️</div>
                        <div>
                            <h3 class="text-sm font-black text-[#06205C] dark:text-white">{{ $selectedMember->first_name }} {{ $selectedMember->last_name }}</h3>
                            <span class="text-xs text-slate-500 font-bold">{{ $selectedMember->delegation?->country?->getLocalized('name') }} — {{ $selectedMember->member_type }}</span>
                        </div>
                    </div>
                    <button wire:click="$set('ticketModalOpen', false)" class="text-slate-400 hover:text-slate-600 font-bold text-sm">✕</button>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs font-bold">
                    <div class="bg-slate-50 dark:bg-slate-900 p-3 rounded-2xl space-y-1">
                        <span class="text-slate-400 block text-[10px]">{{ $t('رقم الجواز', 'Passeport', 'Passport') }}</span>
                        <span class="font-mono text-slate-900 dark:text-white">{{ $selectedMember->passport_number ?: '—' }}</span>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-900 p-3 rounded-2xl space-y-1">
                        <span class="text-slate-400 block text-[10px]">{{ $t('رقم التعريف NIN', 'NIN', 'NIN') }}</span>
                        <span class="font-mono text-slate-900 dark:text-white">{{ $selectedMember->nin_number ?: '—' }}</span>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-900 p-3 rounded-2xl space-y-1">
                        <span class="text-slate-400 block text-[10px]">{{ $t('رحلة الوصول', 'Vol Arrivée', 'Arrival Flight') }}</span>
                        <span class="font-mono text-emerald-600">{{ $selectedMember->arrival_flight ?: '—' }}</span>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-900 p-3 rounded-2xl space-y-1">
                        <span class="text-slate-400 block text-[10px]">{{ $t('رحلة المغادرة', 'Vol Départ', 'Departure Flight') }}</span>
                        <span class="font-mono text-rose-600">{{ $selectedMember->departure_flight ?: '—' }}</span>
                    </div>
                </div>

                @if($selectedMember->flight_ticket_path)
                    <div class="p-4 rounded-2xl bg-blue-50 dark:bg-blue-950 border border-blue-200 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-black text-[#06205C] dark:text-sky-300">📄 {{ $t('ملف تذكرة الطيران المرفقة معتمدة', 'Fichier Billet de Vol Joint', 'Attached Flight Ticket File') }}</span>
                            <a href="{{ str_starts_with($selectedMember->flight_ticket_path, '/') || str_starts_with($selectedMember->flight_ticket_path, 'http') ? $selectedMember->flight_ticket_path : '/storage/' . $selectedMember->flight_ticket_path }}" target="_blank" class="px-4 py-2 rounded-xl bg-[#0066FF] hover:bg-[#0052CC] text-white text-xs font-black shadow-md transition flex items-center gap-1.5">
                                <span>{{ $t('فتح ومعاينة المباشر في النافذة (PDF / صورة)', 'Ouvrir en grand PDF/Image', 'Open Ticket PDF/Image') }} ↗</span>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="p-4 rounded-2xl bg-amber-50 text-amber-900 text-xs font-bold text-center">
                        {{ $t('لم يقم رئيس الوفد برفع ملف تذكرة الطيران حتى الآن.', 'Aucun billet n\'a été téléversé pour le moment.', 'No flight ticket uploaded yet by delegation head.') }}
                    </div>
                @endif

                <div class="pt-3 border-t border-slate-100 dark:border-slate-700 flex justify-end">
                    <button wire:click="$set('ticketModalOpen', false)" class="px-5 py-2 rounded-xl bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 font-bold text-xs">
                        {{ $t('إغلاق', 'Fermer', 'Close') }}
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
