<?php

namespace App\Http\Controllers\Api\Groups\Photos;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\Photos\IndexRequest;
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
            $group->photos()->latest()->with('user', 'comment')->paginate(20),
            200
        );
    }
}
