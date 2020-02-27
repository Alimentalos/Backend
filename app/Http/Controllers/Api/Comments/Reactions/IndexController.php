<?php

namespace App\Http\Controllers\Api\Comments\Reactions;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comments\Reactions\IndexRequest;
use App\Repositories\LikeRepository;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request, Comment $comment)
    {
        return response()->json(
            LikeRepository::generateStats($comment->getLoveReactant(), $request->user('api')->getLoveReacter()),
            200
        );
    }
}
