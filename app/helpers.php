<?php

use App\Contracts\Resource;
use App\Repositories\ActionsRepository;
use App\Repositories\FinderRepository;
use App\Repositories\ResourceRepository;

if (! function_exists('actions')) {
    /**
     * @return ActionsRepository
     */
    function actions()
    {
        return new ActionsRepository();
    }
}

if (! function_exists('finder')) {
    /**
     * @return FinderRepository
     */
    function finder() {
        return new FinderRepository();
    }
}

if (! function_exists('resource')) {
    /**
     * @return Resource
     */
    function resource()
    {
        return (new ResourceRepository())->currentResource();
    }
}
