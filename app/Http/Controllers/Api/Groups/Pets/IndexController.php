<?php

namespace App\Http\Controllers\Api\Groups\Pets;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\Pets\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Display a list with devices of a group
     *
     * @param IndexRequest $request
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Group $group)
    {
        return response()->json(
            $group->pets()->latest()->with('photo', 'user')->paginate(20),
            200
        );
    }
}
