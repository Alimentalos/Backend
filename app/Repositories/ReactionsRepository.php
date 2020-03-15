<?php

namespace App\Repositories;

use Demency\Contracts\Resource;

class ReactionsRepository
{
    /**
     * Fetch reactions via request.
     *
     * @param Resource $resource
     * @return array
     */
    public function index(Resource $resource)
    {
        return $resource->getAvailableReactions() == 'Follow' ?
            likes()->followStats($resource->getLoveReactant(), authenticated()->getLoveReacter()) :
            likes()->stats($resource->getLoveReactant(), authenticated()->getLoveReacter());
    }
}
