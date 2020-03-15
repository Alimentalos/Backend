<?php


namespace App\Repositories;

use App\Asserts\UserGroupAssert;
use Demency\Groupable\Models\Group;
use App\User;

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
