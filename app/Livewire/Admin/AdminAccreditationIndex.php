<?php

namespace App\Livewire\Admin;

use App\Enums\RoleEnum;
use App\Models\AccreditationZone;
use App\Models\Badge;
use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.dashboard.app-shell')]
class AdminAccreditationIndex extends Component
{
    use WithPagination;

    public string $search        = '';
    public string $filterRole    = '';
    public string $filterCountry = '';
    public bool   $formOpen      = false;

    // Checkbox multi-selection
    public array  $selectedUsers = [];
    public bool   $selectAll     = false;

    // Badge form
    public int    $user_id_badge   = 0;
    public string $role_title      = 'COMPETITOR';
    public array  $selected_zones  = [];
    public string $valid_until     = '';

    protected array $rules = [
        'user_id_badge' => 'required|integer|min:1',
        'role_title'    => 'required|string',
    ];

    public function updatedSelectAll(bool $value): void
    {
        if ($value) {
            $this->selectedUsers = $this->getFilteredUsersQuery()->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            $this->selectedUsers = [];
        }
    }

    public function openCreate(): void
    {
        $this->reset(['user_id_badge', 'role_title', 'selected_zones', 'valid_until']);
        $this->role_title = 'COMPETITOR';
        $this->formOpen   = true;
    }

    public function issue(): void
    {
        $this->validate();

        Badge::updateOrCreate(
            ['user_id' => $this->user_id_badge],
            [
                'badge_uuid'       => (string) Str::uuid(),
                'access_token'     => Str::random(32),
                'role_title'       => $this->role_title,
                'allowed_zone_ids' => $this->selected_zones,
                'status'           => 'ACTIVE',
                'valid_until'      => $this->valid_until ?: null,
            ]
        );

        $this->formOpen = false;
        session()->flash('success', 'تم إصدار بطاقة الاعتماد بنجاح.');
    }

    public function blockBadge(int $id): void
    {
        Badge::findOrFail($id)->update(['status' => 'BLOCKED']);
        session()->flash('success', 'تم تعطيل البطاقة.');
    }

    private function getFilteredUsersQuery()
    {
        return User::with([
            'roles',
            'country',
            'organization',
            'wilaya',
            'participant.registrations.skill',
            'badges'
        ])
        ->where('is_active', true)
        ->when($this->search, function ($q) {
            $s = '%' . $this->search . '%';
            $q->where(function ($sub) use ($s) {
                $sub->where('name', 'like', $s)
                    ->orWhere('email', 'like', $s)
                    ->orWhereHas('participant', fn($p) =>
                        $p->where('first_name_ar', 'like', $s)
                          ->orWhere('last_name_ar', 'like', $s)
                          ->orWhere('first_name_latin', 'like', $s)
                          ->orWhere('last_name_latin', 'like', $s)
                          ->orWhereHas('registrations', fn($r) => $r->where('registration_number', 'like', $s))
                    )
                    ->orWhereHas('country', fn($c) => $c->where('name_ar', 'like', $s)->orWhere('name_en', 'like', $s));
            });
        })
        ->when($this->filterRole, function ($q) {
            $roleMap = [
                'COMPETITOR'      => [RoleEnum::PARTICIPANT->value],
                'DELEGATION HEAD' => [RoleEnum::COUNTRY_ADMIN->value],
                'EXPERT JUDGE'    => [RoleEnum::JUDGE->value],
                'MEDIA'           => [RoleEnum::MEDIA_MANAGER->value],
                'VIP'             => [RoleEnum::EXECUTIVE_VIEWER->value],
                'ORGANIZER'       => [RoleEnum::ORGANIZATION_ADMIN->value, RoleEnum::SUPER_ADMIN->value],
            ];

            if (isset($roleMap[$this->filterRole])) {
                $q->whereHas('roles', fn($r) => $r->whereIn('name', $roleMap[$this->filterRole]));
            } else {
                $q->whereHas('badges', fn($b) => $b->where('role_title', $this->filterRole));
            }
        })
        ->when($this->filterCountry, function ($q) {
            $q->where('country_id', $this->filterCountry)
              ->orWhereHas('participant.registrations', fn($r) => $r->where('country_id', $this->filterCountry));
        });
    }

    public function render()
    {
        $users = $this->getFilteredUsersQuery()->orderByDesc('created_at')->paginate(12);

        return view('livewire.admin.accreditations.index', [
            'users'        => $users,
            'allUsers'     => User::orderBy('name')->get(),
            'countries'    => Country::orderBy('name_ar')->get(),
            'badges'       => Badge::with('user')->orderByDesc('created_at')->take(10)->get(),
            'zones'        => AccreditationZone::all(),
            'totalBadges'  => User::where('is_active', true)->count(),
            'activeBadges' => User::where('is_active', true)->count(),
        ]);
    }
}
