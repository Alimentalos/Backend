<?php

namespace App;

use Demency\Contracts\Resource;
use App\Relationships\Commons\BelongsToUser;
use App\Relationships\Commons\Commentable;
use App\Relationships\Commons\HasPhoto;
use App\Relationships\Commons\Photoable;
use App\Resources\PlaceResource;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;

class Place extends Model implements ReactableContract, Resource
{
    use PlaceResource;
    use SpatialTrait;
    use BelongsToUser;
    use Reactable;
    use HasPhoto;
    use Photoable;
    use Commentable;

    /**
     * The default location field of pet.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_FIELD = 'location';

    /**
     * The default location date column.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_DATE_COLUMN = 'created_at';

    /**
     * The default location group by column.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_GROUP_BY_COLUMN = 'uuid';

    /**
     * Mass-assignable properties.
     *
     * @var array
     */
    protected $fillable = [
        'user_uuid',
        'photo_uuid',
        'photo_url',
        'uuid',
        'name',
        'is_public',
        'description',
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
     * The attributes that should be cast to spatial types.
     *
     * @var array
     */
    protected $spatialFields = [
        'location',
    ];

    /**
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];


    /**
     * This model doesn't uses increments.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Get key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'uuid';
    }
}
