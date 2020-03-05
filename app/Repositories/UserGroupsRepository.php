<?php


namespace App\Repositories;

use App\Group;
use App\User;

class UserGroupsRepository
{
    /**
     * Invite User into Group.
     *
     * @param User $user
     * @param Group $group
     */
    public function inviteViaRequest(User $user, Group $group)
    {
        $this->checkUserGroupRejected($user, $group) ?
            $user->groups()
                ->updateExistingPivot($group->uuid, $this->retrieveInvitationAttachAttributes()) :
            $user->groups()
                ->attach($group->uuid, $this->retrieveInvitationAttachAttributes());
    }

    /**
     * Check if User has Group in rejected status.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public function checkUserGroupRejected(User $user, Group $group)
    {
        return $user->groups()
            ->where('group_uuid', $group->uuid)
            ->where('status', Group::REJECTED_STATUS)
            ->exists();
    }

    /**
     * Retrieve user invitation attach default attributes.
     *
     * @return array
     */
    public function retrieveInvitationAttachAttributes()
    {
        return [
            'status' => Group::PENDING_STATUS,
            'is_admin' => fill('is_admin', false)
        ];
    }
}
