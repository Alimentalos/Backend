<?php

namespace App\Http\Controllers\Api\Resource;

use App\Events\Location as LocationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizedRequest;
use App\Http\Resources\Location as LocationResource;
use App\Repositories\GeofenceRepository;
use App\Repositories\LocationsRepository;
use App\Repositories\ModelLocationsRepository;
use Illuminate\Http\JsonResponse;

class LocationsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param AuthorizedRequest $request
     * @return JsonResponse
     */
    public function __invoke(AuthorizedRequest $request)
    {
        // TODO - Reduce number of lines of LocationsController
        // @body move into repository method as createViaRequest.
        $model = ModelLocationsRepository::resolveLocationModel($request);
        $location = ModelLocationsRepository::createLocation($model, $request->all());
        $model->update([
            "location" => LocationsRepository::parsePoint($request->all())
        ]);
        GeofenceRepository::checkLocationUsingModelGeofences($model, $location);
        $payload = new LocationResource($location);
        event(new LocationEvent($payload, $model));
        return response()->json(
            $payload,
            201
        );
    }
}
