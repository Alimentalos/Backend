<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\AccessesRequest;
use Illuminate\Http\JsonResponse;

class AccessesController extends Controller
{
    /**
     * @OA\Get(
     *      path="/pets/{pet}/accesses",
     *      operationId="getPetAccesses",
     *      tags={"Pets"},
     *      summary="Get accesses of pet.",
     *      description="Returns the pet accesses paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="pet",
     *          description="Unique identifier of pet",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Pet accesses retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Get(
     *      path="/devices/{device}/accesses",
     *      operationId="getDeviceAccesses",
     *      tags={"Devices"},
     *      summary="Get accesses of device.",
     *      description="Returns the device accesses paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="device",
     *          description="Unique identifier of device",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Device accesses retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Get(
     *      path="/users/{user}/accesses",
     *      operationId="getUserAccesses",
     *      tags={"Users"},
     *      summary="Get accesses of user.",
     *      description="Returns the user accesses paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="user",
     *          description="Unique identifier of user",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User accesses retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Get resource accesses paginated.
     *
     * @param AccessesRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(AccessesRequest $request, $resource)
    {
        $accesses = $resource
            ->accesses()
            ->with(['accessible', 'geofence', 'first_location', 'last_location'])
            ->latest()
            ->paginate(20);
        return response()->json($accesses, 200);
    }
}
