<?php

namespace App\Resources;

use App\Repositories\DevicesRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

trait DeviceResource
{
    /**
     * Get available device reactions.
     *
     * @return string
     * @codeCoverageIgnore TODO Support device reactions
     * @body Increase code coverage support enabling the device reactions. Just add routes and tests.
     */
    public function getAvailableReactions()
    {
        return 'Follow';
    }

    /**
     * Update device validation rules.
     *
     * @param Request $request
     * @return array
     */
    public function updateRules(Request $request)
    {
        return [];
    }

    /**
     * Store device validation rules.
     *
     * @param Request $request
     * @return array
     */
    public function storeRules(Request $request)
    {
        return [
            'name' => 'required',
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
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getInstances(Request $request)
    {
        $devices = DevicesRepository::fetchInDatabaseDevicesQuery();

        return $devices->latest()->paginate(10);
    }
}
