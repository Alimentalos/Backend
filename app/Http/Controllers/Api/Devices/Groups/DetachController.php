<?php

namespace App\Http\Controllers\Api\Devices\Groups;

use App\Device;
use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Devices\Groups\DetachRequest;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * Detach Device of Group.
     *
     * @param DetachRequest $request
     * @param Device $device
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, Device $device, Group $group)
    {
        $device->groups()->detach($group->id);
        return response()->json([], 200);
    }
}
