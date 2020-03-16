<?php


namespace Demency\Relationships\Repositories;

use Demency\Relationships\Asserts\UserGroupAssert;
use Demency\Relationships\Models\Group;
use Demency\Relationships\Models\User;

class UserGroupsRepository
{
    use UserGroupAssert;

    /**
     * Invite User into Group.
     *
     * @param User $user
     * @param Group $group
     */
    public function invite(User $user, Group $group)
    {
        $this->hasRejected($user, $group) ?
            $user->groups()->updateExistingPivot($group->uuid, $this->attributes()) :
            $user->groups()->attach($group->uuid, $this->attributes());
    }

    /**
     * Retrieve user invitation attach default attributes.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'status' => Group::PENDING_STATUS,
            'is_admin' => fill('is_admin', false)
        ];
    }
}
