<?php

namespace App\Http\Controllers\Api\Pets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\StoreRequest;
use App\Pet;
use App\Repositories\PhotoRepository;
use Grimzy\LaravelMysqlSpatial\Types\Point;
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
            $request->input('title'),
            $request->input('body'),
            $request->has('is_public'),
            $request->input('coordinates')
        );

        $exploded = explode(',', $request->input('coordinates'));

        $pet = Pet::create([
            'name' => $request->input('name'),
            'photo_url' => 'https://storage.googleapis.com/photos.zendev.cl/photos/' . $photo->photo_url,
            'user_id' => $request->user('api')->id,
            'description' => $request->input('description'),
            'hair_color' => $request->input('hair_color'),
            'born_at' => $request->input('born_at'),
            'photo_id' => $photo->id,
            'left_eye_color' => $request->input('left_eye_color'),
            'right_eye_color' => $request->input('right_eye_color'),
            'size' => $request->input('size'),
            'location' => (new Point(
                floatval($exploded[0]),
                floatval($exploded[1])
            )),
            'is_public' => $request->input('is_public')
        ]);

        $pet->load('photo', 'user');

        $photo->pets()->attach($pet->id);

        return response()->json($pet, 200);
    }
}
