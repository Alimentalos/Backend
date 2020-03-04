<?php

namespace App;

use App\Relationships\AccessesRelationships;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Access extends Model
{
    use AccessesRelationships;

    /**
     * The table name.
     *
     * @var string
     */
    protected $table = 'accesses';

    /**
     * Mass-assignable properties.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'accessible_id',
        'accessible_type',
        'geofence_uuid',
        'first_location_uuid',
        'last_location_uuid',
        'status',
    ];

    /**
     * Eager loading properties.
     *
     * @var array
     */
    protected $with = [
        'accessible',
        'geofence',
        'first_location',
        'last_location',
    ];

    /**
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     * @codeCoverageIgnore
     */
    public static function resolveModels(Request $request)
    {
        return self::with('accessible')->latest()->paginate(20);
    }
}
