<?php

namespace App\Http\Controllers\Api\Pets\Groups;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\Groups\IndexRequest;
use App\Pet;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Fetch all Groups of Pet.
     *
     * @param IndexRequest $request
     * @param Pet $pet
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Pet $pet)
    {
        return response()->json(
            $pet->groups()->latest()->with('user', 'photo')->paginate(20),
            200
        );
    }
}
