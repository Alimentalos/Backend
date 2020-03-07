<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *  path="/user",
     *  operationId="user",
     *  tags={"Authentication"},
     *  summary="Get authenticated user.",
     *  description="Returns the user as JSON Object.",
     *  @OA\Response(
     *      response=200,
     *      description="User retrieved successfully"
     *  ),
     *  @OA\Response(response=401, description="Unauthenticated.")
     *  )
     * Show the current api user logged.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $authenticated = authenticated();
        return response()->json($authenticated,200);
    }
}
