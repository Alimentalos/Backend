<?php

namespace App\Http\Controllers\Api\Near\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Near\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/near/users",
     *      operationId="getNearUsers",
     *      tags={"Near"},
     *      summary="Get near users.",
     *      description="Returns the near located users paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="coordinates",
     *          description="Comma-separated latitude and longitude.",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Users retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/near/devices",
     *      operationId="getNearDevices",
     *      tags={"Near"},
     *      summary="Get near devices.",
     *      description="Returns the near located devices paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="coordinates",
     *          description="Comma-separated latitude and longitude.",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Devices retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Get(
     *      path="/near/pets",
     *      operationId="getNearPets",
     *      tags={"Near"},
     *      summary="Get near pets.",
     *      description="Returns the near located pets paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="coordinates",
     *          description="Comma-separated latitude and longitude.",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Pets retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/near/geofences",
     *      operationId="getNearGeofences",
     *      tags={"Near"},
     *      summary="Get near geofences.",
     *      description="Returns the near located geofences paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Response(
     *          response=200,
     *          description="Geofences retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Retrieve paginated near instances.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $resources = finder()->findNearResources($resource, input('coordinates'))->paginate(20);
        return response()->json($resources,200);
    }
}
