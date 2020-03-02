<?php

namespace App\Observers;

use App\Comment;
use App\Repositories\UniqueNameRepository;

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
        $comment->uuid = UniqueNameRepository::createIdentifier();
    }
}
