<?php

namespace Alimentalos\Relationships\Models;

use App\Contracts\CreateFromRequest;
use App\Contracts\Resource;
use App\Contracts\UpdateFromRequest;
use Alimentalos\Relationships\BelongsToUser;
use Alimentalos\Relationships\Commentable;
use Alimentalos\Relationships\HasPhoto;
use Alimentalos\Relationships\Photoable;
use Alimentalos\Relationships\Relationships\AlertRelationships;
use Alimentalos\Relationships\Resources\AlertResource;
use Database\Factories\AlertFactory;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Alert extends Model implements Resource, CreateFromRequest, UpdateFromRequest
{
    use HasFactory;
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

    protected static function newFactory()
    {
        return AlertFactory::new();
    }
}
