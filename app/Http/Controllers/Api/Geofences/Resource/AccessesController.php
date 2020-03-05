<?php

namespace App\Http\Controllers\Api\Geofences\Resource;

use App\Geofence;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Geofences\Resource\AccessesRequest;
use App\Repositories\GeofenceAccessesRepository;
use Illuminate\Http\JsonResponse;

class AccessesController extends Controller
{
    /**
     * Retrieve paginated resource access of geofences.
     *
     * @param AccessesRequest $request
     * @param Geofence $geofence
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(AccessesRequest $request, Geofence $geofence, $resource)
    {
        $accesses = geofencesAccesses()->fetchResourceViaRequest($geofence, $resource);
        return response()->json($accesses,200);
    }
}
