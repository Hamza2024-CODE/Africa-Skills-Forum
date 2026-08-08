<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // System Permissions
        $permissions = [
            'manage-editions',
            'manage-settings',
            'manage-countries',
            'manage-skills',
            'manage-delegations',
            'manage-competitions',
            'manage-evaluations',
            'manage-users',
            'manage-roles',
            'view-audit-logs',
            'manage-media',
            'manage-events',
            'manage-news',
            'executive-view-reports',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Roles
        foreach (RoleEnum::cases() as $roleEnum) {
            $role = Role::firstOrCreate(['name' => $roleEnum->value]);

            if ($roleEnum === RoleEnum::SUPER_ADMIN) {
                $role->givePermissionTo(Permission::all());
            } elseif ($roleEnum === RoleEnum::NATIONAL_ADMIN) {
                $role->givePermissionTo([
                    'manage-countries', 'manage-skills', 'manage-delegations',
                    'manage-competitions', 'manage-evaluations', 'executive-view-reports',
                ]);
            } elseif ($roleEnum === RoleEnum::MEDIA_MANAGER) {
                $role->givePermissionTo(['manage-media', 'manage-events', 'manage-news']);
            } elseif ($roleEnum === RoleEnum::EXECUTIVE_VIEWER) {
                $role->givePermissionTo(['executive-view-reports']);
            } elseif ($roleEnum === RoleEnum::COUNTRY_ADMIN) {
                $role->givePermissionTo(['manage-delegations']);
            }
        }
    }
}
