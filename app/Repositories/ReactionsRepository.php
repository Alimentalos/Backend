<?php

namespace App\Repositories;

use App\Contracts\Resource;
use Illuminate\Http\Request;

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
            LikeRepository::generateFollowStats($resource->getLoveReactant(), authenticated()->getLoveReacter()) :
            LikeRepository::generateStats($resource->getLoveReactant(), authenticated()->getLoveReacter());
    }
}
