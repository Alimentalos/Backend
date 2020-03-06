<?php

namespace App\Repositories;

use App\Action;
use App\Lists\ActionList;
use App\Procedures\ActionProcedure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ActionsRepository
{
    use ActionList;
    use ActionProcedure;

    /**
     * Resolve binding parameters to create activity logs.
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request) {
        $parameters = array_reverse(array_keys($request->route()->parameters()), false);
        if (count($parameters) > 0) {
            if (count($parameters) === 2) {
                $this->createReferencedActionViaRequest($parameters);
            } else {
                $this->createSimpleReferencedActionViaRequest($parameters);
            }
        } else {
            $this->createSimpleActionViaRequest();
        }
    }

    /**
     * Create referenced action via request.
     *
     * @param $parameters
     * @return void
     */
    public function createReferencedActionViaRequest($parameters)
    {
        $this->createReferencedAction(
            [
                'type' => 'success',
                'resource' => Route::currentRouteAction(),
                'parameters' => request()->route($parameters[0])->uuid ?? $parameters[0],
                'referenced' => request()->route($parameters[1])->uuid ?? $parameters[1]
            ]
        );
    }

    /**
     * Create simple referenced action via request.
     *
     * @param $parameters
     */
    public function createSimpleReferencedActionViaRequest($parameters)
    {
        $this->createReferencedAction(
            [
                'type' => 'success',
                'resource' => Route::currentRouteAction(),
                'parameters' => request()->except('photo', 'password', 'password_confirmation', 'shape'),
                'referenced' => request()->route($parameters[0])->uuid ?? $parameters[0]
            ]
        );
    }

    /**
     * Create simple action via request.
     *
     * @return void
     */
    public function createSimpleActionViaRequest()
    {
        $this->createAction(
            'success',
            Route::currentRouteAction(),
            request()->except('photo', 'password', 'password_confirmation', 'shape')
        );
    }

    /**
     * Create non referenced action.
     *
     * @param $type
     * @param $resource
     * @param $parameters
     * @return Action
     */
    public function createAction($type, $resource, $parameters)
    {
        return Action::create($this->parameters($type, $parameters, $resource));
    }

    /**
     * Create referenced action.
     *
     * @param $parameters
     * @return Action
     */
    public function createReferencedAction($parameters)
    {
        return Action::create(
            $this->parameters(
                $parameters['type'], $parameters['parameters'], $parameters['resource'], $parameters['referenced']
            )
        );
    }
}
