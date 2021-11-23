<?php

namespace App\Models;

use App\Contracts\Resource;
use App\Contracts\UpdateFromRequest;
use Alimentalos\Relationships\BelongsToUser;
use Alimentalos\Relationships\Commentable;
use Alimentalos\Relationships\Relationships\CommentRelationships;
use App\Resources\CommentResource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Comment extends Model implements ReactableContract, Resource, UpdateFromRequest
{
    use HasFactory;
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

	/**
	 * The attributes that should be cast to native types.
	 *
	 * @var array
	 */
	protected $casts = [
	    'love_reactant_id' => 'integer',
	];

    protected static function newFactory()
    {
        return CommentFactory::new();
    }
}
