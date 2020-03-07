<?php

namespace App\Repositories;

use App\Geofence;
use App\Lists\GeofenceList;
use App\Procedures\GeofenceProcedure;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;

class GeofenceRepository
{
    use GeofenceProcedure;
    use GeofenceList;

    /**
     * In status.
     */
    public const IN_STATUS = 1;

    /**
     * Still status.
     */
    public const STILL_STATUS = 2;

    /**
     * Out status.
     */
    public const OUT_STATUS = 3;

    /**
     * Update geofence.
     *
     * @param Geofence $geofence
     * @return Geofence
     */
    public function update(Geofence $geofence)
    {
        upload()->check($geofence);
        return $this->updateInstance($geofence);
    }

    /**
     * Create geofence.
     *
     * @return Geofence
     */
    public function create()
    {
        return $this->createInstance();
    }
}
