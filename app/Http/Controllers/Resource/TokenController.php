<?php

namespace App\Http\Controllers\Resource;

use App\Contracts\Resource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Resource\TokenRequest;
use Illuminate\Http\JsonResponse;

class TokenController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/{uuid}/token",
     *      operationId="getResourceToken",
     *      tags={"Resources"},
     *      summary="Get specific resource token.",
     *      description="Returns the specified resource token as JSON Object.",
     *      @OA\Parameter(
     *          name="uuid",
     *          description="Unique identifier of resource",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *         name="resource",
     *         in="path",
     *         description="Resource type that need to be considered",
     *         required=true,
     *         @OA\Schema(
     *         type="string",
     *           @OA\Items(
     *               type="string",
     *               enum={"devices", "pets"},
     *               default="devices"
     *           ),
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Token retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Get specific token of resource.
     *
     * @param TokenRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(TokenRequest $request, Resource $resource)
    {
        return response()->json([
            'message' => 'Token retrieved successfully',
            'api_token' => $resource->api_token
        ]);
    }
}
