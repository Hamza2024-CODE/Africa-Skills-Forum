<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

#[Layout('components.dashboard.app-shell')]
class AdminUserIndex extends Component
{
    use WithPagination;

    public string $search       = '';
    public string $filterRole   = '';
    public string $filterStatus = '';

    // Detail Drawer
    public bool   $drawerOpen   = false;
    public ?int   $selectedId   = null;
    public ?User  $selectedUser = null;

    // Edit Role Modal
    public bool   $roleModalOpen = false;
    public string $newRole       = '';

    // Create User Modal
    public bool   $createModalOpen = false;
    public string $create_name     = '';
    public string $create_email    = '';
    public string $create_role     = 'COUNTRY_ADMIN';
    public string $create_password = '';

    // Delete User Modal
    public bool   $deleteConfirmOpen = false;
    public ?int   $deleteTargetId    = null;

    // Official Registration Status
    public bool $officialRegistrationOpen = true;

    protected $queryString = ['search', 'filterRole', 'filterStatus'];

    public function mount(): void
    {
        $status = \App\Models\GlobalSetting::getByKey('official_registration_open', '0');
        $this->officialRegistrationOpen = ($status === '1');
    }

    public function toggleOfficialRegistration(): void
    {
        $current = \App\Models\GlobalSetting::getByKey('official_registration_open', '0');
        $newStatus = ($current === '1') ? '0' : '1';
        \App\Models\GlobalSetting::setByKey('official_registration_open', $newStatus);
        \App\Models\GlobalSetting::setByKey('public_registration_open', $newStatus);
        $this->officialRegistrationOpen = ($newStatus === '1');
        session()->flash('success', $newStatus === '1' ? 'تم فتح وتفعيل جميع بوابات التسجيل المباشرة.' : 'تم توقيف وإغلاق جميع بوابات التسجيل المباشرة بالكامل في المنصة.');
    }

    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingFilterRole(): void   { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function openDrawer(int $userId): void
    {
        $this->selectedId   = $userId;
        $this->selectedUser = User::with('roles')->find($userId);
        $this->drawerOpen   = true;
    }

    public function closeDrawer(): void
    {
        $this->drawerOpen   = false;
        $this->selectedUser = null;
        $this->selectedId   = null;
    }

    public function openRoleModal(int $userId): void
    {
        $this->selectedId     = $userId;
        $this->selectedUser   = User::with('roles')->find($userId);
        $this->newRole        = $this->selectedUser->roles->first()?->name ?? '';
        $this->roleModalOpen  = true;
    }

    public function saveRole(): void
    {
        $user = User::findOrFail($this->selectedId);
        $user->syncRoles([$this->newRole]);
        $this->roleModalOpen = false;
        session()->flash('success', 'تم تحديث الدور بنجاح.');
    }

    /* ─── Create User Modal (Delegation / Judge / Media / Staff) ─── */
    public function openCreateModal(): void
    {
        $this->reset(['create_name', 'create_email', 'create_role', 'create_password']);
        $this->create_role     = 'COUNTRY_ADMIN';
        $this->create_password = Str::random(10);
        $this->createModalOpen = true;
    }

    public function generateNewPassword(): void
    {
        $this->create_password = Str::random(10);
    }

    public function saveUser(): void
    {
        $this->validate([
            'create_name'     => 'required|string|max:200',
            'create_email'    => 'required|email|unique:users,email',
            'create_role'     => 'required|string',
            'create_password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'uuid'      => (string) Str::uuid(),
            'name'      => $this->create_name,
            'email'     => $this->create_email,
            'password'  => Hash::make($this->create_password),
            'is_active' => true,
        ]);

        $user->assignRole($this->create_role);

        $this->createModalOpen = false;
        session()->flash('success', "تم إنشاء حساب {$this->create_role} بنجاح. كلمة السر: {$this->create_password}");
    }

    public function toggleActive(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->update(['is_active' => !$user->is_active]);
        session()->flash('success', $user->is_active ? 'تم تفعيل الحساب.' : 'تم تعطيل الحساب.');
    }

    public function toggleScanQrPermission(int $userId): void
    {
        $user = User::findOrFail($userId);
        $user->update(['can_scan_qr' => !$user->can_scan_qr]);
        session()->flash('success', $user->can_scan_qr ? 'تم منح صلاحية مسح كود الـ QR.' : 'تم سحب صلاحية مسح كود الـ QR.');
    }

    public function confirmDelete(int $userId): void
    {
        $this->deleteTargetId    = $userId;
        $this->deleteConfirmOpen = true;
    }

    public function deleteUser(): void
    {
        $user = User::findOrFail($this->deleteTargetId);
        if ($user->hasRole('SUPER_ADMIN') && User::role('SUPER_ADMIN')->count() <= 1) {
            $this->deleteConfirmOpen = false;
            session()->flash('error', 'لا يمكن حذف آخر Super Admin.');
            return;
        }
        $user->delete();
        $this->deleteConfirmOpen = false;
        $this->resetPage();
        session()->flash('success', 'تم حذف الحساب بنجاح.');
    }

    /* ─── Export Users to Excel (CSV) ─── */
    public function exportExcel()
    {
        $users = User::with('roles')->latest()->get();

        $csvData = [];
        $csvData[] = [
            'ID الرقم',
            'الاسم واللقب',
            'البريد الإلكتروني',
            'الدور / الصلاحية الرسمية',
            'حالة الحساب',
            'صلاحية مسح QR',
            'تاريخ إنشاء الحساب'
        ];

        foreach ($users as $u) {
            $csvData[] = [
                $u->id,
                $u->name,
                $u->email,
                $u->roles->first()?->name ?? '—',
                $u->is_active ? 'نشط' : 'معطل',
                $u->can_scan_qr ? 'ممنوح' : 'غير ممنوح',
                $u->created_at ? $u->created_at->format('Y-m-d H:i') : '—',
            ];
        }

        $filename = 'WSAP_System_Users_Accounts_' . date('Y_m_d_His') . '.csv';

        return response()->streamDownload(function () use ($csvData) {
            $file = fopen('php://output', 'w');
            fputs($file, "\xEF\xBB\xBF");
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }

    public function render()
    {
        $query = User::with('roles')
            ->whereDoesntHave('roles', fn($r) => $r->where('name', 'EXECUTIVE_VIEWER'))
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('name', 'like', '%'.$this->search.'%')
                  ->orWhere('email', 'like', '%'.$this->search.'%');
            }))
            ->when($this->filterRole, fn($q) => $q->role($this->filterRole))
            ->when($this->filterStatus !== '', fn($q) => $q->where('is_active', $this->filterStatus === '1'))
            ->latest();

        $allRoles = Role::where('name', '!=', 'EXECUTIVE_VIEWER')->pluck('name');

        return view('livewire.admin.users.index', [
            'users'             => $query->paginate(15),
            'allRoles'          => $allRoles,
            'totalUsers'        => User::whereDoesntHave('roles', fn($r) => $r->where('name', 'EXECUTIVE_VIEWER'))->count(),
            'activeUsers'       => User::where('is_active', true)->whereDoesntHave('roles', fn($r) => $r->where('name', 'EXECUTIVE_VIEWER'))->count(),
            'drawerOpen'        => $this->drawerOpen,
            'roleModalOpen'     => $this->roleModalOpen,
            'createModalOpen'   => $this->createModalOpen,
            'deleteConfirmOpen' => $this->deleteConfirmOpen,
        ]);
    }
}
