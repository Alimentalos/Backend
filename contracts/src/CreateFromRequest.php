<?php

namespace Demency\Contracts;

interface CreateFromRequest
{
    /**
     * Create resource instance from request.
     *
     * @return mixed
     */
    public function createViaRequest();
}
