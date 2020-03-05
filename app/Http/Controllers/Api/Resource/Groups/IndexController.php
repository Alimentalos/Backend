<?php

namespace App\Http\Controllers\Api\Resource\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Retrieve paginated groups of instance.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $groups = $resource->groups()->latest()->with('user', 'photo')->paginate(20);
        return response()->json($groups,200);
    }
}
