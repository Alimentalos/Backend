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
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request as RequestFacade;

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
                LoggerRepository::createReferencedAction(
                    $request->user('api'),
                    'success',
                    Route::currentRouteAction(),
                    $request->route($parameters[0])->id,
                    $request->route($parameters[1])->id
                );
            } else {
                LoggerRepository::createReferencedAction(
                    $request->user('api'),
                    'success',
                    Route::currentRouteAction(),
                    $request->except('photo', 'password', 'password_confirmation', 'shape'),
                    $request->route($parameters[0])->id ?? $parameters[0]
                );
            }

        } else {
            LoggerRepository::createAction(
                $request->user('api'),
                'success',
                Route::currentRouteAction(),
                $request->except('photo', 'password', 'password_confirmation', 'shape')
            );
        }
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
        switch ($class) {
            case 'photos':
                return Photo::query();
                break;
            case 'groups':
                return Group::query();
                break;
            case 'users':
                return User::query();
                break;
            case 'devices':
                return Device::query();
                break;
            default:
                return Pet::query();
                break;
        }
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
                return Geofence::orderByDistance(
                    'shape',
                    (new Point(
                        floatval($coordinates[LocationRepository::LATITUDE]),
                        floatval($coordinates[LocationRepository::LONGITUDE])
                    )),
                    'asc'
                );
                break;
            case 'users':
                return User::orderByDistance(
                    'location',
                    (new Point(
                        floatval($coordinates[LocationRepository::LATITUDE]),
                        floatval($coordinates[LocationRepository::LONGITUDE])
                    )),
                    'asc'
                );
                break;
            default:
                return Pet::orderByDistance(
                    'location',
                    (new Point(
                        floatval($coordinates[LocationRepository::LATITUDE]),
                        floatval($coordinates[LocationRepository::LONGITUDE])
                    )),
                    'asc'
                );
        }
    }
}
