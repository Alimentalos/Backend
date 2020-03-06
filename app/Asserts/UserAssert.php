<?php


namespace App\Asserts;


use App\Group;
use App\User;
use Illuminate\Database\Eloquent\Model;

trait UserAssert
{
    /**
     * Assert user has indirect relationship.
     *
     * @param User $user
     * @param object|Model $resource
     * @return boolean
     */
    public function hasIndirectRelationship(User $user, Model $resource)
    {
        // Share group or have same owner are both indirect user relationship.
        return $resource->user_uuid === $user->uuid || $user->groups()
                ->whereIn(
                    'uuid',
                    $resource->groups->pluck('uuid')->toArray()
                )->exists();
    }

    /**
     * Assert user has group.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function hasGroup(User $user, Group $group)
    {
        return in_array($group->uuid, $user->groups->pluck('uuid')->toArray());
    }

    /**
     * Check if userA is same of userB
     *
     * @param object|User $userA
     * @param object|User $userB
     * @return bool
     */
    public function sameUser(User $userA, User $userB)
    {
        return $userA->uuid === $userB->uuid;
    }

    /**
     * Check if userA has same owner of userB
     *
     * @param object|User $userA
     * @param object|User $userB
     * @return bool
     */
    public function sameOwner(User $userA, User $userB)
    {
        return $userA->user_uuid === $userB->user_uuid;
    }

    /**
     * Check if userA is owner of userB
     *
     * @param object|User $userA
     * @param object|User $userB
     * @return bool
     */
    public function isOwner(User $userA, User $userB)
    {
        return $userA->uuid === $userB->user_uuid;
    }

    /**
     * Check if userA is worker of userB
     *
     * @param object|User $userA
     * @param object|User $userB
     * @return bool
     */
    public function isWorker(User $userA, User $userB)
    {
        return $userA->user_uuid === $userB->uuid;
    }

    /**
     * Check if device is property of user
     *
     * @param object|Model $model
     * @param object|User $user
     * @return bool
     */
    public function isProperty(Model $model, User $user)
    {
        return $model->user_uuid === $user->uuid;
    }
}
