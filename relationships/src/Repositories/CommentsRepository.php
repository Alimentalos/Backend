<?php

namespace Alimentalos\Relationships\Repositories;

use Alimentalos\Relationships\Models\Comment;

class CommentsRepository
{
    /**
     * Update comment.
     *
     * @param Comment $comment
     * @return Comment
     */
    public static function update(Comment $comment)
    {
        $comment->update(parameters()->fill(['body', 'is_public'], $comment));
        return $comment;
    }
}
