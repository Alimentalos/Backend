<?php

namespace Alimentalos\Relationships\Models;

use Alimentalos\Contracts\CreateFromRequest;
use Alimentalos\Contracts\Resource;
use Alimentalos\Contracts\UpdateFromRequest;
use Alimentalos\Relationships\BelongsToUser;
use Alimentalos\Relationships\Groupable;
use Alimentalos\Relationships\HasPhoto;
use Alimentalos\Relationships\Photoable;
use Alimentalos\Relationships\Relationships\GeofenceRelationships;
use Alimentalos\Relationships\Resources\GeofenceResource;
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
        'marker',
        'text_color',
        'color',
        'border_color',
        'background_color',
        'fill_color',
        'tag_color',
        'flag_color',
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
     */
    public function getScoutKey()
    {
        return $this->uuid;
    }
}
