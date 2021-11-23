<?php

namespace Alimentalos\Relationships;

use App\Models\Comment;
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
        return $this->morphMany(Comment::class, 'commentable','commentable_type','commentable_id','uuid');
    }
}
