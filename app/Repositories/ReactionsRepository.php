<?php

namespace App\Repositories;

use App\Contracts\Resource;

class ReactionsRepository
{
    /**
     * Fetch reactions via request.
     *
     * @param Resource $resource
     * @return array
     */
    public function fetchViaRequest(Resource $resource)
    {
        return $resource->getAvailableReactions() == 'Follow' ?
            likes()->followStats($resource->getLoveReactant(), authenticated()->getLoveReacter()) :
            likes()->stats($resource->getLoveReactant(), authenticated()->getLoveReacter());
    }
}
