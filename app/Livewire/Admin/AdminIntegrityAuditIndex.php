<?php

namespace App\Livewire\Admin;

use App\Models\Certificate;
use App\Models\Badge;
use App\Models\TechnicalAppeal;
use App\Models\CompetitionResult;
use App\Models\ParticipantScore;
use App\Models\AppNotification;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class AdminIntegrityAuditIndex extends Component
{
    public string $search = '';
    public string $filterEvent = '';

    public function render()
    {
        // Aggregate governance events from all governance tables as a unified integrity timeline
        $events = collect();

        // Certificates issued/revoked
        Certificate::with('user')->latest('issued_at')->take(30)->get()->each(function ($cert) use (&$events) {
            $events->push([
                'time'   => $cert->issued_at,
                'type'   => 'CERTIFICATE_' . $cert->status,
                'label'  => "شهادة {$cert->certificate_type} — الحالة: {$cert->status}",
                'actor'  => $cert->user?->name ?? '—',
                'color'  => $cert->status === 'VALID' ? 'green' : 'red',
            ]);
        });

        // Appeals
        TechnicalAppeal::with('submittedBy')->latest('submitted_at')->take(20)->get()->each(function ($appeal) use (&$events) {
            $events->push([
                'time'   => $appeal->submitted_at,
                'type'   => 'APPEAL_' . $appeal->status,
                'label'  => "طعن فني: {$appeal->subject} — الحالة: {$appeal->status}",
                'actor'  => $appeal->submittedBy?->name ?? '—',
                'color'  => 'amber',
            ]);
        });

        // Competition results published
        CompetitionResult::with(['registration.participant', 'skill'])->where('is_published', true)
            ->latest()->take(20)->get()->each(function ($result) use (&$events) {
                $events->push([
                    'time'   => $result->updated_at,
                    'type'   => 'RESULT_PUBLISHED',
                    'label'  => "نتيجة منشورة — {$result->skill?->name_ar} — {$result->award} (#{$result->rank})",
                    'actor'  => '—',
                    'color'  => 'blue',
                ]);
            });

        // Badges issued
        Badge::with('user')->latest()->take(20)->get()->each(function ($badge) use (&$events) {
            $events->push([
                'time'   => $badge->created_at,
                'type'   => 'BADGE_ISSUED',
                'label'  => "بطاقة اعتماد: {$badge->role_title} — {$badge->status}",
                'actor'  => $badge->user?->name ?? '—',
                'color'  => 'indigo',
            ]);
        });

        $events = $events->sortByDesc('time')->values()->take(50);

        return view('livewire.admin.integrity.index', [
            'events'          => $events,
            'totalCerts'      => Certificate::count(),
            'totalBadges'     => Badge::count(),
            'openAppeals'     => TechnicalAppeal::whereNotIn('status', ['CLOSED'])->count(),
            'publishedResults'=> CompetitionResult::where('is_published', true)->count(),
        ]);
    }
}
