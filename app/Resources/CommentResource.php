<?php


namespace App\Resources;

use App\Comment;
use App\Repositories\CommentsRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

trait CommentResource
{
    /**
     * Update model via request.
     *
     * @param Request $request
     * @return Comment
     */
    public function updateViaRequest(Request $request)
    {
        return CommentsRepository::updateCommentViaRequest($request, $this);
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
     * @param Request $request
     * @return LengthAwarePaginator
     * @codeCoverageIgnore
     */
    public function getInstances(Request $request)
    {
        return Comment::with('user')->latest()->paginate(20);
    }
}
