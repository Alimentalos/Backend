<?php

namespace App\Repositories;

use App\Contracts\Trackable;
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
    public function findModelInstance($class, $uuid)
    {
        return $this->findModel($class)->where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Bind resource instance.
     * (Doesn't uses 'App' prefix)
     *
     * @param $resource
     * @param $uuid
     * @return mixed
     */
    public function findInstance($resource, $uuid)
    {
        return $this->findQuery($resource)->where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Get resource type based on first parameter of request path.
     *
     * @return mixed
     */
    public function currentResource()
    {
        return explode('.', RequestFacade::route()->getName())[0];
    }

    /**
     * Bind resource model query.
     *
     * @param $class
     * @return Builder
     */
    public function findModel($class) {
        return $this->findQuery('App\\' . Str::camel(Str::singular($class)));
    }

    /**
     * Find resource type class.
     *
     * @param $class
     * @return mixed
     */
    public function findClass($class) {
        return $this->find('App\\' . Str::camel(Str::singular($class)));
    }

    /**
     * Bind resource.
     *
     * @param $resource
     * @return mixed
     */
    public function find($resource)
    {
        return resolve($resource);
    }

    /**
     * Bind resource query.
     *
     * @param $resource
     * @return mixed
     */
    public function findQuery($resource)
    {
        return $this->find($resource)->query();
    }

    /**
     * Bind near resource model query using comma-separated coordinates.
     *
     * @param $resource
     * @param $coordinates
     * @return mixed
     */
    public function findNearResources($resource, $coordinates) {
        return $resource->orderByDistance(
            $resource::DEFAULT_LOCATION_FIELD,
            locations()->parsePointFromCoordinates($coordinates),
            'asc'
        );
    }
}
