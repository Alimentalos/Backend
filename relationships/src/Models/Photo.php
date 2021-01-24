<?php

namespace Alimentalos\Relationships\Models;

use Alimentalos\Contracts\Resource;
use Alimentalos\Contracts\UpdateFromRequest;
use Alimentalos\Relationships\BelongsToUser;
use Alimentalos\Relationships\Commentable;
use Alimentalos\Relationships\Relationships\PhotoRelationships;
use Alimentalos\Relationships\Resources\PhotoResource;
use Cog\Contracts\Love\Reactable\Models\Reactable as ReactableContract;
use Cog\Laravel\Love\Reactable\Models\Traits\Reactable;
use Database\Factories\PhotoFactory;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Photo extends Model implements ReactableContract, Resource, UpdateFromRequest
{
    use HasFactory;
    use Searchable;
    use SpatialTrait;
    use Reactable;
    use PhotoResource;
    use PhotoRelationships;
    use BelongsToUser;
    use Commentable;

    /**
     * The default location field of photo.
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
        'love_reactant_id' => 'integer',
    ];

    /**
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];

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
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'uuid';
    }

    protected static function newFactory()
    {
        return PhotoFactory::new();
    }

}
