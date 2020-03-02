<?php

namespace App\Http\Controllers\Api\Devices;

use App\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Devices\DestroyRequest;
use Exception;
use Illuminate\Http\JsonResponse;

class DestroyController extends Controller
{
    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRequest $request
     * @param Device $device
     * @return JsonResponse
     */
    public function __invoke(DestroyRequest $request, Device $device)
    {
        try {
            $device->delete();

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
