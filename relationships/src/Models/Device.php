<?php

namespace Demency\Relationships\Models;

use Demency\Contracts\CreateFromRequest;
use Demency\Contracts\Resource;
use Demency\Contracts\UpdateFromRequest;
use Demency\Relationships\BelongsToUser;
use Demency\Relationships\Geofenceable;
use Demency\Relationships\Groupable;
use Demency\Relationships\Trackable;
use Demency\Relationships\Resources\DeviceResource;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

/**
 * Class Device
 *
 * @package App
 * @author Ian Torres
 * @license MIT
 */
class Device extends Authenticatable implements Resource, CreateFromRequest, UpdateFromRequest
{
    use Searchable;
    use SpatialTrait;
    use DeviceResource;
    use Groupable;
    use Geofenceable;
    use BelongsToUser;
    use Trackable;

    /**
     * The mass assignment fields of the device
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_uuid',
        'name',
        'description',
        'api_token',
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
    protected $hidden = ['id', 'api_token'];

    /**
     * The default location field of device.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_FIELD = 'location';

    /**
     * The default location date column.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_DATE_COLUMN = 'generated_at';

    /**
     * The default location group by column.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_GROUP_BY_COLUMN = 'uuid';

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array['location'] = [
            'latitude' => $array['location']->getLat(),
            'longitude' => $array['location']->getLng(),
        ];

        return $array;
    }
}
