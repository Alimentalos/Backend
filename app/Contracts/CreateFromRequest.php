<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface CreateFromRequest
{
    /**
     * Create resource instance from request.
     *
     * @param Request $request
     * @return mixed
     */
    public function createViaRequest(Request $request);
}
