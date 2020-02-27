<?php

namespace App\Http\Controllers\Api\Devices\Groups;

use App\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Devices\Groups\IndexRequest;
use Illuminate\Http\JsonResponse;

class IndexController extends Controller
{
    /**
     * Fetch all Groups of Device.
     *
     * @param IndexRequest $request
     * @param Device $device
     * @return JsonResponse
     */
    public function __invoke(IndexRequest $request, Device $device)
    {
        return response()->json(
            $device->groups()->latest()->with('user', 'photo')->paginate(20),
            200
        );
    }
}
