<?php

namespace App\Http\Controllers\Api\Groups\Geofences;

use App\Geofence;
use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\Geofences\AttachRequest;
use Illuminate\Http\JsonResponse;

class AttachController extends Controller
{
    /**
     * Attach Group in Group.
     *
     * @param AttachRequest $request
     * @param Group $group
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(AttachRequest $request, Group $group, Geofence $geofence)
    {
        $geofence->groups()->attach($group->id, [
            'status' => Group::ATTACHED_STATUS
        ]);
        return response()->json([], 200);
    }
}
