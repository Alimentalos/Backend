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
     * @throws Exception
     */
    public function __invoke(DestroyRequest $request, Device $device)
    {
        $device->delete();

        // TODO - Refactor using constant
        return response()->json(
            ['message' => 'Deleted successfully.'],
            200
        );
    }
}
