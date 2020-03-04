<?php

use App\Repositories\ActionsRepository;
use App\Repositories\FinderRepository;

if (! function_exists('actions')) {
    function actions()
    {
        return new ActionsRepository();
    }
}

if (! function_exists('finder')) {
    function finder($actions = null, $class = null, $identifier = null) {

        if (in_array($actions, ['resourceModelInstance', 'resourceModelClass', 'resourceInstance', 'detectType', 'nearModels', 'resolve', 'resource', 'resourceModel'])) {
            switch ($actions) {
                case 'resourceModel':
                    return FinderRepository::bindResourceModel($class);
                    break;
                case 'resourceModelClass':
                    return FinderRepository::bindResourceModelClass($class);
                    break;
                case 'resource':
                    return FinderRepository::bindResource($class);
                    break;
                case 'resolve':
                    FinderRepository::resolve($class);
                    break;
                case 'nearModels':
                    return FinderRepository::bindNearModel($class, $identifier);
                    break;
                case 'resourceModelInstance':
                    // This will be resolve a singular or plural class instance in App folder.
                    return FinderRepository::bindResourceModelInstance($class, $identifier);
                    break;
                case 'detectType':
                    // This will be detect which resource is used. Paths like '/user' or '/geofences' will be resolve 'user' and 'geofences' respectively.
                    return FinderRepository::detectResourceType();
                    break;
                default:
                    // This will be resolve a full class name instance.
                    return FinderRepository::bindResourceInstance($class, $identifier);
                    break;
            }
        }

        return resolve(FinderRepository::class);
    }
}
