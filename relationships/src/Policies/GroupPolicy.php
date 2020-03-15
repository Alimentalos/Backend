<?php

namespace Demency\Relationships\Policies;

use App\Geofence;
use Demency\Relationships\Models\Group;
use App\Photo;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
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
     * Determine whether the user can view the group.
     *
     * @param User $user
     * @param Group $group
     * @return mixed
     */
    public function view(User $user, Group $group)
    {
        return $user->is_admin || $group->is_public || users()->hasGroup($user, $group);
    }

    /**
     * Determine whether the user can create groups.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin || subscriptions()->can('create', 'groups', $user);
    }

    /**
     * Determine whether the user can update the group.
     *
     * @param User $user
     * @param Group $group
     * @return mixed
     */
    public function update(User $user, Group $group)
    {
        return $user->is_admin || groups()->hasAdministrator($group, $user);
    }

    /**
     * Determine whether the user can create photo in the group.
     *
     * @param User $user
     * @param Group $group
     * @return mixed
     */
    public function createPhoto(User $user, Group $group)
    {
        return $user->can('create', Photo::class) &&
            ($user->is_admin || groups()->hasAdministrator($group, $user) || groups()->hasAdministrator($user, $group));
    }

    /**
     * Determine whether the user can delete the group.
     *
     * @param User $user
     * @param Group $group
     * @return mixed
     */
    public function delete(User $user, Group $group)
    {
        return $user->is_admin || $group->user_uuid === $user->uuid;
    }

    /**
     * Determine whether the user can attach geofence the device.
     *
     * @param User $user
     * @param Group $group
     * @param Geofence $geofence
     * @return mixed
     */
    public function attachGeofence(User $user, Group $group, Geofence $geofence)
    {
        return $user->is_admin ||
            (
                groups()->hasAdministrator($group, $user) &&
                !in_array($group->uuid, $geofence->groups->pluck('uuid')->toArray())
            );
    }

    /**
     * Determine whether the user can detach geofence the device.
     *
     * @param User $user
     * @param Group $group
     * @param Geofence $geofence
     * @return mixed
     */
    public function detachGeofence(User $user, Group $group, Geofence $geofence)
    {
        return $user->is_admin ||
            (
                groups()->hasAdministrator($group, $user) &&
                in_array($group->uuid, $geofence->groups->pluck('uuid')->toArray())
            );
    }
}
