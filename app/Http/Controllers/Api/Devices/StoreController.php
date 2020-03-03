<?php

namespace App\Http\Controllers\Api\Devices;

use App\Device;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Devices\StoreRequest;
use App\Http\Resources\Device as DeviceResource;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function __invoke(StoreRequest $request)
    {
        $device = Device::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'user_uuid' => $request->user('api')->uuid,
            'is_public' => $request->input('is_public'),
        ]);

        return (new DeviceResource($device))->response()->setStatusCode(201);
    }
}
