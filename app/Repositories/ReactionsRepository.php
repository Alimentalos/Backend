<?php

namespace App\Repositories;

use App\Contracts\Resource;
use Illuminate\Http\Request;

class ReactionsRepository
{
    /**
     * Fetch reactions via request.
     *
     * @param Request $request
     * @param Resource $resource
     * @return array
     */
    public static function fetchViaRequest(Request $request, Resource $resource)
    {
        return $resource->getAvailableReactions() == 'Follow' ?
            LikeRepository::generateFollowStats($resource->getLoveReactant(), $request->user('api')->getLoveReacter()) :
            LikeRepository::generateStats($resource->getLoveReactant(), $request->user('api')->getLoveReacter());
    }
}
