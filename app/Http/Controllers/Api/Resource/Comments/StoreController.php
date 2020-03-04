<?php

namespace App\Http\Controllers\Api\Resource\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Comments\StoreRequest;
use App\Repositories\UniqueNameRepository;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param StoreRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, $resource)
    {
        // TODO - Reduce number of lines of Resource Comments StoreController
        // @body move into repository method as fetchViaRequest.
        $comment = $resource->comments()->create([
            'uuid' => UniqueNameRepository::createIdentifier(),
            'body' => $request->input('body'),
            'user_uuid' => $request->user('api')->uuid,
        ]);

        return response()->json($comment,200);
    }
}
