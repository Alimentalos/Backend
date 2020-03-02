<?php

namespace App\Http\Controllers\Api\Resource\Geofences;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Geofences\AccessesRequest;
use Illuminate\Http\JsonResponse;

class AccessesController extends Controller
{
    /**
     * Fetch all Accesses of a Device.
     *
     * @param AccessesRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(AccessesRequest $request, $resource)
    {
        return response()->json(
            $resource->accesses()->with([
                'accessible', 'geofence', 'first_location', 'last_location'
            ])->latest()->paginate(20),
            200
        );
    }
}
