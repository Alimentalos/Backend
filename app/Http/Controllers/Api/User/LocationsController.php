<?php

namespace App\Http\Controllers\Api\User;

use App\Events\Location as LocationEvent;
use App\Events\UserLocation;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\LocationsRequest;
use App\Http\Resources\Location as LocationResource;
use App\Repositories\GeofenceRepository;
use App\Repositories\LocationRepository;
use App\User;
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
        $user = User::find(auth('api')->user()->id);

        $location = LocationRepository::createLocation(
            $user,
            $request->all()
        );

        $user->update([
            "location" => LocationRepository::parsePoint($request->all())
        ]);

        GeofenceRepository::checkLocationUsingModelGeofences(
            $user,
            $location
        );

        $payload = new LocationResource($location);

        event(new LocationEvent($payload, $user));

        return response()->json(
            $payload,
            200
        );
    }
}
