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
    public static function createViaRequest(Request $request)
    {
        $model = ModelLocationsRepository::resolveLocationModel($request);
        $location = ModelLocationsRepository::createLocation($model, $request->all());
        $model->update(["location" => LocationsRepository::parsePoint($request->all())]);
        GeofenceRepository::checkLocationUsingModelGeofences($model, $location);
        $payload = new LocationResource($location);
        event(new LocationEvent($payload, $model));
        return $payload;
    }
}