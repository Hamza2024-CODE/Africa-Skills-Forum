<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\User;

class AccreditationPolicy
{
    public function batchPrint(User $user): bool
    {
        return $user->hasRole(RoleEnum::SUPER_ADMIN->value);
    }
}
