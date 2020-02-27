<?php

namespace App\Http\Controllers\Api\Users\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Geofences\DetachRequest;
use App\User;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * Detach User of Geofence.
     *
     * @param DetachRequest $request
     * @param User $user
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, User $user, Geofence $geofence)
    {
        $user->geofences()->detach($geofence->id);
        return response()->json([], 200);
    }
}
