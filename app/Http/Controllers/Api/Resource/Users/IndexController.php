<?php

namespace App\Http\Controllers\Api\Resource\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Resource\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Retrieve paginated users of instance.
     *
     * @param IndexRequest $request
     * @param $resource
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, $resource)
    {
        $users = $resource
            ->users()
            ->latest()
            ->with('photo', 'user')
            ->paginate(20);
        return response()->json($users,200);
    }
}
