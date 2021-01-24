<?php


namespace Alimentalos\Relationships\Resources;

use App\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

trait CommentResource
{
    /**
     * Current comments reactions
     *
     * @var string[]
     */
    protected $currentReactions = [
        'Love',
        'Pray',
        'Like',
        'Dislike',
        'Sad',
        'Hate'
    ];

    /**
     * @return array
     */
    public function fields() : array
    {
        return [
            'uuid',
            'user_uuid',
            'title',
            'body',
            'commentable_type',
            'commentable_id',
            'created_at',
            'updated_at',
            'love_reactant_id',
            'commentable',
        ];
    }

    /**
     * Get available comments reactions.
     *
     * @return string
     */
    public function getAvailableReactions()
    {
        return implode(',', $this->currentReactions);
    }

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
        return ['commentable', 'user'];
    }

    /**
     * Get comment instances.
     *
     * @return LengthAwarePaginator
     * @codeCoverageIgnore
     */
    public function getInstances()
    {
        return Comment::latest()->paginate(20);
    }
}
