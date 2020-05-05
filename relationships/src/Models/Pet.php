<?php

namespace Alimentalos\Relationships\Models;

use Alimentalos\Contracts\HasColors;
use Alimentalos\Contracts\Resource;
use Alimentalos\Relationships\BelongsToUser;
use Alimentalos\Relationships\Commentable;
use Alimentalos\Relationships\Geofenceable;
use Alimentalos\Relationships\Groupable;
use Alimentalos\Relationships\HasPhoto;
use Alimentalos\Relationships\Photoable;
use Alimentalos\Relationships\Trackable;
use Alimentalos\Relationships\Resources\PetResource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

class Pet extends Authenticatable implements ReactableContract, Resource, HasColors
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
        'user_uuid', // Related user
        'photo_uuid', // Related photo
        'api_token', // Token to track
        'photo_url', // Profile photo
        'uuid', // Universal unique identifier
        'name', // Name it
        'description', // Describe the pet
        'size', // Size (xs, sm, md, lg, xlg)
        'born_at', // Born date
        'is_public', // Visibility
        'location', // Spatial point
        // Colors
        'hair_color',
        'second_hair_color',
        'left_eye_color',
        'right_eye_color',
    ];

    /**
     * The available colors of the resource.
     *
     * @var array
     */
    protected static $colors = [
        'hair_color',
        'second_hair_color',
        'left_eye_color',
        'right_eye_color',
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
     * @codeCoverageIgnore
     */
    public function toSearchableArray()
    {
        $array = $this->toArray();

        $array['location'] = array_key_exists('location', $array) ? [
            'latitude' => $array['location']->getLat(),
            'longitude' => $array['location']->getLng(),
        ] : 'NO_LOCATION';

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

    /**
     * Get available colors of the resource.
     *
     * @return array
     */
    public static function getColors()
    {
        return self::$colors;
    }
}
