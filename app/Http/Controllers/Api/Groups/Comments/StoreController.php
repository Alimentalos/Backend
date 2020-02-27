<?php

namespace App\Http\Controllers\Api\Groups\Comments;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\Comments\StoreRequest;
use App\Repositories\UniqueNameRepository;
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
        $comment = $group->comments()->create([
            'uuid' => UniqueNameRepository::createIdentifier(),
            'body' => $request->input('body'),
            'user_id' => $request->user('api')->id,
        ]);

        return response()->json(
            $comment,
            200
        );
    }
}
