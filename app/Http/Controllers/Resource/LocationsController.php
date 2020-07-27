<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizedRequest;
use Illuminate\Http\JsonResponse;

class LocationsController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/locations",
     *      operationId="createResourceLocation",
     *      tags={"Locations"},
     *      summary="Create location of resource.",
     *      description="Returns the recently created location as JSON Object.",
     *      @OA\Parameter(
     *          name="api_token",
     *          description="Resource personal access token",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *         name="resource",
     *         in="path",
     *         description="Resource type that need to be considered",
     *         required=true,
     *         @OA\Schema(
     *         type="string",
     *           @OA\Items(
     *               type="string",
     *               enum={"user", "devices", "pet"},
     *               default="user"
     *           ),
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource location created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Create resource locations.
     *
     * @param AuthorizedRequest $request
     * @return JsonResponse
     */
    public function __invoke(AuthorizedRequest $request)
    {
        $locations = resourceLocations()->create();
        return response()->json($locations,201);
    }
}
