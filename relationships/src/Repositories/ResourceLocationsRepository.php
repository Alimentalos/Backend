<?php

namespace Alimentalos\Relationships\Repositories;

use Alimentalos\Relationships\Creations\ResourceLocation as CreatesLocation;
use Alimentalos\Relationships\Events\Location as LocationEvent;
use App\Http\Resources\Location as LocationResource;
use Alimentalos\Relationships\Procedures\ResourceLocationProcedure;
use Alimentalos\Relationships\Queries\LocationQuery;

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
