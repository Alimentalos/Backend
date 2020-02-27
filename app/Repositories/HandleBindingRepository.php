<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Route;

class HandleBindingRepository {

    public static function resolve($request) {
        $parameters = array_keys($request->route()->parameters());
        if (count($parameters) > 0) {
            if (count($parameters) === 2) {
                LoggerRepository::createReferencedAction(
                    $request->user('api'),
                    'success',
                    Route::currentRouteAction(),
                    $request->route($parameters[1])->id,
                    $request->route($parameters[0])->id
                );
            } else {
                LoggerRepository::createReferencedAction(
                    $request->user('api'),
                    'success',
                    Route::currentRouteAction(),
                    $request->except('photo', 'password', 'password_confirmation', 'shape'),
                    $request->route($parameters[0])->id
                );
            }

        } else {
            LoggerRepository::createAction(
                $request->user('api'),
                'success',
                Route::currentRouteAction(),
                $request->except('photo', 'password', 'password_confirmation', 'shape'),
            );
        }
    }
}
