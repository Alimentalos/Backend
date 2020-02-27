<?php

namespace App\Http\Controllers\Api\Pets\Geofences;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\Geofences\AccessesRequest;
use App\Pet;
use Illuminate\Http\JsonResponse;

class AccessesController extends Controller
{
    /**
     * Fetch all Accesses of a Pet.
     *
     * @param AccessesRequest $request
     * @param Pet $pet
     * @return JsonResponse
     */
    public function __invoke(AccessesRequest $request, Pet $pet)
    {
        return response()->json(
            $pet->accesses()->with([
                'accessible', 'geofence', 'first_location', 'last_location'
            ])->latest()->paginate(20),
            200
        );
    }
}
