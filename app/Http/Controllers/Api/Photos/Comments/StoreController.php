<?php

namespace App\Http\Controllers\Api\Photos\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photos\Comments\StoreRequest;
use App\Photo;
use App\Repositories\UniqueNameRepository;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param StoreRequest $request
     * @param Photo $photo
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, Photo $photo)
    {
        $comment = $photo->comments()->create([
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
