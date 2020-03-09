<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RefreshTokenController extends Controller
{
    /**
     * @OA\Post(
     *  path="/refresh",
     *  operationId="getFreshToken",
     *  tags={"Authentication"},
     *  summary="Get fresh authentication token.",
     *  description="Returns the user personal access token.",
     *  @OA\Response(
     *      response=200,
     *      description="Token retrieved successfully"
     *  ),
     *  @OA\Response(response=401, description="Unauthenticated.")
     *  )
     *
     * Show the user api token.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        return token()->refresh();
    }
}
