<?php

namespace Demency\Relationships\Models;

use Demency\Contracts\Resource;
use Demency\Contracts\UpdateFromRequest;
use Demency\Relationships\Relationships\CommentRelationships;
use Demency\Relationships\BelongsToUser;
use Demency\Relationships\Commentable;
use Demency\Relationships\Resources\CommentResource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Comment extends Model implements ReactableContract, Resource, UpdateFromRequest
{
    use Searchable;
    use Reactable;
    use CommentResource;
    use CommentRelationships;
    use BelongsToUser;
    use Commentable;

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
}
