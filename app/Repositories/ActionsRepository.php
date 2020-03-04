<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ActionsRepository
{
    /**
     * Resolve binding parameters to create activity logs.
     *
     * @param Request $request
     */
    public function create(Request $request) {
        $parameters = array_reverse(array_keys($request->route()->parameters()), false);
        if (count($parameters) > 0) {
            if (count($parameters) === 2) {
                $this->createReferencedActionViaRequest($request, $parameters);
            } else {
                $this->createSimpleReferencedActionViaRequest($request, $parameters);
            }
        } else {
            $this->createSimpleActionViaRequest($request);
        }
    }

    /**
     * Create referenced action via request.
     *
     * @param Request $request
     * @param $parameters
     */
    public function createReferencedActionViaRequest(Request $request, $parameters)
    {
        LoggerRepository::createReferencedAction(
            $request->user('api'),
            [
                'type' => 'success',
                'resource' => Route::currentRouteAction(),
                'parameters' => $request->route($parameters[0])->uuid ?? $parameters[0],
                'referenced' => $request->route($parameters[1])->uuid ?? $parameters[1]
            ]
        );
    }

    /**
     * Create simple referenced action via request.
     *
     * @param Request $request
     * @param $parameters
     */
    public function createSimpleReferencedActionViaRequest(Request $request, $parameters)
    {
        LoggerRepository::createReferencedAction(
            $request->user('api'),
            [
                'type' => 'success',
                'resource' => Route::currentRouteAction(),
                'parameters' => $request->except('photo', 'password', 'password_confirmation', 'shape'),
                'referenced' => $request->route($parameters[0])->uuid ?? $parameters[0]
            ]
        );
    }

    /**
     * Create simple action via request.
     *
     * @param Request $request
     */
    public function createSimpleActionViaRequest(Request $request)
    {
        LoggerRepository::createAction(
            $request->user('api'),
            'success',
            Route::currentRouteAction(),
            $request->except('photo', 'password', 'password_confirmation', 'shape')
        );
    }
}
