<?php

namespace App\Repositories;

use App\Creations\ResourceLocation as CreatesLocation;
use App\Events\Location as LocationEvent;
use App\Http\Resources\Location as LocationResource;
use App\Procedures\ResourceLocationProcedure;
use App\Queries\LocationQuery;

class ResourceLocationsRepository
{
    use LocationQuery;
    use ResourceLocationProcedure;
    use CreatesLocation;

    /**
     * Create resource location via request.
     *
     * @return LocationResource
     */
    public function createViaRequest()
    {
        $model = $this->resolveLocationModel();
        $location = $this->createLocation($model, request()->all());
        $model->update(["location" => parser()->point(request()->all())]);
        geofences()->checkLocationUsingModelGeofences($model, $location);
        $payload = new LocationResource($location);
        event(new LocationEvent($payload, $model));
        return $payload;
    }
}
