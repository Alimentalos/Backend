<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Find\IndexRequest;
use Illuminate\Http\JsonResponse;

class FindController extends Controller
{
    /**
     * @OA\Get(
     *      path="/find",
     *      operationId="findResources",
     *      tags={"Find"},
     *      summary="Find the last known location of resources.",
     *      description="Returns resource locations.",
     *      @OA\Parameter(
     *          name="identifiers",
     *          description="Array with unique identifiers",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="array",
     *              @OA\Items(type="string"),
     *          )
     *      ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Resource type that need to be considered",
     *         required=true,
     *         @OA\Schema(
     *         type="string",
     *           @OA\Items(
     *               type="string",
     *               enum={"pets", "users", "devices"},
     *               default="pets"
     *           ),
     *         )
     *     ),
     *      @OA\Parameter(
     *          name="start_date",
     *          description="Start date that need to be considered filter, only dates with format Y-m-d H:i:s are accepted",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="end_date",
     *          description="End date that need to be considered filter, only dates with format Y-m-d H:i:s are accepted",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="accuracy",
     *          description="Max accuracy that need to be considered filter.",
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
     *      @OA\Response(response=400, description="Bad request")
     * )
     * Show current devices locations
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        $locations = locations()->find();
        return response()->json($locations,200);
    }
}
