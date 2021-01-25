<?php


namespace App\Resources;

trait CoinResource
{
    /**
     * Current accesses reactions
     *
     * @var string[]
     */
    protected $currentReactions = [];

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
        return [];
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
