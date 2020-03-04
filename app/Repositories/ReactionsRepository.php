<?php


namespace App\Repositories;


use Illuminate\Http\Request;

class ReactionsRepository
{
    /**
     * Fetch reactions via request.
     *
     * @param Request $request
     * @param $resource
     * @return array
     */
    public static function fetchViaRequest(Request $request, $resource)
    {
        return binder()::bindResource(get_class($resource))::AVAILABLE_REACTIONS == 'Follow' ?
            LikeRepository::generateFollowStats($resource->getLoveReactant(), $request->user('api')->getLoveReacter()) :
            LikeRepository::generateStats($resource->getLoveReactant(), $request->user('api')->getLoveReacter());
    }
}
