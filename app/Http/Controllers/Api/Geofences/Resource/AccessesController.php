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
     * Handle the incoming request.
     *
     * @param AccessesRequest $request
     * @param Geofence $geofence
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(AccessesRequest $request, Geofence $geofence, $resource)
    {
        return response()->json(GeofenceAccessesRepository::fetchResourceViaRequest($request, $geofence, $resource),200);
    }
}
