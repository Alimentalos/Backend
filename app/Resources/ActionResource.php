<?php

namespace App\Resources;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

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
     * @param Request $request
     * @return array
     * @codeCoverageIgnore
     * @reason Actions can't be updated, are system generated.
     */
    public function updateRules(Request $request)
    {
        return [];
    }

    /**
     * Store action validation rules.
     *
     * @param Request $request
     * @return array
     * @codeCoverageIgnore
     * @reason Actions can't be created by request, are system generated.
     */
    public function storeRules(Request $request)
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
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function getInstances(Request $request)
    {
        return authenticated()->is_child ? actions()->getChildActions() : actions()->getOwnerActions();
    }
}
