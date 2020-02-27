<?php

namespace App\Http\Controllers\Api\Comments;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comments\ShowRequest;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param ShowRequest $request
     * @param Comment $comment
     * @return JsonResponse
     */
    public function __invoke(ShowRequest $request, Comment $comment)
    {
        $comment->load('commentable');

        return response()->json(
            $comment,
            200
        );
    }
}
