<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RefreshRequest;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;

class RefreshController extends Controller
{
    /**
     * @OA\Post(
     *  path="/refresh",
     *  operationId="refreshAccessToken",
     *  tags={"Authentication"},
     *  summary="Refresh authentication token.",
     *  description="Returns the user personal access token.",
     *  @OA\Parameter(
     *    name="refresh_token",
     *    description="The refresh token",
     *    required=true,
     *    in="query",
     *    @OA\Schema(
     *    type="string"
     *    )
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Token refreshed successfully"
     *  ),
     *  @OA\Response(response=401, description="Unauthenticated.")
     *  )
     *
     * Refresh the user access token.
     *
     * @param RefreshRequest $request
     * @return JsonResponse
     * @codeCoverageIgnore
     */
    public function __invoke(RefreshRequest $request)
    {
        $http = new Client;

        $response = $http->post('https://www.alimentalos.cl/oauth/token', [
            'form_params' => [

                'grant_type' => 'refresh_token',
                'client_id' => env('PASSPORT_PASSWORD_CLIENT_ID'),
                'client_secret' => env('PASSPORT_PASSWORD_CLIENT_SECRET'),
                'refresh_token' => $request->input('refresh_token'),
                'scope' => '*',
            ],
        ]);

        $decoded = json_decode((string) $response->getBody(), true);
        return response()->json($decoded, 200);
    }
}
