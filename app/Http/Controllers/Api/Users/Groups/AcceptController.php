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
     * Handle the incoming request.
     *
     * @param AcceptRequest $request
     * @param User $user
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(AcceptRequest $request, User $user, Group $group)
    {
        $user->groups()->updateExistingPivot($group->id, [
            'status' => Group::ACCEPTED_STATUS,
        ]);
        return response()->json([], 200);
    }
}
