<?php

namespace App\Policies;

use App\Photo;
use App\Repositories\SubscriptionsRepository;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any alerts.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->is_admin || $user->hasVerifiedEmail();
    }

    /**
     * Determine whether the user can view the group.
     *
     * @param User $user
     * @param Photo $photo
     * @return mixed
     */
    public function view(User $user, Photo $photo)
    {
        return $user->is_admin || $photo->is_public || $photo->user_id === $user->id;
    }

    /**
     * Determine whether the user can create groups.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin || SubscriptionsRepository::can('create', 'photos', $user);
    }

    /**
     * Determine whether the user can update the group.
     *
     * @param User $user
     * @param Photo $photo
     * @return mixed
     */
    public function update(User $user, Photo $photo)
    {
        return $user->is_admin || $photo->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the group.
     *
     * @param User $user
     * @param Photo $photo
     * @return mixed
     */
    public function delete(User $user, Photo $photo)
    {
        return $user->is_admin || $photo->user_id === $user->id;
    }
}
