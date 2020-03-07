<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizedRequest;
use Illuminate\Http\JsonResponse;

class LocationsController extends Controller
{
    /**
     * @OA\Post(
     *      path="/pet/locations",
     *      operationId="createPetLocationInstance",
     *      tags={"Locations"},
     *      summary="Create location of pet.",
     *      description="Returns the recently created location of pet as JSON Object.",
     *      @OA\Parameter(
     *          name="api_token",
     *          description="Pet personal access token",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Pet location created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Post(
     *      path="/user/locations",
     *      operationId="createUserLocationInstance",
     *      tags={"Locations"},
     *      summary="Create location of user.",
     *      description="Returns the recently created location of user as JSON Object.",
     *      @OA\Parameter(
     *          name="api_token",
     *          description="User personal access token",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User location instance created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Post(
     *      path="/device/locations",
     *      operationId="createDeviceLocationInstance",
     *      tags={"Locations"},
     *      summary="Create location of device.",
     *      description="Returns the recently created location of device as JSON Object.",
     *      @OA\Parameter(
     *          name="api_token",
     *          description="User personal access token",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Device location instance created successfully"
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
