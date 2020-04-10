<?php


namespace Alimentalos\Relationships\Resources;

trait AccessResource
{
    /**
     * Get available accesses reactions.
     *
     * @return string
     * @codeCoverageIgnore
     */
    public function getAvailableReactions()
    {
        return 'Love,Pray,Like,Dislike,Sad,Hate';
    }

    /**
     * Update accesses validation rules.
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function updateRules()
    {
        return [];
    }

    /**
     * Store accesses validation rules.
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function storeRules()
    {
        return [];
    }

    /**
     * Get access relationships using lazy loading.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['accessible', 'first_location', 'last_location', 'geofence'];
    }

    /**
     * Get access instances.
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function getInstances()
    {
        return [];
    }
}
