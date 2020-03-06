<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\StoreRequest;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * @OA\Post(
     *      path="/users",
     *      operationId="createUser",
     *      tags={"Users"},
     *      summary="Create user.",
     *      description="Returns the recently created user instance as JSON Object.",
     *      @OA\Response(
     *          response=201,
     *          description="User created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Post(
     *      path="/pets",
     *      operationId="createPet",
     *      tags={"Pets"},
     *      summary="Create pet.",
     *      description="Returns the recently created pet instance as JSON Object.",
     *      @OA\Response(
     *          response=201,
     *          description="Pet created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Post(
     *      path="/groups",
     *      operationId="createGroup",
     *      tags={"Groups"},
     *      summary="Create group.",
     *      description="Returns the recently created group instance as JSON Object.",
     *      @OA\Response(
     *          response=201,
     *          description="Group created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Post(
     *      path="/geofences",
     *      operationId="createGeofence",
     *      tags={"Geofences"},
     *      summary="Create geofence.",
     *      description="Returns the recently created geofence instance as JSON Object.",
     *      @OA\Response(
     *          response=201,
     *          description="Geofence created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Post(
     *      path="/devices",
     *      operationId="createDevice",
     *      tags={"Devices"},
     *      summary="Create device.",
     *      description="Returns the recently created device instance as JSON Object.",
     *      @OA\Response(
     *          response=201,
     *          description="Device created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * @OA\Post(
     *      path="/alerts",
     *      operationId="createAlert",
     *      tags={"Alerts"},
     *      summary="Create alert.",
     *      description="Returns the recently created alert instance as JSON Object.",
     *      @OA\Response(
     *          response=201,
     *          description="Alert created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Create resource.
     *
     * @param StoreRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, $resource)
    {
        $resource = $request->route('resource')->createViaRequest();
        return response()->json($resource,201);
    }
}
