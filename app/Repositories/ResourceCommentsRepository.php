<?php

namespace App\Repositories;

class ResourceCommentsRepository
{
    public function createCommentViaRequest($resource)
    {
        return $resource->comments()->create([
            'uuid' => uuid(),
            'body' => input('body'),
            'user_uuid' => authenticated()->uuid
        ]);
    }
}
