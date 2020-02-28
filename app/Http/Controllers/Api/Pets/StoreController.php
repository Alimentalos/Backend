<?php

namespace App\Http\Controllers\Api\Pets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\StoreRequest;
use App\Repositories\PetsRepository;
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
        $photo = PhotoRepository::createPhotoViaRequest($request);
        $pet = PetsRepository::createPetViaRequest($request, $photo);
        $pet->load('photo', 'user');
        return response()->json($pet, 200);
    }
}
