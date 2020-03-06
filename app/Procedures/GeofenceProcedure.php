<?php


namespace App\Procedures;


use App\Events\GeofenceIn;
use App\Events\GeofenceOut;
use App\Geofence;
use App\Repositories\UniqueNameRepository;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

trait GeofenceProcedure
{
    /**
     * Check if location is using model geofence.
     *
     * @param Model $model
     * @param Model $location
     * @return void
     */
    public function checkLocationUsingModelGeofences(Model $model, Model $location)
    {
        $intersected_geofences = $model->geofences()->intersects('shape', $location->location)->get();

        foreach ($intersected_geofences as $geofence) {
            $this->checkIntersectedGeofence($model, $geofence, $location);
        }

        $disjoint_geofences = $model->geofences()->disjoint('shape', $location->location)->get();

        foreach ($disjoint_geofences as $geofence) {
            $this->checkDisjointedGeofence($model, $geofence, $location);
        }
    }

    /**
     * Create model accesses.
     *
     * @param Model $model
     * @param Geofence $geofence
     * @param Model $location
     * @return void
     */
    public function createAccess(Model $model, Geofence $geofence, Model $location)
    {
        $model->accesses()->create([
            'uuid' => uuid(),
            'geofence_uuid' => $geofence->uuid,
            'first_location_uuid' => $location->uuid,
            'last_location_uuid' => $location->uuid,
            'status' => static::IN_STATUS,
        ]);
        event(new GeofenceIn($location, $geofence, $model));
    }

    /**
     * Get in and still in accesses query.
     *
     * @param Model $model
     * @param Geofence $geofence
     * @return Builder
     */
    public function inAndStillAccessQuery(Model $model, Geofence $geofence)
    {
        return $model->accesses()->where([
            ['accessible_id', $model->uuid],
            ['accessible_type', get_class($model)],
            ['geofence_uuid', $geofence->uuid],
            ['status', static::STILL_STATUS],
        ])->orWhere([
            ['accessible_id', $model->uuid],
            ['accessible_type', get_class($model)],
            ['geofence_uuid', $geofence->uuid],
            ['status', static::IN_STATUS],
        ]);
    }

    /**
     * Update in or still access using the last known location and still status.
     *
     * @param Model $model
     * @param Geofence $geofence
     * @param Model $location
     */
    public function updateStillAccess(Model $model, Geofence $geofence, Model $location)
    {
        $this->inAndStillAccessQuery($model, $geofence)->update([
            'last_location_uuid' => $location->uuid,
            'status' => self::STILL_STATUS,
        ]);
    }

    /**
     * Update in or still access using the las known location and out status.
     *
     * @param Model $model
     * @param Geofence $geofence
     * @param Model $location
     */
    public function updateOutAccess(Model $model, Geofence $geofence, Model $location)
    {
        $this->inAndStillAccessQuery($model, $geofence)->update([
            'last_location_uuid' => $location->uuid,
            'status' => self::OUT_STATUS,
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
    public function checkIntersectedGeofence(Model $model, Geofence $geofence, Model $location)
    {
        if ($this->inAndStillAccessQuery($model, $geofence)->exists()) {
            $this->updateStillAccess($model, $geofence, $location);
        } else {
            $this->createAccess($model, $geofence, $location);
        }
    }

    /**
     * Check disjointed geofences of model location.
     *
     * @param Model $model
     * @param Geofence $geofence
     * @param Model $location
     */
    public function checkDisjointedGeofence(Model $model, Geofence $geofence, Model $location)
    {
        if ($this->inAndStillAccessQuery($model, $geofence)->exists()) {
            $this->updateOutAccess($model, $geofence, $location);
        }
    }

    /**
     * Create points from shape input.
     *
     * @param $shape
     * @return array
     */
    public function createPointsFromShape($shape)
    {
        return array_map(function ($element) {
            return new Point($element['latitude'], $element['longitude']);
        }, $shape);
    }

    /**
     * Create sample polygon.
     *
     * @return array
     */
    public function createSamplePolygon()
    {
        return [new LineString([
            new Point(0, 0),
            new Point(0, 5),
            new Point(5, 5),
            new Point(5, 0),
            new Point(0, 0)
        ])];
    }
}
