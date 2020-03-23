<?php

namespace Demency\Relationships\Repositories;

use Demency\Relationships\Creations\ResourceLocation as CreatesLocation;
use Demency\Relationships\Events\Location as LocationEvent;
use App\Http\Resources\Location as LocationResource;
use Demency\Relationships\Procedures\ResourceLocationProcedure;
use Demency\Relationships\Queries\LocationQuery;

class ResourceLocationsRepository
{
    use LocationQuery;
    use ResourceLocationProcedure;
    use CreatesLocation;

    /**
     * Create resource location.
     *
     * @return LocationResource
     */
    public function create()
    {
        $model = $this->current();
        $location = $this->createInstance($model, request()->all());
        $model->update(["location" => parser()->point(request()->all())]);
        geofences()->checkLocationUsingModelGeofences($model, $location);
        $payload = new LocationResource($location);
        event(new LocationEvent($payload, $model));
        return $payload;
    }
}
