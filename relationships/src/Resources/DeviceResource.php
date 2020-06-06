<?php

namespace Alimentalos\Relationships\Resources;

use Alimentalos\Relationships\Models\Device;
use Alimentalos\Relationships\Repositories\DevicesRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait DeviceResource
{
    /**
     * Update device via request.
     *
     * @return Device
     */
    public function updateViaRequest()
    {
        return devices()->update($this);
    }

    /**
     * Create device via request.
     *
     * @return Device
     */
    public function createViaRequest()
    {
        return devices()->create();
    }

    /**
     * Get available device reactions.
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getAvailableReactions()
    {
        return 'Follow';
    }

    /**
     * Update device validation rules.
     *
     * @return array
     */
    public function updateRules()
    {
        return [];
    }

    /**
     * Store device validation rules.
     *
     * @return array
     */
    public function storeRules()
    {
        return [
            'name' => 'required',
            'marker_color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'color' => 'regex:/#([a-fA-F0-9]{3}){1,2}\b/',
            'is_public' => 'required|boolean',
        ];
    }

    /**
     * Get device relationships using lazy loading.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['user'];
    }

    /**
     * Get device instances.
     *
     * @return LengthAwarePaginator
     */
    public function getInstances()
    {
        $devices = DevicesRepository::fetchInDatabaseDevicesQuery();

        return $devices->latest()->paginate(10);
    }
}
