<?php

namespace App\Http\Controllers\Api\Groups\Photos;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\Photos\StoreRequest;
use App\Repositories\PhotoRepository;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param StoreRequest $request
     * @param Group $group
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, Group $group)
    {
        // TODO - Remove unnecessary complexity
        $photo = PhotoRepository::createPhoto(
            $request->user('api'),
            $request->file('photo'),
            $request->input('title'),
            $request->input('body'),
            $request->input('is_public'),
            $request->input('coordinates')
        );

        $photo->groups()->attach($group->id);

        $photo->load('user', 'comment');

        return response()->json(
            $photo,
            200
        );
    }
}
