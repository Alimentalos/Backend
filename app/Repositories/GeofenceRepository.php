<?php

namespace App\Repositories;

use App\Events\GeofenceIn;
use App\Events\GeofenceOut;
use App\Geofence;
use App\Photo;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

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
     * Update geofence via request.
     *
     * @param Request $request
     * @param Geofence $geofence
     */
    public static function updateGeofenceViaRequest(Request $request, Geofence $geofence)
    {
        $geofence->name = FillRepository::fillMethod($request, 'name', $geofence->name);
        $shape = array_map(function ($element) {
            return new Point($element['latitude'], $element['longitude']);
        }, $request->input('shape'));
        $geofence->shape = new Polygon([new LineString($shape)]);
        $geofence->is_public = FillRepository::fillMethod($request, 'is_public', $geofence->is_public);
        $geofence->save();
    }

    /**
     * Create geofence via request.
     *
     * @param Request $request
     * @param Photo $photo
     * @return Geofence
     */
    public static function createGeofenceViaRequest(Request $request, Photo $photo)
    {
        $geofence = new Geofence();
        $geofence->uuid = UniqueNameRepository::createIdentifier();
        $geofence->photo_id = $photo->id;
        $geofence->name = $request->input('name');
        $geofence->user_id = $request->user('api')->id;
        $geofence->photo_url = 'https://storage.googleapis.com/photos.zendev.cl/photos/' . $photo->photo_url;

        $shape = array_map(function ($element) {
            return new Point($element['latitude'], $element['longitude']);
        }, $request->input('shape'));
        $geofence->shape = new Polygon([new LineString($shape)]);
        $geofence->is_public = $request->input('is_public');
        $geofence->save();
        return $geofence;
    }

    /**
     * Check if location is using model geofence.
     *
     * @param Model $model
     * @param Model $location
     * @return mixed
     */
    public static function checkLocationUsingModelGeofences(Model $model, Model $location)
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

    /**
     * Create model accesses.
     *
     * @param Model $model
     * @param Geofence $geofence
     * @param Model $location
     */
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

    /**
     * Get in and still in accesses query.
     *
     * @param Model $model
     * @param Geofence $geofence
     * @return mixed
     */
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

    /**
     * Update access to still in status.
     *
     * @param Model $model
     * @param Geofence $geofence
     * @param Model $location
     */
    public static function updateStillLog(Model $model, Geofence $geofence, Model $location)
    {
        static::inAndStillQuery($model, $geofence)->update([
            'last_location_id' => $location->id,
            'status' => static::STILL_STATUS,
        ]);
    }

    /**
     * Update access to out status.
     *
     * @param Model $model
     * @param Geofence $geofence
     * @param Model $location
     */
    public static function updateOutLog(Model $model, Geofence $geofence, Model $location)
    {
        static::inAndStillQuery($model, $geofence)->update([
            'last_location_id' => $location->id,
            'status' => static::OUT_STATUS,
        ]);
        event(new GeofenceOut($location, $geofence, $model));
    }

    /**
     * Check intersected geofences of model location.
     *
     * @param Model $model
     * @param Geofence $geofence
     * @param Model $location
     */
    public static function checkIntersectedGeofence(Model $model, Geofence $geofence, Model $location)
    {
        if (static::inAndStillQuery($model, $geofence)->exists()) {
            static::updateStillLog($model, $geofence, $location);
        } else {
            static::createAccess($model, $geofence, $location);
        }
    }

    /**
     * Check disjointed geofences of model location.
     *
     * @param Model $model
     * @param Geofence $geofence
     * @param Model $location
     */
    public static function checkDisjointedGeofence(Model $model, Geofence $geofence, Model $location)
    {
        if (static::inAndStillQuery($model, $geofence)->exists()) {
            static::updateOutLog($model, $geofence, $location);
        }
    }
}
