<?php

namespace App\Resources;

use Illuminate\Http\Request;

trait LocationResource
{
    /**
     * Get available location reactions.
     *
     * @return string
     * @codeCoverageIgnore TODO Add location reactions
     * @body Increase code coverage support enabling the alert reactions. Just add routes and tests.
     */
    public function getAvailableReactions()
    {
        return 'Love,Pray,Like,Dislike,Sad,Hate';
    }

    /**
     * Update location validation rules.
     *
     * @param Request $request
     * @return array
     * @codeCoverageIgnore
     * @justify Locations are device generated, can't be modified by user.
     */
    public function updateRules(Request $request)
    {
        return [];
    }

    /**
     * Store location validation rules.
     *
     * @param Request $request
     * @return array
     * @codeCoverageIgnore
     * @justify Locations are device generated, can't be predefined validation rules.
     */
    public function storeRules(Request $request)
    {
        return [];
    }
}
