<?php

namespace App\Observers;

use App\Comment;
use Exception;
use Webpatser\Uuid\Uuid;

class CommentObserver
{
    /**
     * Handle the comment "creating" event.
     *
     * @param Comment $comment
     * @return void
     * @throws Exception
     */
    public function creating(Comment $comment)
    {
        $comment->uuid = Uuid::generate()->string;
    }
}
