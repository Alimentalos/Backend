<?php

namespace Demency\Relationships\Observers;

use Demency\Relationships\Models\Operation;

class OperationObserver
{
    /**
     * Handle the operation "creating" event.
     *
     * @param Operation $operation
     * @return void
     */
    public function creating(Operation $operation)
    {
        $operation->uuid = uuid();
    }
}
