<?php

namespace App\Contracts;

interface UpdateFromRequest
{
    /**
     * Create resource instance from request.
     *
     * @return mixed
     */
    public function updateViaRequest();
}
