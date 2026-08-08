<?php

namespace App\Livewire\Admin;

use App\Models\Country;
use App\Models\CountryDelegation;
use App\Models\DelegationMember;
use App\Models\Edition;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminDietaryIndex extends Component
{
    use WithPagination;

    // Filters
    public string $searchQuery = '';
    public string $selectedCountryId = 'ALL';
    public string $selectedRole = 'ALL';
    public string $selectedAllergyFilter = 'ALL';

    // Edit Modal State
    public bool $showEditModal = false;
    public ?int $editingMemberId = null;
    public ?DelegationMember $editingMember = null;

    public array $memberDietaryRequirements = [];
    public string $memberDietaryNotes = '';

    public string $flashMessage = '';

    public function updatingSearchQuery() { $this->resetPage(); }
    public function updatingSelectedCountryId() { $this->resetPage(); }
    public function updatingSelectedRole() { $this->resetPage(); }
    public function updatingSelectedAllergyFilter() { $this->resetPage(); }

    public function openEditModal(int $memberId)
    {
        $member = DelegationMember::with(['delegation.country'])->find($memberId);
        if (!$member) return;

        $this->editingMemberId = $member->id;
        $this->editingMember = $member;
        $this->memberDietaryRequirements = is_array($member->dietary_requirements) ? $member->dietary_requirements : [];
        $this->memberDietaryNotes = $member->dietary_notes ?? '';
        $this->showEditModal = true;
    }

    public function toggleRequirement(string $code)
    {
        if (in_array($code, $this->memberDietaryRequirements)) {
            $this->memberDietaryRequirements = array_values(array_filter(
                $this->memberDietaryRequirements,
                fn($item) => $item !== $code
            ));
        } else {
            $this->memberDietaryRequirements[] = $code;
        }
    }

    public function saveDietaryInfo()
    {
        if (!$this->editingMemberId) return;

        $member = DelegationMember::find($this->editingMemberId);
        if ($member) {
            $member->update([
                'dietary_requirements' => array_values(array_unique($this->memberDietaryRequirements)),
                'dietary_notes'        => trim($this->memberDietaryNotes),
            ]);

            $this->flashMessage = 'تم تحديث البيانات الغذائية والحساسية بنجاح';
        }

        $this->showEditModal = false;
        $this->editingMemberId = null;
        $this->editingMember = null;
    }

    public function render()
    {
        $query = DelegationMember::with(['delegation.country', 'skill', 'user']);

        if (!empty($this->searchQuery)) {
            $s = '%' . trim($this->searchQuery) . '%';
            $query->where(function ($q) use ($s) {
                $q->where('first_name', 'like', $s)
                  ->orWhere('last_name', 'like', $s)
                  ->orWhere('passport_number', 'like', $s)
                  ->orWhere('email', 'like', $s);
            });
        }

        if ($this->selectedCountryId !== 'ALL') {
            $query->whereHas('delegation', function ($q) {
                $q->where('country_id', $this->selectedCountryId);
            });
        }

        if ($this->selectedRole !== 'ALL') {
            $query->where('member_type', $this->selectedRole);
        }

        if ($this->selectedAllergyFilter !== 'ALL') {
            if ($this->selectedAllergyFilter === 'HAS_ALLERGY') {
                $query->where(function ($q) {
                    $q->whereNotNull('dietary_requirements')->orWhereNotNull('dietary_notes');
                });
            } else {
                $query->whereJsonContains('dietary_requirements', $this->selectedAllergyFilter);
            }
        }

        $members = $query->orderBy('first_name')->paginate(15);

        // Global Statistics
        $totalMembers = DelegationMember::count();
        $membersWithAllergiesCount = DelegationMember::where(function ($q) {
            $q->whereNotNull('dietary_requirements')->orWhereNotNull('dietary_notes');
        })->count();

        $allergyBreakdown = [
            'GLUTEN_FREE'     => 0,
            'LACTOSE_FREE'    => 0,
            'NUT_ALLERGY'     => 0,
            'SEAFOOD_ALLERGY' => 0,
            'HALAL_ONLY'      => 0,
            'VEGETARIAN'      => 0,
            'VEGAN'           => 0,
            'DIABETIC'        => 0,
        ];

        $allRaw = DelegationMember::select('dietary_requirements')->get();
        foreach ($allRaw as $m) {
            if (is_array($m->dietary_requirements)) {
                foreach ($m->dietary_requirements as $req) {
                    if (isset($allergyBreakdown[$req])) {
                        $allergyBreakdown[$req]++;
                    }
                }
            }
        }

        $countries = Country::orderBy('name_ar')->get();

        return view('livewire.admin.dietary.index', [
            'members'                   => $members,
            'totalMembers'              => $totalMembers,
            'membersWithAllergiesCount' => $membersWithAllergiesCount,
            'allergyBreakdown'          => $allergyBreakdown,
            'countries'                 => $countries,
        ]);
    }
}
