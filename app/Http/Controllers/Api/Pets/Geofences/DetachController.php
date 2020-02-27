<?php

namespace App\Http\Controllers\Api\Pets\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\Geofences\DetachRequest;
use App\Pet;
use Illuminate\Http\JsonResponse;

class DetachController extends Controller
{
    /**
     * Detach Geofence of Group.
     *
     * @param DetachRequest $request
     * @param Pet $pet
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(DetachRequest $request, Pet $pet, Geofence $geofence)
    {
        $pet->geofences()->detach($geofence->id);
        return response()->json([], 200);
    }
}
