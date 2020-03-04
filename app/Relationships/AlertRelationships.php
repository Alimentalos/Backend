<?php

namespace App\Relationships;

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
