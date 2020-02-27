<?php

namespace App\Http\Controllers\Api\Comments;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Comments\UpdateRequest;
use App\Repositories\FillRepository;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Comment $comment
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, Comment $comment)
    {
        $comment->update([
            'body' => FillRepository::fillMethod($request, 'body', $comment->body),
            'is_public' => FillRepository::fillMethod($request, 'is_public', $comment->is_public),
        ]);

        return response()->json(
            $comment,
            200
        );
    }
}
