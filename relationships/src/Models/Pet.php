<?php

namespace Demency\Relationships\Models;

use Demency\Contracts\Resource;
use Demency\Relationships\BelongsToUser;
use Demency\Relationships\Commentable;
use Demency\Relationships\Geofenceable;
use Demency\Relationships\Groupable;
use Demency\Relationships\HasPhoto;
use Demency\Relationships\Photoable;
use Demency\Relationships\Trackable;
use Demency\Relationships\Resources\PetResource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

class Pet extends Authenticatable implements ReactableContract, Resource
{
    use Searchable;
    use SpatialTrait;
    use Reactable;
    use PetResource;
    use BelongsToUser;
    use HasPhoto;
    use Trackable;
    use Photoable;
    use Commentable;
    use Geofenceable;
    use Groupable;

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
        'api_token',
        'photo_url',
        'uuid',
        'name',
        'description',
        'hair_color',
        'left_eye_color',
        'right_eye_color',
        'size',
        'born_at',
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
        'born_at' => 'datetime',
    ];

    /**
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id', 'api_token'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
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
