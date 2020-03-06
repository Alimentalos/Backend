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
     * Update geofence via request.
     *
     * @param Geofence $geofence
     * @return Geofence
     */
    public function updateViaRequest(Geofence $geofence)
    {
        upload()->check($geofence);
        $geofence->name = fill('name', $geofence->name);
        $shape = array_map(function ($element) {
            return new Point($element['latitude'], $element['longitude']);
        }, input('shape'));
        $geofence->shape = new Polygon([new LineString($shape)]);
        $geofence->is_public = fill('is_public', $geofence->is_public);
        $geofence->save();
        $geofence->load('photo', 'user');
        return $geofence;
    }

    /**
     * Create geofence via request.
     *
     * @return Geofence
     */
    public function createViaRequest()
    {
        $photo = photos()->createViaRequest();
        $geofence = new Geofence();
        $geofence->uuid = uuid();
        $geofence->photo_uuid = $photo->uuid;
        $geofence->name = input('name');
        $geofence->user_uuid = authenticated()->uuid;
        $geofence->photo_url = config('storage.path') . $photo->photo_url;

        $shape = $this->createPointsFromShape(input('shape'));
        $geofence->shape = new Polygon([new LineString($shape)]);
        $geofence->is_public = input('is_public');
        $geofence->save();
        $geofence->load('photo', 'user');
        $photo->geofences()->attach($geofence->uuid);
        return $geofence;
    }
}
