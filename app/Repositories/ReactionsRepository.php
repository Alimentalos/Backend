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
            likes()->generateFollowStats($resource->getLoveReactant(), authenticated()->getLoveReacter()) :
            likes()->generateStats($resource->getLoveReactant(), authenticated()->getLoveReacter());
    }
}
