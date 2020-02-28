<?php

namespace App\Repositories;

use App\Device;
use App\Geofence;
use App\Group;
use App\Pet;
use App\Photo;
use App\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class HandleBindingRepository {

    public static function resolve($request) {
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

    public static function bindResourceInstance($class, $uuid)
    {
        return static::bindModel($class)->where('uuid', $uuid)->firstOrFail();
    }

    /**
     * Detect resource type based on first request path parameter.
     *
     * @return mixed
     */
    public static function detectResourceType()
    {
        return explode('.', Request::route()->getName())[0];
    }

    public static function bindModel($class) {
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
