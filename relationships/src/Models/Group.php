<?php

namespace Alimentalos\Relationships\Models;

use App\Contracts\CreateFromRequest;
use App\Contracts\HasColors;
use App\Contracts\Monetizer;
use App\Contracts\Resource;
use App\Contracts\UpdateFromRequest;
use Alimentalos\Relationships\BelongsToUser;
use Alimentalos\Relationships\Commentable;
use Alimentalos\Relationships\HasCoin;
use Alimentalos\Relationships\HasPhoto;
use Alimentalos\Relationships\Photoable;
use Alimentalos\Relationships\Relationships\GroupRelationships;
use Alimentalos\Relationships\Resources\GroupResource;
use Database\Factories\GroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Group extends Model implements Resource, CreateFromRequest, UpdateFromRequest, Monetizer, HasColors
{
    use HasFactory;
    use Searchable;
    use GroupResource;
    use GroupRelationships;
    use BelongsToUser;
    use Photoable;
    use Commentable;
    use HasPhoto;
    use HasCoin;

    /**
     * Pending status
     */
    public const PENDING_STATUS = 1;

    /**
     * Rejected status
     */
    public const REJECTED_STATUS = 2;

    /**
     * Accepted status
     */
    public const ACCEPTED_STATUS = 3;

    /**
     * Accepted status
     */
    public const ATTACHED_STATUS = 4;

    /**
     * Accepted status
     */
    public const BLOCKED_STATUS = 5;

    /**
     * The mass assignment fields of the device.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_uuid',
        'photo_uuid',
        'name',
        'photo_url',
        'is_public',
        'color',
        'background_color',
        'text_color',
        'border_color',
        'fill_color',
        'administrator_color',
        'user_color',
        'owner_color',
    ];

    /**
     * The available colors of the resource.
     *
     * @var array
     */
    protected static $colors = [
        'color',
        'background_color',
        'border_color',
        'fill_color',
        'text_color',
        'user_color',
        'administrator_color',
        'owner_color',
    ];

    /**
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];

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
        return GroupFactory::new();
    }
}
