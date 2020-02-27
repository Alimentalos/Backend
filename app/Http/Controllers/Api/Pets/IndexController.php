<?php

namespace App\Http\Controllers\Api\Pets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\IndexRequest;
use App\Pet;
use Illuminate\Http\JsonResponse;


class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request)
    {
        $pets = Pet::with('user', 'photo')->latest()->paginate(20);

        return response()->json(
            $pets,
            200
        );
    }
}
