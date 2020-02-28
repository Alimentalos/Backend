<?php

namespace App\Http\Controllers\Api\Pets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Models\UpdateRequest;
use App\Pet;
use App\Repositories\PetsRepository;
use App\Repositories\UploadRepository;
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
        UploadRepository::checkPhotoForUpload($request, $pet);
        $pet = PetsRepository::updatePetViaRequest($request, $pet);
        $pet->load('photo', 'user');
        return response()->json($pet, 200);
    }
}
