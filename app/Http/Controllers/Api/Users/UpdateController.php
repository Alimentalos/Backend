<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\UpdateRequest;
use App\Repositories\FillRepository;
use App\Repositories\PhotoRepository;
use App\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, User $user)
    {
        // TODO - Remove unnecessary complexity
        if ($request->has('photo')) {
            $photo = PhotoRepository::createPhoto(
                $request->user('api'),
                $request->file('photo'),
                null,
                null,
                FillRepository::fillMethod($request, 'is_public', $user->is_public),
                $request->input('coordinates')
            );

            $exploded = explode(',', $request->input('coordinates'));

            $user->update([
                'photo_id' => $photo->id,
                'photo_url' => 'https://storage.googleapis.com/photos.zendev.cl/photos/' . $photo->photo_url,
                'location' => (new Point(
                    floatval($exploded[0]),
                    floatval($exploded[1])
                )),
            ]);
            $user->photos()->attach($photo->id);
        }

        $user->load('user', 'photo');

        $user->update([
            'email' => FillRepository::fillMethod($request, 'email', $user->email),
            'name' => FillRepository::fillMethod($request, 'name', $user->name),
            'is_public' => FillRepository::fillMethod($request, 'is_public', $user->is_public),
        ]);
        return response()->json($user, 200);
    }
}
