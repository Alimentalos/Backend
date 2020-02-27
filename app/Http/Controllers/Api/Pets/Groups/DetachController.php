<?php

namespace App\Http\Controllers\Api\Pets\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\Groups\DetachRequest;
use App\Pet;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * Detach Pet of Group.
     *
     * @param DetachRequest $request
     * @param Pet $pet
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, Pet $pet, Group $group)
    {
        $pet->groups()->detach($group->id);
        return response()->json([], 200);
    }
}
