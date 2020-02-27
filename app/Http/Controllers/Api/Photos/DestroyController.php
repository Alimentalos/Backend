<?php

namespace App\Http\Controllers\Api\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photos\DestroyRequest;
use App\Photo;
use Illuminate\Http\JsonResponse;
use Exception;

class DestroyController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRequest $request
     * @param Photo $photo
     * @return JsonResponse
     * @throws Exception
     */
    public function __invoke(DestroyRequest $request, Photo $photo)
    {
        $photo->delete();
        // TODO - Refactor using constant
        return response()->json(
            ['message' => 'Deleted successfully.'],
            200
        );
    }
}
