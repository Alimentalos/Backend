<?php

namespace App\Http\Controllers\Api\Resource\Devices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/users/{user}/devices",
     *      operationId="getUserDevices",
     *      tags={"Users"},
     *      summary="Get devices of user.",
     *      description="Returns the devices of user paginated by a default quantity, payload includes pagination links and stats.",
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
     *          description="Devices retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/groups/{groups}/devices",
     *      operationId="getGroupDevices",
     *      tags={"Groups"},
     *      summary="Get devices of group.",
     *      description="Returns the devices of group paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Parameter(
     *          name="group",
     *          description="Unique identifier of group",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Devices retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Get resource devices paginated.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $devices = $resource->devices()->latest()->with('user')->paginate(20);
        return response()->json($devices,200);
    }
}
