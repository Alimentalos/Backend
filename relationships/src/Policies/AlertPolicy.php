<?php

namespace Alimentalos\Relationships\Policies;

use Alimentalos\Relationships\Models\Alert;
use Alimentalos\Relationships\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AlertPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any alerts.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->is_admin || $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can view the alert.
     *
     * @param User $user
     * @param Alert $alert
     * @return mixed
     */
    public function view(User $user, Alert $alert)
    {
        return $user->is_admin || $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can create alerts.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin || $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can update the alert.
     *
     * @param User $user
     * @param Alert $alert
     * @return mixed
     */
    public function update(User $user, Alert $alert)
    {
        return $user->is_admin || $user->hasVerifiedEmail() && $alert->user_uuid === $user->uuid;
    }

    /**
     * Determine whether the user can delete the alert.
     *
     * @param User $user
     * @param Alert $alert
     * @return mixed
     */
    public function delete(User $user, Alert $alert)
    {
        return $user->is_admin || $user->hasVerifiedEmail() && $alert->user_uuid === $user->uuid;
    }
}
