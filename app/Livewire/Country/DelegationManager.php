<?php

namespace App\Livewire\Country;

use App\Models\Country;
use App\Models\CountryDelegation;
use App\Models\DelegationMember;
use App\Models\Edition;
use App\Models\Skill;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.dashboard.app-shell')]
class DelegationManager extends Component
{
    public ?Edition $edition = null;
    public ?Country $country = null;
    public ?CountryDelegation $delegation = null;

    // Filters & Search
    public string $searchQuery = '';
    public string $selectedRole = 'ALL';
    public string $selectedStatus = 'ALL';

    // Modal Visibility Flags
    public bool $showAddModal = false;
    public bool $showEditModal = false;
    public bool $showViewModal = false;

    // Active Member for Edit or View
    public ?int $editingMemberId = null;
    public ?DelegationMember $viewingMember = null;

    // Form Fields
    public string $firstName = '';
    public string $lastName = '';
    public string $email = '';
    public string $phone = '';
    public string $memberType = 'PARTICIPANT';
    public ?int $skillId = null;
    public string $passportNumber = '';
    public string $ninNumber = '';
    public string $gender = 'male';
    public string $suitSize = '';
    public string $shoeSize = '';
    public string $status = 'APPROVED';
    public string $rejectionReason = '';

    public string $flashMessage = '';

    protected function rules(): array
    {
        return [
            'firstName'      => 'required|string|min:2',
            'lastName'       => 'required|string|min:2',
            'email'          => 'nullable|email',
            'phone'          => 'nullable|string',
            'memberType'     => 'required|string',
            'skillId'        => 'nullable|exists:skills,id',
            'passportNumber' => 'nullable|string',
            'ninNumber'      => 'nullable|string',
            'gender'         => 'required|string',
            'suitSize'       => 'nullable|string',
            'shoeSize'       => 'nullable|string',
            'status'         => 'required|string',
        ];
    }

    public function mount(?int $targetCountryId = null): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if ($user && $user->country_id) {
            $this->country = Country::find($user->country_id);
        } else {
            $this->country = Country::where('iso2', 'DZ')->first() ?? Country::first();
        }

        $this->edition = Edition::where('is_active', true)->first();

        if ($this->edition && $this->country) {
            $this->delegation = CountryDelegation::firstOrCreate([
                'edition_id' => $this->edition->id,
                'country_id' => $this->country->id,
            ]);
        }

