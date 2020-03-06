<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/users",
     *      operationId="getUsers",
     *      tags={"Users"},
     *      summary="Get users.",
     *      description="Returns the users paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Response(
     *          response=200,
     *          description="Users retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/groups",
     *      operationId="getGroups",
     *      tags={"Groups"},
     *      summary="Get groups.",
     *      description="Returns the groups paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Response(
     *          response=200,
     *          description="Groups retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/alerts",
     *      operationId="getAlerts",
     *      tags={"Alerts"},
     *      summary="Get alerts.",
     *      description="Returns the alerts paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Response(
     *          response=200,
     *          description="Alerts retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/devices",
     *      operationId="getDevicesPaginated",
     *      tags={"Devices"},
     *      summary="Get devices.",
     *      description="Returns the devices paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Response(
     *          response=200,
     *          description="Devices retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/geofences",
     *      operationId="getGeofences",
     *      tags={"Geofences"},
     *      summary="Get geofences.",
     *      description="Returns the geofences paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Response(
     *          response=200,
     *          description="Geofences retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/pets",
     *      operationId="getPets",
     *      tags={"Pets"},
     *      summary="Get pets.",
     *      description="Returns the pets paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Response(
     *          response=200,
     *          description="Pets retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/actions",
     *      operationId="getActions",
     *      tags={"Actions"},
     *      summary="Get actions.",
     *      description="Returns the actions paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Response(
     *          response=200,
     *          description="Actions retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * @OA\Get(
     *      path="/photos",
     *      operationId="getPhotos",
     *      tags={"Photos"},
     *      summary="Get photos.",
     *      description="Returns the photos paginated by a default quantity, payload includes pagination links and stats.",
     *      @OA\Response(
     *          response=200,
     *          description="Photos retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Get resource paginated.
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        $instances = resource()->getInstances();
        return response()->json($instances, 200);
    }
}
