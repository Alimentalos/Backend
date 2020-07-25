<?php

namespace App\Http\Controllers\Locations;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Locations\IndexRequest;
use App\Http\Resources\LocationCollection;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @OA\Get(
     *      path="/locations",
     *      operationId="getLocations",
     *      tags={"Locations"},
     *      summary="Get resource locations.",
     *      description="Returns the locations.",
     *      @OA\Parameter(
     *          name="identifier",
     *          description="Resource comma-separated identifiers",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="type",
     *          description="Resource type",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *          type="string",
     *           @OA\Items(
     *               type="string",
     *               enum={"pets", "users", "devices"},
     *               default="pets"
     *           ),
     *         )
     *     ),
     *      @OA\Parameter(
     *          name="start_date",
     *          description="Start date used to filter results",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="end_date",
     *          description="End date used to filter results",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="accuracy",
     *          description="Max accuracy used to filter results",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Locations retrieved successfully"
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource doesn't implements has location trait")
     * )
     * Retrieve locations of instances.
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        $locations = locations()->index();
        return response()->json(new LocationCollection($locations), 200);
    }
}
