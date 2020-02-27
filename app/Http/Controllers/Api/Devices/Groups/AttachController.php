<?php

namespace App\Http\Controllers\Api\Devices\Groups;

use App\Device;
use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Devices\Groups\AttachRequest;
use Illuminate\Http\JsonResponse;

class AttachController extends Controller
{
    /**
     * Attach Device in Group.
     *
     * @param AttachRequest $request
     * @param Device $device
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(AttachRequest $request, Device $device, Group $group)
    {
        $device->groups()->attach($group->id);
        return response()->json([], 200);
    }
}
