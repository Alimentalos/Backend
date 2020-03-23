<?php

namespace Demency\Relationships\Policies;

use Demency\Relationships\Models\Photo;
use Demency\Relationships\Models\Place;
use Demency\Relationships\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlacePolicy
{
    use HandlesAuthorization;
    use PhotoablesPolicy;

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
     * Determine whether the user can view the pet.
     *
     * @param User $user
     * @param Place $place
     * @return mixed
     */
    public function view(User $user, Place $place)
    {
        return $user->is_admin || $place->is_public || $place->user_uuid === $user->uuid;
    }

    /**
     * Determine whether the user can create pets.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin || subscriptions()->can('create', 'places', $user);
    }

    /**
     * Determine whether the user can update the pet.
     *
     * @param User $user
     * @param Place $place
     * @return mixed
     */
    public function update(User $user, Place $place)
    {
        return $user->is_admin || $place->user_uuid === $user->uuid;
    }

    /**
     * Determine whether the user can create photo in the pet.
     *
     * @param User $user
     * @param Place $place
     * @return mixed
     */
    public function createPhoto(User $user, Place $place)
    {
        return $user->can('create', Photo::class) &&
            ($user->is_admin || $place->is_public || $place->user_uuid === $user->uuid);
    }

    /**
     * Determine whether the user can delete the pet.
     *
     * @param User $user
     * @param Place $place
     * @return mixed
     */
    public function delete(User $user, Place $place)
    {
        return $user->is_admin || $place->user_uuid === $user->uuid;
    }



}
