<?php

namespace App\Http\Controllers\Api\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\ShowRequest;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param ShowRequest $request
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(ShowRequest $request, Group $group)
    {
        $group->load('photo', 'user');

        return response()->json($group, 200);
    }
}
