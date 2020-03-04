<?php


namespace App\Resources;

use Illuminate\Http\Request;

trait AccessResource
{
    /**
     * Get available accesses reactions.
     *
     * @return string
     * @codeCoverageIgnore TODO Support accesses reactions
     * @body Increase code coverage support enabling the accesses reactions. Just add routes and tests.
     * @reason Not implemented.
     */
    public function getAvailableReactions()
    {
        return 'Love,Pray,Like,Dislike,Sad,Hate';
    }

    /**
     * Update accesses validation rules.
     *
     * @param Request $request
     * @return array
     * @codeCoverageIgnore
     * @reason Accesses can't be updated, are system generated.
     */
    public function updateRules(Request $request)
    {
        return [];
    }

    /**
     * Store accesses validation rules.
     *
     * @param Request $request
     * @return array
     * @codeCoverageIgnore
     * @reason Accesses can't be created by request, are system generated.
     */
    public function storeRules(Request $request)
    {
        return [];
    }

    /**
     * Get access relationships using lazy loading.
     *
     * @return array
     * @codeCoverageIgnore
     * @reason Not implemented.
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['user'];
    }

    /**
     * Get access instances.
     *
     * @param Request $request
     * @return array
     * @codeCoverageIgnore TODO Support accesses index
     * @body Increase code coverage support enabling the accesses index. Just add routes and tests.
     * @reason Not implemented.
     */
    public function getInstances(Request $request)
    {
        return [];
    }
}
