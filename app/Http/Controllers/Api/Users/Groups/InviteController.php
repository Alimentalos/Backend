<?php

namespace App\Http\Controllers\Api\Users\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Groups\InviteRequest;
use App\Repositories\UserGroupsRepository;
use App\User;
use Illuminate\Http\JsonResponse;

class InviteController extends Controller
{
    /**
     * Invite user group invitation.
     *
     * @param InviteRequest $request
     * @param User $user
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(InviteRequest $request, User $user, Group $group)
    {
        userGroups()->inviteViaRequest($user, $group);
        return response()->json([], 200);
    }
}
