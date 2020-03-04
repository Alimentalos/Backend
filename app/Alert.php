<?php

namespace App;

use App\Contracts\Resource;
use App\Relationships\AlertRelationships;
use App\Relationships\Commons\BelongsToUser;
use App\Relationships\Commons\Commentable;
use App\Relationships\Commons\HasPhoto;
use App\Relationships\Commons\Photoable;
use App\Repositories\AlertsRepository;
use App\Resources\AlertResource;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Alert extends Model implements Resource
{
    use SpatialTrait;
    use AlertResource;
    use AlertRelationships;
    use BelongsToUser;
    use Commentable;
    use HasPhoto;
    use Photoable;

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

    /**
     * Update model via request.
     *
     * @param Request $request
     * @return Alert
     */
    public function updateViaRequest(Request $request)
    {
        return AlertsRepository::updateAlertViaRequest($request, $this);
    }

    /**
     * Create model via request.
     *
     * @param Request $request
     * @return Alert
     */
    public static function createViaRequest(Request $request)
    {
        return AlertsRepository::createViaRequest($request);
    }
}
