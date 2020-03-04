<?php


namespace App\Repositories;


use Illuminate\Http\Request;

class ResourceCommentsRepository
{
    public static function createCommentViaRequest(Request $request, $resource)
    {
        return $resource->comments()->create(['uuid' => UniqueNameRepository::createIdentifier(), 'body' => $request->input('body'), 'user_uuid' => $request->user('api')->uuid]);
    }
}
