<?php

namespace Demency\Relationships\Repositories;

use Demency\Relationships\Models\Geofence;
use Demency\Relationships\Lists\GeofenceList;
use Demency\Relationships\Procedures\GeofenceProcedure;

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
