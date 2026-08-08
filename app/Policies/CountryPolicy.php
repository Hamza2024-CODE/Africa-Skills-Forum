<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Country;
use App\Models\User;

class CountryPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole([
            RoleEnum::SUPER_ADMIN->value,
            RoleEnum::NATIONAL_ADMIN->value,
            RoleEnum::COUNTRY_ADMIN->value,
        ]);
    }

    public function view(User $user, Country $country): bool
    {
        if ($user->hasRole(RoleEnum::SUPER_ADMIN->value) || $user->hasRole(RoleEnum::NATIONAL_ADMIN->value)) {
            return true;
        }

        if ($user->hasRole(RoleEnum::COUNTRY_ADMIN->value)) {
            return (int) $user->country_id === (int) $country->id;
        }

        return false;
    }

    public function update(User $user, Country $country): bool
    {
        if ($user->hasRole(RoleEnum::SUPER_ADMIN->value)) {
            return true;
        }

        if ($user->hasRole(RoleEnum::COUNTRY_ADMIN->value)) {
            return (int) $user->country_id === (int) $country->id;
        }

        return false;
    }

    public function delete(User $user, Country $country): bool
    {
        return $user->hasRole(RoleEnum::SUPER_ADMIN->value);
    }
}
