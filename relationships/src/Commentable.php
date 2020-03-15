<?php

namespace Demency\Relationships;

use App\Comment;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait Commentable
{
    /**
     * The resource related comments.
     *
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable',
            'commentable_type',
            'commentable_id',
            'uuid'
        );
    }
}
