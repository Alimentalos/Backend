<?php

namespace App\Http\Controllers\Api\Groups\Geofences;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\Geofences\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Fetch all Geofences of Group.
     *
     * @param IndexRequest $request
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Group $group)
    {
        return response()->json(
            $group->geofences()->latest()->paginate(20),
            200
        );
    }
}
