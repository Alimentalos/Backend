<?php

namespace App\Resources;

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
}
