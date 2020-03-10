<?php

namespace App\Repositories;

use App\Geofence;
use App\Lists\GeofenceList;
use App\Procedures\GeofenceProcedure;

class GeofenceRepository
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
