<?php


namespace Alimentalos\Relationships\Resources;

trait AccessResource
{
    /**
     * Current accesses reactions
     *
     * @var string[]
     */
    protected $currentReactions = [
        'Love',
        'Pray',
        'Like',
        'Dislike',
        'Sad',
        'Hate'
    ];

    /**
     * @return array
     * @codeCoverageIgnore
     */
    public function fields() : array
    {
        return [];
    }

    /**
     * Get available accesses reactions.
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getAvailableReactions()
    {
        return implode(',', $this->currentReactions);
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
