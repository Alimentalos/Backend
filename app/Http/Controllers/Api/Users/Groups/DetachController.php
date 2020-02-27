<?php

namespace App\Http\Controllers\Api\Users\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Groups\DetachRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param DetachRequest $request
     * @param User $user
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, User $user, Group $group)
    {
        $user->groups()->detach($group->id);
        return response()->json([], 200);
    }
}
