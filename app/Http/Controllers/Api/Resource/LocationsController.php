<?php

namespace App\Http\Controllers\Api\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorizedRequest;
use Illuminate\Http\JsonResponse;

class LocationsController extends Controller
{
    /**
     * @OA\Post(
     *      path="/{resource}/locations",
     *      operationId="createResourceLocationInstance",
     *      tags={"Resources"},
     *      summary="Create resource locations instance.",
     *      description="Returns the recently created location instance as JSON Object.",
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
     *          description="Resource location instance created successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     * )
     * Create resource locations instance.
     *
     * @param AuthorizedRequest $request
     * @return JsonResponse
     */
    public function __invoke(AuthorizedRequest $request)
    {
        $locations = resourceLocations()->createViaRequest();
        return response()->json($locations,201);
    }
}
