<?php

namespace App\Resources;

use App\Models\Location;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait LocationResource
{
    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function fields() : array
    {
        return [];
    }

    /**
     * Get available location reactions.
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getAvailableReactions()
    {
        return 'Love,Pray,Like,Dislike,Sad,Hate';
    }

    /**
     * Update location validation rules.
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function updateRules()
    {
        return [];
    }

    /**
     * Store location validation rules.
     *
     * @return array
     * @codeCoverageIgnore
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
     * @codeCoverageIgnore
     */
    public function getInstances()
    {
        return Location::query()->paginate(25);
    }
}
