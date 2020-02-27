<?php

namespace App\Http\Controllers\Api\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photos\ShowRequest;
use App\Photo;
use Illuminate\Http\JsonResponse;

class ShowController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param ShowRequest $request
     * @param Photo $photo
     * @return JsonResponse
     */
    public function __invoke(ShowRequest $request, Photo $photo)
    {
        $photo->load('user');

        return response()->json($photo, 200);
    }
}
