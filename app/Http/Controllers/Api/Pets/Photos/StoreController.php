<?php

namespace App\Http\Controllers\Api\Pets\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\Photos\StoreRequest;
use App\Pet;
use App\Repositories\PhotoRepository;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param StoreRequest $request
     * @param Pet $pet
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request, Pet $pet)
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

        $exploded = explode(',', $request->input('coordinates'));

        $pet->update([
            'photo_id' => $photo->id,
            'location' => (new Point(
                floatval($exploded[0]),
                floatval($exploded[1])
            )),
        ]);

        $photo->pets()->attach($pet->id);

        $photo->load('user', 'comment');

        return response()->json(
            $photo,
            200
        );
    }
}
