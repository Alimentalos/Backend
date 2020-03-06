<?php

namespace App\Repositories;

use App\Comment;
use Illuminate\Http\Request;

class CommentsRepository
{
    /**
     * Update comment via request.
     *
     * @param Comment $comment
     * @return Comment
     */
    public static function updateCommentViaRequest(Comment $comment)
    {
        $comment->update(parameters()->fill(['body', 'is_public'], $comment));
        return $comment;
    }
}
