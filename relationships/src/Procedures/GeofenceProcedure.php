<?php


namespace Alimentalos\Relationships\Procedures;


use Alimentalos\Relationships\Events\GeofenceIn;
use Alimentalos\Relationships\Events\GeofenceOut;
use Alimentalos\Relationships\Models\Geofence;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

trait GeofenceProcedure
{
    /**
     * In status.
     */
    public $in_status = 1;

    /**
     * Still status.
     */
    public $still_status = 2;

    /**
     * Out status.
     */
    public $out_status = 3;

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
            'status' => $this->in_status,
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
            ['status', $this->still_status],
        ])->orWhere([
            ['accessible_id', $model->uuid],
            ['accessible_type', get_class($model)],
            ['geofence_uuid', $geofence->uuid],
            ['status', $this->in_status],
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
            'status' => $this->still_status,
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
            'status' => $this->out_status,
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

    /**
     * Create geofence instance.
     *
     * @return Geofence
     */
    public function createInstance()
    {
        $photo = photos()->create();
        $geofence = new Geofence();
        $geofence->uuid = uuid();
        $geofence->photo_uuid = $photo->uuid;
        $geofence->name = input('name');
        $geofence->user_uuid = authenticated()->uuid;
        $geofence->photo_url = config('storage.path') . $photo->photo_url;
        $geofence->marker = fill('marker', null);
        foreach(Geofence::getColors() as $attribute) {
            $geofence->{$attribute} = fill($attribute, null);
        }

        $shape = $this->createPointsFromShape(input('shape'));
        $geofence->shape = new Polygon([new LineString($shape)]);
        $geofence->is_public = input('is_public');
        $geofence->save();
        $photo->geofences()->attach($geofence->uuid);
        return $geofence;
    }

    /**
     * Update geofence instance.
     *
     * @param Geofence $geofence
     * @return Geofence
     */
    public function updateInstance(Geofence $geofence)
    {
        upload()->check($geofence);
        $geofence->name = fill('name', $geofence->name);
        $shape = array_map(function ($element) {
            return new Point($element['latitude'], $element['longitude']);
        }, input('shape'));
        $geofence->shape = new Polygon([new LineString($shape)]);
        $geofence->is_public = fill('is_public', $geofence->is_public);
        $geofence->marker = fill('marker', $geofence->marker);
        foreach(Geofence::getColors() as $attribute) {
            $geofence->{$attribute} = fill($attribute, $geofence->{$attribute});
        }
        $geofence->save();
        return $geofence;
    }
}
