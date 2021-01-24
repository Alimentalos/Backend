<?php

namespace Alimentalos\Relationships\Models;

use Alimentalos\Contracts\HasColors;
use Alimentalos\Contracts\Resource;
use Alimentalos\Relationships\BelongsToUser;
use Alimentalos\Relationships\Commentable;
use Alimentalos\Relationships\HasPhoto;
use Alimentalos\Relationships\Photoable;
use Alimentalos\Relationships\Resources\PlaceResource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Database\Factories\PlaceFactory;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Place extends Model implements ReactableContract, Resource, HasColors
{
    use HasFactory;
    use Searchable;
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
        'color',
        'marker_color'
    ];

    protected static $colors = [
        'color',
        'marker_color'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_public' => 'boolean',
        'love_reactant_id' => 'integer',
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

    protected static function newFactory()
    {
        return PlaceFactory::new();
    }
}
