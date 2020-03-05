<?php

namespace App\Http\Controllers\Api\Resource\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Groups\DetachRequest;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * Detach group of instance.
     *
     * @param DetachRequest $request
     * @param $resource
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, $resource, Group $group)
    {
        $resource->groups()->detach($group->uuid);
        return response()->json([], 200);
    }
}
