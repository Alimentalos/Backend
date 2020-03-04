<?php

namespace App\Relationships;

trait CommentRelationships
{
    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo();
    }
}
