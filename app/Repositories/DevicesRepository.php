<?php

namespace App\Repositories;

use App\Device;
use App\Http\Resources\Device as DeviceResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class DevicesRepository
{
    /**
     * Create device via request.
     *
     * @param Request $request
     * @return DeviceResource
     */
    public static function createDeviceViaRequest(Request $request)
    {
        $device = Device::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'user_uuid' => $request->user('api')->uuid,
            'is_public' => $request->input('is_public'),
        ]);
        return (new DeviceResource($device));
    }

    /**
     * Update device via request.
     *
     * @param Request $request
     * @param Device $device
     * @return DeviceResource
     */
    public static function updateDeviceViaRequest(Request $request, Device $device)
    {
        $device->update([
            'name' => FillRepository::fillMethod($request, 'name', $device->name),
            'description' => FillRepository::fillMethod($request, 'description', $device->description),
            'is_public' => FillRepository::fillMethod($request, 'is_public', $device->is_public)
        ]);

        return new DeviceResource($device);
    }

    /**
     * @return Builder
     */
    public static function fetchInDatabaseDevicesQuery()
    {
        $userGroups = auth('api')->user()->groups->pluck('uuid')->toArray();
        return Device::where('user_uuid', auth('api')->user()->uuid)
            ->orWhere('is_public', true)
            ->OrWhereHas('groups', function (Builder $query) use ($userGroups) {
                $query->whereIn('uuid', $userGroups);
            });
    }

    /**
     * Fetch in database devices
     * @return Device[]|Collection
     */
    public static function fetchInDatabaseDevices()
    {
        return static::fetchInDatabaseDevicesQuery()->get();
    }

    /**
     * Fetch in database devices by comma separated string of devices uuid
     *
     * @param $devices
     * @return Collection
     */
    public static function fetchInDatabase($devices)
    {
        if (is_null($devices) or $devices === '') {
            return static::fetchInDatabaseDevices();
        }
        return Device::whereIn('uuid', explode(',', $devices))
            ->where('user_uuid', auth('api')->user()->uuid)
            ->get();
    }
}
