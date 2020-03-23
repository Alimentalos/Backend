<?php

namespace Alimentalos\Relationships\Observers;

use Alimentalos\Relationships\Models\Operation;

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
