<?php

namespace Alimentalos\Relationships\Observers;

use Alimentalos\Relationships\Models\Comment;

class CommentObserver
{
    /**
     * Handle the comment "creating" event.
     *
     * @param Comment $comment
     * @return void
     */
    public function creating(Comment $comment)
    {
        $comment->uuid = uuid();
    }
}
