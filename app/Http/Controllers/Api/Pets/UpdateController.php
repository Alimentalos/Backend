<?php

namespace App\Http\Controllers\Api\Pets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\UpdateRequest;
use App\Pet;
use App\Repositories\FillRepository;
use App\Repositories\PhotoRepository;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Pet $pet
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, Pet $pet)
    {
        // TODO - Remove unnecessary complexity
        if ($request->has('photo')) {
            $photo = PhotoRepository::createPhoto(
                $request->user('api'),
                $request->file('photo'),
                null,
                null,
                FillRepository::fillMethod($request, 'is_public', $pet->is_public),
                $request->input('coordinates')
            );

            $exploded = explode(',', $request->input('coordinates'));

            $pet->update([
                'photo_id' => $photo->id,
                'photo_url' => 'https://storage.googleapis.com/photos.zendev.cl/photos/' . $photo->photo_url,
                'location' => (new Point(
                    floatval($exploded[0]),
                    floatval($exploded[1])
                )),
            ]);

            $pet->photos()->attach($photo->id);
        }

        $pet->update([
            'name' => FillRepository::fillMethod($request, 'name', $pet->name),
            'description' => FillRepository::fillMethod($request, 'description', $pet->description),
            'hair_color' => FillRepository::fillMethod($request, 'hair_color', $pet->hair_color),
            'born_at' => FillRepository::fillMethod($request, 'born_at', $pet->born_at),
            'left_eye_color' => FillRepository::fillMethod($request, 'left_eye_color', $pet->left_eye_color),
            'right_eye_color' => FillRepository::fillMethod($request, 'right_eye_color', $pet->right_eye_color),
            'size' => FillRepository::fillMethod($request, 'size', $pet->size),
            'is_public' => FillRepository::fillMethod($request, 'is_public', $pet->is_public),
        ]);

        $pet->load('photo', 'user');

        return response()->json($pet, 200);
    }
}
