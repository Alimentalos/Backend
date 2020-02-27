<?php

namespace App\Http\Controllers\Api\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photos\IndexRequest;
use App\Photo;
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
        $photos = Photo::with('user', 'photoable')->latest()->paginate(20);

        return response()->json(
            $photos,
            200
        );
    }
}
