<?php

namespace App\Http\Controllers\Api\Users\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Groups\RejectRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class RejectController extends Controller
{
    /**
     * @OA\Post(
     *      path="/users/{user}/groups/{group}/reject",
     *      operationId="rejectUserGroupInstance",
     *      tags={"Users"},
     *      summary="Reject user group invitation.",
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
     *          description="User instance reject to group successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Reject user group invitation.
     *
     * @param RejectRequest $request
     * @param User $user
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(RejectRequest $request, User $user, Group $group)
    {
        $user->groups()->updateExistingPivot($group->uuid, ['status' => Group::REJECTED_STATUS]);
        return response()->json([], 200);
    }
}
