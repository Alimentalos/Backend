<?php

namespace App\Http\Controllers\Api\Resource\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Groups\IndexRequest;
use App\Pet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    /**
     * Fetch all Groups of resource.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        return response()->json(
            $resource->groups()->latest()->with('user', 'photo')->paginate(20),
            200
        );
    }
}
