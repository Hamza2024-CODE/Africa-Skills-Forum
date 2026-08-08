<?php

namespace App\Policies;

use App\Models\ParticipantProfile;
use App\Models\Registration;
use App\Models\User;

class ParticipantPolicy
{
    /**
     * Determine whether the user can view the participant registration.
     */
    public function view(User $user, Registration $registration): bool
    {
        // 1. Super admin can view any
        if ($user->hasRole('SUPER_ADMIN') || $user->hasRole('NATIONAL_ADMIN')) {
            return true;
        }

        // 2. Country Admin can only view registrations belonging to their country
        if ($user->hasRole('COUNTRY_ADMIN') && $user->country_id === $registration->country_id) {
            return true;
        }

        // 3. Participant user can view own registration
        if ($registration->participant && $registration->participant->user_id === $user->id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can update registration status.
     */
    public function updateStatus(User $user, Registration $registration): bool
    {
        // Only Super Admin or National Admin can approve/reject/qualify
        if ($user->hasRole('SUPER_ADMIN') || $user->hasRole('NATIONAL_ADMIN')) {
            return true;
        }

        // Country Admin can request review or update internal notes for own country only
        if ($user->hasRole('COUNTRY_ADMIN') && $user->country_id === $registration->country_id) {
            return true;
        }

        return false;
    }
}
