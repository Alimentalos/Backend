<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * @OA\Get(
     *  path="/logout",
     *  operationId="getLogout",
     *  tags={"Authentication"},
     *  summary="Invalidates user access token.",
     *  description="Returns message JSON Object response.",
     *  @OA\Response(
     *      response=200,
     *      description="Token invalidated successfully"
     *  ),
     *  @OA\Response(response=401, description="Unauthenticated.")
     *  )
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        auth('api')->logout();
        return response()->json(['message' => 'Token invalidated successfully']);
    }
}
