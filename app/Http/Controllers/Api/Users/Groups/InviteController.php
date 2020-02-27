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
     * Handle the incoming request.
     *
     * @param InviteRequest $request
     * @param User $user
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(InviteRequest $request, User $user, Group $group)
    {
        // TODO - Remove unnecessary complexity
        if (
            $user->groups()
                ->where('group_id', $group->id)
                ->where('status', Group::REJECTED_STATUS)
                ->exists()
        ) {
            $user->groups()->updateExistingPivot($group->id, [
                'status' => Group::PENDING_STATUS,
                'is_admin' => $request->has('is_admin') ? $request->input('is_admin') : false,
            ]);
        } else {
            $user->groups()->attach($group->id, [
                'status' => Group::PENDING_STATUS,
                'is_admin' => $request->has('is_admin') ? $request->input('is_admin') : false,
            ]);
        }
        return response()->json([], 200);
    }
}
