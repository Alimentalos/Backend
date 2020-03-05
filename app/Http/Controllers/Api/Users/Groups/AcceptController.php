<?php

namespace App\Http\Controllers\Api\Users\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Groups\AcceptRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class AcceptController extends Controller
{
    /**
     * @OA\Post(
     *      path="/users/{user}/groups/{group}/accept",
     *      operationId="acceptUserGroupInstance",
     *      tags={"Users"},
     *      summary="Accept user group invitation.",
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
     *          description="User instance accepted to group successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Accept user group invitation.
     *
     * @param AcceptRequest $request
     * @param User $user
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(AcceptRequest $request, User $user, Group $group)
    {
        $user->groups()->updateExistingPivot($group->uuid, ['status' => Group::ACCEPTED_STATUS]);
        return response()->json([], 200);
    }
}
