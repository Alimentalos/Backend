<?php

namespace App\Repositories;

use App\Device;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class DevicesRepository
{
    /**
     * @return Builder
     */
    public static function fetchInDatabaseDevicesQuery()
    {
        $userGroups = auth('api')->user()->groups->pluck('id')->toArray();
        return Device::where('user_id', auth('api')->user()->id)
            ->orWhere('is_public', true)
            ->OrWhereHas('groups', function (Builder $query) use ($userGroups) {
                $query->whereIn('id', $userGroups);
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
            ->where('user_id', auth('api')->user()->id)
            ->get();
    }
}
