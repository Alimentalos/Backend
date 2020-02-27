<?php

namespace App\Http\Controllers\Api\Users\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\Photos\StoreRequest;
use App\Repositories\PhotoRepository;
use App\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param StoreRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, User $user)
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

        // TODO - Refactor this repeated code
        $exploded = explode(',', $request->input('coordinates'));

        $user->update([
            'location' => (new Point(
                floatval($exploded[0]),
                floatval($exploded[1])
            )),
        ]);

        $photo->users()->attach($user->id);

        $photo->load('user', 'comment');

        return response()->json(
            $photo,
            200
        );
    }
}
