<?php

namespace App\Livewire\Admin;

use App\Models\AuditLog;
use App\Models\Certificate;
use App\Models\Country;
use App\Models\Edition;
use App\Models\Organization;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\User;
use App\Models\WsapNotification;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class SuperAdminDashboard extends Component
{
    public string $activeTab = 'overview';

    public function setTab(string $tab): void
    {
        $validTabs = ['overview', 'accreditations_delegations', 'users_access', 'cms_media', 'security_governance'];
        if (in_array($tab, $validTabs, true)) {
            $this->activeTab = $tab;
        }
    }

    public function render()
    {
        $recentUsers = User::with(['roles', 'country'])
            ->latest()
            ->take(8)
            ->get();

        $recentRegistrations = Registration::with(['skill', 'country', 'user'])
            ->latest()
            ->take(6)
            ->get();

        $recentAuditLogs = AuditLog::latest()
            ->take(5)
            ->get();

        $recentDiplomaticMeetings = \App\Models\DiplomaticMeeting::with(['hostMinister.country', 'guestMinister.country', 'room'])
            ->where('status', '!=', 'CANCELLED')
            ->orderBy('start_time', 'asc')
            ->take(4)
            ->get();

        $settings = app(\App\Services\SettingsEngine::class);

        return view('livewire.admin.super-admin-dashboard', [
            'totalUsers'                => User::count(),
            'totalParticipants'         => ParticipantProfile::count(),
            'totalRegistrations'        => Registration::count(),
            'pendingRegistrations'      => Registration::where('status', 'PENDING')->count(),
            'approvedRegistrations'     => Registration::where('status', 'APPROVED')->count(),
            'totalCountries'            => Country::count(),
            'totalSkills'               => Skill::count(),
            'totalOrganizations'        => Organization::count(),
            'totalEditions'             => Edition::count(),
            'issuedCertificates'        => Certificate::count(),
            'totalMinisters'            => \App\Models\MinisterialOfficial::count(),
            'availableMinisters'        => \App\Models\MinisterialOfficial::where('availability_status', 'AVAILABLE')->count(),
            'todayDiplomaticMeetings'   => \App\Models\DiplomaticMeeting::whereDate('start_time', now()->toDateString())->count(),
            'recentUsers'               => $recentUsers,
            'recentRegistrations'       => $recentRegistrations,
            'recentAuditLogs'           => $recentAuditLogs,
            'recentDiplomaticMeetings'  => $recentDiplomaticMeetings,
            'activeEdition'             => Edition::where('is_active', true)->first(),
            'systemHealth'              => ['score' => '99.9%'],
            'activeTab'                 => $this->activeTab,
            'countdownEnabled'          => filter_var($settings->get('countdown_enabled', true), FILTER_VALIDATE_BOOLEAN),
            'showPartnersSection'       => filter_var($settings->get('show_partners_section', true), FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}

