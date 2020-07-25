<?php

namespace App\Http\Controllers\Resource;

use App\Http\Controllers\Controller;
use App\Http\Requests\Resource\CreateRequest;
use App\Http\Requests\Resource\ShowRequest;
use Alimentalos\Contracts\Resource;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class CreateController extends Controller
{
	/**
	 * @OA\Get(
	 *      path="/{resource}/create",
	 *      operationId="getCreateResourceForm",
	 *      tags={"Resources"},
	 *      summary="Get specific resource create form.",
	 *      description="Returns the specified resource create form as HTML form.",
	 *     @OA\Parameter(
	 *         name="resource",
	 *         in="path",
	 *         description="Resource type that need to be considered",
	 *         required=true,
	 *         @OA\Schema(
	 *         type="string",
	 *           @OA\Items(
	 *               type="string",
	 *               enum={"users", "devices", "groups", "pets", "actions", "locations", "geofences", "photos", "comments", "alerts"},
	 *               default="devices"
	 *           ),
	 *         )
	 *     ),
	 *      @OA\Response(
	 *          response=200,
	 *          description="Resource retrieved successfully"
	 *       ),
	 *      @OA\Response(response=400, description="Bad request"),
	 *      @OA\Response(response=404, description="Resource not found")
	 * )
	 * Get specific create resource form.
	 *
	 * @param CreateRequest $request
	 * @return View
	 */
    public function __invoke(CreateRequest $request)
    {
		return view(finder()->currentResource() . '.create');
    }
}
