<?php

namespace Demency\Relationships\Models;

use Demency\Contracts\CreateFromRequest;
use Demency\Contracts\Resource;
use Demency\Contracts\UpdateFromRequest;
use Demency\Relationships\Relationships\AlertRelationships;
use Demency\Relationships\BelongsToUser;
use Demency\Relationships\Commentable;
use Demency\Relationships\HasPhoto;
use Demency\Relationships\Photoable;
use Demency\Relationships\Resources\AlertResource;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Alert extends Model implements Resource, CreateFromRequest, UpdateFromRequest
{
    use Searchable;
    use SpatialTrait;
    use AlertResource;
    use AlertRelationships;
    use BelongsToUser;
    use Commentable;
    use HasPhoto;
    use Photoable;

    /**
     * The default location field of alert.
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
     * The table name of alert.
     *
     * @var string
     */
    protected $table = 'alerts';

    /**
     * The mass assignment fields of alert.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'photo_uuid',
        'user_uuid',
        'alert_id',
        'alert_type',
        'photo_url',
        'type',
        'location',
        'title',
        'body',
        'status',
    ];

    /**
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];

    /**
     * The attributes that should be cast to spatial types.
     *
     * @var array
     */
    protected $spatialFields = [
        'location',
    ];
}
