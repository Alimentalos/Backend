<?php

namespace App;

use App\Contracts\Resource;
use App\Relationships\AccessRelationships;
use App\Resources\AccessResource;
use Illuminate\Database\Eloquent\Model;

class Access extends Model implements Resource
{
    use AccessRelationships;
    use AccessResource;

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
}
