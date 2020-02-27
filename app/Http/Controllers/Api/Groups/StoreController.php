<?php

namespace App\Http\Controllers\Api\Groups;

use App\Group;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Groups\StoreRequest;
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
        // TODO - Remove unnecessary complexity
        $photo = PhotoRepository::createPhoto(
            $request->user('api'),
            $request->file('photo'),
            null,
            null,
            $request->input('is_public'),
            $request->input('coordinates')
        );

        $group = Group::create([
            'name' => $request->input('name'),
            'user_id' => $request->user('api')->id,
            'photo_id' => $photo->id,
            'photo_url' => 'https://storage.googleapis.com/photos.zendev.cl/photos/' . $photo->photo_url,
        ]);

        $request->user('api')
            ->groups()
            ->attach(
                $group->id,
                ['is_admin' => true]
            );

        $group->load('photo', 'user');

        $group->photos()->attach($photo->id);

        return response()->json($group, 200);
    }
}
