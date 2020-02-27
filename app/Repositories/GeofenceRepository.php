<?php

namespace App\Repositories;

use App\Events\GeofenceIn;
use App\Events\GeofenceOut;
use App\Geofence;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Database\Eloquent\Model;

class GeofenceRepository
{
    public const IN_STATUS = 1;
    public const STILL_STATUS = 2;
    public const OUT_STATUS = 3;

    /**
     * Testing Geofence
     * @return mixed
     * @codeCoverageIgnore
     */
    public static function checkLocationInGeofence()
    {
        //
        $place1 = new Geofence();
        $place1->name = "blablabla";
        $place1->user_id = 1;
        $place1->shape = new Polygon([new LineString([
            new Point(0, 0),
            new Point(0, 5),
            new Point(5, 5),
            new Point(5, 0),
            new Point(0, 0)
        ])]);

        $point = new Point(10, 10);
        return Geofence::disjoint('shape', $point)->get();
    }

    /**
     * @param Model $model
     * @param Model $location
     * @return mixed
     */
    public static function checkLocationUsingUserGeofences(Model $model, Model $location)
    {
        $intersected_geofences = $model->geofences()->intersects('shape', $location->location)->get();

        foreach ($intersected_geofences as $geofence) {
            self::checkIntersectedGeofence($model, $geofence, $location);
        }

        $disjoint_geofences = $model->geofences()->disjoint('shape', $location->location)->get();

        foreach ($disjoint_geofences as $geofence) {
            self::checkDisjointedGeofence($model, $geofence, $location);
        }
    }

    public static function createAccess(Model $model, Geofence $geofence, Model $location)
    {
        $model->accesses()->create([
            'uuid' => UniqueNameRepository::createIdentifier(),
            'geofence_id' => $geofence->id,
            'first_location_id' => $location->id,
            'last_location_id' => $location->id,
            'status' => static::IN_STATUS,
        ]);
        event(new GeofenceIn($location, $geofence, $model));
    }

    public static function inAndStillQuery(Model $model, Geofence $geofence)
    {
        return $model->accesses()->where([
            ['accessible_id', $model->id],
            ['accessible_type', get_class($model)],
            ['geofence_id', $geofence->id],
            ['status', static::STILL_STATUS],
        ])->orWhere([
            ['accessible_id', $model->id],
            ['accessible_type', get_class($model)],
            ['geofence_id', $geofence->id],
            ['status', static::IN_STATUS],
        ]);
    }

    public static function updateStillLog(Model $model, Geofence $geofence, Model $location)
    {
        static::inAndStillQuery($model, $geofence)->update([
            'last_location_id' => $location->id,
            'status' => static::STILL_STATUS,
        ]);
    }

    public static function updateOutLog(Model $model, Geofence $geofence, Model $location)
    {
        static::inAndStillQuery($model, $geofence)->update([
            'last_location_id' => $location->id,
            'status' => static::OUT_STATUS,
        ]);
        event(new GeofenceOut($location, $geofence, $model));
    }

    public static function checkIntersectedGeofence(Model $model, Geofence $geofence, Model $location)
    {
        if (static::inAndStillQuery($model, $geofence)->exists()) {
            static::updateStillLog($model, $geofence, $location);
        } else {
            static::createAccess($model, $geofence, $location);
        }
    }

    public static function checkDisjointedGeofence(Model $model, Geofence $geofence, Model $location)
    {
        if (static::inAndStillQuery($model, $geofence)->exists()) {
            static::updateOutLog($model, $geofence, $location);
        }
    }
}
