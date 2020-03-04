<?php

namespace App\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

trait LocationResource
{
    /**
     * Get available location reactions.
     *
     * @return string
     * @codeCoverageIgnore TODO Add location reactions
     * @body Increase code coverage support enabling the alert reactions. Just add routes and tests.
     */
    public function getAvailableReactions()
    {
        return 'Love,Pray,Like,Dislike,Sad,Hate';
    }

    /**
     * Update location validation rules.
     *
     * @param Request $request
     * @return array
     * @codeCoverageIgnore
     * @reason Locations are device generated, can't be modified by user.
     */
    public function updateRules(Request $request)
    {
        return [];
    }

    /**
     * Store location validation rules.
     *
     * @param Request $request
     * @return array
     * @codeCoverageIgnore
     * @reason Locations are device generated, can't be predefined validation rules.
     */
    public function storeRules(Request $request)
    {
        return [];
    }

    /**
     * Get location relationships using lazy loading.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['trackable'];
    }

    /**
     * Get location instances.
     *
     * @param Request $request
     * @return Collection
     * @codeCoverageIgnore
     * @reason Locations uses custom LocationRepository query.
     */
    public function getInstances(Request $request)
    {
        return self::query()->get();
    }
}
