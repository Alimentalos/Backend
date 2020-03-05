<?php

namespace App\Repositories;

use App\Events\Location as LocationEvent;
use App\Http\Resources\Location as LocationResource;
use Illuminate\Http\Request;

class ResourceLocationsRepository
{
    /**
     * Create resource location via request.
     *
     * @param Request $request
     * @return LocationResource
     */
    public function createViaRequest(Request $request)
    {
        $model = modelLocations()->resolveLocationModel();
        $location = modelLocations()->createLocation($model, $request->all());
        $model->update(["location" => parser()->point($request->all())]);
        geofences()->checkLocationUsingModelGeofences($model, $location);
        $payload = new LocationResource($location);
        event(new LocationEvent($payload, $model));
        return $payload;
    }
}
