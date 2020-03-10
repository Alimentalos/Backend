<?php

namespace App;

use App\Contracts\Resource;
use App\Relationships\Commons\BelongsToUser;
use App\Resources\ActionResource;
use Illuminate\Database\Eloquent\Model;

class Action extends Model implements Resource
{
    use ActionResource;
    use BelongsToUser;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'parameters' => 'array'
    ];

    /**
     * The mass assignment fields of the action.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'user_uuid',
        'type',
        'resource',
        'parameters',
        'referenced_uuid'
    ];

    /**
     * The properties which are hidden.
     *
     * @var array
     */
    protected $hidden = ['id'];


    public $with = ['user'];
}
