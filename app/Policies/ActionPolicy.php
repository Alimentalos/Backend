<?php

namespace App\Policies;

use App\Models\Action;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ActionPolicy
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
     * Determine whether the user can view the action.
     *
     * @param User $user
     * @param Action $action
     * @return mixed
     */
    public function view(User $user, Action $action)
    {
        return $user->id_admin || $action->user_uuid === $user->uuid || $action->user_uuid === $user->user_uuid;
    }

    /**
     * Determine whether the user can delete the action.
     *
     * @param User $user
     * @param Action $action
     * @return mixed
     */
    public function delete(User $user, Action $action)
    {
        return $user->is_admin;
    }
}
