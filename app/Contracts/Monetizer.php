<?php

namespace App\Contracts;

interface Monetizer
{
    /**
     * Get coins instances of resource.
     *
     * @return mixed
     */
    public function coins();
}
