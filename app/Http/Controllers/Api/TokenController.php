<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Token\IndexRequest;
use App\Repositories\TokenRepository;
use Illuminate\Http\JsonResponse;

class TokenController extends Controller
{
    /**
     * @OA\Get(
     *  path="/token",
     *  operationId="getUserToken",
     *  tags={"Authentication"},
     *  summary="Get authentication token based on user credentials",
     *  description="Returns the user personal access token",
     *  @OA\Response(
     *      response=200,
     *      description="Token fetched successfully"
     *  ),
     *  @OA\Response(response=401, description="Unauthenticated.")
     *  )
     *
     * Show the user api token.
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        return token()->handle();
    }
}
