<?php

namespace App\Repositories;

use App\Contracts\Resource;

class ResourceCommentsRepository
{
    /**
     * Create resource comment via request.
     *
     * @param Resource $resource
     * @return mixed
     */
    public function createViaRequest(Resource $resource)
    {
        return $resource->comments()->create([
            'uuid' => uuid(),
            'body' => input('body'),
            'user_uuid' => authenticated()->uuid
        ]);
    }
}
