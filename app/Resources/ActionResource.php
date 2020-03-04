<?php

namespace App\Resources;

use Illuminate\Http\Request;

trait ActionResource
{
    /**
     * Get available alert reactions.
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
     * Update alert validation rules.
     *
     * @param Request $request
     * @return array
     * @codeCoverageIgnore
     * @justify Actions can't be updated, are system generated.
     */
    public function updateRules(Request $request)
    {
        return [];
    }

    /**
     * Store alert validation rules.
     *
     * @param Request $request
     * @return array
     * @codeCoverageIgnore
     * @justify Actions can't be created by request, are system generated.
     */
    public function storeRules(Request $request)
    {
        return [];
    }
}
