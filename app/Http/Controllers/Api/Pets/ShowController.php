<?php

namespace App\Http\Controllers\Api\Pets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\ShowRequest;
use App\Pet;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param ShowRequest $request
     * @param Pet $pet
     * @return JsonResponse
     */
    public function __invoke(ShowRequest $request, Pet $pet)
    {
        $pet->load('photo', 'user');

        return response()->json($pet, 200);
    }
}
