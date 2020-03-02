<?php

namespace App\Http\Controllers\Api\Pets;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Pets\DestroyRequest;
use App\Pet;
use Exception;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRequest $request
     * @param Pet $pet
     * @return JsonResponse
     */
    public function __invoke(DestroyRequest $request, Pet $pet)
    {
        try {
            $pet->delete();

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
