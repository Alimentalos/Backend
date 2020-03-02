<?php

namespace App\Http\Controllers\Api\Photos;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Photos\DestroyRequest;
use App\Photo;
use Exception;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRequest $request
     * @param Photo $photo
     * @return JsonResponse
     */
    public function __invoke(DestroyRequest $request, Photo $photo)
    {
        try {
            $photo->delete();

            return response()->json(
                ['message' => 'Deleted successfully.'],
                200
            );
        } catch (Exception $exception) {
            return response()->json(
                ['message' => 'Resource cannot be deleted.'],
                500
            );
        }
    }
}
