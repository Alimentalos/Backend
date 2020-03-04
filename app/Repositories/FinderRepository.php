<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Str;

class FinderRepository {

    /**
     * Bind resource model instance.
     * (Uses prefix 'App')
     *
     * @param $class
     * @param $uuid
     * @return Builder|Model
     */
    public static function bindResourceModelInstance($class, $uuid)
    {
        return static::bindResourceModel($class)->where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Bind resource instance.
     * (Doesn't uses 'App' prefix)
     *
     * @param $resource
     * @param $uuid
     * @return mixed
     */
    public static function bindResourceInstance($resource, $uuid)
    {
        return static::bindResourceQuery($resource)->where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Detect resource type based on first request path parameter.
     *
     * @return mixed
     */
    public static function detectResourceType()
    {
        return explode('.', RequestFacade::route()->getName())[0];
    }

    /**
     * Bind resource model query.
     *
     * @param $class
     * @return Builder
     */
    public static function bindResourceModel($class) {
        return static::bindResourceQuery('App\\' . Str::camel(Str::singular($class)));
    }

    /**
     * Bind resource model class.
     *
     * @param $class
     * @return mixed
     */
    public static function bindResourceModelClass($class) {
        return static::bindResource('App\\' . Str::camel(Str::singular($class)));
    }

    /**
     * Bind resource.
     *
     * @param $resource
     * @return mixed
     */
    public static function bindResource($resource)
    {
        return resolve($resource);
    }

    /**
     * Bind resource query.
     *
     * @param $resource
     * @return mixed
     */
    public static function bindResourceQuery($resource)
    {
        return static::bindResource($resource)->query();
    }

    /**
     * Bind near resource model query using comma-separated coordinates.
     *
     * @param $resource
     * @param $coordinates
     * @return mixed
     */
    public static function bindNearModel($resource, $coordinates) {
        $model = static::bindResourceModel($resource);
        return $model->orderByDistance(
            static::bindResourceModelClass($resource)::DEFAULT_LOCATION_FIELD,
            LocationsRepository::parsePointFromCoordinates($coordinates),
            'asc'
        );
    }
}
