<?php

namespace App\Http\Controllers\Api\Pets\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\Groups\AttachRequest;
use App\Pet;
use Illuminate\Http\JsonResponse;

class AttachController extends Controller
{
    /**
     * Attach Pet in Group.
     *
     * @param AttachRequest $request
     * @param Pet $pet
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(AttachRequest $request, Pet $pet, Group $group)
    {
        $pet->groups()->attach($group->id, [
            'status' => Group::ATTACHED_STATUS
        ]);
        return response()->json([], 200);
    }
}
