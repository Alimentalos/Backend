<?php

namespace App;

use App\Contracts\Resource;
use App\Contracts\UpdateFromRequest;
use App\Relationships\Commons\BelongsToUser;
use App\Relationships\Commons\Commentable;
use App\Relationships\PhotoRelationships;
use App\Resources\PhotoResource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model implements ReactableContract, Resource, UpdateFromRequest
{
    use SpatialTrait;
    use Reactable;
    use PhotoResource;
    use PhotoRelationships;
    use BelongsToUser;
    use Commentable;


    /**
     * The mass assignment fields of the photo
     *
     * @var array
     */
    protected $fillable = [
        'user_uuid',
        'comment_uuid',
        'photo_url',
        'ext',
        'uuid',
        'is_public',
        'location',
    ];

    /**
     * The attributes that should be cast to spatial types.
     *
     * @var array
     */
    protected $spatialFields = [
        'location',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_public' => 'boolean',
    ];

    /**
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];

    protected $with = ['user', 'comment'];
}
