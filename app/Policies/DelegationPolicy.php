<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\CountryDelegation;
use App\Models\User;

class DelegationPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            RoleEnum::SUPER_ADMIN->value,
            RoleEnum::NATIONAL_ADMIN->value,
            RoleEnum::COUNTRY_ADMIN->value,
        ]);
    }

    public function view(User $user, CountryDelegation $delegation): bool
    {
        if ($user->hasRole(RoleEnum::SUPER_ADMIN->value) || $user->hasRole(RoleEnum::NATIONAL_ADMIN->value)) {
            return true;
        }

        if ($user->hasRole(RoleEnum::COUNTRY_ADMIN->value)) {
            return (int) $user->country_id === (int) $delegation->country_id;
        }

        return false;
    }

    public function update(User $user, CountryDelegation $delegation): bool
    {
        if ($user->hasRole(RoleEnum::SUPER_ADMIN->value)) {
            return true;
        }

        if ($user->hasRole(RoleEnum::COUNTRY_ADMIN->value)) {
            return (int) $user->country_id === (int) $delegation->country_id;
        }

        return false;
    }

    public function delete(User $user, CountryDelegation $delegation): bool
    {
        return $user->hasRole(RoleEnum::SUPER_ADMIN->value);
    }
}
