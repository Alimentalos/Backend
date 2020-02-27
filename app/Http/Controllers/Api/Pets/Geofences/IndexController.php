<?php

namespace App\Http\Controllers\Api\Pets\Geofences;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\Geofences\IndexRequest;
use App\Pet;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Fetch all Geofences of Pet.
     *
     * @param IndexRequest $request
     * @param Pet $pet
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Pet $pet)
    {
        return response()->json(
            $pet->geofences()->latest()->paginate(20),
            200
        );
    }
}
