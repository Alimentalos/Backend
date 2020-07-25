<?php

namespace App\Http\Controllers\Users\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Groups\AcceptRequest;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Http\JsonResponse;

class AcceptController extends Controller
{
    /**
     * @OA\Post(
     *      path="/users/{user}/groups/{group}/accept",
     *      operationId="acceptUserGroup",
     *      tags={"Users"},
     *      summary="Accept invitation to join group of user.",
     *      description="Update the user relationship status of group by setting as ACCEPTED only when user is the authenticated and has one PENDING invitation.",
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
