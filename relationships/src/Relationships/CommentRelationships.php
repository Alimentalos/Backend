<?php

namespace Alimentalos\Relationships\Relationships;

trait CommentRelationships
{
    /**
     * Get all of the owning commentable models.
     */
    public function commentable()
    {
        return $this->morphTo(
            'commentable',
            'commentable_type',
            'commentable_id',
            'uuid'
        );
    }
}
