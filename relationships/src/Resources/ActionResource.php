<?php

namespace Alimentalos\Relationships\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait ActionResource
{
    /**
     * Current actions reactions
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
     * Get available actions reactions.
     *
     * @codeCoverageIgnore
     * @return string
     */
    public function getAvailableReactions()
    {
        return implode(',', $this->currentReactions);
    }

    /**
     * Update action validation rules.
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function updateRules()
    {
        return [];
    }

    /**
     * Store action validation rules.
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function storeRules()
    {
        return [];
    }

    /**
     * Get action relationships using lazy loading.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['user'];
    }

    /**
     * Get action instances.
     *
     * @return LengthAwarePaginator
     */
    public function getInstances()
    {
        return authenticated()->is_child ? actions()->getChildActions() : actions()->getOwnerActions();
    }
}
