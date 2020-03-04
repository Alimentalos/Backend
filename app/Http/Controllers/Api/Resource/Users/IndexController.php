<?php

namespace App\Http\Controllers\Api\Resource\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Display a list with users of a group
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        return response()->json(
            $resource->users()->latest()->with('photo', 'user')->paginate(20),
            200
        );
    }
}
