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
     * @return DeviceResource
     */
    public static function createDeviceViaRequest()
    {
        $device = Device::create([
            'name' => input('name'),
            'description' => input('description'),
            'user_uuid' => authenticated()->uuid,
            'is_public' => input('is_public'),
        ]);
        return (new DeviceResource($device));
    }

    /**
     * Update device via request.
     *
     * @param Device $device
     * @return DeviceResource
     */
    public function updateDeviceViaRequest(Device $device)
    {
        $device->update(parameters()->fillPropertiesUsingResource(['name', 'description', 'is_public'], $device));

        return new DeviceResource($device);
    }

    /**
     * @return Builder
     */
    public static function fetchInDatabaseDevicesQuery()
    {
        $userGroups = authenticated()->groups->pluck('uuid')->toArray();
        return Device::where('user_uuid', authenticated()->uuid)
            ->orWhere('is_public', true)
            ->OrWhereHas('groups', fn(Builder $query) => $query->whereIn('uuid', $userGroups));
    }

    /**
     * Fetch in database devices
     * @return Device[]|Collection
     */
    public function fetchInDatabaseDevices()
    {
        return $this->fetchInDatabaseDevicesQuery()->get();
    }

    /**
     * Fetch in database devices by comma separated string of devices uuid
     *
     * @param $devices
     * @return Collection
     */
    public function fetchInDatabase($devices)
    {
        if (is_null($devices) or $devices === '') {
            return $this->fetchInDatabaseDevices();
        }
        return Device::whereIn('uuid', explode(',', $devices))
            ->where('user_uuid', authenticated()->uuid)
            ->get();
    }
}
