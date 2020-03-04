<?php

namespace App\Http\Controllers\Api\Resource\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        return response()->json($resource->photos()->latest()->with('user', 'comment')->paginate(20),200);
    }
}
