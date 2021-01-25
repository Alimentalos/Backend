<?php

namespace App\Policies;

use App\Models\Geofence;
use App\Models\Group;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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
     * Determine whether the user can attach group the user.
     *
     * @param User $user
     * @param User $attached
     * @param Group $group
     * @return mixed
     */
    public function attachGroup(User $user, User $attached, Group $group)
    {
        return $user->is_admin ||
            (
                users()->isProperty($attached, $user) &&
                groups()->hasAdministrator($group, $user) &&
                !resources()->hasGroup($attached, $group)
            );
    }

    /**
     * Determine whether the user can invite group the user.
     *
     * @param User $user
     * @param User $invited
     * @param Group $group
     * @return mixed
     */
    public function inviteGroup(User $user, User $invited, Group $group)
    {
        return $user->is_admin ||
            (
                $user->uuid !== $invited->uuid &&
                groups()->hasAdministrator($group, $user) &&
                !resources()->hasGroup($invited, $group) &&
                !resources()->isBlocked($invited, $group)
            );
    }

    /**
     * Determine whether the user can reject group the user.
     *
     * @param User $user
     * @param User $invited
     * @param Group $group
     * @return mixed
     */
    public function rejectGroup(User $user, User $invited, Group $group)
    {
        return $user->is_admin ||
            (
                $user->uuid === $invited->uuid &&
                !resources()->hasGroup($invited, $group) &&
                !resources()->isBlocked($invited, $group)
            );
    }

    /**
     * Determine whether the user can block group the user.
     *
     * @param User $user
     * @param User $invited
     * @param Group $group
     * @return mixed
     */
    public function blockGroup(User $user, User $invited, Group $group)
    {
        return $user->is_admin ||
            (
                $user->uuid === $invited->uuid &&
                !resources()->hasGroup($invited, $group) &&
                !resources()->isBlocked($invited, $group)
            );
    }

    /**
     * Determine whether the user can accept group the user.
     *
     * @param User $user
     * @param User $invited
     * @param Group $group
     * @return mixed
     */
    public function acceptGroup(User $user, User $invited, Group $group)
    {
        return $user->is_admin ||
            (
                $user->uuid === $invited->uuid &&
                !resources()->hasGroup($invited, $group) &&
                !resources()->isBlocked($invited, $group)
            );
    }


    /**
     * Determine whether the user can detach group the user.
     *
     * @param User $user
     * @param User $detached
     * @param Group $group
     * @return mixed
     */
    public function detachGroup(User $user, User $detached, Group $group)
    {
        return $user->is_admin ||
            (
                groups()->hasAdministrator($group, $user) &&
                resources()->hasGroup($detached, $group)
            );
    }

    /**
     * Determine whether the user can attach geofence the device.
     *
     * @param User $user
     * @param User $attached
     * @param Geofence $geofence
     * @return mixed
     */
    public function attachGeofence(User $user, User $attached, Geofence $geofence)
    {
        return $user->is_admin || !in_array($attached->uuid, $geofence->users->pluck('uuid')->toArray());
    }

    /**
     * Determine whether the user can detach geofence the device.
     *
     * @param User $user
     * @param User $detached
     * @param Geofence $geofence
     * @return mixed
     */
    public function detachGeofence(User $user, User $detached, Geofence $geofence)
    {
        return $user->is_admin || in_array($detached->uuid, $geofence->users->pluck('uuid')->toArray());
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return $user->is_admin || $model->is_public || users()->isWorker($user, $model) ||
            users()->isOwner($user, $model) ||
            users()->sameUser($model, $user) ||
            users()->sameOwner($model, $user);
    }

    /**
     * Determine whether the user can create photo in the user.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function createPhoto(User $user, User $model)
    {
        return $user->can('create', Photo::class) &&
            ($user->is_admin || $user->uuid === $model->uuid);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin || subscriptions()->can('create', 'users', $user);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        return $user->is_admin ||  users()->sameUser($model, $user) || users()->isOwner($user, $model);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->is_admin || users()->isOwner($user, $model);
    }
}
