<?php

namespace App;

use App\Contracts\Resource;
use App\Relationships\CommentRelationships;
use App\Repositories\CommentsRepository;
use App\Resources\CommentResource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Comment extends Model implements ReactableContract, Resource
{
    use Reactable;
    use CommentResource;
    use CommentRelationships;

    /**
     * The mass assignment fields of the comment
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_uuid',
        'title',
        'body',
    ];

    /**
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];

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
     * Get lazy loaded relationships of Geofence.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['commentable'];
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     * @codeCoverageIgnore
     */
    public static function resolveModels(Request $request)
    {
        return self::with('user')->latest()->paginate(20);
    }
}
