<?php

namespace App\Repositories;

use App\Device;
use App\Geofence;
use App\Group;
use App\Pet;
use App\Photo;
use App\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as RequestFacade;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class HandleBindingRepository {

    /**
     * Resolve binding parameters to create activity logs.
     *
     * @param Request $request
     */
    public static function resolve(Request $request) {
        $parameters = array_reverse(array_keys($request->route()->parameters()), false);
        if (count($parameters) > 0) {
            if (count($parameters) === 2) {
                static::createReferencedActionViaRequest($request, $parameters);
            } else {
                static::createSimpleReferencedActionViaRequest($request, $parameters);
            }
        } else {
            static::createSimpleActionViaRequest($request);
        }
    }

    /**
     * Create referenced action via request.
     *
     * @param Request $request
     * @param $parameters
     */
    public static function createReferencedActionViaRequest(Request $request, $parameters)
    {
        LoggerRepository::createReferencedAction(
            $request->user('api'),
            [
                'type' => 'success',
                'resource' => Route::currentRouteAction(),
                'parameters' => $request->route($parameters[0])->id,
                'referenced' => $request->route($parameters[1])->id
            ]
        );
    }

    /**
     * Create simple referenced action via request.
     *
     * @param Request $request
     * @param $parameters
     */
    public static function createSimpleReferencedActionViaRequest(Request $request, $parameters)
    {
        LoggerRepository::createReferencedAction(
            $request->user('api'),
            [
                'type' => 'success',
                'resource' => Route::currentRouteAction(),
                'parameters' => $request->except('photo', 'password', 'password_confirmation', 'shape'),
                'referenced' => $request->route($parameters[0])->id ?? $parameters[0]
            ]
        );
    }

    /**
     * Create simple action via request.
     *
     * @param Request $request
     */
    public static function createSimpleActionViaRequest(Request $request)
    {
        LoggerRepository::createAction(
            $request->user('api'),
            'success',
            Route::currentRouteAction(),
            $request->except('photo', 'password', 'password_confirmation', 'shape')
        );
    }

    /**
     * Bind resource instance.
     *
     * @param $class
     * @param $uuid
     * @return Builder|Model
     */
    public static function bindResourceInstance($class, $uuid)
    {
        return static::bindResourceModel($class)->where('uuid', $uuid)->firstOrFail();
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
        return resolve('App\\' . Str::camel(Str::singular($class)))->query();
    }

    /**
     * Bind near resource model query.
     *
     * @param $resource
     * @param $coordinates
     * @return mixed
     */
    public static function bindNearModel($resource, $coordinates) {
        switch ($resource) {
            case 'geofences':
                return Geofence::orderByDistance('shape', static::makePoint($coordinates),'asc');
                break;
            case 'users':
                return User::orderByDistance('location', static::makePoint($coordinates),'asc');
                break;
            default:
                return Pet::orderByDistance('location', static::makePoint($coordinates),'asc');
        }
    }

    public static function makePoint($coordinates)
    {
        return new Point(
            floatval($coordinates[LocationRepository::LATITUDE]),
            floatval($coordinates[LocationRepository::LONGITUDE])
        );
    }
}
