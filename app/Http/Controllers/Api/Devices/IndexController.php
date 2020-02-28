<?php

namespace App\Http\Controllers\Api\Devices;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Devices\IndexRequest;
use App\Http\Resources\DeviceCollection;
use App\Repositories\DevicesRepository;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param IndexRequest $request
     * @return DeviceCollection
     */
    public function __invoke(IndexRequest $request)
    {
        $devices = DevicesRepository::fetchInDatabaseDevicesQuery();

        return new DeviceCollection(
            $devices->latest()->paginate(10)
        );
    }
}
