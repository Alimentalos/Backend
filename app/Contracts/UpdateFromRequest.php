<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface UpdateFromRequest
{
    /**
     * Create resource instance from request.
     *
     * @param Request $request
     * @return mixed
     */
    public function updateViaRequest(Request $request);
}
