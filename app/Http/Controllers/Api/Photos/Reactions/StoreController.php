<?php

namespace App\Http\Controllers\Api\Photos\Reactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photos\Reactions\StoreRequest;
use App\Photo;
use App\Repositories\LikeRepository;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, Photo $photo)
    {
        LikeRepository::updateLike(
            $photo->getLoveReactant(),
            $request->user('api')->getLoveReacter(),
            $request->input('type')
        );
        return response()->json(
            [],
            200
        );
    }
}
