<?php

namespace App\Http\Controllers\Api\Pets\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\Photos\IndexRequest;
use App\Pet;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * @param IndexRequest $request
     * @param Pet $pet
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Pet $pet)
    {
        return response()->json(
            $pet->photos()->latest()->with('user', 'comment')->paginate(20),
            200
        );
    }
}
