<?php

namespace App\Http\Controllers\Api\Pets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Models\UpdateRequest;
use App\Pet;
use App\Repositories\PetsRepository;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * Update the specified pet in storage.
     *
     * @param UpdateRequest $request
     * @param Pet $pet
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, Pet $pet)
    {
        $pet = PetsRepository::updatePetViaRequest($request, $pet);
        return response()->json($pet, 200);
    }
}
