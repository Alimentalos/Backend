<?php

namespace Alimentalos\Contracts;

interface CreateFromRequest
{
    /**
     * Create resource instance from request.
     *
     * @return mixed
     */
    public function createViaRequest();
}
