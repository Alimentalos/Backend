<?php


namespace App\Repositories;

use App\Group;
use App\User;
use Illuminate\Http\Request;

class UserGroupsRepository
{
    /**
     * Invite User into Group.
     *
     * @param Request $request
     * @param User $user
     * @param Group $group
     */
    public static function inviteViaRequest(Request $request, User $user, Group $group)
    {
        static::checkUserGroupRejected($user, $group) ?
            $user->groups()->updateExistingPivot($group->uuid, static::retrieveInvitationAttachAttributes($request)) :
            $user->groups()->attach($group->uuid, static::retrieveInvitationAttachAttributes($request));
    }

    /**
     * Check if User has Group in rejected status.
     *
     * @param User $user
     * @param Group $group
     * @return bool
     */
    public static function checkUserGroupRejected(User $user, Group $group)
    {
        return $user->groups()->where('group_uuid', $group->uuid)->where('status', Group::REJECTED_STATUS)->exists();
    }

    /**
     * Retrieve user invitation attach default attributes.
     *
     * @param Request $request
     * @return array
     */
    public static function retrieveInvitationAttachAttributes(Request $request)
    {
        return ['status' => Group::PENDING_STATUS, 'is_admin' => FillRepository::fillMethod($request, 'is_admin', false)];
    }
}
