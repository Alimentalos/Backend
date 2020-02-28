<?php

namespace App\Http\Controllers\Api\Pets\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\Photos\StoreRequest;
use App\Pet;
use App\Repositories\LocationRepository;
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
        $photo = PhotoRepository::createPhotoViaRequest($request);
        $pet = LocationRepository::updateModelLocation($request, $pet);
        $pet->update([
            'photo_id' => $photo->id,
        ]);
        $photo->pets()->attach($pet->id);
        $photo->load('user', 'comment');
        return response()->json(
            $photo,
            200
        );
    }
}
