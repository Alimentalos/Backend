<?php

namespace App\Http\Controllers\Api\Pets\Geofences;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\Geofences\AttachRequest;
use App\Pet;
use Illuminate\Http\JsonResponse;

class AttachController extends Controller
{
    /**
     * Attach Pet in Geofence.
     *
     * @param AttachRequest $request
     * @param Pet $pet
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(AttachRequest $request, Pet $pet, Geofence $geofence)
    {
        $pet->geofences()->attach($geofence->id);
        return response()->json([], 200);
    }
}
