<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\StoreRequest;
use Alimentalos\Contracts\Resource;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}",
     *      operationId="createResource",
     *      tags={"Resources"},
     *      summary="Create resource.",
     *      description="Returns the recently created resource as JSON Object.",
     *     @OA\Parameter(
     *         name="resource",
     *         in="path",
     *         description="Resource type that need to be considered",
     *         required=true,
     *         @OA\Schema(
     *         type="string",
     *           @OA\Items(
     *               type="string",
     *               enum={"users", "pets", "groups", "geofences", "devices", "alerts"},
     *               default="devices"
     *           ),
     *         )
     *     ),
     *      @OA\Response(
     *          response=201,
     *          description="User created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Create resource.
     *
     * @param StoreRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, Resource $resource)
    {
        $resource = $request->route('resource')->createViaRequest();
        $resource->load($resource->lazy_relationships);
        return response()->json($resource,201);
    }
}
