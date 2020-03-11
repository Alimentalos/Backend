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
     * @return Builder
     */
    public function fetchInDatabaseDevices()
    {
        return $this->fetchInDatabaseDevicesQuery();
    }

    /**
     * Fetch in database devices by comma separated string of devices uuid
     *
     * @param $devices
     * @return Builder
     */
    public function fetchInDatabase($devices)
    {
        if (is_null($devices) or $devices === '') {
            return $this->fetchInDatabaseDevices();
        }
        return Device::whereIn('uuid', explode(',', $devices))
            ->orWhere('user_uuid', authenticated()->uuid)
            ->orWhere('is_public', true);
    }
}
