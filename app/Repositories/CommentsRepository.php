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
        $comment->update(ParametersRepository::fillPropertiesWithRelated($request, ['body', 'is_public'], $comment));
        return $comment;
    }
}
