<?php

namespace Alimentalos\Relationships\Policies;

use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\Pet;
use Alimentalos\Relationships\Models\Photo;
use Alimentalos\Relationships\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PetPolicy
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
     * @param Pet $pet
     * @return mixed
     */
    public function view(User $user, Pet $pet)
    {
        return $user->is_admin || $pet->is_public || $pet->user_uuid === $user->uuid;
    }

    /**
     * Determine whether the user can create pets.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin || subscriptions()->can('create', 'pets', $user);
    }

    /**
     * Determine whether the user can update the pet.
     *
     * @param User $user
     * @param Pet $pet
     * @return mixed
     */
    public function update(User $user, Pet $pet)
    {
        return $user->is_admin || $pet->user_uuid === $user->uuid;
    }

    /**
     * Determine whether the user can create photo in the pet.
     *
     * @param User $user
     * @param Pet $pet
     * @return mixed
     */
    public function createPhoto(User $user, Pet $pet)
    {
        return $user->can('create', Photo::class) &&
            ($user->is_admin || $pet->is_public || $pet->user_uuid === $user->uuid);
    }

    /**
     * Determine whether the user can delete the pet.
     *
     * @param User $user
     * @param Pet $pet
     * @return mixed
     */
    public function delete(User $user, Pet $pet)
    {
        return $user->is_admin || $pet->user_uuid === $user->uuid;
    }

    /**
     * Determine whether the user can attach group the pet.
     *
     * @param User $user
     * @param Pet $pet
     * @param Group $group
     * @return mixed
     */
    public function attachGroup(User $user, Pet $pet, Group $group)
    {
        return $user->is_admin ||
            (
                users()->isProperty($pet, $user) &&
                groups()->hasAdministrator($group, $user) &&
                !resources()->hasGroup($pet, $group)
            );
    }

    /**
     * Determine whether the user can detach group the pet.
     *
     * @param User $user
     * @param Pet $pet
     * @param Group $group
     * @return mixed
     */
    public function detachGroup(User $user, Pet $pet, Group $group)
    {
        return $user->is_admin ||
            (
                users()->isProperty($pet, $user) &&
                groups()->hasAdministrator($group, $user) &&
                resources()->hasGroup($pet, $group)
            );
    }

    /**
     * Determine whether the user can attach geofence the pet.
     *
     * @param User $user
     * @param Pet $pet
     * @param Geofence $geofence
     * @return mixed
     */
    public function attachGeofence(User $user, Pet $pet, Geofence $geofence)
    {
        return $user->is_admin ||
            (
                users()->isProperty($pet, $user) &&
                !in_array($pet->uuid, $geofence->pets->pluck('uuid')->toArray())
            );
    }

    /**
     * Determine whether the user can detach geofence the pet.
     *
     * @param User $user
     * @param Pet $pet
     * @param Geofence $geofence
     * @return mixed
     */
    public function detachGeofence(User $user, Pet $pet, Geofence $geofence)
    {
        return $user->is_admin ||
            (
                users()->isProperty($pet, $user) &&
                in_array($pet->uuid, $geofence->pets->pluck('uuid')->toArray())
            );
    }
}
