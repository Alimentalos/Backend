<?php

namespace App\Http\Controllers\Api\Comments\Comments;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Models\Comments\IndexRequest;

class IndexController extends Controller
{
    public function __invoke(IndexRequest $request, Comment $comment)
    {
        return response()->json(
            $comment->comments()->with('user')->latest()->paginate(20),
            200
        );
    }
}
