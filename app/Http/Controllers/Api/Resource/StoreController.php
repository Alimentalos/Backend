<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\StoreRequest;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/",
     *      operationId="createResourceInstance",
     *      tags={"Resources"},
     *      summary="Create resource instance",
     *      description="Returns the recently created instance as JSON Object",
     *      @OA\Parameter(
     *          name="resource",
     *          description="Resource class type",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Resource instance created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     *
     * @param StoreRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, $resource)
    {
        return response()->json($request->route('resource')->createViaRequest($request),201);
    }
}
