<?php


namespace App\Asserts;


use App\Group;
use App\User;
use Illuminate\Database\Eloquent\Model;

trait UserAssert
{
    /**
     * Assert user has indirect relationship with resource.
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
     * Assert first user is same of second user.
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
     * Assert first user has same owner of second user.
     *
     * @param object|User $first
     * @param object|User $second
     * @return bool
     */
    public function sameOwner(User $first, User $second)
    {
        return $first->user_uuid === $second->user_uuid;
    }

    /**
     * Assert first user is owner of second user.
     *
     * @param object|User $first
     * @param object|User $second
     * @return bool
     */
    public function isOwner(User $first, User $second)
    {
        return $first->uuid === $second->user_uuid;
    }

    /**
     * Assert first user is child of second user.
     *
     * @param object|User $first
     * @param object|User $second
     * @return bool
     */
    public function isWorker(User $first, User $second)
    {
        return $first->user_uuid === $second->uuid;
    }

    /**
     * Assert model is user property.
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
