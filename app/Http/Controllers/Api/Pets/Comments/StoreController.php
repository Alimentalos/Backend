<?php

namespace App\Http\Controllers\Api\Pets\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\Comments\StoreRequest;
use App\Pet;
use App\Repositories\UniqueNameRepository;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param StoreRequest $request
     * @param Pet $pet
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, Pet $pet)
    {
        $comment = $pet->comments()->create([
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
