<?php


namespace Demency\Relationships\Asserts;


use Demency\Relationships\Models\Group;
use Illuminate\Database\Eloquent\Model;

trait ResourceGroupAssert
{
    /**
     * Assert resource has group.
     *
     * @param object|Model $resource
     * @param object|Group $group
     * @return bool
     */
    public static function hasGroup(Model $resource, Group $group)
    {
        return $resource->groups()->where('group_uuid', $group->uuid)
            ->whereIn('status', [
                Group::ACCEPTED_STATUS, Group::ATTACHED_STATUS
            ])->exists();
    }

    /**
     * Assert resource has group blocked.
     *
     * @param object|Model $resource
     * @param object|Group $group
     * @return bool
     */
    public static function isBlocked(Model $resource, Group $group)
    {
        return $resource->groups()->where('group_uuid', $group->uuid)
            ->whereIn('status', [
                Group::BLOCKED_STATUS
            ])->exists();
    }
}
