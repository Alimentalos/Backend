<?php


namespace App\Resources;

use Illuminate\Http\Request;

trait CommentResource
{
    /**
     * Get available comment reactions.
     *
     * @return string
     */
    public function getAvailableReactions()
    {
        return 'Love,Pray,Like,Dislike,Sad,Hate';
    }

    /**
     * Update comment validation rules.
     *
     * @param Request $request
     * @return array
     */
    public function updateRules(Request $request)
    {
        return [];
    }

    /**
     * Store comment validation rules.
     *
     * @param Request $request
     * @return array
     * @codeCoverageIgnore TODO Support store validation rules.
     *
     */
    public function storeRules(Request $request)
    {
        return [];
    }
}
