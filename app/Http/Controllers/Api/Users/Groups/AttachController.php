<?php

namespace App\Http\Controllers\Api\Users\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Groups\AttachRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class AttachController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param AttachRequest $request
     * @param User $user
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(AttachRequest $request, User $user, Group $group)
    {
        $user->groups()->attach($group->id, [
            'status' => Group::ATTACHED_STATUS,
            'is_admin' => $request->has('is_admin') ? $request->input('is_admin') : false,
        ]);
        return response()->json([], 200);
    }
}
