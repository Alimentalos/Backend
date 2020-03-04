<?php

namespace App;

use App\Contracts\Resource;
use App\Relationships\AlertRelationships;
use App\Repositories\AlertsRepository;
use App\Repositories\StatusRepository;
use App\Resources\AlertResource;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Alert extends Model implements Resource
{
    use SpatialTrait;
    use AlertResource;
    use AlertRelationships;

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

    /**
     * Get lazy loaded relationships of Alert.
     *
     * @return array
     */
    public function getLazyRelationshipsAttribute()
    {
        return ['user', 'photo', 'alert'];
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public static function resolveModels(Request $request)
    {
        return Alert::query()
            ->with('user', 'photo', 'alert')
            ->whereIn(
                'status',
                $request->has('whereInStatus') ?
                    explode(',', $request->input('whereInStatus')) : StatusRepository::availableAlertStatuses() // Filter by statuses
            )->latest('created_at')->paginate(25); // Order by latest
    }
}
