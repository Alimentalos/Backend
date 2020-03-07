<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RegisterRequest;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *  path="/register",
     *  operationId="registerUser",
     *  tags={"Authentication"},
     *  summary="Crea user via register.",
     *  description="Returns the registered user as JSON Object.",
     *  @OA\Response(
     *      response=200,
     *      description="User registered successfully"
     *  ),
     *  @OA\Response(response=401, description="Unauthenticated.")
     *  )
     * Handle the incoming request.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function __invoke(RegisterRequest $request)
    {
        $registered = users()->register();
        return response()->json($registered,201);
    }
}
