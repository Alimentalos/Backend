<?php

namespace App\Http\Controllers\Resource;

use App\Contracts\Resource;
use App\Http\Controllers\Controller;
use App\Http\Requests\Resource\EditRequest;
use Illuminate\View\View;

class EditController extends Controller
{
	/**
	 * @OA\Get(
	 *      path="/{resource}/{uuid}/edit",
	 *      operationId="getEditResourceForm",
	 *      tags={"Resources"},
	 *      summary="Get specific resource edit form.",
	 *      description="Returns the specified edit form resource as HTML form.",
	 *      @OA\Parameter(
	 *          name="uuid",
	 *          description="Unique identifier of resource",
	 *          required=true,
	 *          in="path",
	 *          @OA\Schema(
	 *              type="string"
	 *          )
	 *      ),
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
	 * @param EditRequest $request
	 * @param Resource $resource
	 * @return View
	 */
    public function __invoke(EditRequest $request, Resource $resource)
    {
		$resource->load($resource->lazy_relationships);
		return view(finder()->currentResource() . '.edit')->with(['instance' => $resource]);
    }
}
