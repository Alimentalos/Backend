<?php

namespace App\Http\Controllers\Api\Resource;

use App\Events\Location as LocationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\LocationsRequest;
use App\Http\Resources\Location as LocationResource;
use App\Repositories\GeofenceRepository;
use App\Repositories\LocationRepository;
use App\Repositories\ModelLocationsRepository;
use Illuminate\Http\JsonResponse;

class LocationsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param LocationsRequest $request
     * @return JsonResponse
     */
    public function __invoke(LocationsRequest $request)
    {
        $model = ModelLocationsRepository::resolveLocationModel($request);
        $location = ModelLocationsRepository::createLocation($model, $request->all());
        $model->update([
            "location" => LocationRepository::parsePoint($request->all())
        ]);
        GeofenceRepository::checkLocationUsingModelGeofences($model, $location);
        $payload = new LocationResource($location);
        event(new LocationEvent($payload, $model));
        return response()->json(
            $payload,
            200
        );
    }
}
