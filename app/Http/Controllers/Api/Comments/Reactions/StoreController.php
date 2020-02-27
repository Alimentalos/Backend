<?php

namespace App\Http\Controllers\Api\Comments\Reactions;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comments\Reactions\StoreRequest;
use App\Repositories\LikeRepository;

class StoreController extends Controller
{
    public function __invoke(StoreRequest $request, Comment $comment)
    {
        LikeRepository::updateLike(
            $comment->getLoveReactant(),
            $request->user('api')->getLoveReacter(),
            $request->input('type')
        );
        return response()->json(
            [],
            200
        );
    }
}
