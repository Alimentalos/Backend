<?php

namespace Demency\Relationships\Relationships;

trait AlertRelationships
{
    /**
     * The related alert resource.
     */
    public function alert()
    {
        return $this->morphTo();
    }
}
