<?php

namespace App\Http\Controllers\Api\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photos\UpdateRequest;
use App\Photo;
use App\Repositories\FillRepository;
use Illuminate\Http\JsonResponse;

class UpdateController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Photo $photo
     * @return JsonResponse
     */
    public function __invoke(UpdateRequest $request, Photo $photo)
    {
        $photo->update([
            'title' => FillRepository::fillMethod($request, 'title', $photo->title),
            'description' => FillRepository::fillMethod($request, 'description', $photo->description),
            'is_public' => FillRepository::fillMethod($request, 'is_public', $photo->is_public),
        ]);

        $photo->load('user');

        return response()->json($photo, 200);
    }
}
