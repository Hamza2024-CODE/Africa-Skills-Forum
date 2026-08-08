<?php

namespace App\Livewire\Organization;

use App\Models\Organization;
use App\Models\ParticipantProfile;
use App\Models\Registration;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class OrganizationDashboard extends Component
{
    public $organization;
    public $totalTrainees = 0;
    public $approvedCount = 0;
    public $pendingCount = 0;
    public $rejectedCount = 0;

    public function mount(?int $targetOrgId = null)
    {
        $user = Auth::user();

        // Strict IDOR Scoping: User can ONLY access their own organization
        if ($user && $user->organization_id) {
            if ($targetOrgId && $targetOrgId !== $user->organization_id && !$user->hasRole('SUPER_ADMIN')) {
                throw new AuthorizationException('Cross-organization IDOR access denied.');
            }
            $this->organization = Organization::find($user->organization_id);
        } else {
            $this->organization = Organization::where('is_active', true)->first();
        }

        if ($this->organization) {
            $profiles = ParticipantProfile::where('organization_id', $this->organization->id)->get();
            $this->totalTrainees = $profiles->count();

            $profileIds = $profiles->pluck('id')->toArray();
            $registrations = Registration::whereIn('participant_profile_id', $profileIds)->get();

            $this->approvedCount = $registrations->where('status', 'APPROVED')->count();
            $this->pendingCount = $registrations->whereIn('status', ['SUBMITTED', 'DRAFT'])->count();
            $this->rejectedCount = $registrations->where('status', 'REJECTED')->count();
        }
    }

    public function render()
    {
        $trainees = $this->organization
            ? ParticipantProfile::where('organization_id', $this->organization->id)->take(10)->get()
            : collect();

        return view('livewire.organization.organization-dashboard', [
            'trainees' => $trainees
        ]);
    }
}
