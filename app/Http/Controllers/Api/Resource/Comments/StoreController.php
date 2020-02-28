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
        $comment = $resource->comments()->create([
            'uuid' => UniqueNameRepository::createIdentifier(),
            'body' => $request->input('body'),
            'user_id' => $request->user('api')->id,
        ]);

        return response()->json(
            $comment,
            200
        );
    }
}
