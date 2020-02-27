<?php

namespace App\Http\Controllers\Api\Groups\Geofences;

use App\Geofence;
use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\Geofences\DetachRequest;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * Detach Group of Group.
     *
     * @param DetachRequest $request
     * @param Group $group
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, Group $group, Geofence $geofence)
    {
        $geofence->groups()->detach($group->id);
        return response()->json([], 200);
    }
}
