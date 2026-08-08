<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use App\Models\Edition;
use App\Models\Organization;
use App\Models\Registration;
use App\Models\Skill;
use App\Models\User;
use App\Models\Wilaya;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class AdminReportsIndex extends Component
{
    public function render()
    {
        return view('livewire.admin.reports.index', [
            'totalUsers'        => User::count(),
            'totalRegistrations'=> Registration::count(),
            'approvedRegs'      => Registration::where('status', 'APPROVED')->count(),
            'pendingRegs'       => Registration::where('status', 'PENDING')->count(),
            'rejectedRegs'      => Registration::where('status', 'REJECTED')->count(),
            'totalSkills'       => Skill::count(),
            'totalWilayas'      => Wilaya::count(),
            'totalCountries'    => Country::count(),
            'totalOrgs'         => Organization::count(),
            'totalEditions'     => Edition::count(),
            'topWilayas'        => Wilaya::withCount('registrations')->orderByDesc('registrations_count')->take(5)->get(),
            'topSkills'         => Skill::withCount('registrations')->orderByDesc('registrations_count')->take(5)->get(),
        ]);
    }
}
