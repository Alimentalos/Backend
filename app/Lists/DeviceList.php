<?php


namespace App\Lists;


use App\Device;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

trait DeviceList
{
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