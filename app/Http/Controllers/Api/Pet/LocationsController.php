<?php

namespace App\Http\Controllers\Api\Pet;

use App\Events\Location as LocationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pet\LocationsRequest;
use App\Http\Resources\Location as LocationResource;
use App\Pet;
use App\Repositories\GeofenceRepository;
use App\Repositories\LocationRepository;
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
        // TODO - Remove unnecessary complexity
        $pet = Pet::find(auth('pets')->user()->id);
        $location = LocationRepository::createLocation(
            $pet,
            $request->all()
        );

        $pet->update([
            "location" => LocationRepository::parsePoint($request->all())
        ]);

        GeofenceRepository::checkLocationUsingUserGeofences(
            $pet,
            $location
        );

        $payload = new LocationResource($location);

        event(new LocationEvent($payload, $pet));

        return response()->json(
            $payload,
            200
        );
    }
}
