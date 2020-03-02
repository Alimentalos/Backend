<?php

namespace App\Policies;

use App\Geofence;
use App\Group;
use App\Photo;
use App\Repositories\GroupsRepository;
use App\Repositories\SubscriptionsRepository;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GroupPolicy
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
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function view(User $user, Group $group)
    {
        return $user->is_admin || $group->is_public || GroupsRepository::userHasGroup($user, $group->id);
    }

    /**
     * Determine whether the user can create groups.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin || SubscriptionsRepository::can('create', 'groups', $user);
    }

    /**
     * Determine whether the user can update the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function update(User $user, Group $group)
    {
        return $user->is_admin || GroupsRepository::userIsGroupAdmin($user, $group);
    }

    /**
     * Determine whether the user can create photo in the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function createPhoto(User $user, Group $group)
    {
        return $user->can('create', Photo::class) &&
            ($user->is_admin || GroupsRepository::userIsGroupAdmin($user, $group) || GroupsRepository::userHasGroup($user, $group->id));
    }

    /**
     * Determine whether the user can delete the group.
     *
     * @param  \App\User  $user
     * @param  \App\Group  $group
     * @return mixed
     */
    public function delete(User $user, Group $group)
    {
        return $user->is_admin || $group->user_id === $user->id;
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
        return true || $user->is_admin ||
            (
                GroupsRepository::userIsGroupAdmin($user, $group) &&
                !in_array($group->id, $geofence->groups->pluck('id')->toArray())
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
        return true || $user->is_admin ||
            (
                GroupsRepository::userIsGroupAdmin($user, $group) &&
                in_array($group->id, $geofence->groups->pluck('id')->toArray())
            );
    }
}
