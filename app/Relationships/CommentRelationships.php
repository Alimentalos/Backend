<?php

namespace App\Relationships;

use App\Comment;
use App\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait CommentRelationships
{
    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * The related User.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_uuid','uuid');
    }

    /**
     * The related Comments.
     *
     * @return MorphMany
     */
    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable','commentable_type','commentable_id','uuid');
    }
}
