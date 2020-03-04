<?php

namespace App\Http\Controllers\Api\Resource\Geofences;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Fetch all Geofences of resource.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        return response()->json(
            $resource->geofences()->latest()->with('user', 'photo')->paginate(20),
            200
        );
    }
}
