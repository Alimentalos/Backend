<?php

namespace App\Resources;

use Illuminate\Http\Request;

trait ActionResource
{
    /**
     * Get available alert reactions.
     *
     * @return string
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
     */
    public function storeRules(Request $request)
    {
        return [];
    }
}
