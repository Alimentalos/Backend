<?php

namespace App\Http\Controllers\Api\Groups\Users;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\Users\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Display a list with users of a group
     *
     * @param IndexRequest $request
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Group $group)
    {
        return response()->json(
            $group->users()->latest()->with('photo', 'user')->paginate(20),
            200
        );
    }
}
