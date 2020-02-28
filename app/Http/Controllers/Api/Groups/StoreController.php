<?php

namespace App\Http\Controllers\Api\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\StoreRequest;
use App\Repositories\GroupsRepository;
use App\Repositories\PhotoRepository;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request)
    {
        $photo = PhotoRepository::createPhotoViaRequest($request);
        $group = GroupsRepository::createGroupViaRequest($request, $photo);
        $group->load('photo', 'user');
        return response()->json($group, 200);
    }
}
