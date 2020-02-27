<?php

namespace App\Http\Controllers\Api\Device;

use App\Device;
use App\Events\Location as LocationEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Device\LocationsRequest;
use App\Http\Resources\Location as LocationResource;
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
        $device = Device::find(auth('devices')->user()->id);
        $location = LocationRepository::createLocation(
            $device,
            $request->all()
        );

        $device->update([
            "location" => LocationRepository::parsePoint($request->all())
        ]);

        GeofenceRepository::checkLocationUsingUserGeofences(
            $device,
            $location
        );

        $payload = new LocationResource($location);

        event(new LocationEvent($payload, $device));

        return response()->json(
            $payload,
            200
        );
    }
}
