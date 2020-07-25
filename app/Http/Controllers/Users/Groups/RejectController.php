<?php

namespace App\Http\Controllers\Users\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\Groups\RejectRequest;
use Alimentalos\Relationships\Models\Group;
use Alimentalos\Relationships\Models\User;
use Illuminate\Http\JsonResponse;

class RejectController extends Controller
{
    /**
     * @OA\Post(
     *      path="/users/{user}/groups/{group}/reject",
     *      operationId="rejectUserGroup",
     *      tags={"Users"},
     *      summary="Reject user invitation to join group.",
     *      description="Update the user relationship status of group by setting as REJECTED only when user is the authenticated and has one PENDING invitation.",
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
