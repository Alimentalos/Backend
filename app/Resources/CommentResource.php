<?php


namespace App\Resources;

use App\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait CommentResource
{
    /**
     * Update comment via request.
     *
     * @return Comment
     */
    public function updateViaRequest()
    {
        return comments()->update($this);
    }

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
     * @return array
     */
    public function updateRules()
    {
        return [];
    }

    /**
     * Store comment validation rules.
     *
     * @return array
     * @codeCoverageIgnore TODO Support store validation rules.
     *
     */
    public function storeRules()
    {
        return [];
    }

    /**
     * Get geofence relationships using lazy loading.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['commentable'];
    }

    /**
     * Get comment instances.
     *
     * @return LengthAwarePaginator
     * @codeCoverageIgnore
     */
    public function getInstances()
    {
        return Comment::with('user')->latest()->paginate(20);
    }
}
