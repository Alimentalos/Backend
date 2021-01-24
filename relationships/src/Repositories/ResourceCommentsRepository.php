<?php

namespace Alimentalos\Relationships\Repositories;

use App\Contracts\Resource;

class ResourceCommentsRepository
{
    /**
     * Create resource comment.
     *
     * @param Resource $resource
     * @return mixed
     */
    public function create(Resource $resource)
    {
        return $resource->comments()->create([
            'uuid' => uuid(),
            'body' => input('body'),
            'user_uuid' => authenticated()->uuid
        ]);
    }
}
