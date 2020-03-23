<?php

namespace Demency\Relationships\Models;

use Demency\Contracts\CreateFromRequest;
use Demency\Contracts\Resource;
use Demency\Contracts\UpdateFromRequest;
use Demency\Relationships\BelongsToUser;
use Demency\Relationships\Groupable;
use Demency\Relationships\HasPhoto;
use Demency\Relationships\Photoable;
use Demency\Relationships\Relationships\GeofenceRelationships;
use Demency\Relationships\Resources\GeofenceResource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Geofence extends Model implements ReactableContract, Resource, CreateFromRequest, UpdateFromRequest
{
    use Searchable;
    use SpatialTrait;
    use Reactable;
    use GeofenceResource;
    use GeofenceRelationships;
    use BelongsToUser;
    use Photoable;
    use Groupable;
    use HasPhoto;

    /**
     * The default location field of geofence.
     *
     * @var string
     */
    public const DEFAULT_LOCATION_FIELD = 'shape';

    /**
     * The mass assignment fields of the geofence.
     *
     * @var array
     */
    protected $fillable = [
        'photo_uuid',
        'user_uuid',
        'uuid',
        'photo_url',
        'is_public',
    ];

    /**
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];

    /**
     * The spatial fields of the geofence.
     *
     * @var array
     */
    protected $spatialFields = [
        'shape',
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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     * @codeCoverageIgnore
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array['shape'] = $array['shape']->getLineStrings();

        return $array;
    }

    /**
     * Get the value used to index the model.
     *
     * @return mixed
     * @codeCoverageIgnore
     */
    public function getScoutKey()
    {
        return $this->uuid;
    }
}
