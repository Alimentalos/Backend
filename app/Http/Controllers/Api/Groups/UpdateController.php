<?php

namespace App\Http\Controllers\Api\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Models\UpdateRequest;
use App\Repositories\GroupsRepository;
use App\Repositories\UploadRepository;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, Group $group)
    {
        UploadRepository::checkPhotoForUpload($request, $group);
        $group = GroupsRepository::updateGroupViaRequest($request, $group);
        $group->load('photo', 'user');
        return response()->json($group, 200);
    }
}
