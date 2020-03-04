<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Token\IndexRequest;
use App\Repositories\TokenRepository;
use Illuminate\Http\JsonResponse;

class TokenController extends Controller
{
    /**
     * Show the user api token.
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        return TokenRepository::handleAuthentication($request);
    }
}
