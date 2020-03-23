<?php

namespace Alimentalos\Relationships\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait ActionResource
{
    /**
     * Get available action reactions.
     *
     * @return string
     * @codeCoverageIgnore TODO Support action reactions
     * @body Increase code coverage support enabling the action reactions. Just add routes and tests.
     */
    public function getAvailableReactions()
    {
        return 'Love,Pray,Like,Dislike,Sad,Hate';
    }

    /**
     * Update action validation rules.
     *
     * @return array
     * @codeCoverageIgnore
     * @reason Actions can't be updated, are system generated.
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
     * @reason Actions can't be created by request, are system generated.
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
