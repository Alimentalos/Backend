<?php

namespace App\Http\Controllers\Api\Resource\Pets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Display a list with devices of a group
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        return response()->json($resource->pets()->latest()->with('photo', 'user')->paginate(20),200);
    }
}
