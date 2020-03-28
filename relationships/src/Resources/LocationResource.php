<?php

namespace Alimentalos\Relationships\Resources;

use Alimentalos\Relationships\Models\Location;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait LocationResource
{
    /**
     * Get available location reactions.
     *
     * @return string
     */
    public function getAvailableReactions()
    {
        return 'Love,Pray,Like,Dislike,Sad,Hate';
    }

    /**
     * Update location validation rules.
     *
     * @return array
     */
    public function updateRules()
    {
        return [];
    }

    /**
     * Store location validation rules.
     *
     * @return array
     * @reason Locations are device generated, can't be predefined validation rules.
     */
    public function storeRules()
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
     * @return LengthAwarePaginator
     */
    public function getInstances()
    {
        return Location::query()->paginate(25);
    }
}
