<?php

namespace App\Http\Controllers\Api\Users\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Groups\BlockRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class BlockController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param BlockRequest $request
     * @param User $user
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(BlockRequest $request, User $user, Group $group)
    {
        $user->groups()->updateExistingPivot($group->uuid, [
            'status' => Group::BLOCKED_STATUS,
        ]);
        return response()->json([], 200);
    }
}
