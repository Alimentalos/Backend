<?php

use App\Repositories\HandleBindingRepository;

if (! function_exists('finder')) {
    function finder($actions = null, $class = null, $identifier = null) {

        if (in_array($actions, ['resourceModelInstance', 'resourceModelClass', 'resourceInstance', 'detectType', 'nearModels', 'resolve', 'resource', 'resourceModel'])) {
            switch ($actions) {
                case 'resourceModel':
                    return HandleBindingRepository::bindResourceModel($class);
                    break;
                case 'resourceModelClass':
                    return HandleBindingRepository::bindResourceModelClass($class);
                    break;
                case 'resource':
                    return HandleBindingRepository::bindResource($class);
                    break;
                case 'resolve':
                    HandleBindingRepository::resolve($class);
                    break;
                case 'nearModels':
                    return HandleBindingRepository::bindNearModel($class, $identifier);
                    break;
                case 'resourceModelInstance':
                    // This will be resolve a singular or plural class instance in App folder.
                    return HandleBindingRepository::bindResourceModelInstance($class, $identifier);
                    break;
                case 'detectType':
                    // This will be detect which resource is used. Paths like '/user' or '/geofences' will be resolve 'user' and 'geofences' respectively.
                    return HandleBindingRepository::detectResourceType();
                    break;
                default:
                    // This will be resolve a full class name instance.
                    return HandleBindingRepository::bindResourceInstance($class, $identifier);
                    break;
            }
        }

        return resolve(HandleBindingRepository::class);
    }
}
