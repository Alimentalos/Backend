<?php

namespace Alimentalos\Relationships\Policies;

use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Models\Geofence;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DevicePolicy
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
     * Determine whether the user can view the device.
     *
     * @param User $user
     * @param Device $device
     * @return mixed
     */
    public function view(User $user, Device $device)
    {
        return $user->is_admin || $device->is_public || users()->hasIndirectRelationship($user, $device);
    }

    /**
     * Determine whether the user can create devices.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->is_admin || subscriptions()->can('create', 'devices', $user);
    }

    /**
     * Determine whether the user can attach group the device.
     *
     * @param User $user
     * @param Device $device
     * @param Group $group
     * @return mixed
     */
    public function attachGroup(User $user, Device $device, Group $group)
    {
        return $user->is_admin ||
            (
                users()->isProperty($device, $user) &&
                groups()->hasAdministrator($group, $user) &&
                !resources()->hasGroup($device, $group)
            );
    }

    /**
     * Determine whether the user can detach group the device.
     *
     * @param User $user
     * @param Device $device
     * @param Group $group
     * @return mixed
     */
    public function detachGroup(User $user, Device $device, Group $group)
    {
        return $user->is_admin ||
            (
                users()->isProperty($device, $user) &&
                groups()->hasAdministrator($group, $user) &&
                resources()->hasGroup($device, $group)
            );
    }

    /**
     * Determine whether the user can attach geofence the device.
     *
     * @param User $user
     * @param Device $device
     * @param Geofence $geofence
     * @return mixed
     */
    public function attachGeofence(User $user, Device $device, Geofence $geofence)
    {
        return $user->is_admin ||
            (
                users()->isProperty($device, $user) &&
                !in_array($device->uuid, $geofence->devices->pluck('uuid')->toArray())
            );
    }

    /**
     * Determine whether the user can detach geofence the device.
     *
     * @param User $user
     * @param Device $device
     * @param Geofence $geofence
     * @return mixed
     */
    public function detachGeofence(User $user, Device $device, Geofence $geofence)
    {
        return $user->is_admin ||
            (
                users()->isProperty($device, $user) &&
                in_array($device->uuid, $geofence->devices->pluck('uuid')->toArray())
            );
    }

    /**
     * Determine whether the user can update the device.
     *
     * @param User $user
     * @param Device $device
     * @return mixed
     */
    public function update(User $user, Device $device)
    {
        return $user->is_admin || users()->isProperty($device, $user);
    }

    /**
     * Determine whether the user can delete the device.
     *
     * @param User $user
     * @param Device $device
     * @return mixed
     */
    public function delete(User $user, Device $device)
    {
        return $user->is_admin || users()->isProperty($device, $user);
    }
}
