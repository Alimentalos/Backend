<?php

namespace App\Http\Controllers\Api\Pets\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\Reactions\StoreRequest;
use App\Pet;
use App\Repositories\LikeRepository;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, Pet $pet)
    {
        LikeRepository::updateLike(
            $pet->getLoveReactant(),
            $request->user('api')->getLoveReacter(),
            $request->input('type')
        );
        return response()->json(
            [],
            200
        );
    }
}
