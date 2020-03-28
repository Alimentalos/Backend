<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TokenRequest;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;

class TokenController extends Controller
{
    /**
     * @OA\Post(
     *  path="/token",
     *  operationId="createAccessToken",
     *  tags={"Authentication"},
     *  summary="Get authentication token using user credentials.",
     *  description="Returns the user personal access token.",
     *  @OA\Parameter(
     *    name="username",
     *    description="Registered user email address",
     *    required=true,
     *    in="query",
     *    @OA\Schema(
     *    type="string"
     *    )
     *  ),
     *  @OA\Parameter(
     *    name="password",
     *    description="Current user password",
     *    required=true,
     *    in="query",
     *    @OA\Schema(
     *    type="string"
     *    )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Token retrieved successfully"
     *  ),
     *  @OA\Response(response=401, description="Unauthenticated.")
     *  )
     *
     * Show the user access token.
     *
     * @param TokenRequest $request
     * @return JsonResponse
     */
    public function __invoke(TokenRequest $request)
    {
        $http = new Client;

        $response = $http->post('https://www.alimentalos.cl/oauth/token', [
            'form_params' => [

                'grant_type' => 'password',
                'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
                'client_secret' => env('PASSPORT_PASSWORD_CLIENT_SECRET'),
                'username' => $request->input('email'),
                'password' => $request->input('password'),
                'scope' => '*',
            ],
        ]);

        $decoded = json_decode((string) $response->getBody(), true);
        return response()->json($decoded, 200);
    }
}
