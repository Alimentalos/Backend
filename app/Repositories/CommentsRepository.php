<?php

namespace App\Repositories;

use App\Comment;
use Illuminate\Http\Request;

class CommentsRepository
{
    /**
     * Update comment via request.
     *
     * @param Request $request
     * @param Comment $comment
     * @return Comment
     */
    public static function updateCommentViaRequest(Request $request, Comment $comment)
    {
        $comment->update([
            'body' => FillRepository::fillMethod($request, 'body', $comment->body),
            'is_public' => FillRepository::fillMethod($request, 'is_public', $comment->is_public),
        ]);
        return $comment;
    }
}
