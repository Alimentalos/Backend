<?php

namespace Alimentalos\Relationships\Relationships;

trait LocationRelationships
{
    /**
     * Get all of the owning trackable models.
     */
    public function trackable()
    {
        return $this->morphTo(
            'trackable',
            'trackable_type',
            'trackable_id',
            'uuid'
        );
    }
}
