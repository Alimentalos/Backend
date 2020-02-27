<?php

namespace App\Http\Controllers\Api\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Users\StoreRequest;
use App\Repositories\PhotoRepository;
use App\User;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Auth\Events\Registered;
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
        // TODO - Remove unnecessary complexity
        $photo = PhotoRepository::createPhoto(
            $request->user('api'),
            $request->file('photo'),
            null,
            null,
            $request->has('is_public'),
            $request->input('coordinates')
        );

        $exploded = explode(',', $request->input('coordinates'));

        $user = User::create([
            'user_id' => $request->user('api')->id,
            'photo_id' => $photo->id,
            'photo_url' => 'https://storage.googleapis.com/photos.zendev.cl/photos/' . $photo->photo_url,
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'password' => bcrypt($request->input('password')),
            'is_public' => $request->input('is_public'),
            'location' => (new Point(
                floatval($exploded[0]),
                floatval($exploded[1])
            )),
        ]);

        $user->photos()->attach($photo->id);

        event(new Registered($user));

        $user->load('photo', 'user');

        return response()->json($user, 200);
    }
}
