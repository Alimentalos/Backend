<?php

namespace App\Http\Controllers\Api\Resource\Devices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Retrieve paginated devices of resource.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $devices = $resource->devices()->latest()->with('user')->paginate(20);
        return response()->json($devices,200);
    }
}
