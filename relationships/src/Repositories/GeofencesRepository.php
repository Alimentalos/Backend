<?php

namespace Alimentalos\Relationships\Repositories;

use Alimentalos\Relationships\Lists\GeofenceList;
use App\Models\Geofence;
use Alimentalos\Relationships\Procedures\GeofenceProcedure;

class GeofencesRepository
{
    use GeofenceProcedure;
    use GeofenceList;

    /**
     * Create geofence.
     *
     * @return Geofence
     */
    public function create()
    {
        return $this->createInstance();
    }

    /**
     * Update geofence.
     *
     * @param Geofence $geofence
     * @return Geofence
     */
    public function update(Geofence $geofence)
    {
        return $this->updateInstance($geofence);
    }
}
