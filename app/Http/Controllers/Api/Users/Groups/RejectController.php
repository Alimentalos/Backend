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
