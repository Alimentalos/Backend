<?php

namespace App\Http\Controllers\Api\Groups\Comments;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\Comments\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @param IndexRequest $request
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Group $group)
    {
        return response()->json(
            $group->comments()->latest()->with('user')->latest()->paginate(20),
            200
        );
    }
}
