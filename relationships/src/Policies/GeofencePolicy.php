<?php

namespace Demency\Relationships\Policies;

use Demency\Relationships\Models\Geofence;
use Demency\Relationships\Models\Group;
use Demency\Relationships\Models\Photo;
use Demency\Relationships\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GeofencePolicy
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
     * Determine whether the user can view the geofence.
     *
     * @param User $user
     * @param Geofence $geofence
     * @return mixed
     */
    public function view(User $user, Geofence $geofence)
    {
        return $user->is_admin || $geofence->is_public || $geofence->user_uuid === $user->uuid || $geofence->user_uuid === $user->user_uuid;
    }

    /**
     * Determine whether the user can create geofences.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin || subscriptions()->can('create', 'geofences', $user);
    }

    /**
     * Determine whether the user can update the geofence.
     *
     * @param User $user
     * @param Geofence $geofence
     * @return mixed
     */
    public function update(User $user, Geofence $geofence)
    {
        return $user->is_admin || $geofence->user_uuid === $user->uuid;
    }

    /**
     * Determine whether the user can create photo in the geofence.
     *
     * @param User $user
     * @param Geofence $geofence
     * @return mixed
     */
    public function createPhoto(User $user, Geofence $geofence)
    {
        return $user->can('create', Photo::class) &&
            ($user->is_admin || $geofence->user_uuid === $user->uuid || $geofence->is_public);
    }

    /**
     * Determine whether the user can attach group the geofence.
     *
     * @param User $user
     * @param Geofence $geofence
     * @param Group $group
     * @return mixed
     */
    public function attachGroup(User $user, Geofence $geofence, Group $group)
    {
        return $user->is_admin ||
            (
                users()->isProperty($geofence, $user) &&
                groups()->hasAdministrator($group, $user) &&
                !resources()->hasGroup($geofence, $group)
            );
    }

    /**
     * Determine whether the user can detach group the geofence.
     *
     * @param User $user
     * @param Geofence $geofence
     * @param Group $group
     * @return mixed
     */
    public function detachGroup(User $user, Geofence $geofence, Group $group)
    {
        return $user->is_admin ||
            (
                users()->isProperty($geofence, $user) &&
                groups()->hasAdministrator($group, $user) &&
                resources()->hasGroup($geofence, $group)
            );
    }

    /**
     * Determine whether the user can delete the geofence.
     *
     * @param User $user
     * @param Geofence $geofence
     * @return mixed
     */
    public function delete(User $user, Geofence $geofence)
    {
        return $user->is_admin || $geofence->user_uuid === $user->uuid;
    }
}
