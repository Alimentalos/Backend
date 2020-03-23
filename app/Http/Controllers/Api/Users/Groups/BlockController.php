<?php

namespace App\Http\Controllers\Api\Users\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Groups\BlockRequest;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Http\JsonResponse;

class BlockController extends Controller
{
    /**
     * @OA\Post(
     *      path="/users/{user}/groups/{group}/block",
     *      operationId="blockUserGroup",
     *      tags={"Users"},
     *      summary="Block user invitation to join group.",
     *      description="Update the user relationship status of group by setting as BLOCKED only when user is the authenticated and has one PENDING invitation. This disable to other users send new applications to this user and group.",
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
     *          description="User instance blocked to group successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Block user group invitation.
     *
     * @param BlockRequest $request
     * @param User $user
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(BlockRequest $request, User $user, Group $group)
    {
        $user->groups()->updateExistingPivot($group->uuid, ['status' => Group::BLOCKED_STATUS]);
        return response()->json([], 200);
    }
}