        // Dedicated Role Pages Routing Logic
        if (request()->routeIs('country.participants')) {
            $this->selectedRole = 'PARTICIPANT';
            $this->memberType   = 'PARTICIPANT';
        } elseif (request()->routeIs('country.judges')) {
            $this->selectedRole = 'JUDGE';
            $this->memberType   = 'JUDGE';
        } elseif (request()->routeIs('country.press')) {
            $this->selectedRole = 'PRESS';
            $this->memberType   = 'PRESS';
        } elseif (request()->routeIs('country.supervisors')) {
            $this->selectedRole = 'SUPERVISOR';
            $this->memberType   = 'SUPERVISOR';
        } elseif (request()->routeIs('country.vips')) {
            $this->selectedRole = 'VIP';
            $this->memberType   = 'VIP';
        }
    }

    public function openAddModal(): void
    {
        $this->resetInputFields();
        $this->showAddModal = true;
    }

    public function addMember(): void
    {
        $this->validate();

        if (!$this->delegation) return;

        /** @var \App\Services\DocumentVerificationService $docVerifier */
        $docVerifier = app(\App\Services\DocumentVerificationService::class);

        // Strict Uniqueness Check for Email, Phone, NIN, and Passport
        $check = $docVerifier->checkIdentityUniqueness(
            $this->ninNumber,
            $this->passportNumber,
            $this->email,
            $this->phone
        );

        if (!$check['is_valid']) {
            foreach ($check['errors'] as $field => $msg) {
                if ($field === 'email') $this->addError('email', $msg);
                if ($field === 'phone') $this->addError('phone', $msg);
                if ($field === 'nin') $this->addError('ninNumber', $msg);
                if ($field === 'passport') $this->addError('passportNumber', $msg);
            }
            return;
        }

        DelegationMember::create([
            'delegation_id'    => $this->delegation->id,
            'member_type'      => $this->memberType,
            'skill_id'         => $this->skillId,
            'first_name'       => $this->firstName,
            'last_name'        => $this->lastName,
            'email'            => $this->email,
            'phone'            => $this->phone,
            'passport_number'  => $this->passportNumber,
            'nin_number'       => $this->ninNumber,
            'gender'           => $this->gender,
            'suit_size'        => $this->suitSize,
            'shoe_size'        => $this->shoeSize,
            'status'           => $this->status,
            'rejection_reason' => $this->status === 'REJECTED' ? $this->rejectionReason : null,
        ]);

        $this->resetInputFields();
        $this->showAddModal = false;
        $this->flashMessage = __('messages.success') ?? 'تمت إضافة العضو بنجاح إلى الوفد.';
    }

    public function editMember(int $memberId): void
    {
        $member = DelegationMember::find($memberId);
        if (!$member) return;

        $this->editingMemberId = $member->id;
        $this->firstName       = $member->first_name;
        $this->lastName        = $member->last_name;
        $this->email           = $member->email ?? '';
        $this->phone           = $member->phone ?? '';
        $this->memberType      = $member->member_type;
        $this->skillId         = $member->skill_id;
        $this->passportNumber  = $member->passport_number ?? '';
        $this->ninNumber       = $member->nin_number ?? '';
        $this->gender          = $member->gender ?? 'male';
        $this->suitSize        = $member->suit_size ?? '';
        $this->shoeSize        = $member->shoe_size ?? '';
        $this->status          = $member->status ?? 'APPROVED';
        $this->rejectionReason = $member->rejection_reason ?? '';

        $this->showEditModal = true;
    }

    public function updateMember(): void
    {
        $this->validate();

        $member = DelegationMember::find($this->editingMemberId);
        if (!$member) return;

        /** @var \App\Services\DocumentVerificationService $docVerifier */
        $docVerifier = app(\App\Services\DocumentVerificationService::class);

        // Strict Uniqueness Check for Email, Phone, NIN, and Passport
        $check = $docVerifier->checkIdentityUniqueness(
            $this->ninNumber,
            $this->passportNumber,
            $this->email,
            $this->phone,
            $this->editingMemberId
        );

        if (!$check['is_valid']) {
            foreach ($check['errors'] as $field => $msg) {
                if ($field === 'email') $this->addError('email', $msg);
                if ($field === 'phone') $this->addError('phone', $msg);
                if ($field === 'nin') $this->addError('ninNumber', $msg);
                if ($field === 'passport') $this->addError('passportNumber', $msg);
            }
            return;
        }

        $member->update([
            'member_type'      => $this->memberType,
            'skill_id'         => $this->skillId,
            'first_name'       => $this->firstName,
            'last_name'        => $this->lastName,
            'email'            => $this->email,
            'phone'            => $this->phone,
            'passport_number'  => $this->passportNumber,
            'nin_number'       => $this->ninNumber,
            'gender'           => $this->gender,
            'suit_size'        => $this->suitSize,
            'shoe_size'        => $this->shoeSize,
            'status'           => $this->status,
            'rejection_reason' => $this->status === 'REJECTED' ? $this->rejectionReason : null,
        ]);

        $this->showEditModal = false;
        $this->resetInputFields();
        $this->flashMessage = 'تم تعديل وتحديث بيانات عضو الوفد بنجاح.';
    }

    public function viewMemberDetails(int $memberId): void
    {
        $this->viewingMember = DelegationMember::with(['skill', 'delegation.country'])->find($memberId);
        if ($this->viewingMember) {
            $this->showViewModal = true;
        }
    }

    public function approveMember(int $memberId): void
    {
        $member = DelegationMember::find($memberId);
        if ($member) {
            $member->update([
                'status'           => 'APPROVED',
                'rejection_reason' => null,
            ]);
            $this->flashMessage = 'تم اعتماد وتثبيت عضو الوفد بنجاح.';
        }
    }

    public function rejectMember(int $memberId): void
    {
        $member = DelegationMember::find($memberId);
        if ($member) {
            $member->update([
                'status' => 'REJECTED',
            ]);
            $this->flashMessage = 'تم تغيير حالة العضو إلى مرفوض.';
        }
    }

    public function removeMember(int $memberId): void
    {
        DelegationMember::where('id', $memberId)->delete();
        $this->flashMessage = 'تم إزالة العضو من الوفد بنجاح.';
    }

    private function resetInputFields(): void
    {
        $this->editingMemberId = null;
        $this->firstName       = '';
        $this->lastName        = '';
        $this->email           = '';
        $this->phone           = '';
        $this->memberType      = $this->selectedRole !== 'ALL' ? $this->selectedRole : 'PARTICIPANT';
        $this->skillId         = null;
        $this->passportNumber  = '';
        $this->ninNumber       = '';
        $this->gender          = 'male';
        $this->suitSize        = '';
        $this->shoeSize        = '';
        $this->status          = 'APPROVED';
        $this->rejectionReason = '';
    }

    public function render()
    {
        $query = $this->delegation ? $this->delegation->members()->with('skill') : DelegationMember::query()->whereRaw('1=0');

        if ($this->selectedRole !== 'ALL') {
            $query->where('member_type', $this->selectedRole);
        }

        if ($this->selectedStatus !== 'ALL') {
            $query->where('status', $this->selectedStatus);
        }

        if (!empty($this->searchQuery)) {
            $s = '%' . $this->searchQuery . '%';
            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'like', $s)
                  ->orWhere('last_name', 'like', $s)
                  ->orWhere('passport_number', 'like', $s)
                  ->orWhere('nin_number', 'like', $s)
                  ->orWhere('email', 'like', $s);
            });
        }

        $members = $query->orderBy('id', 'desc')->get();
        $skills = Skill::where('is_active', true)->orderBy('sort_order')->get();

        return view('livewire.country.delegation-manager', [
            'members' => $members,
            'skills'  => $skills,
        ]);
    }
}
