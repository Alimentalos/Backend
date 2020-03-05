<?php

namespace App\Http\Controllers\Api\Resource\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Resource\Groups\AttachRequest;
use App\Repositories\FillRepository;
use Illuminate\Http\JsonResponse;

class AttachController extends Controller
{
    /**
     * Attach group to instance.
     *
     * @param AttachRequest $request
     * @param $resource
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(AttachRequest $request, $resource, Group $group)
    {
        $resource->groups()
            ->attach($group->uuid,[
                'status' => Group::ATTACHED_STATUS,
                'is_admin' => fill( 'is_admin', false)
            ]);
        return response()->json([], 200);
    }
}
