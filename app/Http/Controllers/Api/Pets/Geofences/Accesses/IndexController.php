<?php

namespace App\Http\Controllers\Api\Pets\Geofences\Accesses;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\Geofences\Accesses\IndexRequest;
use App\Pet;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Fetch all Accesses of a Pet using specific Geofence.
     *
     * @param IndexRequest $request
     * @param Pet $pet
     * @param Geofence $geofence
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Pet $pet, Geofence $geofence)
    {
        return response()->json(
            $pet->accesses()->with([
                'accessible', 'geofence', 'first_location', 'last_location'
            ])->where([
                ['geofence_id', $geofence->id]
            ])->latest()->paginate(20),
            200
        );
    }
}
