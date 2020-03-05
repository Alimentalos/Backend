<?php

namespace App\Http\Controllers\Api\Users\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Groups\InviteRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class InviteController extends Controller
{
    /**
     * @OA\Post(
     *      path="/users/{user}/groups/{group}/invite",
     *      operationId="inviteUserGroupInstance",
     *      tags={"Users"},
     *      summary="Invite user to group.",
     *      description="Returns empty array as JSON response.",
     *      @OA\Parameter(
     *          name="user",
     *          description="User identifier",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="group",
     *          description="Group identifier",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User instance invited to group successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
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
