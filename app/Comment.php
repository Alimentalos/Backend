<?php

namespace App;

use App\Contracts\Resource;
use App\Contracts\UpdateFromRequest;
use App\Relationships\CommentRelationships;
use App\Relationships\Commons\BelongsToUser;
use App\Relationships\Commons\Commentable;
use App\Resources\CommentResource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model implements ReactableContract, Resource, UpdateFromRequest
{
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


    protected $with = ['user'];
}
