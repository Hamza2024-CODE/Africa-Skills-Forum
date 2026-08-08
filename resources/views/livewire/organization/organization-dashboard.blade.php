<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 tracking-tight">
                {{ $organization?->getLocalized('name') ?? 'المؤسسة التكوينية' }} — {{ app()->getLocale() === 'fr' ? 'Centre d\'Institution' : (app()->getLocale() === 'en' ? 'Training Center Operational Hub' : 'مركز المؤسسة التكوينية والتدريب') }}
            </h1>
            <p class="text-xs font-bold text-slate-500 mt-1">
                {{ app()->getLocale() === 'fr' ? 'Gestion des stagiaires, formateurs et validation des dossiers d\'inscription.' : (app()->getLocale() === 'en' ? 'Manage trainees, instructors, and registration verification.' : 'متابعة المترشحين، المدربين المؤطرين، وجاهزية ملفات المؤسسة التكوينية.') }}
            </p>
        </div>
    </div>

    <!-- KPI Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        <x-dashboard.stat-card 
            :title="app()->getLocale() === 'fr' ? 'Stagiaires Inscrits' : (app()->getLocale() === 'en' ? 'Enrolled Trainees' : 'إجمالي المترشحين المسجلين')" 
            :value="$totalTrainees" 
            :badge="app()->getLocale() === 'fr' ? 'Liste Officielle' : (app()->getLocale() === 'en' ? 'Official Roster' : 'مترشحو المؤسسة')" 
            color="blue" />
        <x-dashboard.stat-card 
            :title="app()->getLocale() === 'fr' ? 'Dossiers Validés' : (app()->getLocale() === 'en' ? 'Approved Dossiers' : 'الملفات المقبولة')" 
            :value="$approvedCount" 
            :badge="app()->getLocale() === 'fr' ? 'Approuvés' : (app()->getLocale() === 'en' ? 'Approved' : 'ملفات معتمدة')" 
            color="emerald" />
        <x-dashboard.stat-card 
            :title="app()->getLocale() === 'fr' ? 'En Cours d\'Étude' : (app()->getLocale() === 'en' ? 'Pending Review' : 'الملفات قيد الدراسة')" 
            :value="$pendingCount" 
            :badge="app()->getLocale() === 'fr' ? 'En Attente' : (app()->getLocale() === 'en' ? 'In Review' : 'قيد التدقيق')" 
            color="amber" />
        <x-dashboard.stat-card 
            :title="app()->getLocale() === 'fr' ? 'Dossiers Non Retenus' : (app()->getLocale() === 'en' ? 'Rejected Submissions' : 'الملفات غير المقبولة')" 
            :value="$rejectedCount" 
            :badge="app()->getLocale() === 'fr' ? 'Rejetés' : (app()->getLocale() === 'en' ? 'Rejected' : 'مرفوضة')" 
            color="rose" />
    </div>

    <!-- Trainees Roster Table -->
    <x-dashboard.data-table 
        :title="app()->getLocale() === 'fr' ? 'Stagiaires & Candidats de l\'Établissement' : (app()->getLocale() === 'en' ? 'Institute Trainees & Candidates' : 'قائمة مترشحي وطالب التكوين التابعين للمؤسسة')"
        :headers="[
            app()->getLocale() === 'fr' ? 'Code Candidat' : (app()->getLocale() === 'en' ? 'Candidate Code' : 'رمز المترشح'),
            app()->getLocale() === 'fr' ? 'Nom et Prénom' : (app()->getLocale() === 'en' ? 'Full Name' : 'الاسم واللقب'),
            app()->getLocale() === 'fr' ? 'NIN / PASSPORT' : (app()->getLocale() === 'en' ? 'NIN / Passport' : 'رقم التعريف / الهوية'),
            app()->getLocale() === 'fr' ? 'Statut Dossier' : (app()->getLocale() === 'en' ? 'Dossier Status' : 'حالة الملف')
        ]">
        @forelse($trainees as $t)
            <tr class="hover:bg-slate-50/80 transition">
                <td class="px-6 py-4 font-black text-slate-900">{{ $t->candidate_code ?? 'CND-'.$t->id }}</td>
                <td class="px-6 py-4 font-bold text-slate-700">{{ $t->first_name_ar }} {{ $t->last_name_ar }}</td>
                <td class="px-6 py-4 font-semibold text-slate-500">{{ $t->nin ? 'NIN-'.$t->nin : 'موثق' }}</td>
                <td class="px-6 py-4">
                    <span class="px-2.5 py-1 rounded-full text-[11px] font-black bg-blue-50 text-blue-700 border border-blue-200">
                        {{ app()->getLocale() === 'fr' ? 'Dossier Conforme' : (app()->getLocale() === 'en' ? 'Dossier Verified' : 'ملف معتمد') }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-xs font-bold text-slate-400">
                    {{ app()->getLocale() === 'fr' ? 'Aucun stagiaire enregistré pour cette institution' : (app()->getLocale() === 'en' ? 'No trainees recorded for this institute' : 'لا يوجد مترشحون مسجلون تحت هذه المؤسسة حالياً') }}
                </td>
            </tr>
        @endforelse
    </x-dashboard.data-table>
</div>
