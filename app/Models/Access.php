<?php

namespace App\Models;

use App\Contracts\Resource;
use Alimentalos\Relationships\Relationships\AccessRelationships;
use App\Resources\AccessResource;
use Database\Factories\AccessFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Access extends Model implements Resource
{
    use HasFactory;
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
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];

    protected static function newFactory()
    {
        return AccessFactory::new();
    }
}
