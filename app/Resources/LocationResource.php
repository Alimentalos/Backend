<?php

namespace App\Resources;

use Illuminate\Http\Request;

trait LocationResource
{
    /**
     * Get available location reactions.
     *
     * @return string
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
     */
    public function storeRules(Request $request)
    {
        return [];
    }
}
